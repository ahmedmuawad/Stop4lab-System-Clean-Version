<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\Test;
use App\Models\User;
use App\Models\Group;
use App\Models\Branch;
use App\Models\Offers;
use App\Models\Culture;
use App\Models\Expense;
use App\Models\KnowsBy;
use App\Models\Package;
use App\Models\Patient;
use App\Models\Printer;
use App\Models\Setting;
use App\Models\Contract;
use App\Models\GroupRay;
use App\Models\GroupTest;
use App\Models\Government;
use App\Models\GroupOffer;
use App\Models\SubContract;
use App\Models\GroupCulture;
use App\Models\GroupPackage;
use App\Models\GroupPayment;
use Illuminate\Http\Request;
use App\Models\BranchProduct;
use App\Models\CultureOption;
use App\Models\ExtraServices;
use App\Models\GroupRayResult;
use App\Models\ExpenseCategory;
use App\Models\GroupTestResult;
use App\Models\Branches_custody;
use App\Models\testExtraService;
use App\Models\GroupCultureOption;
use App\Models\GroupCultureResult;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\GroupRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use App\Models\invoiceImages;

class GroupsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_group',     ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_group',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_group',     ['only' => ['edit', 'updae']]);
        $this->middleware('can:delete_group',   ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $governments = Government::select('id', 'name')->get();
        return view('admin.groups.index', compact('governments'));
    }
    //  ======================== Task : test_sample ======================== 
    /* get groups datatable */
    public function ajax(Request $request)
    {
        if (auth()->guard('admin')->user()->lab_id != null) {

            $model = Group::with('patient', 'contract', 'branch', 'created_by_user')
                ->whereHas('contract', function ($q) {
                    $q->where('id', auth()->guard('admin')->user()->lab_id);
                });
            $userContract = Contract::find(auth()->guard('admin')->user()->lab_id);
            if ($userContract) {
                if ($userContract->type == "lab_to_lab") {
                    $model->where('user_id', auth()->guard('admin')->user()->id);
                }
            }
        } elseif (auth()->guard('admin')->user()->commission != null) {
            $model = Group::with('patient', 'contract', 'branch', 'created_by_user')
                ->whereHas('doctor', function ($q) {
                    $q->where('id', auth()->guard('admin')->user()->id);
                });
        } else {
            $model = Group::with('patient', 'contract', 'branch', 'created_by_user');

            if (isset(setting('account')['show_groups']) && setting('account')['show_groups'] == 'current') {
                $model->where('branch_id', session('branch_id'));
            } elseif (isset(setting('account')['show_groups']) && setting('account')['show_groups'] == 'available') {
                $user = User::with('branches')->find(auth()->guard('admin')->user()->id);

                $branchIds = array_column($user->branches->toArray(), 'branch_id');

                $model->whereIn('branch_id', $branchIds);
            }
        }

        if ($request['filter_date'] != '') {
            //format date
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select groups of date between
            ($date[0] == $date[1]) ? $model->whereDate('created_at', $from) : $model->whereBetween('created_at', [$from, $to]);
        }


        if ($request['filter_created_by'] != '') {
            $model->whereIn('created_by', $request['filter_created_by']);
        }

        if ($request['filter_signed_by'] != '') {
            $model->whereIn('signed_by', $request['filter_signed_by']);
        }

        if ($request['filter_status'] != '') {
            $model->where('done', $request['filter_status']);
        }

        if ($request['filter_barcode'] != '') {
            $model->where('barcode', $request['filter_barcode']);
        }

        if ($request['filter_contract'] != '') {
            $model->whereIn('contract_id', $request['filter_contract']);
        }

        if ($request['labs'] != '') {
            $model->whereIn('user_id', $request['labs']);
        }

        if ($request['government_id'] != '') {
            $model->where('government_id', $request['government_id']);
        }

        if ($request['region_id'] != '') {
            $model->where('region_id', $request['region_id']);
        }

        if ($request['rep_id'] != '') {
            $model->where('rep_id', $request['rep_id']);
        }

        return DataTables::eloquent($model)
            ->editColumn('done', function ($group) {
                return view('admin.groups._status', compact('group'));
            })
            ->addColumn('action', function ($group) {
                return view('admin.groups._action', compact('group'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->editColumn('created_at', function ($group) {
                return date('Y-m-d H:i', strtotime($group['created_at']));
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

        $branch_id = session()->get('branch_id');

        $allExtraServices = ExtraServices::where('branch_id', $branch_id)->get();
        $offers = Offers::where('status', 'active')->get();
        // $extraServices = testExtraService::select('extraServiceId')->where('groupId' , $id)->get()->toArray();
        // $extraServiceArray = array_column($extraServices, 'extraServiceId');
        $contracts = Contract::all();

        $governments = Government::select('id', 'name')->get();
        $branch = Branch::find(session('branch_id'));
        $knows = KnowsBy::all();

        //.Reception.invoices
        return view('admin.groups.create', compact('contracts', 'offers', 'allExtraServices', 'governments', 'branch', 'knows'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // public function updateInvoiceID($group_id=1){
    //     $myDate = now();
    //     $date=date('Y-m-d',strtotime($myDate));
    //     $year = Carbon::parse($myDate)->format('Y');
    //     $month = Carbon::parse($myDate)->format('m');
    //     $day = Carbon::parse($myDate)->format('d');
    //     $branch_id = session('branch_id');
    //     $getLastBranchInvoiceID = Group::whereDate('created_at' , $date)->where('branch_id' , $branch_id)->count();
    //     $getLastBranchInvoiceID++;
    //     $invoiceNumber = str_pad((string)$getLastBranchInvoiceID,3 , "0" , STR_PAD_LEFT);
    //     $invoiceID = $year[2].$year[3].$month.$day .$branch_id.$invoiceNumber;
    //     // dd($invoiceID);
    //     return $invoiceID;
    // }


    public function store(GroupRequest $request)
    {
        //  dd($request->all());
        // $group_id = $this->updateInvoiceID();
        $group = Group::create($request->except('_token', 'images', 'including_portal_number', "pressure", 'services', 'offers', 'tests', 'rays', 'cultures', 'packages', 'payments', 'DataTables_Table_0_length', 'DataTables_Table_1_length', 'DataTables_Table_2_length', 'diabetic', 'fluid_patient', 'liver_patient', 'pregnant', 'answer_other', 'antibiotic', 'gland', 'tumors', 'iron', 'cortisone', 'doctor_id', 'doctor_type', 'normal_doctor_id', 'is_out', 'questions'));
        $group->update([
            'including_portal_number' => isset($request['including_portal_number']) ? 1 : 0,
            'created_by' => auth()->guard('admin')->user()->id,
            "status" => 'pending',
            'is_out' => isset($request['is_out']) ? 1 : 0,
            'allow_print' => isset($request['allow_print']) ? 1 : 0,
            // 'id'=>1778,
        ]);

        // doctor type

        if ($request->normal_doctor_id != null) {
            $typeOfDoctor = explode('_', $request->normal_doctor_id);
            if ($typeOfDoctor[0] == 'doctor') {
                $group->doctor_id = $typeOfDoctor[1];
                $group->normal_doctor_id = null;
                $group->save();
            } else {
                $group->normal_doctor_id = $typeOfDoctor[1];
                $group->doctor_id = null;
                $group->save();
            }
        }
        $reports_settings = setting('reports');
        $test_settings = json_encode($reports_settings);
        //Stor SxtraService

        // Log::Info(['req'=>$request->services]);
        $extraPrice = 0.0;
        if ($request->has('services')) {
            foreach ($request['services'] as $service) {
                $extraService = ExtraServices::where('id', $service['id'])->first();
                $extraPrice += $extraService->price;
                testExtraService::create([
                    'groupId' => $group->id,
                    'extraServiceId' => $service['id'],
                ]);
            }
        }

        if ($request->has('offers')) {
            foreach ($request['offers'] as $offer) {
                GroupOffer::create([
                    'offer_id' => $offer['id'],
                    'group_id' => $group->id,
                    'price' => $offer['price'],
                ]);
            }
        }
        Group::where('id', $group->id)->update(['extra_service_price' => ($extraPrice)]);

        //store assigned tests
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                
                $realTest = Test::find($test['id']);

                // if($realTest->parent_id){
                //     $test['id'] = $realTest->parent_id;
                // }

                $groupTest = GroupTest::create([
                    'group_id' => $group->id,
                    'test_id' => $test['id'],
                    'price' => $test['price'],
                    'check_test_by' => auth()->guard('admin')->user()->id,
                    'check_test_date' => now(),
                    'lab_to_lab_cost' => $test['cost'],
                    'setting' => ($realTest->setting == null) ? $test_settings : $realTest->setting,
                ]);

                if ($test['lab_status'] == 'Out') {
                    $groupTest->update(['send_status' => '0']);
                }

                $realTest->update(['lab_to_lab_status' => $test['lab_status'] == 'In' ? 0 : 1]);
            }
        }

        if ($request->has('questions')) {
            foreach ($request['questions'] as $key => $question) {
                $group->questions()->create([
                    'question_id' => $key,
                    'answer' => $question
                ]);
            }
        }

        // dd($group->questions);

        //store assigned rays
        if ($request->has('rays')) {
            foreach ($request['rays'] as $ray) {
                $group_ray = GroupRay::create([
                    'group_id' => $group->id,
                    'ray_id' => $ray['id'],
                    'price' => $ray['price'],
                ]);
                GroupRayResult::create([
                    'group_ray_id' => $group_ray->id,
                    'ray_id' => $ray['id'],
                ]);
            }
        }

        //store assigned cultures
        $culture_options = CultureOption::where('parent_id', 0)->get();
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $group_culture = GroupCulture::create([
                    'group_id' => $group->id,
                    'culture_id' => $culture['id'],
                    'price' => $culture['price'],
                    'check_test_by' => auth()->guard('admin')->user()->id,
                    'check_test_date' => now(),
                    'lab_to_lab_cost' => $culture['cost'],
                    'setting' => $test_settings,
                ]);

                //assign default report
                foreach ($culture_options as $culture_option) {
                    GroupCultureOption::create([
                        'group_culture_id' => $group_culture['id'],
                        'culture_option_id' => $culture_option['id'],
                    ]);
                }
            }
        }


        if ($request->file('images')) {
            $index = 0;

            // dd($request->file('images'));
            foreach ($request->file('images') as $image) {
            // dd($image);

                $image_name = $group->id . '.' . 'image_' . $index++ . '.' . $image->getClientOriginalExtension();
                // dd($image_name);
                $image->move('uploads/group', $image_name);

                // $image = GroupImage::where('group_id', $group_test->group_id)->where('test_id', 855)

                //     ->first();

                // if ($image) {
                //     GroupImage::where('group_id', $group_test->group_id)->where('test_id', 855)
                //         ->where('image_num', 1)
                //         ->update([
                //             'image_name' => $image_name,
                //         ]);
                // } else {
                invoiceImages::create([
                    'group_id' => $group->id,
                    'img_name' => $image_name,
                ]);
            }
        }

        //store assigned packages
        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                // packages tests and cultures
                $original_package = Package::find($package['id']);

                $group_package = GroupPackage::create([
                    'group_id' => $group['id'],
                    'package_id' => $package['id'],
                    'price' => $package['price'],
                    // 'lab_to_lab_cost' => $package['cost'],
                ]);
                //tests
                foreach ($original_package['tests'] as $test) {
                    $realTest = Test::find($test['test']['id']);

                    GroupTest::create([
                        'group_id' => $group['id'],
                        'test_id' => $test['test']['id'],
                        'check_test_by' => auth()->guard('admin')->user()->id,
                        'check_test_date' => now(),
                        'package_id' => $group_package['id'],
                        'setting' => ($realTest->setting == null) ? $test_settings : $realTest->setting,

                    ]);
                }

                //cultures
                foreach ($original_package['cultures'] as $culture) {
                    $group_culture = GroupCulture::create([
                        'group_id' => $group['id'],
                        'culture_id' => $culture['culture']['id'],
                        'package_id' => $group_package['id']
                    ]);

                    //assign default report
                    foreach ($culture_options as $culture_option) {
                        GroupCultureOption::create([
                            'group_culture_id' => $group_culture['id'],
                            'culture_option_id' => $culture_option['id'],
                        ]);
                    }
                }
            }
        }

        //payments
        if ($request->has('payments')) {
            foreach ($request['payments'] as $payment) {
                $group->payments()->create([
                    'date' => $payment['date'],
                    'payment_method_id' => $payment['payment_method_id'],
                    'amount' => $payment['amount'],
                ]);
            }
        }

        //barcode

        $bracode = $group['id'];
        $group->update(['barcode' => $bracode]);
        // generate_barcode($group['id']);

        //assign default report
        $this->assign_tests_report($group['id']);

        //assign consumption
        $this->assign_consumption($group['id']);

        //calculations
        group_test_calculations($group['id']);



        //save receipt pdf
        $group = Group::find($group['id']);
        $pdf = generate_pdf($group, 2);

        // $this->invoice($request);
        $type = 2;
        $reports_settings = setting('reports');
        $info_settings = setting('info');
        $barcode_settings = setting('barcode');

        if (isset(setting("account")['invoice_layout']) && setting("account")['invoice_layout'] == 'with_header') {
            $header = false;
        } elseif (isset(setting("account")['invoice_layout']) && setting("account")['invoice_layout'] == 'without_header') {
            $header = true;
        }

        $pdf_2 = PDF::loadView(
            "pdf.receipt_2",
            compact(
                "group",
                "header",
                "reports_settings",
                "info_settings",
                "type",
                "barcode_settings"
            )
        );

        $pdf_name = "uploads/pdf_/receipt_2_" . $group['id'] . ".pdf";
        $pdf_2->save($pdf_name);

        // dd($group->toArray());
        if (isset($pdf)) {
            $group->update(['receipt_pdf' => $pdf]);
            $print = $this->printer($pdf, 'receipt');
        }

        //send notification with the patient code
        $patient = Patient::find($group['patient_id']);
        send_notification('patient_code', $patient);

        $branche = session('branch_id');

        $ar = [];
        if ($request->tests) {
            foreach ($request->tests as $key => $test) {

                $ar[] = $key;
            }

            $tests = Test::whereIn('id', $ar)->get();
            //    $consumptions = [];
            if ($tests->isNotEmpty()) {
                foreach ($tests as $tes) {
                    $consumptions = $tes->consumptions()->pluck('product_id');
                    if ($consumptions->isNotEmpty()) {
                        $branche_product = BranchProduct::where([['branch_id', session('branch_id')], ['product_id', $consumptions]])->first();

                        if ($branche_product) {
                            $branche_product->update(['initial_quantity' => $branche_product->initial_quantity - 1]);
                        }
                    }
                }
            }
        }



        $pdf = MedicalReportsController::prePrintPdf2($group, true);
        MedicalReportsController::prePrintPdf2($group, false);


        //save report pdf link

        $group->update(['report_pdf' => $pdf]);

        session()->flash('success', __('Group saved successfully'));

        return redirect()->route('admin.groups.show', $group['id']);
    }




    public function sendCalculator(Request $request)
    {

        $group = Group::create($request->except('_token', 'type', 'phone', 'tests', 'rays', 'cultures', 'packages', 'payments', 'DataTables_Table_0_length', 'DataTables_Table_1_length', 'DataTables_Table_2_length', 'diabetic', 'fluid_patient', 'liver_patient', 'pregnant', 'answer_other', 'antibiotic', 'gland', 'tumors', 'iron', 'cortisone', 'doctor_id', 'doctor_type', 'normal_doctor_id', 'is_out'));
        $group->update([
            'branch_id' => session('branch_id'),
            'created_by' => auth()->guard('admin')->user()->id,
            'is_out' => isset($request['is_out']) ? 1 : 0,
        ]);

        //store assigned tests
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $groupTest = GroupTest::create([
                    'group_id' => $group->id,
                    'test_id' => $test['id'],
                    'price' => $test['price'],
                    'check_test_by' => auth()->guard('admin')->user()->id,
                    'check_test_date' => now(),
                ]);
                $realTest = Test::find($test['id']);
                if ($realTest->lab_to_lab_status == '1') {
                    $groupTest->update(['send_status' => '0']);
                }
            }
        }

        //store assigned cultures
        $culture_options = CultureOption::where('parent_id', 0)->get();
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $group_culture = GroupCulture::create([
                    'group_id' => $group->id,
                    'culture_id' => $culture['id'],
                    'price' => $culture['price'],
                    'check_test_by' => auth()->guard('admin')->user()->id,
                    'check_test_date' => now(),
                    // 'lab_to_lab_cost' => $culture['cost'],
                ]);

                //assign default report
                foreach ($culture_options as $culture_option) {
                    GroupCultureOption::create([
                        'group_culture_id' => $group_culture['id'],
                        'culture_option_id' => $culture_option['id'],
                    ]);
                }
            }
        }

        //store assigned packages
        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                // packages tests and cultures
                $original_package = Package::find($package['id']);

                $group_package = GroupPackage::create([
                    'group_id' => $group['id'],
                    'package_id' => $package['id'],
                    'price' => $package['price'],
                    // 'lab_to_lab_cost' => $package['cost'],
                ]);

                //tests
                foreach ($original_package['tests'] as $test) {
                    GroupTest::create([
                        'group_id' => $group['id'],
                        'test_id' => $test['test']['id'],
                        'check_test_by' => auth()->guard('admin')->user()->id,
                        'check_test_date' => now(),
                        'package_id' => $group_package['id']
                    ]);
                }

                //cultures
                foreach ($original_package['cultures'] as $culture) {
                    $group_culture = GroupCulture::create([
                        'group_id' => $group['id'],
                        'culture_id' => $culture['culture']['id'],
                        'package_id' => $group_package['id']
                    ]);

                    //assign default report
                    foreach ($culture_options as $culture_option) {
                        GroupCultureOption::create([
                            'group_culture_id' => $group_culture['id'],
                            'culture_option_id' => $culture_option['id'],
                        ]);
                    }
                }
            }
        }

        //barcode
        // generate_barcode($group['id']);

        //assign default report
        $this->assign_tests_report($group['id']);

        //assign consumption
        // $this->assign_consumption($group['id']);

        //calculations
        group_test_calculations($group['id']);

        //save receipt pdf
        $group = Group::find($group['id']);
        // $pdf = generate_pdf($group, 2);

        $type = 2;
        $reports_settings = setting('reports');
        $info_settings = setting('info');
        $barcode_settings = setting('barcode');

        $pdf_2 = PDF::loadView(
            "pdf.calculate",
            compact(
                "group",
                "reports_settings",
                "info_settings",
                "type",
                "barcode_settings"
            )
        );

        $pdf_name = "uploads/pdf_/calculate_" . $request['phone'] . ".pdf";
        $sub_massage = "calculate_" . $request['phone'] . ".pdf";
        $pdf_2->save($pdf_name);

        $whatsapp = setting("whatsapp");
        // $message = url($pdf_name);
        $whatmessage = "مرفق عرض سعر التحليل المطلوبة" .  url($pdf_name);
        // $message = str_replace(
        // 	["{patient_name}", "{report_link}"],
        // 	[$request['phone'] , url($pdf_name)],
        // 	$whatsapp["report"]["message"]
        // );

        // 


        $url = "https://wa.me/" . $request['phone'] . "?text=" . $whatmessage;

        $this->destroy($group->id);

        // return $this->send_whatsapp_massage(url($pdf_name),$request['phone'],"stop4labs2",$sub_massage);


        //send notification with the patient code

        session()->flash('success', __('Group saved successfully'));

        if ($request->type == 1) {
            return redirect($pdf_name);
        }
        return redirect($url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);

        $extraService = testExtraService::where('groupId', $id)->with('extraService')->get();


        $barcode_settings = setting('barcode');

        return view('admin.groups.show', compact('group', 'barcode_settings', 'extraService'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::with(['tests_with_canceled.test.test_price','tests_with_canceled.test.sample','invoiceImage', 'cultures.culture.culture_price', 'packages.package.package_price'])
            ->findOrFail($id);

        $branch_id = session()->get('branch_id');
        // $extraServices = ExtraServices::where('')
        $extraServices = testExtraService::select('extraServiceId')->where('groupId', $id)
            ->with('extraService')
            ->get();

        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $packages = Package::all();
        $contracts = Contract::all();
        $sub_contracts = $group->contract_id ? SubContract::where('main_contract_id', $group->contract_id)->get() : null;
        $governments = Government::select('id', 'name')->get();
        $branch = Branch::find(session('branch_id'));
        $knows = KnowsBy::all();

        return view('admin.groups.edit', compact('group', 'extraServices', 'tests', 'cultures', 'packages', 'contracts', 'governments', 'branch', 'sub_contracts', 'knows'));
    }

    public function deleteGroupImage(Request $request){
        // dd($request->group_id . '  ' . $request->image_name);

        $image = invoiceImages::where('group_id' , $request->group_id)->where('img_name' , $request->image_name)->delete();
        if($image){
            session()->flash('success', __('Image Deleted successfully'));
            return redirect()->back();
        }
    }

    // updatePatientContractId
    public function updatePatientContractId(Request $request)
    {

        $patient = Patient::find($request->patient_id);
        $contract = Contract::find($request->contract_id);
        $lab_to_lab = $contract->type == 'lab_to_lab';
        $sub_contracts = $contract->sub_contracts->count();
        $sub_contracts_obj = $contract->sub_contracts;

        $patient->update(['contract_id' => $request->contract_id]);

        return response()->json(['status' => 'success', 'message' => 'تم التعديل بنجاح', 'lab_to_lab' => $lab_to_lab, 'sub_contracts_obj' => $sub_contracts_obj, 'sub_contracts' => $sub_contracts, 'contract' => $contract]);
    }

    // get contract in calculator
    public function CalcContractId(Request $request)
    {
        if ($request->contract_id == 0) {
            $lab_to_lab = false;
            $sub_contracts = 0;
            $sub_contracts_obj = [];
            return response()->json(['status' => 'success', 'message' => 'تم التعديل بنجاح', 'lab_to_lab' => $lab_to_lab, 'sub_contracts_obj' => $sub_contracts_obj, 'sub_contracts' => $sub_contracts, 'type' => 'no-contract']);
        } else {
            $contract = Contract::find($request->contract_id);
            $lab_to_lab = $contract->type == 'lab_to_lab';
            $sub_contracts = $contract->sub_contracts->count();
            $sub_contracts_obj = $contract->sub_contracts;
            return response()->json(['status' => 'success', 'message' => 'تم التعديل بنجاح', 'lab_to_lab' => $lab_to_lab, 'sub_contracts_obj' => $sub_contracts_obj, 'sub_contracts' => $sub_contracts, 'type' => $contract->type]);
        }
    }
    // +++++++++++++++++++++++++++++++++ update() +++++++++++++++++++++++++++++++++
    /* Update the specified resource in storage  */
    public function update(GroupRequest $request, $id)
    {
        $group = Group::findOrFail($id);

        $retrieve_amount = (isset($request->retrieve_amount)) ? $request->retrieve_amount : 0.00;
        $group->update($request->except(
            '_method',
            '_token',
            "services",
            "offers",
            'tests',
            "pressure",
            'rays',
            'questions',
            'cultures',
            'packages',
            'payments',
            'DataTables_Table_0_length',
            'DataTables_Table_1_length',
            'DataTables_Table_2_length',
            'diabetic',
            'fluid_patient',
            "images",
            'liver_patient',
            'pregnant',
            'answer_other',
            'doctor_id',
            'doctor_type',
            'antibiotic',
            'gland',
            'tumors',
            'iron',
            'cortisone',
            'normal_doctor_id'

        ));

        $group->update([
            'created_by' => auth()->guard('admin')->user()->id,
            'is_out' => isset($request['is_out']) ? 1 : 0,
            'allow_print' => isset($request['allow_print']) ? 1 : 0,
            'including_portal_number' => isset($request['including_portal_number']) ? 1 : 0,

        ]);


        // $extraPrice = 0.0;
        // if(!empty($request['extraServices'])){
        //     foreach($request['extraServices'] as $extra){
        //         $extraService = ExtraServices::where('id' , $extra)->first();
        //         if(testExtraService::where("groupId" , $group->id)->where('extraServiceId', '$extra,')->first()){
        //             $extraPrice+=$extraService->price;
        //             testExtraService::create([
        //                 'groupId'=>$group->id,
        //                 'extraServiceId'=>$extra,
        //             ]);
        //         }
        //         Log::Info(['Price'=>$extraPrice]);
        //     }
        // }
        $extraPrice = 0.0;
        if ($request->has('services')) {
            testExtraService::where('groupId', $group->id)->delete();
            foreach ($request['services'] as $service) {
                // Log::Info(['service'=>$service]);
                $extraService = ExtraServices::where('id', $service['id'])->first();

                testExtraService::create([
                    'groupId' => $group->id,
                    'extraServiceId' => $service['id'],
                ]);
                $extraPrice += $extraService->price;
            }
        }

        if ($request->has('questions')) {
            $group->questions()->delete();
            foreach ($request['questions'] as $key => $question) {
                $group->questions()->create([
                    'question_id' => $key,
                    'answer' => $question
                ]);
            }
        }
        GroupOffer::where('group_id', $group->id)->delete();
        if ($request->has('offers')) {
            foreach ($request['offers'] as $offer) {
                GroupOffer::create([
                    'offer_id' => $offer['id'],
                    'group_id' => $group->id,
                    'price' => $offer['price'],
                ]);
            }
        }

        Group::where('id', $group->id)->update(['extra_service_price' => ($extraPrice)]);

        $branch_custody = Branches_custody::where('priceable_id', $group->id)->where('priceable_type', 'App\Models\Group')->first();

        if (isset($request->retrieve_amount)) {

            if ($branch_custody) {
                $branch_custody->custody = $request->retrieve_amount;
                $branch_custody->save();
            } else {
                Branches_custody::create([
                    'branche_id' => session('branch_id'),
                    'user_id' => auth()->guard('admin')->user()->id,
                    'priceable_id' => $group->id,
                    'priceable_type' => 'App\Models\Group',
                    'custody' => $request->retrieve_amount,
                    'custody_type' => 0
                ]);
            }
        } else {
            if ($branch_custody) {
                $branch_custody->delete();
            }
        }


        $group->update([
            'contract_id' => (isset($request['contract_id'])) ? $request['contract_id'] : '',
            'retrieve_amount' => $retrieve_amount,
        ]);


        // update doctores
        if ($request->normal_doctor_id != null) {
            $typeOfDoctor = explode('_', $request->normal_doctor_id);
            if ($typeOfDoctor[0] == 'doctor') {
                $group->doctor_id = $typeOfDoctor[1];
                $group->normal_doctor_id = null;
                $group->save();
            } else {
                $group->normal_doctor_id = $typeOfDoctor[1];
                $group->doctor_id = null;
                $group->save();
            }
        }

        if ($request->normal_doctor_id == null) {
            $group->normal_doctor_id = null;
            $group->doctor_id = null;
            $group->save();
        }

        //store assigned tests
        $selected_tests = [];

        $reports_settings = setting('reports');
        $test_settings =  json_encode($reports_settings);

        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $realTest = Test::find($test['id']);

                $realTest->update(['lab_to_lab_status' => $test['lab_status'] == 'Out' ? 1 : 0]);


                $selected_tests[] = $test['id'];

                $group_test = GroupTest::where([
                    ['group_id', $id],
                    ['test_id', $test['id']],
                ])->first();

                if (isset($group_test)) {
                    $group_test->update([
                        'price' => $test['price'],
                        'lab_to_lab_cost' => $test['cost'],
                        'is_canceled' => $test['is_canceled'],
                    ]);
                } else {
                    GroupTest::create([
                        'group_id' => $group->id,
                        'test_id' => $test['id'],
                        'price' => $test['price'],
                        'lab_to_lab_cost' => $test['cost'],
                        'setting' => ($realTest->setting == null) ? $test_settings : $realTest->setting,

                    ]);
                }
            }
        }

        //delete unselected rays
        $group->tests()->whereNotIn('test_id', $selected_tests)->delete();

        //store assigned rays
        $selected_rays = [];
        if ($request->has('rays')) {
            foreach ($request['rays'] as $ray) {
                $selected_rays[] = $ray['id'];

                $group_ray = GroupRay::where([
                    ['group_id', $id],
                    ['ray_id', $ray['id']],
                ])->first();

                if (isset($group_ray)) {
                    $group_ray->update([
                        'price' => $ray['price'],
                        'is_canceled' => $ray['is_canceled'],
                    ]);
                } else {
                    $group_ray = GroupRay::create([
                        'group_id' => $group->id,
                        'ray_id' => $ray['id'],
                        'price' => $ray['price'],
                    ]);

                    GroupRayResult::create([
                        'group_ray_id' => $group_ray->id,
                        'ray_id' => $ray['id'],
                    ]);
                }
            }
        }

        //delete unselected rays
        $group->rays()->whereNotIn('ray_id', $selected_rays)->delete();

        //store assigned cultures
        $selected_cultures = [];
        $culture_options = CultureOption::where('parent_id', 0)->get();
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $selected_cultures[] = $culture['id'];

                $group_culture = GroupCulture::where([
                    ['group_id', $id],
                    ['culture_id', $culture['id']]
                ])->first();

                if (isset($group_culture)) {
                    $group_culture->update([
                        'price' => $culture['price'],
                        'is_canceled' => $culture['is_canceled'],
                        // 'lab_to_lab_status' => $culture['lab_to_lab_status'],
                        // 'lab_to_lab_cost' => $culture['cost'],
                    ]);
                } else {
                    $group_culture = GroupCulture::create([
                        'group_id' => $group->id,
                        'culture_id' => $culture['id'],
                        'price' => $culture['price'],
                        'setting' => $test_settings,
                        // 'lab_to_lab_status' => $culture['lab_to_lab_status'],
                        // 'lab_to_lab_cost' => $culture['lab_to_lab_cost'],
                    ]);

                    //assign default report
                    foreach ($culture_options as $culture_option) {
                        GroupCultureOption::create([
                            'group_culture_id' => $group_culture['id'],
                            'culture_option_id' => $culture_option['id'],
                        ]);
                    }
                }
            }
        }

        //delete unselected cultures
        $group->cultures()->whereNotIn('culture_id', $selected_cultures)->delete();

        //store assigned packages
        $packages_selected = [];
        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $packages_selected[] = $package['id'];

                $group_package = GroupPackage::where([
                    ['group_id', $id],
                    ['package_id', $package['id']]
                ])->first();

                // original package
                $original_package = Package::find($package['id']);

                if (isset($group_package)) {
                    $group_package->update([
                        'price' => $package['price'],
                        'is_canceled' => $package['is_canceled'],
                    ]);
                    if ($package['is_canceled'] == 1) {
                        GroupTest::where('group_id', $group['id'])
                            ->where('package_id', $group_package['id'])
                            ->update([
                                'is_canceled' => 1
                            ]);
                    }
                } else {
                    $group_package = GroupPackage::create([
                        'group_id' => $group['id'],
                        'package_id' => $package['id'],
                        'price' => $package['price'],

                    ]);

                    //tests
                    foreach ($original_package['tests'] as $test) {
                        $realTest = Test::find($test['id']);

                        GroupTest::create([
                            'group_id' => $group['id'],
                            'test_id' => $test['test']['id'],
                            'package_id' => $group_package['id'],
                            'setting' => ($realTest->setting == null) ? $test_settings : $realTest->setting,

                        ]);
                    }

                    //cultures
                    foreach ($original_package['cultures'] as $culture) {
                        $group_culture = GroupCulture::create([
                            'group_id' => $group['id'],
                            'culture_id' => $culture['culture']['id'],
                            'package_id' => $group_package['id']
                        ]);

                        //assign default report
                        foreach ($culture_options as $culture_option) {
                            GroupCultureOption::create([
                                'group_culture_id' => $group_culture['id'],
                                'culture_option_id' => $culture_option['id'],
                            ]);
                        }
                    }
                }
            }
        }

        if ($request->hasfile('images')) {
            // $index = 0;
            foreach ($request->file('images') as $image) {
                $image_name = $group->id . '.' . 'image_' . now() . ' ' . $image->getClientOriginalExtension();
                $image->move('uploads/group', $image_name);
                invoiceImages::create([
                    'group_id' => $group->id,
                    'img_name' => $image_name,
                ]);
            }
        }

        //delete unselected packages
        $unselected_packages = GroupPackage::where([
            ['group_id', $id],
        ])->whereNotIn('package_id', $packages_selected)
            ->get();

        if (count($unselected_packages)) {
            foreach ($unselected_packages as $unselected_package) {
                $unselected_package->tests()->delete();
                $unselected_package->cultures()->delete();
                $unselected_package->delete();
            }
        }

        //payments
        $group->payments()->delete();
        if ($request->has('payments')) {
            foreach ($request['payments'] as $payment) {
                $group->payments()->create([
                    'date' => $payment['date'],
                    'payment_method_id' => $payment['payment_method_id'],
                    'amount' => $payment['amount'],
                ]);
            }
        }


        $bracode = $group['id'];
        $group->update(['barcode' => $bracode]);

        //assign default report
        $this->assign_tests_report($id);

        //assign consumption
        $this->assign_consumption($group['id']);

        //calculations
        group_test_calculations($id);

        //save receipt pdf
        $group = Group::with(['tests', 'cultures'])->where('id', $id)->first();
        $pdf = generate_pdf($group, 2);


        $type = 2;
        $reports_settings = setting('reports');
        $info_settings = setting('info');
        $barcode_settings = setting('barcode');

        if (isset(setting("account")['invoice_layout']) && setting("account")['invoice_layout'] == 'with_header') {
            $header = false;
        } elseif (isset(setting("account")['invoice_layout']) && setting("account")['invoice_layout'] == 'without_header') {
            $header = true;
        }

        $pdf_2 = PDF::loadView(
            "pdf.receipt_2",
            compact(
                "group",
                "header",
                "reports_settings",
                "info_settings",
                "type",
                "barcode_settings"
            )
        );

        $pdf_name = "uploads/pdf_/receipt_2_" . $group['id'] . ".pdf";
        $pdf_2->save($pdf_name);

        if (isset($pdf)) {
            $group->update(['receipt_pdf' => $pdf]);
            $print = $this->printer($pdf, 'receipt');
        }

        //send notification with the patient code
        $patient = Patient::find($group['patient_id']);
        send_notification('patient_code', $patient);


        $pdf = MedicalReportsController::prePrintPdf2($group, true);
        MedicalReportsController::prePrintPdf2($group, false);


        //save report pdf link

        $group->update(['report_pdf' => $pdf]);


        session()->flash('success', __('Group updated successfully'));
        if ($request->retrieve_amount > 0) {
            return redirect()->route('admin.groups.index');
        }



        return redirect()->route('admin.groups.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroy($id)
    {
        //delete group
        $group = Group::findOrFail($id);
        $group->payments()->delete();

        //delete group tests
        $group_tests = GroupTest::where('group_id', $id)->get();

        //delete test results
        foreach ($group_tests as $group_test) {
            GroupTestResult::where('group_test_id', $group_test['id'])->delete();
        }
        GroupTest::where('group_id', $id)->delete();

        //delete group rays

        $group_rays = GroupRay::where('group_id', $id)->get();

        if ($group_rays) {
            foreach ($group_rays as $group_ray) {
                GroupRayResult::where('group_ray_id', $group_ray->id)->delete();
            }
            GroupRay::where('group_id', $id)->delete();
        }



        //delete group cultures
        $group_cultures = GroupCulture::where('group_id', $id)->get();
        foreach ($group_cultures as $group_culture) {
            GroupCultureResult::where('group_culture_id', $group_culture['id'])->delete();
        }
        GroupCulture::where('group_id', $id)->delete();

        //delete packages
        $group->packages()->delete();

        //delete consumption
        $group->consumptions()->delete();

        //delete group
        $group->delete();

        //return success
        session()->flash('success', __('Group deleted successfully'));
        return redirect()->route('admin.groups.index');
    }

    // retrieve group by id
    public function retrieve($id)
    {

        $group =  Group::findOrfail($id);

        $paid = ($group->paid) - ($group->retrieve_amount);

        if ($paid > get_custody_branch()) {
            session()->flash('failed', __('Not Enough Cach in Custody'));

            return redirect()->back();
        }

        $group->retrieve_amount = $group->paid;
        $group->delete_type = 1;
        $group->deleted_by = auth()->guard('admin')->user()->id;
        $group->retrieve_date = now();
        $group->save();


        Branches_custody::create([
            'branche_id' => session('branch_id'),
            'user_id' => auth()->guard('admin')->user()->id,
            'priceable_id' => $group->id,
            'priceable_type' => 'App\Models\Group',
            'custody' => $paid,
            'custody_type' => 0
        ]);

        foreach ($group->all_tests as $test) {
            $test->update(['is_canceled' => 1]);
        }
        foreach ($group->all_cultures as $test) {
            $test->update(['is_canceled' => 1]);
        }

        session()->flash('warning', __("You Should Return $paid EGP"));

        session()->flash('success', __('Group deleted successfully'));
        return redirect()->route('admin.groups.index');
    }

    // get list of group retrieved

    public function getGroupsRetrieved(Request $request)
    {
        $query = DB::table('groups')
            ->where('delete_type', '1')
            ->leftJoin('patients', 'groups.patient_id', '=', 'patients.id')
            ->leftJoin('users', 'groups.created_by', '=', 'users.id')
            ->leftJoin('users as dele', 'groups.deleted_by', '=', 'dele.id')
            ->leftJoin('branches', 'groups.branch_id', '=', 'branches.id')
            ->select('patients.name as p_name', 'dele.name as dele_name', 'users.name as u_name', 'patients.code as p_code', 'branches.name as b_name', 'groups.*');
        return DataTables::of($query)
            // ->editColumn('created_at', function ($group) {
            //     return date('Y-m-d H:i', strtotime($group['created_at']));
            // })
            ->toJson();
    }

    public function retrieved()
    {
        return view('admin.groups.retrieved');
    }


    /**
     * generate pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        $group = Group::with('patient', 'analyses', 'cultures')->where('id', $id)->first();

        $response = generate_pdf($group, 2);

        if (!empty($response)) {
            return redirect($response['url']);
        } else {
            session()->flash('failed', __('Something Went Wrong'));
            return redirect()->back();
        }
    }


    /**
     * assign default tests report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public   function assign_tests_report($id)
    {
        $group = Group::with('tests')->where('id', $id)->first();

        //tests reports
        foreach ($group['tests'] as $test) {
            if (!$test->has_results) {
                $test->update(['has_results' => true]);

                $separated = Test::where('id', $test['test_id'])->first();

                if ($separated['separated']) {
                    GroupTestResult::create([
                        'group_test_id' => $test['id'],
                        'test_id' => $test['test_id'],
                    ]);
                }

                foreach ($test['test']['components'] as $component) {
                    GroupTestResult::create([
                        'group_test_id' => $test['id'],
                        'test_id' => $component['id'],
                    ]);
                }
            }
        }

        //packages reports
        if (count($group['packages'])) {
            foreach ($group['packages'] as $package) {
                if (count($package['tests'])) {
                    foreach ($package['tests'] as $test) {
                        if (!$test->has_results) {
                            $test->update(['has_results' => true]);

                            $separated = Test::where('id', $test['test_id'])->first();

                            if ($separated['separated']) {
                                GroupTestResult::create([
                                    'group_test_id' => $test['id'],
                                    'test_id' => $test['test_id'],
                                ]);
                            }

                            foreach ($test['test']['components'] as $component) {
                                GroupTestResult::create([
                                    'group_test_id' => $test['id'],
                                    'test_id' => $component['id'],
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }



    /**
     * print barcode
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_barcode(Request $request, $id)
    {
        $group = Group::find($id);

        $group->barcoded_by = auth()->guard('admin')->user()->id;
        $group->barcoded_date = now();

        $group->save();

        $sample_type_arr = $request['sample_type_arr'];

        $type = 2;
        $reports_settings = setting('reports');
        $info_settings = setting('info');
        $barcode_settings = setting('barcode');

        if ($group->rays->count()) {
            $pdf = PDF::loadView(
                "pdf.barcode_ray",
                compact("group", "barcode_settings"),
                [],
                [
                    "format" => [$barcode_settings["width"][session('branch_id')], $barcode_settings["height"][session('branch_id')]]
                ]
            );
            $pdf_name = "barcode.pdf";
            $pdf->save("uploads/pdf/" . $pdf_name);
            $pdf = url("uploads/pdf/" . $pdf_name);
        } else {

            $pdf = print_barcode($group, $sample_type_arr);
        }

        // $this->printer($pdf,'parcode',$sample_type_arr );

        return redirect($pdf);
    }


    public function print_barcode_file(Request $request, $id)
    {
        //  dd($request->all());
        $group = Group::find($id);

        $group->barcoded_by = auth()->guard('admin')->user()->id;
        $group->barcoded_date = now();

        $group->save();

        $sample_type_arr = $request['sample_type_arr'];

        $type = 2;
        $reports_settings = setting('reports');
        $info_settings = setting('info');
        $barcode_settings = setting('barcode');

        if ($group->rays->count()) {
            $pdf = PDF::loadView(
                "pdf.barcode_ray",
                compact("group", "barcode_settings"),
                [],
                [
                    "format" => [$barcode_settings["width"][session('branch_id')], $barcode_settings["height"][session('branch_id')]]
                ]
            );
            $pdf_name = "barcode.pdf";
            $pdf->save("uploads/pdf/" . $pdf_name);
            $pdf = url("uploads/pdf/" . $pdf_name);
        } else {

            $pdf = print_barcode_file($group, $sample_type_arr);
        }

        // $this->printer($pdf,'parcode',$sample_type_arr );

        return redirect($pdf);
    }

    /**
     * send receipt mail
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send_receipt_mail(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $patient = $group['patient'];

        send_notification('receipt', $patient, $group);

        session()->flash('success', __('Mail sent successfully'));

        return redirect()->route('admin.groups.index');
    }

    /**
     * Assign consumptions to invoice
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign_consumption($id)
    {
        $group = Group::find($id);
        $group->consumptions()->delete();

        if (isset($group)) {
            foreach ($group['all_tests'] as $test) {
                if (isset($test['test'])) {
                    foreach ($test['test']['consumptions'] as $consumption) {
                        $group->consumptions()->create([
                            'branch_id' => $group['branch_id'],
                            'testable_type' => 'App\Models\Test',
                            'testable_id' => $test['test_id'],
                            'product_id' => $consumption['product_id'],
                            'quantity' => $consumption['quantity']
                        ]);
                    }
                }
            }
            foreach ($group['rays'] as $ray) {
                if (isset($ray['ray'])) {
                    foreach ($ray['ray']['consumptions'] as $consumption) {
                        $group->consumptions()->create([
                            'branch_id' => $group['branch_id'],
                            'testable_type' => 'App\Models\Ray',
                            'testable_id' => $ray['ray_id'],
                            'product_id' => $consumption['product_id'],
                            'quantity' => $consumption['quantity']
                        ]);
                    }
                }
            }

            foreach ($group['all_cultures'] as $culture) {
                if (isset($culture['culture'])) {
                    foreach ($culture['culture']['consumptions'] as $consumption) {
                        $group->consumptions()->create([
                            'branch_id' => $group['branch_id'],
                            'testable_type' => 'App\Models\Culture',
                            'testable_id' => $culture['culture_id'],
                            'product_id' => $consumption['product_id'],
                            'quantity' => $consumption['quantity']
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Print working paper
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function working_paper($id)
    {
        $group = Group::findOrFail($id);

        $group->working_paper_by = auth()->guard('admin')->user()->id;
        $group->working_paper_date = now();

        $group->save();

        $pdf = generate_pdf($group, 7);

        $print =  $this->printer($pdf, 'working_paper');

        return redirect($pdf);
    }

    public static function printer($pdf, $type, $number = 1)
    {

        $setting_printer = (Setting::where('key', 'printer')->first()) ?  setting('printer') : null;
        // dd($setting_printer);
        if ($setting_printer == null) {
            return false;
        }

        $printer = new Printer();
        $printer->url_pdf = $pdf;
        $printer->print_type = $type;
        $printer->count = $number;
        $printer->printer_name = setting('printer')["$type"];
        $printer->save();

        return true;
    }

    /**
     * Bulk delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(BulkActionRequest $request)
    {
        foreach ($request['ids'] as $id) {
            //delete group
            $group = Group::findOrFail($id);
            $group->payments()->delete();

            //delete group tests
            $group_tests = GroupTest::where('group_id', $id)->get();

            //delete test results
            foreach ($group_tests as $group_test) {
                GroupTestResult::where('group_test_id', $group_test['id'])->delete();
            }
            GroupTest::where('group_id', $id)->delete();

            //delete group cultures
            $group_cultures = GroupCulture::where('group_id', $id)->get();
            foreach ($group_cultures as $group_culture) {
                GroupCultureResult::where('group_culture_id', $group_culture['id'])->delete();
            }
            GroupCulture::where('group_id', $id)->delete();

            //delete packages
            $group->packages()->delete();

            //delete consumption
            $group->consumptions()->delete();

            //delete group
            $group->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.groups.index');
    }

    /**
     * Bulk print barcodes
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_print_barcode(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])->get();

        $pdf = print_bulk_barcode($groups);

        return redirect($pdf);
    }

    /**
     * Bulk print receipts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_print_receipt(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])->get();

        $pdf = PDFMerger::init();

        foreach ($groups as $group) {
            //generate pdf
            $url = generate_pdf($group, 2);

            $pdf->addString(file_get_contents($url));
        }

        $pdf->merge();
        $pdf->save('uploads/pdf/bulk.pdf');

        return redirect('uploads/pdf/bulk.pdf');
    }

    /**
     * Bulk print working paper
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_print_working_paper(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])->get();

        $pdf = print_bulk_working_paper($groups);

        return redirect($pdf);
    }

    /**
     * Bulk send receipt mail
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_send_receipt_mail(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])->get();

        foreach ($groups as $group) {
            $patient = $group['patient'];
            send_notification('receipt', $patient, $group);
        }

        session()->flash('success', __('Receipts have been sent successfully'));
        return redirect()->route('admin.groups.index');
    }

    // update check test of table group test
    public function checkTest(Request $request, $id)
    {
        // dd($request->all());
        $group_test = Group::findOrFail($id);

        if ($request->test_id) {

            foreach ($request->test_id as $key => $test) {

                $group_test->all_tests()->where('id', $test)->update([
                    'check_test' => $request->check_test[$key] != null ? 1 : 0,
                    'check_test_by' => $request->check_test[$key] != null ? auth()->guard('admin')->user()->id : null,
                    'check_test_date' => $request->check_test[$key] != null ? now() : null
                ]);
            }

            if (isset($request->sample_status_test)) {
                foreach ($request->sample_status_test as $key => $test) {
                    $group_test->all_tests()->where('id', $key)->update([
                        'sample_status' => $test

                    ]);
                }
            }


            if (isset($request->sample_status_notes_test)) {
                foreach ($request->sample_status_notes_test as $key => $test) {
                    $group_test->all_tests()->where('id', $key)->update([
                        'sample_status_notes' => $test

                    ]);
                }
            }
        }




        if ($request->culture_id) {

            foreach ($request->culture_id as $key => $test) {

                $group_test->all_cultures()->where('id', $test)->update([
                    'check_test' => $request->check_test[$key] != null ? 1 : 0,
                    'check_test_by' => $request->check_test[$key] != null ? auth()->guard('admin')->user()->id : null,
                    'check_test_date' => $request->check_test[$key] != null ? now() : null
                ]);
            }

            if (isset($request->sample_status_culture)) {
                foreach ($request->sample_status_culture as $key => $culture) {
                    // dd($key);
                    $group_test->all_cultures()->where('id', $key)->update([
                        'sample_status' => $culture

                    ]);
                }
            }
            if (isset($request->sample_status_notes_culture)) {
                foreach ($request->sample_status_notes_culture as $key => $culture) {
                    $group_test->all_cultures()->where('id', $key)->update([
                        'sample_status_notes' => $culture

                    ]);
                }
            }
        }


        return redirect()->back()->with('success', __('Check test updated successfully'));
    }

    public function Calculator()
    {
        $contracts = Contract::all();
        $governments = Government::select('id', 'name')->get();
        return view('admin.groups.calculate', compact('contracts', 'governments'));
    }

    public function cycle($id)
    {
        $group = Group::with('all_tests')->findOrFail($id);
        return view('admin.groups.cycle', compact('group'));
    }
    public function payDelayedMoney(Request $request)
    {

        try {
            foreach ($request->values as $key => $value) {
                if ($value != null and $value != 0) {
                    $group = Group::find($request->ids[$key]);
                    GroupPayment::create([
                        'group_id'          => $request->ids[$key],
                        'date'              => Carbon::now()->format('Y-m-d'),
                        'payment_method_id' => 1,
                        'amount'            => $value
                    ]);
                    $group->delayed_money = 0;

                    $group->paid += $value;
                    $group->save();

                    $group->due = $group->total - $group->paid;
                    $group->save();
                }
            }
            return response()->json(['success' => true, 'msg' => __('Delayed money paid successfully')]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'msg' => __('Something went wrong')]);
        }
    }

    public function paidDue($group_id)
    {
        try {
            $group = Group::find($group_id);


            $expenseCategroy = ExpenseCategory::firstOrCreate(['name' => 'Due For Patient']);

            $expense = Expense::create([
                'expense_category_id' => $expenseCategroy->id,
                'payment_method_id' => setting('account')['payment'],
                'amount' => $group->due_for_patient,
                'date' => get_system_date(),
                'branch_id' => session('branch_id'),
                'doctor_id' => auth()->guard('admin')->user()->id
            ]);


            // Log::Info(['group_padid' => $group->paid]);

            // $diff = ($group->paid - $group->due_for_patient);
            // Log::Info(['Due For' => $group->due_for_patient]);
            // Log::Info(['Due diff' => $diff]);
            // Group::where('group_id',  $group_id)->update([
            //     'paid' => ($group->paid - $group->due_for_patient),
            // ]);

            if (isset(setting('account')['expenses_type']) && setting('account')['expenses_type'] == "custody") {
                if ($group->due_for_patient > get_custody_branch()) {
                    session()->flash('failed', __('Custody Not Less Than Amount'));
                    return redirect()->back();
                }


                Branches_custody::create([
                    'branche_id' => session('branch_id'),
                    'custody' => $group->due_for_patient,
                    'user_id' => auth()->guard('admin')->user()->id,
                    'priceable_type' => 'App\Models\Expense',
                    'priceable_id' => $expense->id,
                    'custody_type' => 0
                ]);
            }

            if ($group->due_for_patient > 0) {
                // GroupPayment::create([
                //     'group_id'          => $group_id,
                //     'date'              => Carbon::now()->format('Y-m-d'),
                //     'payment_method_id' => 1,
                //     'amount'            => $group->due_for_patient > 0 ? (-1 * $group->due_for_patient) : $group->due_for_patient,
                // ]);

                // $group->update(['paid' => ($group->paid - $group->due_for_patient)]);
                $group->update(['due_for_patient' => 0]);
            }

            // if ($group->due < 0) {
            //     GroupPayment::create([
            //         'group_id'          => $group_id,
            //         'date'              => Carbon::now()->format('Y-m-d'),
            //         'payment_method_id' => 1,
            //         'amount'            => $group->due > 0 ? (-1 * $group->due) : $group->due,
            //     ]);
            //     $group->update(['paid' => ($group->paid - $group->due_for_patient)]);
            //     $group->update(['due' => 0]);
            // }
            session()->flash('success', __('Paid Due for Patient successfully'));
            return redirect()->route('admin.groups.index');
        } catch (\Exception $exception) {
            session()->flash('faild', __('Something went wrong'));
            return redirect()->route('admin.groups.index');
        }
    }

    public function rayBasedBy(Request $request, $id)
    {
        $group = Group::find($id);
        foreach ($request->based_by as $key => $user) {
            $group->rays()->where('ray_id', $key)->update(['based_by' => $user]);
        }

        return redirect()->back()->with('success', __('Check test updated successfully'));
    }


    public static function send_whatsapp_massage($message, $phone, $temp, $sub_massage = null)
    {
        $fcmUrl = "https://graph.facebook.com/v15.0/104505749186776/messages";

        $headers = [
            'Authorization: Bearer EAASkCUF4DjUBAKc2drlZCJYIZA8PZBkUvJV3BOQUuZAFZBMTR9TPo74bGupuQXtZB2lnZCfYQxbxOUjOwt5Ez0fdUmnrd7ryrZCoz21TIsFZB5uLBs8LKkBhDIvgQeOzQquzafjeUbySf4zNhUOWqpC3E8471cUyDQ5PBIC0wFs4dVBL5ZBprQNeNC75bZAyjLZC942NFGyFioR5cmZAQuV4FgQykLk2TqZC1oJh8ZD',
            'Content-Type: application/json'
        ];

        $data = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => "$phone",
            "type" => "template",
            "template" => [
                "name" => "$temp",
                "language" => [
                    "code" => "ar"
                ],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => "TEXT-STRING"
                            ]
                        ]
                    ],
                    [
                        "type" => "button",
                        "sub_type" => "url",
                        "index" => "0",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" => "$sub_massage"
                            ]
                        ]
                    ]
                ]

            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
