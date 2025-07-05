<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\SafeTransfer;
use Illuminate\Http\Request;
use App\Models\Branches_custody;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;

class SafeTrasfersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view_safe',     ['only' => ['index', 'ajax','view']]);
        $this->middleware('can:create_safe',   ['only' => ['create', 'store']]);
        $this->middleware('can:accept_safe',     ['only' => ['accept']]);
        $this->middleware('can:refuse_safe',   ['only' => ['refuse']]);
        $this->middleware('can:export_safe',   ['only' => ['export']]);
        $this->middleware('can:accept_export_safe',   ['only' => ['acceptExport','accept_all']]);
        $this->middleware('can:delete_safe',   ['only' => ['destroy','bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request['type'] ?: 'pending';

        $model=SafeTransfer::with('payments');

        if ($type == 'main') {
            $model->where('export',"Send");
        } else if($type == 'pending') {
            $model->where('to_branch_id',session('branch_id'))->where('accept','Pending');
        }else if($type == 'export'){
            $model->where('to_branch_id',session('branch_id'))->where('accept','Accept')->where('export',"Pending");
        } else if($type == 'refused') {
            $model->where('from_branch_id',session('branch_id'))->where('accept','Refused');
        }

        if ($request['filter_to_user'] != '') {
            $model->where('to_user_id', $request['filter_to_user']);
        }
        if ($request['filter_from_user'] != '') {
            $model->where('from_user_id', $request['filter_from_user']);
        }
        if ($request['filter_to_branch'] != '') {
            $model->where('to_branch_id', $request['filter_to_branch']);
        }
        if ($request['filter_from_branch'] != '') {
            $model->where('from_branch_id', $request['filter_from_branch']);
        }
        if ($request['filter_date'] != '') {
            //format date
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select groups of date between
            $date[0] == $date[1]
                ? $model->whereDate('created_at', $from)
                : $model->whereBetween('created_at', [$from, $to]);
        }

        $model = $model->get();
        $totalCach = 0;
        $totalOther = 0;

        foreach($model as $safe){
            $totalCach += $safe->payments()->where('payment_method_id','1')->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$safe->id)->sum('custody');
            $totalOther += $safe->payments()->where('payment_method_id','!=','1')->sum('amount');
        }

        $total = number_format(get_bank(),0);

        return view('admin.safe_transfer.index',compact('type','total','totalCach','totalOther'));
    }

         /**
    * get culture options datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {

        // return $request->all();
    
        $model=SafeTransfer::query()->with('payments','fromBrnach','toBrnach','toUser','fromUser');

        if ($request['type'] == 'main') {
            $model->where('export',"Send");
        } else if($request['type'] == 'pending') {
            $model->where('to_branch_id',session('branch_id'))->where('accept','Pending');
        }else if($request['type'] == 'export'){
            $model->where('to_branch_id',session('branch_id'))->where('accept','Accept')->where('export',"Pending");
        } else if($request['type'] == 'refused') {
            $model->where('from_branch_id',session('branch_id'))->where('accept','Refused');
        }

        if ($request['filter_to_user'] != '') {
            $model->where('to_user_id', $request['filter_to_user']);
        }
        if ($request['filter_from_user'] != '') {
            $model->where('from_user_id', $request['filter_from_user']);
        }
        if ($request['filter_to_branch'] != '') {
            $model->where('to_branch_id', $request['filter_to_branch']);
        }
        if ($request['filter_from_branch'] != '') {
            $model->where('from_branch_id', $request['filter_from_branch']);
        }
        if ($request['filter_date'] != '') {
            //format date
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select groups of date between
            $date[0] == $date[1]
                ? $model->whereDate('created_at', $from)
                : $model->whereBetween('created_at', [$from, $to]);
        }
        
        
        return DataTables::eloquent($model)
        ->addColumn('payments',function($safe){
            $custody = Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$safe->id)->sum('custody');
            return view('admin.safe_transfer._payment',compact('safe','custody'));
        })
        ->addColumn('payments_without_custody',function($safe){
            $custody = 0;
            return view('admin.safe_transfer._payment',compact('safe','custody'));
        })
        ->addColumn('from_to',function($safe){
            return date('Y-m-d',strtotime($safe->from_date)) . " : " . date('Y-m-d',strtotime($safe->to_date)); 
        })
        ->editColumn('created_at',function($safe){
            return date('Y-m-d h:i A',strtotime($safe->created_at)); 
        })
        ->addColumn('action',function($safe)use($request){
            $type = $request['type'];
            return view('admin.safe_transfer._action',compact('safe','type'));
        })
        ->addColumn('bulk_checkbox', function ($item) {
            return view('partials._bulk_checkbox', compact('item'));
        })
        ->toJson();
    }
    public function ajax_refused(Request $request)
    {
    
        $model=SafeTransfer::query()->with('payments','fromBrnach','toBrnach','toUser','fromUser');

        $model->where('from_branch_id',session('branch_id'))->where('accept','Refused');


        if ($request['filter_to_user'] != '') {
            $model->where('to_user_id', $request['filter_to_user']);
        }
        if ($request['filter_from_user'] != '') {
            $model->where('from_user_id', $request['filter_from_user']);
        }
        if ($request['filter_to_branch'] != '') {
            $model->where('to_branch_id', $request['filter_to_branch']);
        }
        if ($request['filter_from_branch'] != '') {
            $model->where('from_branch_id', $request['filter_from_branch']);
        }
        if ($request['filter_date'] != '') {
            //format date
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select groups of date between
            $date[0] == $date[1]
                ? $model->whereDate('created_at', $from)
                : $model->whereBetween('created_at', [$from, $to]);
        }
        
        
        return DataTables::eloquent($model)
        ->addColumn('payments',function($safe){
            $custody = Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$safe->id)->sum('custody');
            return view('admin.safe_transfer._payment',compact('safe','custody'));
        })
        ->addColumn('from_to',function($safe){
            return date('Y-m-d',strtotime($safe->from_date)) . " : " . date('Y-m-d',strtotime($safe->to_date)); 
        })
        ->editColumn('created_at',function($safe){
            return date('Y-m-d h:i A',strtotime($safe->created_at)); 
        })
        ->addColumn('action',function($safe)use($request){
            $type = 'refused';
            return view('admin.safe_transfer._action',compact('safe','type'));
        })
        ->addColumn('bulk_checkbox', function ($item) {
            return view('partials._bulk_checkbox', compact('item'));
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
        $allBranches = Branch::all();
        return view('admin.safe_transfer.create',compact('allBranches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if($request->has('safe_id')){
            foreach($request->safe_id as $safe){

                SafeTransfer::where('id',$safe)
                ->update(['to_branch_id' => $request->to_branch_id ,'export' => 'Pending' , 'accept' => 'Pending' , 'type' => 'Outside']);
            }
        }
        // $date=explode('-',$request['date']);
        // $from=date('Y-m-d',strtotime($date[0]));
        // $to=date('Y-m-d',strtotime($date[1]));

        // $safe = new SafeTransfer();
        // $safe->from_branch_id = $request->from_branch_id;
        // $safe->to_branch_id = $request->to_branch_id;
        // $safe->from_date = $from;
        // $safe->to_date = $to;
        // $safe->from_user_id = auth()->guard('admin')->user()->id;

        // $safe->save();

        // if ($request->has('payments')) {
        //     foreach ($request['payments'] as $payment) {
        //         $safe->payments()->create([
        //             'payment_method_id' => $payment['payment_method_id'],
        //             'amount' => $payment['amount'],
        //         ]);
        //     }
        // }

        
        session()->flash('success',__('Safe Transfer successfully'));

        return redirect()->back();
        // dd($request->all());
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
   
        SafeTransfer::find($id)->update(['accept'=>"Accept" ,'to_user_id' => auth()->guard('admin')->user()->id]);

        session()->flash('success',__('Accept Safe Transfer successfully'));

        return redirect()->back();
    }
    public function acceptExport($id)
    {
   
        SafeTransfer::find($id)->update(['export'=>"Accept"]);

        session()->flash('success',__('Accept Safe Transfer successfully'));

        return redirect()->back();
    }
    public function refuse($id)
    {
   
        SafeTransfer::find($id)->update(['accept'=> "Refused" , 'to_user_id' => null]);

        session()->flash('success',__('Refused Safe Transfer successfully'));

        return redirect()->back();
    }
    public function refuseExport($id)
    {
   
        SafeTransfer::find($id)->update(['export'=> "Refused"]);

        session()->flash('success',__('Refused Safe Transfer successfully'));

        return redirect()->back();
    }
    public function export($id)
    {
   
        SafeTransfer::find($id)->update(['export'=>"Send"]);

        session()->flash('success',__('Send Safe Transfer To Owner successfully'));

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id > 1){

            $safe=SafeTransfer::findOrFail($id);
            $safe->payments()->delete();
            $safe->delete();
        }

        session()->flash('success',__('deleted successfully'));
        
        return redirect()->back();
    }

    public function bulk_delete(BulkActionRequest $request)
    {
        // dd($request->all());
        foreach ($request['ids'] as $id) {
            $safe = SafeTransfer::find($id);

            $safe->payments()->delete();
            $safe->delete();


        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->back();
    }
    public function accept_all(BulkActionRequest $request)
    {
        // dd($request->all());
        foreach ($request['ids'] as $id) {
            SafeTransfer::find($id)->update(['export'=>"Accept"]);
        }

        session()->flash('success', __('Accept All successfully'));

        return redirect()->back();
    }
}
