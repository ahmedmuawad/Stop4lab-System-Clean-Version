<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Expense;
use App\Models\SafeTransfer;
use Illuminate\Http\Request;
use App\Http\Middleware\Branch;
use App\Models\ExpenseCategory;
use App\Models\ExpensesCustody;
use App\Models\Branches_custody;
use App\Http\Controllers\Controller;
use App\Models\Branch as ModelsBranch;
use App\Http\Requests\Admin\ExpenseRequest;
use App\Http\Requests\Admin\BulkActionRequest;

class ExpensesController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_expense',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_expense',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_expense',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_expense',   ['only' => ['destroy','bulk_delete']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense_categories=ExpenseCategory::all();
        $branchs=ModelsBranch::all();

        return view('admin.accounting.expenses.index',compact('expense_categories','branchs'));
    }

    /**
    * get analyses datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Expense::with('category','payment_method','doctor','custody')
                        ->where('branch_id',session('branch_id'));
        
        if ($request['filter_date'] != '') {
            //format date
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select groups of date between
            ($date[0] == $date[1]) ? $model->whereDate('date', $from) : $model->whereBetween('date', [$from, $to]);
        }
        
        if ($request['filter_category'] != '') {
            $model->where('expense_category_id', $request['filter_category']);
        }

        if ($request['filter_branch'] != '') {
            $model->where('branch_id', $request['filter_branch']);
        }
        return DataTables::eloquent($model)
        ->editColumn('amount',function($expense){
           return formated_price($expense['amount']);
        })
        ->editColumn('notes',function($expense){
           return strip_tags($expense['notes']);
        })
        ->addColumn('action',function($expense){
            return view('admin.accounting.expenses._action',compact('expense'));
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expense_categories=ExpenseCategory::all();
        $custody = ModelsBranch::where('id',session('branch_id'))->first()->custody;
        return view('admin.accounting.expenses.create',compact('expense_categories','custody'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $request['date']=\Carbon\Carbon::parse($request['date']);

        if(isset(setting('account')['expenses_type']) && setting('account')['expenses_type'] == "cach" ) {
            $expense=Expense::create($request->except('_token','_method','files'));
            $expense->update([
                'branch_id'=>session('branch_id'),
                'doctor_id'=> auth()->guard('admin')->user()->id
            ]);
        }else{
            if($request->amount > get_custody_branch() && !$request->has('source')){
                session()->flash('failed',__('Custody Not Less Than Amount'));

                return redirect()->route('admin.expenses.index');
            }

            $expense=Expense::create($request->except('_token','_method','files'));
            $expense->update([
                'branch_id'=>session('branch_id'),
                'doctor_id'=> auth()->guard('admin')->user()->id
            ]);


            if($request->has('source')){

                if($request->source == '4'){
                    $safe=SafeTransfer::where('to_branch_id',session('branch_id'))
                                        ->where('accept',"Accept")
                                        ->where('export','!=','Accept')
                                        ->whereHas('payments',function($q){return $q->where('amount','>',0);})
                                        ->get();

            if($request->amount > get_safe(session('branch_id'))){

                session()->flash('failed',__('Not Enough Cach in Safe Branch'));

                return redirect()->back();
            }
            

            $temp = $request->amount ;
            foreach($safe as $item){
                $safeAmount =  $item->payments()->where('payment_method_id',setting("account")['payment'])->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$item->id)->sum('custody');
                
                if($safeAmount > 0){
                    $due        = $temp - $safeAmount;
                    $due2       = $temp - $due;
    
                    if($temp > 0 ){
                        if($due >= 0){
                            $custody = Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => session('branch_id'),
                                'custody_type' => $request->source,
                                'custody' => $due2,         
                                'created_at' => $expense->date,         
                            ]);
                            $temp = $due;
                            ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);
                        }elseif($due < 0){
                            $custody = Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => session('branch_id'),
                                'custody_type' => $request->source,
                                'custody' => $temp,  
                                'created_at' => $expense->date,         
  
                            ]);
                            $temp = $due;
                            ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);

                        }
                    }
                }
            }
                    
        
                }elseif($request->source == '3'){
                    $safe=SafeTransfer::where('to_branch_id',setting("account")['branch'])->where('accept',"Accept")->where('export','!=','Accept')->where('type','Outside')
                    ->get();

                    if($request->amount > get_main_safe()){
                        session()->flash('failed',__('Not Enough Cach in Main Safe'));

                        return redirect()->back();
                    }

                    $temp = $request->amount ;
                    foreach($safe as $item){
                        $safeAmount =  $item->payments()->where('payment_method_id',setting("account")['payment'])->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$item->id)->sum('custody');
                        
                        if($safeAmount > 0){
                            $due        = $temp - $safeAmount;
                            $due2       = $temp - $due;
            
                            if($temp > 0 ){
                                if($due >= 0){
                                    $custody = Branches_custody::create([
                                        'priceable_type' => "App\Models\SafeTransfer",
                                        'priceable_id' => $item->id,
                                        'branche_id' => session('branch_id'),
                                        'custody_type' => $request->source,
                                        'custody' => $due2, 
                                        'created_at' => $expense->date,         
        
                                    ]);
                                    $temp = $due;
                                    ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);

                                }elseif($due < 0){
                                    $custody = Branches_custody::create([
                                        'priceable_type' => "App\Models\SafeTransfer",
                                        'priceable_id' => $item->id,
                                        'branche_id' => session('branch_id'),
                                        'custody_type' => $request->source,
                                        'custody' => $temp, 
                                        'created_at' => $expense->date,
                                    ]);
                                    $temp = $due;
                                    ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);

                                }
                            }
                        }
                    }
        
                }elseif($request->source == '1'){
        
                    $safe=SafeTransfer::where('export','Accept')->first();
                    $custody = Branches_custody::create([
                        'branche_id'=>session('branch_id'),
                        'custody' => $request->amount,
                        'user_id' => auth()->guard('admin')->user()->id,
                        'priceable_type' => "App\Models\SafeTransfer",
                        'priceable_id' => $safe->id,
                        'created_at' => $expense->date,
                        'custody_type' => 1
                    ]);
                    ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);


                }elseif($request->source == '2'){
                    $custody = Branches_custody::create([
                        'branche_id'=>session('branch_id'),
                        'custody' => $request->amount,
                        'user_id' => auth()->guard('admin')->user()->id,
                        'created_at' => $expense->date,
                        'custody_type' => 2
                    ]);
                    ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);

                }
            }

            Branches_custody::create([
                'branche_id'=>session('branch_id'),
                'custody' => $request->amount,
                'user_id' => auth()->guard('admin')->user()->id,
                'priceable_type' => 'App\Models\Expense',
                'priceable_id' => $expense->id,
                'created_at' => $expense->date,
                'custody_type' => 0
            ]);



        }


        session()->flash('success',__('Expense created successfully'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $custody = ModelsBranch::where('id',session('branch_id'))->first()->custody;
        $expense_categories=ExpenseCategory::all();
        $expense=Expense::where('branch_id',session('branch_id'))
                        ->findOrFail($id);

        return view('admin.accounting.expenses.edit',compact('expense_categories','expense','custody'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, $id)
    {
        $request['date']=\Carbon\Carbon::parse($request['date']);

        $expense=Expense::where('branch_id',session('branch_id'))
        ->findOrFail($id);

        Branches_custody::where('priceable_id',$expense->id)->where('priceable_type','App\Models\Expense')->delete();

        $expenseCustody = ExpensesCustody::where('expenses_id',$expense->id)->get();

        $custody = array_column($expenseCustody->toArray(),'custoday_id');

        Branches_custody::whereIn('id',$custody)->delete();

        $expense->delete();

        if(isset(setting('account')['expenses_type']) && setting('account')['expenses_type'] == "cach" ) {
            $expense=Expense::create($request->except('_token','_method','files'));
            $expense->update([
                'branch_id'=>session('branch_id'),
                'doctor_id'=> auth()->guard('admin')->user()->id
            ]);
        }else{
            if($request->amount > get_custody_branch() && !$request->has('source')){
                session()->flash('failed',__('Custody Not Less Than Amount'));

                return redirect()->route('admin.expenses.index');
            }

            $expense=Expense::create($request->except('_token','_method','files'));
            $expense->update([
                'branch_id'=>session('branch_id'),
                'doctor_id'=> auth()->guard('admin')->user()->id
            ]);


            if($request->has('source')){

                if($request->source == '4'){
                    $safe=SafeTransfer::where('to_branch_id',session('branch_id'))
                                        ->where('accept',"Accept")
                                        ->where('export','!=','Accept')
                                        ->whereHas('payments',function($q){return $q->where('amount','>',0);})
                                        ->get();

            if($request->amount > get_safe(session('branch_id'))){

                session()->flash('failed',__('Not Enough Cach in Safe Branch'));

                return redirect()->back();
            }
            

            $temp = $request->amount ;
            foreach($safe as $item){
                $safeAmount =  $item->payments()->where('payment_method_id',setting("account")['payment'])->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$item->id)->sum('custody');
                
                if($safeAmount > 0){
                    $due        = $temp - $safeAmount;
                    $due2       = $temp - $due;
    
                    if($temp > 0 ){
                        if($due >= 0){
                            $custody = Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => session('branch_id'),
                                'custody_type' => $request->source,
                                'custody' => $due2,         
                                'created_at' => $expense->date,         
                            ]);
                            $temp = $due;
                            ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);
                        }elseif($due < 0){
                            $custody = Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => session('branch_id'),
                                'custody_type' => $request->source,
                                'custody' => $temp,  
                                'created_at' => $expense->date,         
  
                            ]);
                            $temp = $due;
                            ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);

                        }
                    }
                }
            }
                    
        
                }elseif($request->source == '3'){
                    $safe=SafeTransfer::where('to_branch_id',setting("account")['branch'])->where('accept',"Accept")->where('export','!=','Accept')->where('type','Outside')
                    ->get();

                    if($request->amount > get_main_safe()){
                        session()->flash('failed',__('Not Enough Cach in Main Safe'));

                        return redirect()->back();
                    }

                    $temp = $request->amount ;
                    foreach($safe as $item){
                        $safeAmount =  $item->payments()->where('payment_method_id',setting("account")['payment'])->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$item->id)->sum('custody');
                        
                        if($safeAmount > 0){
                            $due        = $temp - $safeAmount;
                            $due2       = $temp - $due;
            
                            if($temp > 0 ){
                                if($due >= 0){
                                    $custody = Branches_custody::create([
                                        'priceable_type' => "App\Models\SafeTransfer",
                                        'priceable_id' => $item->id,
                                        'branche_id' => session('branch_id'),
                                        'custody_type' => $request->source,
                                        'custody' => $due2, 
                                        'created_at' => $expense->date,         
        
                                    ]);
                                    $temp = $due;
                                    ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);

                                }elseif($due < 0){
                                    $custody = Branches_custody::create([
                                        'priceable_type' => "App\Models\SafeTransfer",
                                        'priceable_id' => $item->id,
                                        'branche_id' => session('branch_id'),
                                        'custody_type' => $request->source,
                                        'custody' => $temp, 
                                        'created_at' => $expense->date,
                                    ]);
                                    $temp = $due;
                                    ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);

                                }
                            }
                        }
                    }
        
                }elseif($request->source == '1'){
        
                    $safe=SafeTransfer::where('export','Accept')->first();
                    $custody = Branches_custody::create([
                        'branche_id'=>session('branch_id'),
                        'custody' => $request->amount,
                        'user_id' => auth()->guard('admin')->user()->id,
                        'priceable_type' => "App\Models\SafeTransfer",
                        'priceable_id' => $safe->id,
                        'created_at' => $expense->date,
                        'custody_type' => 1
                    ]);
                    ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);


                }elseif($request->source == '2'){
                    $custody = Branches_custody::create([
                        'branche_id'=>session('branch_id'),
                        'custody' => $request->amount,
                        'user_id' => auth()->guard('admin')->user()->id,
                        'created_at' => $expense->date,
                        'custody_type' => 2
                    ]);
                    ExpensesCustody::create(['custoday_id' => $custody->id ,'expenses_id' => $expense->id]);

                }
            }

            Branches_custody::create([
                'branche_id'=>session('branch_id'),
                'custody' => $request->amount,
                'user_id' => auth()->guard('admin')->user()->id,
                'priceable_type' => 'App\Models\Expense',
                'priceable_id' => $expense->id,
                'created_at' => $expense->date,
                'custody_type' => 0
            ]);



        }


        session()->flash('success',__('Expense updated successfully'));

        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $expense=Expense::where('branch_id',session('branch_id'))
                        ->findOrFail($id);

        Branches_custody::where('priceable_id',$expense->id)->where('priceable_type','App\Models\Expense')->delete();

        $expenseCustody = ExpensesCustody::where('expenses_id',$expense->id)->get();

        $custody = array_column($expenseCustody->toArray(),'custoday_id');

        Branches_custody::whereIn('id',$custody)->delete();
        
        $expense->delete();

        session()->flash('success',__('Expense Deleted successfully'));

        return redirect()->route('admin.expenses.index');
    }

    /**
     * Bulk delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(BulkActionRequest $request)
    {
        foreach($request['ids'] as $id)
        {
            $expense=Expense::where('branch_id',session('branch_id'))
            ->findOrFail($id);

            Branches_custody::where('priceable_id',$expense->id)->where('priceable_type','App\Models\Expense')->delete();

            $expenseCustody = ExpensesCustody::where('expenses_id',$expense->id)->get();

            $custody = array_column($expenseCustody->toArray(),'custoday_id');

            Branches_custody::whereIn('id',$custody)->delete();

            $expense->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.expenses.index');
    }
}
