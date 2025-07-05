<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Cash_in_vault;
use App\Models\Vault_payment;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Branches_custody;
use Yajra\DataTables\Facades\DataTables;

class CashVaultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $toDay;
    public $now;

    public function __construct()
    {
        $this->toDay = Carbon::today();
        $this->now = Carbon::now()->timezone('Africa/Cairo');
        $this->middleware('can:view_vault',     ['only' => ['index', 'ajax']]);
        $this->middleware('can:create_vault',   ['only' => ['create','store']]);
    }
    public function index()
    {
        return view('admin.vault.index');
    }

        /**
     * get antibiotics datatable
     *
     * @access public
     * @var  @Request $request
     */
    public function ajax(Request $request)
    {
        $model=Cash_in_vault::query()->with('payments','user','branch');

        return DataTables::eloquent($model)
        ->addColumn('cash',function($vault){
            return view('admin.vault._payment',compact('vault'));
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
        $vault = Cash_in_vault::where('branche_id',session('branch_id'))
        ->where('user_id',auth()->guard('admin')->user()->id)
        ->where('created_at','>=',$this->toDay)
        ->latest()
        ->first();

        return view('admin.vault.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $amount = 0;
        if($request->has('payments')){
            foreach($request->payments as $payment){
                $amount += $payment['amount'];
            }
        }

        if($request->type == 0){
            $vault = Cash_in_vault::where('branche_id',session('branch_id'))
                                    ->where('user_id',auth()->guard('admin')->user()->id)
                                    ->where('created_at','>=',$this->toDay)
                                    ->whereNotNull('start_date')
                                    ->latest()
                                    ->first();
            if($vault){
                session()->flash('failed',__("You Recipte $vault->begin_cash EGP This Day , You Shoud Export "));

                return redirect()->back();
            }
            $vault = new Cash_in_vault();
            $vault->start_date = now();
            $vault->begin_cash = $amount;
            $vault->user_id = auth()->guard('admin')->user()->id;
            $vault->branche_id = session('branch_id');
            

        }else{
            $vault = Cash_in_vault::where('branche_id',session('branch_id'))
                                    ->where('user_id',auth()->guard('admin')->user()->id)
                                    ->latest()
                                    ->first();
            if($vault){
                $vault->end_date = now();
                $vault->end_cash = $amount;
                if ($request->has('payments')) {
                    foreach ($request['payments'] as $payment) {
                        if($payment['payment_method_id'] == '1' && $payment['amount'] != get_cash_vault() ){
                            session()->flash('resulte', "This Money is not Equal Cach");
                            $vault->notes = "Export Monay = ".$payment['amount']." EGP & Cash In Vault = " . get_cash_vault() . " EGP" ;
                        }
                    }
                }
            }

        }



        $vault->save();

        // $vaultPayment = new Vault_payment();

        //payments

        if ($request->has('payments')) {
            foreach ($request['payments'] as $payment) {
                $vault->payments()->create([
                    'payment_method_id' => $payment['payment_method_id'],
                    'amount' => $payment['amount'],
                    'vault_type' => $request->type,
                ]);
            }
        }
        
        

        session()->flash('success',__('created successfully'));

        return redirect()->back();
    }


    public function custody(Request $request)
    {
        $custody = new Branches_custody();

        $custody->branche_id = session('branch_id');
        $custody->custody_type = 2;
        $custody->custody = $request->custody;
        $custody->status = 0;
        $custody->user_id = auth()->guard('admin')->user()->id;

        $custody->save();

        session()->flash('success',__('Request successfully'));

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
