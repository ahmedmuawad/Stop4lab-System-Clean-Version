<?php



namespace App\Http\Controllers\Admin;



use Excel;

use App\Models\Test;

use App\Models\User;

use App\Models\Group;

use App\Models\Branch;

use App\Models\Doctor;

use App\Models\Culture;

use App\Models\Expense;

use App\Models\Package;

use App\Models\Product;

use App\Models\Contract;

use App\Models\Employee;

use App\Models\Purchase;

use App\Models\Supplier;

use App\Models\GroupPayment;

use Illuminate\Http\Request;

use App\Models\PaymentMethod;

use Illuminate\Support\Carbon;

use App\Models\PurchasePayment;

use App\Models\PurchaseProduct;

use App\Models\TransferProduct;

use App\Models\EmployeeSchedule;

use App\Models\AdjustmentProduct;

use App\Models\EmployeeViolation;

use App\Models\ProductConsumption;

use Illuminate\Support\Facades\DB;

use App\Exports\BranchProductExport;
use App\Http\Controllers\Controller;
use App\Models\Branches_custody;

class ReportsController extends Controller

{

    /**

     * assign roles

     */

    public function __construct()

    {

        $this->middleware('can:view_accounting_report',     ['only' => ['accounting']]);

        $this->middleware('can:view_doctor_report',     ['only' => ['doctor']]);

        $this->middleware('can:view_inventory_report',     ['only' => ['inventory']]);

        $this->middleware('can:view_supplier_report',     ['only' => ['supplier']]);

        $this->middleware('can:view_hr',     ['only' => ['employee']]);

    }





    /**

     * accounting report

     *

     * @return \Illuminate\Http\Response

     */

    public function accounting(Request $request)

    {

        if($request->has('date'))

        {

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));


            //filter branches

            $branches=[];

            if($request->has('branches'))

            {
                $requestBranches = $request['branches'];

            }else{
                $user = User::find(auth()->guard('admin')->user()->id);
                $branchIds = [];
                foreach($user->branches as $branch){
                    $branchIds[] = $branch->branch_id;
                }
                $requestBranches = $branchIds;
            }

            //balance

            $payment_methods=PaymentMethod::all();

            foreach($payment_methods as $payment_method)

            {
                // if($request->has('branches')){
                    //income
                    $payment_method['income'] = 
                    
                    ($from==$to)?
                    GroupPayment::whereHas('group', function($q)use($requestBranches){
                        return $q->whereIn('branch_id',$requestBranches);
                    })->whereDate('date',$from)->where('payment_method_id',$payment_method['id'])
                    ->sum('amount')
                    :
                    GroupPayment::whereHas('group', function($q)use($requestBranches){
                        return $q->whereIn('branch_id',$requestBranches);
                    })->whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->sum('amount')
                    ;

                    $payment_method['expense']=($from==$to)?Expense::whereDate('date',$from)->where('payment_method_id',$payment_method['id'])->whereIn('branch_id',$requestBranches)->sum('amount'):Expense::whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->whereIn('branch_id',$requestBranches)->sum('amount');
                    if($payment_method['id'] == '1'){
                        $payment_method['custody']=($from==$to)? Branches_custody::where('custody_type','2')->where('status','1')->whereDate('created_at',$from)->whereIn('branche_id',$requestBranches)->sum('custody') : Branches_custody::where('custody_type','2')->where('status','1')->whereBetween('created_at',[$from,$to])->whereIn('branche_id',$requestBranches)->sum('custody');
                    }else{
                        $payment_method['custody']=0;
                    }

                // }else{
                //     $payment_method['income']=($from==$to)?GroupPayment::whereDate('date',$from)->where('payment_method_id',$payment_method['id'])->sum('amount'):GroupPayment::whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->sum('amount');
                //     $payment_method['expense']=($from==$to)?Expense::whereDate('date',$from)->whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->sum('amount'):Expense::whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->sum('amount');
                //     $payment_method['custody']=($from==$to)? Branches_custody::where('custody_type','2')->where('status','1')->whereDate('created_at',$from)->whereIn('branch_id',$requestBranches)->sum('custody') : Branches_custody::where('custody_type','2')->where('status','1')->whereBetween('created_at',[$from,$to])->whereIn('branch_id',$requestBranches)->sum('custody');

                // }


                $payment_method['balance']=$payment_method['income'] - $payment_method['custody'] ;

            }



            //select groups of date between

            $groups=($from==$to)?Group::with('patient','doctor')->whereDate('created_at',$from):Group::with('patient','doctor')->whereBetween('created_at',[$from,$to]);



            //payments

            $payments=($from==$to)?GroupPayment::with('group.patient','group.doctor','group.normalDoctor','group.contract','group.all_tests.test','group.all_cultures.culture')->whereDate('date',$from):GroupPayment::with('group.patient','group.doctor','group.normalDoctor','group.contract','group.all_tests.test','group.all_cultures.culture')->whereBetween('date',[$from,$to]);



            //expenses

            $expenses=($from==$to)?Expense::whereDate('date',$from):Expense::whereBetween('date',[$from,$to]);



            //purchase payment

            $purchase_payments=($from==$to)?PurchasePayment::whereDate('date',$from):PurchasePayment::whereBetween('date',[$from,$to]);


            // custody from vault

            $custody =($from==$to)? Branches_custody::where('custody_type','2')->where('status','1')->whereDate('created_at',$from) : Branches_custody::where('custody_type','2')->where('status','1')->whereBetween('created_at',[$from,$to]);

            // end custody from vault
           

            //filter doctors

            $doctors=[];

            if($request->has('doctors'))

            {

                $groups->whereIn('doctor_id',$request['doctors']);



                $doctors=Doctor::whereIn('id',$request['doctors'])->get();

            }



            //filter tests

            $tests=[];

            if($request->has('tests'))

            {

                $groups->whereHas('tests',function($q)use($request){

                    return $q->whereIn('test_id',$request['tests']);

                });



                $tests=Test::whereIn('id',$request['tests'])->get();

            }



            //filter cultures

            $cultures=[];

            if($request->has('cultures'))

            {

                $groups->whereHas('cultures',function($q)use($request){

                    return $q->whereIn('culture_id',$request['cultures']);

                });



                $cultures=Culture::whereIn('id',$request['cultures'])->get();

            }



            //filter packages

            $packages=[];

            if($request->has('packages'))

            {

                $groups->whereHas('packages',function($q)use($request){

                    return $q->whereIn('package_id',$request['packages']);

                });



                $packages=Package::whereIn('id',$request['packages'])->get();

            }





            $groups->whereIn('branch_id',$requestBranches);



            $payments->whereHas('group',function($query)use($requestBranches){

                return $query->whereIn('branch_id',$requestBranches);

            });





            $expenses->whereIn('branch_id',$requestBranches);

            



            $purchase_payments->whereHas('purchase',function($query)use($requestBranches){

                return $query->whereIn('branch_id',$requestBranches);

            });



            $branches=Branch::whereIn('id',$requestBranches)->get();



            //filter contracts

            $contracts=[];

            if($request->has('contracts'))

            {

                $groups->whereIn('contract_id',$request['contracts']);



                $contracts=Contract::whereIn('id',$request['contracts'])->get();

            }

            //filter labs

            $labs=[];

            if($request->has('labs'))

            {

                $groups->whereIn('user_id',$request['labs']);



                $labs=User::whereIn('id',$request['labs'])->get();

            }

            //filter reps

            $reps=[];

            if($request->has('reps'))

            {

                $groups->whereIn('rep_id',$request['reps']);



                $reps=User::whereIn('id',$request['reps'])->get();

            }


            // summary of branches
            $branchSummary = $groups->get()->groupBy('branch_id')->all();
            foreach($branchSummary  as $key => $branch){

                $branchModel = Branch::find($key);
                $branchExpenses = ($from==$to)?Expense::whereDate('date',$from)->where('branch_id',$branchModel->id)->sum('amount'):Expense::whereBetween('date',[$from,$to])->where('branch_id',$branchModel->id)->sum('amount');
                $branchCustody = ($from==$to)? Branches_custody::where('custody_type','2')->where('status','1')->whereDate('created_at',$from)->where('branche_id',$branchModel->id)->sum('custody') : Branches_custody::where('custody_type','2')->where('status','1')->whereBetween('created_at',[$from,$to])->where('branche_id',$branchModel->id)->sum('custody');
                $payment_methods_branch=PaymentMethod::all();

                foreach($payment_methods_branch as $payment_method){
                    $payment_method->income = ($payment_method['id'] == '1')? get_payments_cach($branchCustody,$from,$to,$branchModel['id']) : get_payments_income($from,$to,$branchModel['id'],$payment_method['id']) ;
                }

                $branch->paid = $payment_methods_branch;
                $branch->name = $branchModel->name ;
                $branch->total = $branch->sum('total');
                $branch->due = $branch->sum('due');
                $branch->expenses = $branchExpenses;
                $branch->branchCustody = $branchCustody;
                $branch->totalPaid = $branch->paid->sum('income') + $branchCustody ;

                $branch->custody = $branch->totalPaid - $branchCustody;


            }
            // summary of branches


            
            



            $groups=$groups->get();

            // groups of due
            $groupsDue = $groups->where('due','>','0');
            // $groupsDue = $groupsDue->get();
            // groups of due

            // groups of Delay
            $groupsDelay = $groups->where('delayed_money','>','0');
            // $groupsDelay = $groupsDelay->get();
            // groups of Delay
            $purchase_payments=$purchase_payments->get();


            $expenses=$expenses->get();



            if( $request->ray_status == 1 ){ // without rays
                $groups=$groups->reject(function ($group) {
                    return count($group->rays);
                });
                $groupIds = [];
                foreach($groups as $group){
                    array_push($groupIds,$group->id);
                }
                foreach($payment_methods as $payment_method)
                {
                    //income
                    $payment_method['income'] = GroupPayment::whereHas('group', function($q)use($groupIds){
                        return $q->whereIn('id',$groupIds);
                    })
                    ->where('payment_method_id',$payment_method['id'])
                    ->sum('amount');

                    if($request->has('branches')){
                        $payment_method['expense']=($from==$to)?Expense::whereDate('date',$from)->where('payment_method_id',$payment_method['id'])->whereIn('branch_id',$request['branches'])->sum('amount'):Expense::whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->whereIn('branch_id',$request['branches'])->sum('amount');
                    }else{
                        $payment_method['expense']=($from==$to)?Expense::whereDate('date',$from)->whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->sum('amount'):Expense::whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->sum('amount');
                    }
                    $payment_method['balance']=$payment_method['income']-$payment_method['expense'];
                }

                // payments

                // $payments->whereHas('group',function($query)use($groupIds){

                //     return $query->whereIn('id',$groupIds);

                // });
            }

            if( $request->ray_status == 0 ){ // only rays
                $groups=$groups->filter(function ($group) {
                    return count($group->rays);
                });
                $groupIds = [];
                foreach($groups as $group){
                    array_push($groupIds,$group->id);
                }
                foreach($payment_methods as $payment_method)

                {
                    //income
                    $payment_method['income'] = GroupPayment::whereHas('group', function($q)use($groupIds){
                        return $q->whereIn('id',$groupIds);
                    })
                    ->where('payment_method_id',$payment_method['id'])
                    ->sum('amount');

                    if($request->has('branches')){
                        $payment_method['expense']=($from==$to)?Expense::whereDate('date',$from)->where('payment_method_id',$payment_method['id'])->whereIn('branch_id',$request['branches'])->sum('amount'):Expense::whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->whereIn('branch_id',$request['branches'])->sum('amount');
                    }else{
                        $payment_method['expense']=($from==$to)?Expense::whereDate('date',$from)->whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->sum('amount'):Expense::whereBetween('date',[$from,$to])->where('payment_method_id',$payment_method['id'])->sum('amount');
                    }
                    $payment_method['balance']=$payment_method['income']-$payment_method['expense'];
                }

                // payments

                $payments->whereHas('group',function($query)use($groupIds){

                    return $query->whereIn('id',$groupIds);

                });
            }

            $payments=$payments->get();



            //make accounting

            $total=0;
            $cost=0;

            // $paid=$total_income;
            $paid=$payments->sum('amount');

            $due=0;

            $total_expenses=$expenses->sum('amount');

            $total_purchases=$purchase_payments->sum('amount');

            $delayed_money = 0;

            foreach($groups as $group)

            {

                $total+=$group['total'];
                $delayed_money+=$group['delayed_money'];
                $cost+=$group['cost'];
                $due+=$group['due'];

            }

            
            // total custody 
            $totalCustody = $custody->whereIn('branche_id',$requestBranches)->sum('custody');
            $custody = $paid - $totalCustody;

             

            //profit

            $profit=$paid-$total_expenses-$total_purchases;


            //total after cost

            $total_after_cost=$total - $cost;



            //old date

            $input_date=$request['date'];


            //ray status

            $ray_status = $request['ray_status'];

            if($request->has('pdf'))

            {
                $branches= ($request->has('branches')) ? Branch::whereIn('id',$request['branches'])->get() : Branch::get() ;

                $pdf=generate_pdf(compact(

                    'from',

                    'to',

                    'delayed_money',

                    'branchSummary',

                    'tests',

                    'cultures',

                    'packages',

                    'branches',

                    'doctors',

                    'input_date',

                    'groups',

                    'custody',

                    'payments',

                    'expenses',

                    'purchase_payments',

                    'total',

                    'paid',

                    'due',

                    'total_expenses',

                    'total_purchases',
                    
                    'totalCustody',

                    'profit',

                    'ray_status',

                    'payment_methods',

                    'groupsDelay',

                    'groupsDue'

                ),3);



                return redirect($pdf);

            }





            return view('admin.reports.accounting',compact(

                'from',

                'to',

                'contracts',

                'delayed_money',

                'branchSummary',

                'labs',

                'reps',

                'tests',

                'cultures',

                'packages',

                'branches',

                'doctors',

                'input_date',

                'groups',

                'custody',

                'payments',

                'expenses',

                'purchase_payments',

                'total',

                'paid',

                'due',

                'cost',

                'total_expenses',

                'total_purchases',

                'totalCustody',

                'profit',

                'total_after_cost',

                'ray_status',

                'payment_methods',
                
                'groupsDelay',

                'groupsDue'

            ));

        }



        return view('admin.reports.accounting');

    }

    /**
     * doctors report
     *
     * @return \Illuminate\Http\Response
     */

    public function doctor(Request $request)
    {
        if($request->has('date'))
        {
            //format date

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));



            //select groups of date between

            $groups=($from==$to)?Group::with('patient','doctor')->whereDate('created_at',$from):Group::with('patient','doctor')->whereBetween('created_at',[$from,$to]);

            //payments

            $payments=($from==$to)?Expense::with('category')->whereDate('date',$from)->where('doctor_id',$request['doctor_id'])->get():Expense::with('category')->whereBetween('date',[$from,$to])->where('doctor_id',$request['doctor_id'])->get();



            //filter doctors

            if($request->has('doctor_id'))

            {

                $groups->where('doctor_id',$request['doctor_id']);



                $doctor=User::find($request['doctor_id']);

            }



            $groups=$groups->get();



            //make accounting

            $total=0; $paid=0; $due=0;



            $total+=$groups->sum('doctor_commission');

            $paid+=$payments->sum('amount');

            $due=$total-$paid;



            //old date

            $input_date=$request['date'];



            if($request->has('pdf'))

            {

                $pdf=generate_pdf(compact(

                    'from',

                    'to',

                    'doctor',

                    'input_date',

                    'groups',

                    'payments',

                    'total',

                    'paid',

                    'due',

                ),4);

                return redirect($pdf);
            }



            return view('admin.reports.doctor',compact(

                'from',

                'to',

                'doctor',

                'input_date',

                'groups',

                'payments',

                'total',

                'paid',

                'due',

            ));

        }

        return view('admin.reports.doctor');

    }
    public function normal_doctor(Request $request)
    {
        if($request->has('date'))
        {
            //format date

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));



            //select groups of date between

            $groups=($from==$to)?Group::with('patient','doctor')->whereDate('created_at',$from):Group::with('patient','doctor')->whereBetween('created_at',[$from,$to]);

            //payments

            // $payments=($from==$to)?GroupPayment::whereDate('date',$from):GroupPayment::whereBetween('date',[$from,$to]);

            $payments=($from==$to)?Expense::with('category')->whereDate('date',$from)->where('doctor_id',$request['doctor_id'])->get():Expense::with('category')->whereBetween('date',[$from,$to])->where('doctor_id',$request['doctor_id'])->get();



            //filter doctors

            if($request->has('normal_doctor_id'))

            {

                $groups->where('normal_doctor_id',$request['normal_doctor_id']);



                $doctor=Doctor::find($request['normal_doctor_id']);

            }



            $groups=$groups->get();


            //make accounting

            $total=0; $paid=0; $due=0;



            $total+=$groups->sum('total');

            $paid+=$groups->sum('paid');

            $due=$total-$paid;



            //old date

            $input_date=$request['date'];



            if($request->has('pdf'))

            {

                $pdf=generate_pdf(compact(

                    'from',

                    'to',

                    'doctor',

                    'input_date',

                    'groups',

                    'payments',

                    'total',

                    'paid',

                    'due',

                ),4);

                return redirect($pdf);
            }



            return view('admin.reports.normal_doctor',compact(

                'from',

                'to',

                'doctor',

                'input_date',

                'groups',

                'payments',

                'total',

                'paid',

                'due',

            ));

        }

        return view('admin.reports.normal_doctor');

    }



    public function supplier(Request $request)

    {

        if($request->has('date'))

        {

            //format date

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));



            //select purchases of date between

            $purchases=($from==$to)?Purchase::whereDate('date',$from):Purchase::whereBetween('date',[$from,$to]);

            $payments=($from==$to)?PurchasePayment::whereDate('date',$from):PurchasePayment::whereBetween('date',[$from,$to]);



            //filter doctors

            if($request->has('supplier_id'))

            {

                $purchases->where('supplier_id',$request['supplier_id']);

                $payments->whereHas('purchase',function($query)use($request){

                    return $query->where('supplier_id',$request['supplier_id']);

                });



                $supplier=Supplier::find($request['supplier_id']);

            }



            $purchases=$purchases->get();

            $payments=$payments->get();



            //summary

            $total=$purchases->sum('total');

            $paid=$payments->sum('amount');

            $due=$total-$paid;



            //old date

            $input_date=$request['date'];



            if($request->has('pdf'))

            {

                $pdf=generate_pdf(compact(

                    'from',

                    'to',

                    'supplier',

                    'input_date',

                    'purchases',

                    'payments',

                    'total',

                    'paid',

                    'due',

                ),5);



                return redirect($pdf);

            }



            return view('admin.reports.supplier',compact(

                'from',

                'to',

                'supplier',

                'input_date',

                'purchases',

                'payments',

                'total',

                'paid',

                'due',

            ));

        }

        return view('admin.reports.supplier');

    }



    public function purchase(Request $request)

    {

        if($request->has('date'))

        {

            //format date

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));



            //select purchases of date between

            $purchases=($from==$to)?Purchase::whereDate('date',$from):Purchase::whereBetween('date',[$from,$to]);

            $payments=($from==$to)?PurchasePayment::whereDate('date',$from):PurchasePayment::whereBetween('date',[$from,$to]);



            //filter branch

            $branches=[];

            if($request->has('branch_id'))

            {

                $purchases->whereIn('branch_id',$request['branch_id']);

                $payments->whereHas('purchase',function($query)use($request){

                    return $query->whereIn('branch_id',$request['branch_id']);

                });

                $branches=Branch::whereIn('id',$request['branch_id'])->get();

            }



            //filter supplier

            $suppliers=[];

            if($request->has('supplier_id'))

            {

                $purchases->whereIn('supplier_id',$request['supplier_id']);

                $payments->whereHas('purchase',function($query)use($request){

                    return $query->whereIn('supplier_id',$request['supplier_id']);

                });

                $suppliers=Supplier::whereIn('id',$request['supplier_id'])->get();

            }



            $purchases=$purchases->get();

            $payments=$payments->get();



            //summary

            $total=$purchases->sum('total');

            $paid=$payments->sum('amount');

            $due=$total-$paid;



            //old date

            $input_date=$request['date'];



            if($request->has('pdf'))

            {



                $pdf=generate_pdf(compact(

                    'from',

                    'to',

                    'input_date',

                    'purchases',

                    'payments',

                    'total',

                    'paid',

                    'due',

                ),6);



                return redirect($pdf);

            }





            return view('admin.reports.purchase',compact(

                'from',

                'to',

                'input_date',

                'purchases',

                'payments',

                'branches',

                'suppliers',

                'total',

                'paid',

                'due',

            ));

        }

        return view('admin.reports.purchase');

    }



    public function inventory(Request $request)

    {

        if($request->has('date'))

        {

            //format date

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));



            //select purchases of date between

            if($from==$to)

            {

                $purchase_products=PurchaseProduct::whereHas('purchase',function($query)use($from){

                    return $query->whereDate('date',$from);

                });

            }

            else{

                $purchase_products=PurchaseProduct::whereHas('purchase',function($query)use($from,$to){

                    return $query->whereBetween('date',[$from,$to]);

                });

            }



            //select adjustments of date between

            if($from==$to)

            {

                $adjustment_products=AdjustmentProduct::whereHas('adjustment',function($query)use($from){

                    return $query->whereDate('date',$from);

                });

            }

            else{

                $adjustment_products=AdjustmentProduct::whereHas('adjustment',function($query)use($from,$to){

                    return $query->whereBetween('date',[$from,$to]);

                });

            }



            //select transfers of date between

            if($from==$to)

            {

                $transfer_products=TransferProduct::whereHas('transfer',function($query)use($from){

                    return $query->whereDate('date',$from);

                });

            }

            else{

                $transfer_products=TransferProduct::whereHas('transfer',function($query)use($from,$to){

                    return $query->whereBetween('date',[$from,$to]);

                });

            }



            //select consumption of date between

            if($from==$to)

            {

                $consumption_products=ProductConsumption::whereDate('created_at',$from);

            }

            else{

                $consumption_products=ProductConsumption::whereBetween('created_at',[$from,$to]);

            }



            //filter branch

            $branches=[];

            if($request->has('branch_id'))

            {

                $purchase_products->whereIn('branch_id',$request['branch_id']);//filter purchases by branch

                $adjustment_products->whereIn('branch_id',$request['branch_id']);//filter adjustment by branch

                $transfer_products->where(function($query)use($request){

                    return $query->whereIn('from_branch_id',$request['branch_id'])

                                 ->orWhereIn('to_branch_id',$request['branch_id']);

                });//filter transfer by branch

                $consumption_products->whereIn('branch_id',$request['branch_id']);//filter consumption by branch

                $branches=Branch::whereIn('id',$request['branch_id'])->get();//get branches

            }



            $purchase_products=$purchase_products->get();

            $adjustment_products=$adjustment_products->get();

            $transfer_products=$transfer_products->get();

            $consumption_products=$consumption_products->get();



            //old date

            $input_date=$request['date'];



            return view('admin.reports.inventory',compact(

                'from',

                'to',

                'input_date',

                'purchase_products',

                'adjustment_products',

                'transfer_products',

                'consumption_products',

                'branches',

            ));

        }

        return view('admin.reports.inventory');

    }



    public function product(Request $request)

    {

        if($request->has('generate'))

        {

            $branches=($request->has('branch_id'))?Branch::whereIn('id',$request['branch_id'])->get():Branch::all();



            foreach($branches as $branch)

            {

                $products=($request->has('product_id'))?Product::whereIn('id',$request['product_id'])->get():$products=Product::all();



                $branch_products=[];

                foreach($products as $product)

                {

                    $initial=$product->branches()->where('branch_id',$branch['id'])->sum('initial_quantity');

                    $purchases=$product->purchases()->where('branch_id',$branch['id'])->sum('quantity');

                    $in=$product->adjustments()->where('type',1)->where('branch_id',$branch['id'])->sum('quantity');

                    $out=$product->adjustments()->where('type',2)->where('branch_id',$branch['id'])->sum('quantity');

                    $transfers_from=$product->transfers()->where('from_branch_id',$branch['id'])->sum('quantity');

                    $transfers_to=$product->transfers()->where('to_branch_id',$branch['id'])->sum('quantity');

                    $consumptions=$product->consumptions()->where('branch_id',$branch['id'])->sum('quantity');



                    $stock_quantity=$initial+$purchases+$in+$transfers_to-$out-$transfers_from-$consumptions;



                    $branch_products[]=['product'=>$product,'quantity'=>$stock_quantity];

                    $branch['products']=$branch_products;

                }

            }



            $report_branches=$branches;



            return view('admin.reports.product',compact('report_branches','products'));

        }



        return view('admin.reports.product');

    }



    public function branch_products(Request $request)

    {

        ob_end_clean(); // this

        ob_start(); // and this

        return Excel::download(new BranchProductExport, 'branch_products.xlsx');

    }





    public function employee(Request $request)

    {

        $employees = Employee::with('user')->get();

                    // format date

        if($request->has('date'))

        {

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));





            $attendace = EmployeeSchedule::groupBy('employee_id')

                                            ->select('*',DB::raw('SUM(work_mins) as total_time'),DB::raw('COUNT(employee_id) as work_days'),DB::raw('SUM(over_time) as overTime'))

                                            ->with('employee','employee.weekends','employee.violation','employee.user','employee.user.roles.role')

                                            ->whereBetween('start_shift',[$from,$to])

                                            ->whereNotNull('end_shift')

                                            ->get();



            foreach($attendace as $item){
                $empViolation = $item->employee->violation->whereBetween('created_at',[$from,$to]);
                // dd($empViolation);
                $empViolation = ($empViolation->isNotEmpty())? ($empViolation->sum('violation')) : 0;
                $item->daysViolations = ($empViolation / $item->employee->works_mins);
                $item->daySalary = $item->employee->salary / 30;
                $item->hourSalary = ($item->daySalary) / ($item->employee->works_mins / 60);
                $item->poundViolations = ($empViolation / 60) * $item->hourSalary ;
                $item->overTimeHours = $item->overTime / 60 ;
                $item->overTimePound = ($item->overTimeHours * $item->employee->over_time ) * $item->hourSalary ;
                $item->weekends = $item->employee->weekends;
                $item->job = (isset($item->employee->user->roles[0]->role->name))? $item->employee->user->roles[0]->role->name : '';
            }

            foreach($attendace as $item){
                $empVocation = $item->employee->vocation->whereBetween('created_at',[$from,$to]) ;//->sum('vocation');
                $empVocation = ($empVocation->isNotEmpty())? ($empVocation->sum('vocation')) : 0;
                $item->freeDays = (int)(count($item->weekends) * ($item->work_days / (7-count($item->weekends)))) ;
                $item->PoundVocations = (($empVocation / $item->employee->works_mins) + $item->freeDays) * $item->daySalary  ;
                $item->dayVocations = ($empVocation / $item->employee->works_mins) + $item->freeDays;
            }



            foreach($attendace as $item){

                if($item->employee->violation_status == 1){

                    $item->totalSalary = ((int)(($item->total_time - $item->overTime) / 60) * $item->hourSalary) - ($item->poundViolations) + ($item->PoundVocations) + ($item->overTimePound)  ;

                }else{

                    $item->totalSalary = ($item->work_days * $item->daySalary) - ($item->poundViolations) + ($item->PoundVocations) + ($item->overTimePound);

                }

            }









            $total = $attendace->sum('totalSalary');

            $paid = $employees->sum('salary');

            $vio = $paid - $total;





        //    dd($attendace);



            $input_date=$request['date'];



            if($request->has('pdf'))

            {

                $pdf=generate_pdf(compact(

                    'from',

                    'to',

                    'input_date',

                    'attendace',

                    'total',

                    'paid',

                    'vio',

                    'employees'

                ),5);



                return redirect($pdf);

            }



            if($request->has('employee_id')){

                $employeeTable = EmployeeSchedule::with('employee','employee.weekends','employee.user')

                                                ->where('employee_id',$request->employee_id)

                                                ->whereBetween('start_shift',[$from,$to])

                                                ->get();

                return view('admin.reports.employee',compact(

                    'from',

                    'to',

                    'input_date',

                    'attendace',

                    'total',

                    'paid',

                    'vio',

                    'employees',

                    'employeeTable'

                ));

            }



            return view('admin.reports.employee',compact(

                'from',

                'to',

                'input_date',

                'attendace',

                'total',

                'vio',

                'paid',

                'employees'

            ));

         }





        return view('admin.reports.employee',compact('employees'));

    }



    public function labReports(Request $request) {



        $labs_users = User::where('user_type','!=', 'representative')->where('government_id', '!=', null)->where('region_id', '!=', null)->get();

        $reps_users = User::where('user_type', 'representative')->latest()->get();

        $labs = User::where('user_type','!=', 'representative')->where('government_id', '!=', null)->where('region_id', '!=', null)->paginate(12);



        if($request->has('date'))

        {

            //format date

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));





            //select groups of date between

            $labs =($from==$to) ?

                User::where('user_type','!=', 'representative')->where('government_id', '!=', null)->where('region_id', '!=', null)->whereDate('created_at',$from)->paginate(12) :

                User::where('user_type','!=', 'representative')->where('government_id', '!=', null)->where('region_id', '!=', null)->whereBetween('created_at',[$from,$to])->paginate(12);

        }

        return view('admin.medical_reports.lab', compact('labs', 'labs_users', 'reps_users'));

    }



    public function representativeReports(Request $request) {

        $labs_users = User::where('user_type','!=', 'representative')->where('government_id', '!=', null)->where('region_id', '!=', null)->get();

        $reps_users = User::where('user_type', 'representative')->latest()->get();

        $reps = User::where('user_type', 'representative')->latest()->paginate(12);



        if($request->has('date'))

        {

            //format date

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));





            //select groups of date between

            $reps =($from==$to) ?

                User::where('user_type', 'representative')->whereDate('created_at',$from)->paginate(12) :

                User::where('user_type', 'representative')->whereBetween('created_at',[$from,$to])->paginate(12);

        }





        return view('admin.medical_reports.rep', compact('reps', 'labs_users', 'reps_users'));

    }


    public function contract(Request $request) {


        $contracts = Contract::get();

        if($request->has('date'))

        {

            $contractId = ($request->has('contract')) ? $request->contract : []; 

            //format date
            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

            





            //select groups of date between


            $testsIds = [];
            $groups = Group::with('all_tests')->whereIn('contract_id',$contractId)->whereBetween('created_at',[$from,$to])->get();

            foreach($groups as $group ){
                foreach($group->all_tests as $test){
                    if(!in_array($test->test_id,$testsIds)){
                        array_push($testsIds,$test->test_id);
                    }
                }
            }            
            
            $tests = Test::whereIn('id',$testsIds)->get();

            foreach($tests as $test){
                $test->testCount = $test->groups()->whereHas('group',function($g)use($contractId){$g->whereIn('contract_id',$contractId); })->whereBetween('created_at',[$from,$to])->count();
            }

            $contractSelected =  $request->contract;

            return view('admin.reports.contract', compact('contracts','tests','contractSelected'));

        }




        

        return view('admin.reports.contract', compact('contracts'));

    }

    public function delayedMoney(Request $request)
    {
        if($request->has('date')) {
            //format date
            $date=explode('-',$request['date']);
            $from=date('Y-m-d',strtotime($date[0]));
            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

            //select groups of date between
            $groups=($from==$to)?Group::with('patient','doctor')->whereDate('created_at',$from):Group::with('patient','doctor')->whereBetween('created_at',[$from,$to]);

            //filter branches
            $branches=[];
            if($request->has('branches')) {
                $groups->whereIn('branch_id',$request['branches']);
                $branches=Branch::whereIn('id',$request['branches'])->get();
            }

            $labs=[];
            if($request->has('labs')) {
                $groups->whereIn('user_id',$request['labs']);
                $labs=User::where('type', 'lab')->whereIn('id',$request['labs'])->get();
            }


            //filter contracts
            $contracts=[];
            if($request->has('contracts')) {
                $groups->whereIn('contract_id',$request['contracts']);
                $contracts=Contract::whereIn('id',$request['contracts'])->get();
            }

            $groups=$groups->where('delayed_money', '!=', 0)->get();

            //make accounting

            $total=0;
            foreach($groups as $group)
            {
                $total+=$group['delayed_money'];
            }


            //old date
            $input_date=$request['date'];

            if($request->has('pdf')) {
                $pdf=generate_pdf(compact(

                    'from',
                    'to',
                    'branches',
                    'input_date',
                    'groups',
                    'total'
                ),3);
                return redirect($pdf);
            }

            return view('admin.reports.delayed_money',compact(
                'from',
                'to',
                'contracts',
                'branches',
                'labs',
                'input_date',
                'groups',
                'total'
            ));

        }

        return view('admin.reports.delayed_money');

    }

}

