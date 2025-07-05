<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\User;
use App\Models\Group;
use App\Models\Branch;
use App\Models\Expense;
use App\Models\Setting;
use App\Models\Contract;
use App\Models\GroupTest;
use App\Models\Government;
use App\Models\GroupCulture;
use App\Models\GroupPackage;
use App\Models\GroupPayment;
use App\Models\SafeTransfer;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Carbon;
use App\Models\ExpenseCategory;
use App\Models\Branches_custody;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportsDetialsController extends Controller
{

    public function __construct()

    {


        $this->middleware('can:view_accounting_report',     ['only' => ['workLoadMonth']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workLoadMonth(Request $request)
    {
        if($request->has('date')){

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

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

            $branches = Branch::whereIn('id',$requestBranches)->get();

            foreach($branches as $branch){

                $branch->works = Group::where('branch_id',$branch->id)->whereBetween('created_at',[$from,$to])
                    ->select(DB::raw('count(id) as `data`'),DB::raw('sum(paid) as `paid`'),DB::raw('sum(discount_value) as `discount`'), DB::raw('sum(total) as `total`'), DB::raw('sum(subtotal) as `subtotal`'), DB::raw('sum(delayed_money) as `delayed_money`'),  DB::raw('sum(due) as `due`'),  DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                    ->groupby('year','month')
                    ->get();
    
                foreach($branch->works as $work ){
                    $paymentDate = '01/'.$work->month.'/'.$work->year;
                    $work->monthName = Carbon::createFromFormat('d/m/Y', $paymentDate)->format('F');

                    $fromDate = $work->year.'-'.$work->month.'-01';
                    $getNumberOfDays =  Carbon::create($work->year, $work->month)->daysInMonth ;
                    $toDate = $work->year.'-'.$work->month.'-'.$getNumberOfDays;

                    $fromLocal=date('Y-m-d',strtotime($fromDate));

                    $toLocal=date('Y-m-d 23:59:59',strtotime($toDate));
                    
                    $branchExpenses = Expense::whereBetween('date',[$fromLocal,$toLocal])->where('branch_id',$branch->id)->sum('amount');
                    $branchCustody = Branches_custody::where('custody_type','2')->where('status','1')->whereBetween('created_at',[$fromLocal,$toLocal])->where('branche_id',$branch->id)->sum('custody');
                    $payment_methods_branch=PaymentMethod::all();
    
                    foreach($payment_methods_branch as $payment_method){
                        $payment_method->income = ($payment_method['id'] == setting("account")['payment'])? get_payments_cach($branchCustody,$fromLocal,$toLocal,$branch['id']) : get_payments_income($fromLocal,$toLocal,$branch['id'],$payment_method['id']) ;
                    }
    
                    $work->paid = $payment_methods_branch;
                    $work->expenses = $branchExpenses;
                    $work->branchCustody = $branchCustody;
                    $work->totalPaid = $work->paid->sum('income') + $branchCustody ;
    
                    $work->custody = $work->totalPaid - $branchCustody;
       
                }
            }

            $date=$request['date'];

            $payment_methods=PaymentMethod::all();

            if($request->has('pdf'))

            {

                $type = 3;
                $reports_settings = setting('reports');
                $info_settings = setting('info');
                $barcode_settings = setting('barcode');
                $pdf = PDF::loadView(
                    "pdf.work_load",
                    compact(
                        "branches",
                        "payment_methods",
                        'date',
                        'from',
                        'to',
                        "reports_settings",
                        "info_settings",
                        "type",
                        "barcode_settings"
                    )
                );

                $pdf->save("uploads/pdf_/work_load.pdf");

                return   redirect(url("uploads/pdf_/work_load.pdf"));

            }

            return view('admin.reports_details.work_load_month',compact('branches','date'));
        }
        return view('admin.reports_details.work_load_month');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workLoadDay(Request $request)
    {
        if($request->has('date')){

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

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

            $branches = Branch::whereIn('id',$requestBranches)->get();

            foreach($branches as $branch){

                $branch->works = Group::where('branch_id',$branch->id)->whereBetween('created_at',[$from,$to])
                    ->select(DB::raw('count(id) as `data`'),DB::raw('sum(paid) as `paid`'),DB::raw('sum(subtotal) as `subtotal`'),  DB::raw('sum(total) as `total`'), DB::raw('sum(due) as `due`'),DB::raw('sum(discount_value) as `discount`'),DB::raw('sum(delayed_money) as `delayed_money`'), DB::raw('YEAR(created_at) year, MONTH(created_at) month , Day(created_at) day'))
                    ->groupby('year','month','day')
                    ->get();
    
                foreach($branch->works as $work ){
    
                    $work->monthName = $work->year.'-'.$work->month.'-'.$work->day;

                    $from=date('Y-m-d',strtotime($work->monthName));

    
                    
                    $branchExpenses = Expense::whereDate('date',$work->monthName)->where('branch_id',$branch->id)->sum('amount');
                    $branchCustody = Branches_custody::where('custody_type','2')->where('status','1')->whereDate('created_at',$work->monthName)->where('branche_id',$branch->id)->sum('custody');
                    $payment_methods_branch=PaymentMethod::all();
    
                    foreach($payment_methods_branch as $payment_method){
                        $payment_method->income = ($payment_method['id'] == setting("account")['payment'])? get_payments_cach($branchCustody,$work->monthName,$work->monthName,$branch['id']) : get_payments_income($work->monthName,$work->monthName,$branch['id'],$payment_method['id']) ;
                    }
    
                    $work->paid = $payment_methods_branch;
                    $work->expenses = $branchExpenses;
                    $work->branchCustody = $branchCustody;
                    $work->totalPaid = $work->paid->sum('income') + $branchCustody ;
    
                    $work->custody = $work->totalPaid - $branchCustody;
                }
            }

            $date=$request['date'];

            $payment_methods=PaymentMethod::all();

            if($request->has('pdf'))

            {

                $type = 3;
                $reports_settings = setting('reports');
                $info_settings = setting('info');
                $barcode_settings = setting('barcode');
                $pdf = PDF::loadView(
                    "pdf.work_load",
                    compact(
                        "branches",
                        "payment_methods",
                        'date',
                        'from',
                        'to',
                        "reports_settings",
                        "info_settings",
                        "type",
                        "barcode_settings"
                    )
                );

                $pdf->save("uploads/pdf_/work_load.pdf");

                return   redirect(url("uploads/pdf_/work_load.pdf"));

            }

            return view('admin.reports_details.work_load_day',compact('branches','date'));
        }
        return view('admin.reports_details.work_load_day');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workOneDay(Request $request)
    {
        if($request->has('date')){

            $date=$request['date'];

            $from = $date;
            $to = $date;

            $requestBranches = $request['branches'];

            $branches = Branch::where('id',$requestBranches)->get();

            $groups=Group::with('patient','doctor')->whereDate('created_at',$from)->where('branch_id',$requestBranches);

            // $branchSummary = $groups->get()->groupBy('branch_id')->all();
            $branchSummary = Branch::where('id',$requestBranches)->get();
            

            foreach($branchSummary  as $key => $branch){

                $branchModel = Branch::find($branch->id);
                $branchExpenses = Expense::whereDate('date',$date)->where('branch_id',$branchModel->id)->sum('amount');
                $branchCustody = Branches_custody::where('custody_type','2')->where('status','1')->whereDate('created_at',$date)->where('branche_id',$branchModel->id)->sum('custody');
                $payment_methods_branch=PaymentMethod::all();

                foreach($payment_methods_branch as $payment_method){
                    $payment_method->income = ($payment_method['id'] == setting("account")['payment'])? get_payments_cach($branchCustody,$from,$to,$branchModel['id']) : get_payments_income($from,$to,$branchModel['id'],$payment_method['id']) ;
                }

                $branch->paid = $payment_methods_branch;
                $branch->data = Group::whereDate('created_at',$from)->where('branch_id',$branch->id)->count('id');
                $branch->name = $branchModel->name ;
                $branch->totalDiscount = Group::whereDate('created_at',$from)->where('branch_id',$branch->id)->sum('discount_value');
                $branch->totalDelayedMoney =  Group::whereDate('created_at',$from)->where('branch_id',$branch->id)->sum('delayed_money');
                $branch->total = Group::whereDate('created_at',$from)->where('branch_id',$branch->id)->sum('total');
                $branch->due = Group::whereDate('created_at',$from)->where('branch_id',$branch->id)->sum('due');
                $branch->subtotal = Group::whereDate('created_at',$from)->where('branch_id',$branch->id)->sum('subtotal');
                $branch->discount = Group::whereDate('created_at',$from)->where('branch_id',$branch->id)->sum('discount_value');
                $branch->delayed_money = Group::whereDate('created_at',$from)->where('branch_id',$branch->id)->sum('delayed_money');
                $branch->expenses = $branchExpenses;
                $branch->branchCustody = $branchCustody;
                $branch->totalPaid = $branch->paid->sum('income') + $branchCustody ;
                $branch->custody = $branch->totalPaid - $branchCustody;
                $branch->brnachGroups = GroupPayment::with('group.patient','group.doctor','group.normalDoctor','group.contract','group.all_tests.test','group.all_cultures.culture')->whereHas('group',function($q)use($branchModel){return $q->where('branch_id',$branchModel->id);})->whereDate('date',$from)->get();


            }

            if($request->has('export')){

                // $old_trans = SafeTransfer::where('from_branch_id',$branchModel->id)
                //                             ->where('to_branch_id',$branchModel->id)
                //                             ->whereDate('created_at',$date)
                //                             ->get();
                
                  
                $branchModel = Branch::find($requestBranches);
                
                $branchExpenses = Expense::whereDate('date',$date)->where('branch_id',$branchModel->id)->sum('amount');
                $branchCustody = Branches_custody::where('custody_type','2')->where('status','1')->whereDate('created_at',$date)->where('branche_id',$branchModel->id)->sum('custody');
                $payment_methods_branch=PaymentMethod::all();

                $totalIncome = 0;
                foreach($payment_methods_branch as $payment_method){
                    $payment_method->income = ($payment_method['id'] == setting("account")['payment'])? get_payments_cach($branchCustody,$from,$to,$branchModel['id']) : get_payments_income($from,$to,$branchModel['id'],$payment_method['id']) ;
                    $totalIncome += $payment_method->income;
                }

                // dd($old_trans);

                // if($old_trans->count() || $totalIncome == 0 ){
                //     session()->flash('failed','');

                //     return redirect()->route('admin.index');
                // }

                $safe = new SafeTransfer();
                $safe->from_branch_id = $branchModel->id;
                $safe->to_branch_id = $branchModel->id;
                $safe->from_date = $from;
                $safe->to_date = $to;
                $safe->from_user_id = auth()->guard('admin')->user()->id;
                $safe->save();

                foreach($payment_methods_branch as $payment_method){
                    if($payment_method->income > 0){

                        $safe->payments()->create([
                            'payment_method_id' => $payment_method['id'],
                            'amount' => $payment_method->income ,
                        ]);
                    }
                }

                session()->flash('success',__('Safe Transfer successfully'));

                return redirect()->route('admin.index');

            }

            if($request->has('pdf'))

            {

                $type = 3;
                $reports_settings = setting('reports');
                $info_settings = setting('info');
                $barcode_settings = setting('barcode');
                $pdf = PDF::loadView(
                    "pdf.work_one_day",
                    compact(
                        "branches",
                        
                        'date',
                        'from',
                        'to',
                        "branchSummary",
                        "reports_settings",
                        "info_settings",
                        "type",
                        "barcode_settings"
                    )
                );

                $pdf->save("uploads/pdf_/work_load.pdf");

                return   redirect(url("uploads/pdf_/work_load.pdf"));

            }



            return view('admin.reports_details.work_one_day',compact('branches','date','branchSummary'));
        }
        return view('admin.reports_details.work_one_day');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expenses(Request $request)
    {
        $expense_categories=ExpenseCategory::all();
        if($request->has('date')){

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

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



            $expenses =($from==$to)?Expense::whereDate('date',$from)->whereIn('branch_id',$requestBranches):Expense::whereBetween('date',[$from,$to])->whereIn('branch_id',$requestBranches);

            if($request->has('category'))
            {
                $expenses->where('expense_category_id',$request['category']);

            }

            $expenses  = $expenses->get();

            $date=$request['date'];

            $branches = Branch::whereIn('id',$requestBranches)->get();
            $category_input = $request['category'];

            if($request->has('pdf'))

            {

                $type = 3;
                $reports_settings = setting('reports');
                $info_settings = setting('info');
                $barcode_settings = setting('barcode');
                $pdf = PDF::loadView(
                    "pdf.expenses",
                    compact(
                        "branches",
                        'date',
                        'from',
                        'to',
                        "reports_settings",
                        "info_settings",
                        "type",
                        "expenses",
                        "barcode_settings"
                    )
                );

                $pdf->save("uploads/pdf_/expenses.pdf");

                return   redirect(url("uploads/pdf_/expenses.pdf"));

            }
            
            return view('admin.reports_details.expenses',compact('expenses','date','expense_categories','branches','category_input'));
        }
         
        return view('admin.reports_details.expenses',compact('expense_categories'));
    }
    public function payments(Request $request)
    {

        $payments=GroupPayment::with('group.patient','group.doctor','group.normalDoctor','group.contract','group.all_tests.test','group.all_cultures.culture')
                                ->whereHas('group',function($q){return $q->where('branch_id',session('branch_id'));})
                                ->whereDate('date',get_system_date())
                                ->get();

         
        return view('admin.reports_details.payments',compact('payments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testesBranch(Request $request)
    {
        $expense_categories=ExpenseCategory::all();
        if($request->has('date')){

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

            $date=$request['date'];

            $branches = Branch::where('id',$request['branches'])->get();

            $type_input = $request->type ;

            if($request->has('type'))
            {
                if($type_input == '0'){
                    $groupTests = GroupTest::with('test')
                                            ->whereHas('group',function($q)use($request,$from,$to) {
                                                $q->where('branch_id',$request['branches'])->whereBetween('created_at',[$from,$to]);
                                            })
                                            ->where('package_id',null)
                                            ->select(DB::raw('count(test_id) as `data`'),DB::raw('sum(price) as price'),'test_id')
                                            ->groupBy('test_id')
                                            ->orderBy('data','desc')
                                            ->get();
                    foreach($groupTests as $test){
                        $test->testName = (isset($test->test))? $test->test->name : '';
                    }

                }elseif($type_input == '1'){
                    $groupTests = GroupCulture::with('culture')
                                            ->whereHas('group',function($q)use($request,$from,$to) {
                                                $q->where('branch_id',$request['branches'])->whereBetween('created_at',[$from,$to]);
                                            })
                                            ->where('package_id',null)
                                            ->select(DB::raw('count(culture_id) as `data`'),DB::raw('sum(price) as price'),'culture_id')
                                            ->groupBy('culture_id')
                                            ->orderBy('data','desc')
                                            ->get();
                    foreach($groupTests as $test){
                        $test->testName = (isset($test->culture))? $test->culture->name : '';
                    }
                }elseif($type_input == '2'){
                    $groupTests = GroupPackage::with('package')
                                            ->whereHas('group',function($q)use($request,$from,$to) {
                                                $q->where('branch_id',$request['branches'])->whereBetween('created_at',[$from,$to]);
                                            })
                                            ->select(DB::raw('count(package_id) as `data`'),DB::raw('sum(price) as price'),'package_id')
                                            ->groupBy('package_id')
                                            ->orderBy('data','desc')
                                            ->get();
                    foreach($groupTests as $test){
                        $test->testName = (isset($test->package))? $test->package->name : '';
                    }
                }
            }

            if($request->has('pdf'))

            {

                $type = 3;
                $reports_settings = setting('reports');
                $info_settings = setting('info');
                $barcode_settings = setting('barcode');
                $pdf = PDF::loadView(
                    "pdf.tests_branches",
                    compact(
                        "branches",
                        'date',
                        'from',
                        'to',
                        "reports_settings",
                        "info_settings",
                        "type",
                        "barcode_settings",
                        "groupTests",
                        "type_input",
                    )
                );

                $pdf->save("uploads/pdf_/tests_branches.pdf");

                return   redirect(url("uploads/pdf_/tests_branches.pdf"));

            }
            
            return view('admin.reports_details.testes_branch',compact('date','branches','groupTests','type_input'));
        }
         
        return view('admin.reports_details.testes_branch');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contract(Request $request)
    {
        $contracts= (auth()->guard('admin')->user()->lab_id == null) ? Contract::all() : Contract::where('id',auth()->guard('admin')->user()->lab_id)->get();
        $governments = Government::all();
        if($request->has('date')){

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

            $date=$request['date'];

            

            if($request->has('contract'))
            {
                $contractInvoice = Contract::where('id',$request->contract)->first();
                $contractSelected = $request->contract;

            }
            
            $government_id = null;
            $region_id = null;
            $user_id = null;


            $group = ($from==$to)? Group::with('patient','doctor','normalDoctor','contract','all_tests.test','all_cultures.culture')->where('contract_id',$contractInvoice->id)->whereDate('created_at',$from) : Group::with('patient','doctor','normalDoctor','contract','all_tests.test','all_cultures.culture')->where('contract_id',$contractInvoice->id)->whereBetween('created_at',[$from,$to]) ;
            $userContract = Contract::find(auth()->guard('admin')->user()->lab_id);

            if($userContract){
                if($userContract->type == "lab_to_lab"){
                    $group->where('user_id',auth()->guard('admin')->user()->id);
                }
            }
            if($request->has('government_id') && $request->government_id != null ){
                $group->where('government_id',$request->government_id);
                $government_id = $request->government_id;

            }
            if($request->has('region_id') && $request->region_id != null){
                $group->where('region_id',$request->region_id);
                $region_id = $request->region_id;

            }
            if($request->has('user_id') && $request->user_id != null){
                $group->where('user_id',$request->user_id);
                $user_id = $request->user_id;
            }
            
            $contractInvoice->data = $group->count();
            $contractInvoice->sub_total = $group->sum('subtotal');
            $contractInvoice->due = $group->sum('due');
            $contractInvoice->delayed_money = $group->sum('delayed_money');
            $contractInvoice->groups = $group->get();

            if($request->has('pdf'))

            {

                $type = 3;
                $reports_settings = setting('reports');
                $info_settings = setting('info');
                $barcode_settings = setting('barcode');
                $pdf = PDF::loadView(
                    "pdf.contract_details",
                    compact(
                        'date',
                        'from',
                        'to',
                        "reports_settings",
                        "info_settings",
                        "type",
                        "government_id",
                        "region_id",
                        "user_id",
                        "barcode_settings",
                        "contractInvoice",
                    )
                );

                $pdf->save("uploads/pdf_/contract_details.pdf");

                return   redirect(url("uploads/pdf_/contract_details.pdf"));

            }
            
            return view('admin.reports_details.contract_details',compact('date','contractInvoice','contractSelected','contracts','governments','government_id','region_id','user_id'));
        }
         
        return view('admin.reports_details.contract_details',compact('contracts','governments'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vault(Request $request)
    {
        // $contracts=Contract::all();
        if($request->has('date')){

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

            $date=$request['date'];

            

            if($request->has('pdf'))

            {

                $type = 3;
                $reports_settings = setting('reports');
                $info_settings = setting('info');
                $barcode_settings = setting('barcode');
                $pdf = PDF::loadView(
                    "pdf.contract_details",
                    compact(
                        'date',
                        'from',
                        'to',
                        "reports_settings",
                        "info_settings",
                        "type",
                        "barcode_settings",
                        "contractInvoice",
                    )
                );

                $pdf->save("uploads/pdf_/contract_details.pdf");

                return   redirect(url("uploads/pdf_/contract_details.pdf"));

            }
            
            return view('admin.reports_details.contract_details',compact('date','contractInvoice','contractSelected','contracts'));
        }
         
        return view('admin.reports_details.vaulte');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function custody(Request $request)
    {
        // $contracts=Contract::all();
        if($request->has('date')){

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));

            $date=$request['date'];

            // branch
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

            $branches = Branch::whereIn('id',$requestBranches)->get();
            $custodys = ($from==$to)? Branches_custody::with('branche')->where('status',1)->whereIn('branche_id',$requestBranches)->orderby('id','desc')->whereDate('created_at',$from)->get() : Branches_custody::with('branche')->where('status',1)->whereIn('branche_id',$requestBranches)->orderby('id','desc')->whereBetween('created_at',[$from,$to])->get();

            $presonal = $custodys->where('custody_type','1')->sum('custody');
            $lab = $custodys->where('custody_type','2')->sum('custody');
            $mainSafe = $custodys->where('custody_type','3')->sum('custody');
            $branchSafe = $custodys->where('custody_type','4')->sum('custody');
            $out = $custodys->where('custody_type','0')->sum('custody');
            if($request->has('pdf'))

            {

                $type = 3;
                $reports_settings = setting('reports');
                $info_settings = setting('info');
                $barcode_settings = setting('barcode');
                $pdf = PDF::loadView(
                    "pdf.contract_details",
                    compact(
                        'date',
                        'from',
                        'to',
                        'out',
                        "reports_settings",
                        "info_settings",
                        "type",
                        "barcode_settings",
                        "contractInvoice",
                    )
                );

                $pdf->save("uploads/pdf_/contract_details.pdf");

                return   redirect(url("uploads/pdf_/contract_details.pdf"));

            }
            
            return view('admin.reports_details.custody',compact('date','custodys','branches','lab','out','presonal','branchSafe','mainSafe'));
        }
         
        return view('admin.reports_details.custody');
    }
    public function safe(Request $request)
    {
        // $contracts=Contract::all();
        if($request->has('date')){

            $date=explode('-',$request['date']);

            $from=date('Y-m-d',strtotime($date[0]));

            $to=date('Y-m-d 23:59:59',strtotime($date[1]));



            $from_branch = null;
            $to_branch = null;
            $from_user  = null;
            $to_user = null;

            $model=SafeTransfer::with('payments','fromBrnach','toBrnach','toUser','fromUser');

            if ($request['filter_to_user'] != '') {
                $model->where('to_user_id', $request['filter_to_user']);
                $to_user = User::find($request['filter_to_user']);

            }
            if ($request['filter_from_user'] != '') {
                $model->where('from_user_id', $request['filter_from_user']);
                $from_user = User::find($request['filter_from_user']);
            }
            if ($request['filter_to_branch'] != '') {
                $model->where('to_branch_id', $request['filter_to_branch']);
                $to_branch = Branch::find($request['filter_to_branch']);

            }
            if ($request['filter_from_branch'] != '') {
                $model->where('from_branch_id', $request['filter_from_branch']);
                $from_branch = Branch::find($request['filter_from_branch']);
            }
            if ($request['date'] != '') {
                //format date
                $date = explode('-', $request['date']);
                $from = date('Y-m-d', strtotime($date[0]));
                $to = date('Y-m-d 23:59:59', strtotime($date[1]));

                //select groups of date between
                $date[0] == $date[1]
                    ? $model->whereDate('from_date', $from)
                    : $model->whereBetween('from_date', [$from, $to]);
            }

            $model->where('accept','Accept');
            $model = $model->get();

            $totalCach = 0;
            $totalBeforeCustody = 0;
            $totalOther = 0;

            foreach($model as $safe){
                $totalCach += $safe->payments()->where('payment_method_id','1')->sum('amount') - Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$safe->id)->sum('custody');
                $totalBeforeCustody += $safe->payments()->where('payment_method_id','1')->sum('amount') ;
                $totalOther += $safe->payments()->where('payment_method_id','!=','1')->sum('amount');
            }

            



            // if($request->has('pdf'))

            // {

            //     $type = 3;
            //     $reports_settings = setting('reports');
            //     $info_settings = setting('info');
            //     $barcode_settings = setting('barcode');
            //     $pdf = PDF::loadView(
            //         "pdf.contract_details",
            //         compact(
            //             'date',
            //             'from',
            //             'to',
            //             'out',
            //             "reports_settings",
            //             "info_settings",
            //             "type",
            //             "barcode_settings",
            //             "contractInvoice",
            //         )
            //     );

            //     $pdf->save("uploads/pdf_/contract_details.pdf");

            //     return   redirect(url("uploads/pdf_/contract_details.pdf"));

            // }
            $date=$request['date'];
            return view('admin.reports_details.safe',compact('date','model','totalCach','totalBeforeCustody','totalOther','to_user','from_user','to_branch','from_branch'));
        }
         
        return view('admin.reports_details.safe');
    }

    
}
