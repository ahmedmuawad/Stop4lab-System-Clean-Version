<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\SafeTransfer;
use Illuminate\Http\Request;
use App\Models\Branches_custody;
use App\Models\SafeTransferPayment;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;

class BranchCustodyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view_branch',     ['only' => ['index','ajax']]);
        $this->middleware('can:create_branch',   ['only' => ['create', 'store','visa','transferToBank']]);
        $this->middleware('can:edit_branch',     ['only' => ['edit', 'update','refuse','accept']]);
        $this->middleware('can:delete_branch',   ['only' => ['destroy','bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get branches to show safe ditails
        $branches = Branch::get();
        foreach($branches  as $branch){
            $branch->get_safe = get_safe($branch->id);
        }
        //get requested custody
        $requsts = Branches_custody::with('branche','user')->where('status','0')->get();
        return view('admin.branch_custody.index',compact('requsts','branches'));
    }

    public function ajax(Request $request)
    {
        // get custodys 
        $model=Branches_custody::query()->with('branche')->where('status','1')->where('custody_type','!=',0);

        return DataTables::eloquent($model)
        ->addColumn('action',function($branch){
            return view('admin.branch_custody._action',compact('branch'));
        })
        ->editColumn('created_at',function($branch){
            return date('Y-m-d H:i', strtotime($branch['created_at']));
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }

    public function create()
    {
        // get branches to show safe ditails
        $branches = Branch::get();
        foreach($branches  as $branch){
            $branch->get_safe = get_safe($branch->id);
        }
        return view('admin.branch_custody.create',compact('branches'));
    }

    public function store(Request $request)
    {
        if($request->custody_type == '2'){
            if($request->custody > get_cash_vault(null,$request->branche_id)){
                session()->flash('failed',__('Not Enough Cach in Branch'));

                return redirect()->back();
            }
        }

        if($request->custody_type == '4'){

            $safe=SafeTransfer::where('to_branch_id',$request->branche_id)
                                ->where('accept',"Accept")
                                ->where('export','!=','Accept')
                                ->whereHas('payments',function($q){return $q->where('amount','>',0);})
                                ->get();
            
            if($request->custody > get_safe($request->branche_id)){

                session()->flash('failed',__('Not Enough Cach in Safe Branch'));

                return redirect()->back();
            }
            

            $temp = $request->custody ;
            foreach($safe as $item){
                $safeAmount =  $item->payments()->where('payment_method_id',setting("account")['payment'])->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$item->id)->sum('custody');
                
                if($safeAmount > 0){
                    $due        = $temp - $safeAmount;
                    $due2       = $temp - $due;
    
                    if($temp > 0 ){
                        if($due >= 0){
                            Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => $request->branche_id,
                                'custody_type' => $request->custody_type,
                                'custody' => $due2,         
                            ]);
                            $temp = $due;
                        }elseif($due < 0){
                            Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => $request->branche_id,
                                'custody_type' => $request->custody_type,
                                'custody' => $temp,    
                            ]);
                            $temp = $due;
                        }
                    }
                }
            }
 

        }elseif($request->custody_type == '3'){
            $safe=SafeTransfer::where('to_branch_id',setting("account")['branch'])
                                ->where('accept',"Accept")
                                ->where('export','!=','Accept')
                                ->where('type','Outside')
                                ->get();
            

            if($request->custody > get_main_safe()){
                session()->flash('failed',__('Not Enough Cach in Main Safe'));

                return redirect()->back();
            }

            $temp = $request->custody ;
            foreach($safe as $item){
                $safeAmount =  $item->payments()->where('payment_method_id',setting("account")['payment'])->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$item->id)->sum('custody');
                
                if($safeAmount > 0){
                    $due        = $temp - $safeAmount;
                    $due2       = $temp - $due;
    
                    if($temp > 0 ){
                        if($due >= 0){
                            Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => $request->branche_id,
                                'custody_type' => $request->custody_type,
                                'custody' => $due2,         
                            ]);
                            $temp = $due;
                        }elseif($due < 0){
                            Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => $request->branche_id,
                                'custody_type' => $request->custody_type,
                                'custody' => $temp,    
                            ]);
                            $temp = $due;
                        }
                    }
                }
            }


        }elseif($request->custody_type == '1'){

            $safe=SafeTransfer::where('export','Accept')->first();

            Branches_custody::create([
                'priceable_type' => "App\Models\SafeTransfer",
                'priceable_id' => $safe->id,
                'branche_id' => $request->branche_id,
                'custody_type' => $request->custody_type,
                'custody' =>  $request->custody       
            ]);
        }elseif($request->custody_type == '2'){
            Branches_custody::create([
                'branche_id' => $request->branche_id,
                'custody_type' => $request->custody_type,
                'custody' =>  $request->custody       
            ]);
        }


        session()->flash('success',__('Branch created successfully'));

        return redirect()->route('admin.branches_custody.index');
    }

    public function edit($id)
    {
        $custody = Branches_custody::find($id);
        return view('admin.branch_custody.edit',compact('custody'));

    }
    public function update(Request $request, $id)
    {

        $custody = Branches_custody::find($id);
        $custody->update(['created_at' => $request->created_at]);

        return redirect()->route('admin.branches_custody.index');

    }

    public function accept($id)
    {
        $custody = Branches_custody::findOrFail($id);
        // $custody->status = 1;
        // $custody->save();

        if($custody->custody_type == '4'){

            $safe=SafeTransfer::where('to_branch_id',$custody->branche_id)
                                ->where('accept',"Accept")
                                ->where('export','!=','Accept')
                                ->whereHas('payments',function($q){return $q->where('amount','>',0);})
                                ->get();
            
            if($custody->custody > get_safe($custody->branche_id)){

                session()->flash('failed',__('Not Enough Cach in Safe Branch'));

                return redirect()->back();
            }
            

            $temp = $custody->custody ;
            foreach($safe as $item){
                $safeAmount =  $item->payments()->where('payment_method_id',setting("account")['payment'])->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$item->id)->sum('custody');
                
                if($safeAmount > 0){
                    $due        = $temp - $safeAmount;
                    $due2       = $temp - $due;
    
                    if($temp > 0 ){
                        if($due >= 0){
                            Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => $custody->branche_id,
                                'custody_type' => $custody->custody_type,
                                'custody' => $due2,         
                            ]);
                            $temp = $due;
                        }elseif($due < 0){
                            Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => $custody->branche_id,
                                'custody_type' => $custody->custody_type,
                                'custody' => $temp,    
                            ]);
                            $temp = $due;
                        }
                    }
                }
            }
            

        }elseif($custody->custody_type == '3'){
            $safe=SafeTransfer::where('to_branch_id',setting("account")['branch'])
                                ->where('accept',"Accept")
                                ->where('export','!=','Accept')
                                ->where('type','Outside')
                                ->get();
            

            if($custody->custody > get_main_safe()){
                session()->flash('failed',__('Not Enough Cach in Main Safe'));

                return redirect()->back();
            }

            $temp = $custody->custody ;
            foreach($safe as $item){
                $safeAmount =  $item->payments()->where('payment_method_id',setting("account")['payment'])->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$item->id)->sum('custody');
                
                if($safeAmount > 0){
                    $due        = $temp - $safeAmount;
                    $due2       = $temp - $due;
    
                    if($temp > 0 ){
                        if($due >= 0){
                            Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => $custody->branche_id,
                                'custody_type' => $custody->custody_type,
                                'custody' => $due2,         
                            ]);
                            $temp = $due;
                        }elseif($due < 0){
                            Branches_custody::create([
                                'priceable_type' => "App\Models\SafeTransfer",
                                'priceable_id' => $item->id,
                                'branche_id' => $custody->branche_id,
                                'custody_type' => $custody->custody_type,
                                'custody' => $temp,    
                            ]);
                            $temp = $due;
                        }
                    }
                }
            }

        }elseif($custody->custody_type == '1'){
            $safe=SafeTransfer::where('export','Accept')->first();
            
            Branches_custody::create([
                'priceable_type' => "App\Models\SafeTransfer",
                'priceable_id' => $safe->id,
                'branche_id' => $custody->branche_id,
                'custody_type' => $custody->custody_type,
                'custody' =>  $custody->custody       
            ]);

        }elseif($custody->custody_type == '2'){
            Branches_custody::create([
                'branche_id' => $custody->branche_id,
                'custody_type' => $custody->custody_type,
                'custody' =>  $custody->custody,
                'user_id' =>   $custody->user_id   
            ]);
        }

        $custody->delete();

        session()->flash('success',__('Accpect successfully'));

        return redirect()->back();
    }

    public function refuse($id)
    {
        $custody = Branches_custody::findOrFail($id);
        $custody->delete();

        session()->flash('success',__('Refuse successfully'));

        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $custody = Branches_custody::findOrFail($id);

        $custody->delete();

        session()->flash('success',__('Custoday deleted successfully'));

        return redirect()->route('admin.branches_custody.index');
    }

    public function bulk_delete(BulkActionRequest $request)
    {
        foreach($request['ids'] as $id)
        {
            $custody=Branches_custody::findOrFail($id);
            $custody->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.branches_custody.index');
    }

    public function transferToBank()
    {
        $branches = Branch::all();
        foreach($branches as $branch){

            if(get_custody_branch($branch->id) > 0){

                $safe = SafeTransfer::create([
                    'export' => 'Accept',
                    'accept' => 'Accept',
                    'type' => 'Outside',
                    'from_branch_id' => $branch->id,
                    'to_branch_id' => $branch->id,
                    'from_user_id' => auth()->guard('admin')->user()->id,
                    'to_user_id' => auth()->guard('admin')->user()->id,
                    'from_date' => get_system_date(),
                    'to_date' => get_system_date(),
                    'to_user_id' => auth()->guard('admin')->user()->id,
                ]);

                $safe->payments()->create([
                    'payment_method_id' => setting("account")['payment'],
                    'amount' => get_custody_branch($branch->id),
                ]);

                Branches_custody::create([
                    'branche_id' => $branch->id,
                    'custody_type' => 0,
                    'custody' => get_custody_branch($branch->id),
                    'status' => 1,
                    'user_id' => auth()->guard('admin')->user()->id
                ]);
            }
        }

        session()->flash('success',get_total_branches_custody() . __(' EGP  Transfer To Bank successfully'));

        return redirect()->back();
    }

    public function convertBranchSafeToVisa($id){
        
        $branchSafes = SafeTransfer::where('to_branch_id',$id)->where('accept',"Accept")->where('export','!=','Accept')->where('type','Inside')->get();

        foreach($branchSafes  as $branchSafe){
            $safes = $branchSafe->payments()->where('payment_method_id','!=',setting("account")['payment'])->get();
            foreach($safes as $safe){
                $amount = $safe->amount - ($safe->amount * 0.02);

                $safe->update(['amount' =>$amount , 'payment_method_id' => setting("account")['payment']]);
            }
        }

        session()->flash('success', __('Transfer successfully'));

        return redirect()->back();
       
    }
    public function convertMainSafeToVisa(){
        
        $mainSafes = SafeTransfer::where('to_branch_id',setting("account")['branch'])->where('accept',"Accept")->where('export','!=','Accept')->where('type','Outside')->get();

        foreach($mainSafes  as $mainSafe){
            $safes = $mainSafe->payments()->where('payment_method_id','!=',setting("account")['payment'])->get();
            foreach($safes as $safe){
                $amount = $safe->amount - ($safe->amount * 0.02);

                $safe->update(['amount' =>$amount , 'payment_method_id' => setting("account")['payment']]);
            }
        }

        session()->flash('success', __('Transfer successfully'));

        return redirect()->back();
       
    }
    public function convertBankToVisa(){
        
        $banks = SafeTransfer::where('export','Accept')->get();

        foreach($banks  as $bank){
            $safes = $bank->payments()->where('payment_method_id','!=',setting("account")['payment'])->get();
            foreach($safes as $safe){
                $amount = $safe->amount - ($safe->amount * 0.02);

                $safe->update(['amount' =>$amount , 'payment_method_id' => setting("account")['payment']]);
            }
        }

        session()->flash('success', __('Transfer successfully'));

        return redirect()->back();
       
    }
}
