<?php

namespace App\Http\Controllers\Admin;

use App;
use PDF;
use Throwable;
use DataTables;
use App\Models\Test;
use App\Models\User;
use App\Models\Group;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\Category;
use App\Models\GroupRay;
use App\Models\GroupTest;
use App\Models\Antibiotic;
use App\Models\TestOption;
use App\Models\TestComment;
use App\Models\GroupCulture;
use Illuminate\Http\Request;
use App\Models\GroupRayResult;
use App\Models\GroupTestResult;
use App\Models\GroupCultureOption;
use App\Models\GroupCultureResult;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ReportReferanceRange;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Controllers\Admin\GroupsController;
use App\Http\Requests\Admin\UploadReportRequest;
use App\Http\Requests\Admin\UpdateCultureResultRequest;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class MedicalReportsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_medical_report', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('can:create_mediacl_report', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('can:edit_medical_report', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('can:delete_medical_report', [
            'only' => ['destroy', 'bulk_delete'],
        ]);
        $this->middleware('can:show_without_sgin_medical_report', [
            'only' => ['print_show_report'],
        ]);
        // $this->middleware('can:sign_medical_report', ['only' => ['sign']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request['type'] ?: 'all';
        if ($request->ajax()) {
            if (
                auth()
                    ->guard('admin')
                    ->user()->lab_id != null
            ) {
                $model = Group::query()
                    ->with(
                        'patient',
                        'tests',
                        'cultures',
                        'contract',
                        'signed_by_user',
                        'created_by_user'
                    )
                    ->whereHas('contract', function ($q) {
                        $q->where(
                            'id',
                            auth()
                                ->guard('admin')
                                ->user()->lab_id
                        );
                    });
            } elseif (
                auth()
                    ->guard('admin')
                    ->user()->address != null
            ) {
                $model = Group::query()
                    ->with(
                        'patient',
                        'tests',
                        'cultures',
                        'contract',
                        'signed_by_user',
                        'created_by_user'
                    )
                    ->where(
                        'doctor_id',
                        auth()
                            ->guard('admin')
                            ->user()->id
                    );
            } else {
                $model = Group::query()->with(
                    'patient',
                    'tests',
                    'cultures',
                    'branch',
                    'contract',
                    'signed_by_user',
                    'created_by_user'
                );
                //->where('branch_id',session('branch_id'));
            }

            if ($request['type'] == 'done') {
                $model->where('done', 1);
            } else if($request['type'] == 'pending') {
                $model->where('done', 0);
            } else if($request['type'] == 'sample_status') {
                $model->whereHas('tests',function($q){$q->where('sample_status','1');});
            } else if($request['type'] == 'unsigned') {
                $model->where('signed_by', null);
            }

            if ($request['filter_status'] != '') {
                $model->where('done', $request['filter_status']);
            }

            if ($request['filter_barcode'] != '') {
                $model->where('barcode', $request['filter_barcode']);
            }

            if ($request['filter_created_by'] != '') {
                $model->whereIn('created_by', $request['filter_created_by']);
            }

            if ($request['filter_signed_by'] != '') {
                $model->whereIn('signed_by', $request['filter_signed_by']);
            }

            if ($request['filter_contract'] != '') {
                $model->whereIn('contract_id', $request['filter_contract']);
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
                ->editColumn('patient.gender', function ($group) {
                    return __(ucwords($group['patient']['gender']));
                })
                ->editColumn('tests', function ($group)use($type) {
                    return view(
                        'admin.medical_reports._tests',
                        compact('group','type')
                    );
                })
                ->addColumn('signed', function ($group) {
                    return view(
                        'admin.medical_reports._signed',
                        compact('group')
                    );
                })
                ->editColumn('done', function ($group) {
                    return view(
                        'admin.medical_reports._status',
                        compact('group')
                    );
                })
                ->addColumn('action', function ($group) {
                    return view(
                        'admin.medical_reports._action',
                        compact('group')
                    );
                })
                ->addColumn('bulk_checkbox', function ($item) {
                    return view('partials._bulk_checkbox', compact('item'));
                })
                ->editColumn('created_at', function ($group) {
                    return date('Y-m-d H:i', strtotime($group['created_at']));
                })
                ->toJson();
        }
        
        return view('admin.medical_reports.index', compact('type'));
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

        $user = User::find(auth()->guard('admin')->user()->id);

        $branchIds = [];

        foreach($user->branches as $branch){
            $branchIds[] = $branch->branch_id;
        }

        if(!in_array($group->branch_id,$branchIds)){
            session()->flash('failed',__("You Done Have Access To This Branch"));
            return redirect()->back(); 
        }

        $next = Group::where('id', '>', $id)
            ->orderBy('id', 'asc')
            ->first();
        $previous = Group::where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->first();

        return view(
            'admin.medical_reports.show',
            compact('group', 'next', 'previous')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete group
        $group = Group::findOrFail($id);
        $group->payments()->delete();

        //delete group tests
        $group_tests = GroupTest::where('group_id', $id)->get();

        //delete test results
        foreach ($group_tests as $group_test) {
            GroupTestResult::where(
                'group_test_id',
                $group_test['id']
            )->delete();
        }
        GroupTest::where('group_id', $id)->delete();

        //delete group cultures
        $group_cultures = GroupCulture::where('group_id', $id)->get();
        foreach ($group_cultures as $group_culture) {
            GroupCultureResult::where(
                'group_culture_id',
                $group_culture['id']
            )->delete();
        }
        GroupCulture::where('group_id', $id)->delete();

        //delete packages
        $group->packages()->delete();

        //delete consumption
        $group->consumptions()->delete();

        //delete group
        $group->delete();

        //return success
        session()->flash('success', __('Medical report deleted successfully'));
        return redirect()->route('admin.medical_reports.index');
    }

    /**
     * Generate report pdf
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        // $count = 0;
        // foreach($group->all_tests as $test){
        //     if($test->signed_by != null){
        //         $count = 1;
        //     }
        // }

        // if ($count == 0) {
        //     session()->flash('failed', 'عفواً لم يتم التوقيع بعد ');
        //     return redirect()->back();
        // }

        $group->medical_print_by = Auth()->guard('admin')->user()->id;
        $group->medical_print_date = now();

        $group->save();

        if ($group['uploaded_report']) {
            GroupsController::printer($group['report_pdf'],'report');
            // return redirect($group['report_pdf']);
        }

        //set null if no analysis or cultures selected
        if (empty($request['tests'])) {
            $request['tests'] = [-1];
        }
        if (empty($request['cultures'])) {
            $request['cultures'] = [-1];
        }

        $group->all_tests()->update(['sort' => 0 , 'new_line' => 0]);
        $group->all_cultures()->update(['sort' => 0 , 'new_line' => 0]);

        if($request->has('sort_test')){    
            foreach($request->sort_test as $key => $val){
                $gt = GroupTest::find($key);
                $gt->sort = $val;
                $gt->save();   
            }
        }

        if($request->has('new_line_test')){
            foreach($request->new_line_test as $key => $val){
                $gt = GroupTest::find($key);
                $gt->new_line = $val;
                $gt->save();
            }
        }
        if($request->has('sort_culture')){
            
            foreach($request->sort_culture as $key => $val){
                $gt = GroupCulture::find($key);
                $gt->sort = $val;
                $gt->save();
            }
        }

        if($request->has('new_line_culture')){
            foreach($request->new_line_culture as $key => $val){
                $gt = GroupCulture::find($key);
                $gt->new_line = $val;
                $gt->save();
            }
        }

        //categories
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done',1)
                ->whereIn('id', $request['tests'])
                ->orderBy('sort')
                ->get();

            $category['tests'] = $tests;


            $category['cultures'] = GroupCulture::whereHas('culture', function (
                $query
            ) use ($category) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->whereIn('id', $request['cultures'])
                ->get();

            $rays = GroupRay::where('group_id', $group['id'])->get();
            if($rays){
                $category['rays'] = $rays;
            }

        }

        //find group
        $group = Group::with([
            'all_tests' => function ($q) use ($request) {
                return $q->whereIn('id', $request['tests']);
            },
            'all_cultures' => function ($q) use ($request) {
                return $q->whereIn('id', $request['cultures']);
            },
        ])
            ->where('id', $id)
            ->first();

        // session put report_design
        session()->put('report_design', $request['report_design']);

        // dd($request->all());

        //generate pdf
        $data = ['group' => $group, 'categories' => $categories];
        $pdf = generate_pdf($data);

        GroupsController::printer($pdf,'report');

        return redirect($pdf); //return pdf url
    }

    /**
     * Print report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_report($id)
    {
        $group = Group::findOrFail($id);

        // $count = 0;
        // foreach($group->all_tests as $test){
        //     if($test->signed_by != null){
        //         $count++;
        //     }
        // }

        // if ($count == 0) {
        //     session()->flash('failed', 'عفواً لم يتم التوقيع بعد ');
        //     return redirect()->back();
        // }

        $group->medical_print_by = Auth()->guard('admin')->user()->id;
        $group->medical_print_date = now();

        $group->save();

        if ($group['uploaded_report']) {
            GroupsController::printer($group['report_pdf'],'report');
            return redirect($group['report_pdf']);
        }

        //categories
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done',1)
                ->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });



            $rays = GroupRay::where('group_id', $group['id'])
                ->get();

            if($rays){
                $category['rays'] = $rays;
            }




            $category['cultures'] = GroupCulture::whereHas('culture', function (
                $query
            ) use ($category) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->get();
        }

        //generate pdf
        $data = ['group' => $group, 'categories' => $categories];

        $pdf = generate_pdf($data);

        GroupsController::printer($pdf,'report');

        return redirect($pdf); //return pdf url
    }
    /**
     * Print report with out sign
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_show_report($id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf']);
        }

        //categories
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done',1)
                ->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $rays = GroupRay::where('group_id', $group['id'])
                ->get();

            if($rays){
                $category['rays'] = $rays;
            }

            $category['cultures'] = GroupCulture::whereHas('culture', function (
                $query
            ) use ($category) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->get();
        }

        //generate pdf
        $data = ['group' => $group, 'categories' => $categories];

        $pdf = generate_pdf($data);

        GroupsController::printer($pdf,'report');

        return redirect($pdf); //return pdf url
    }

    public function print_report_2(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $group->medical_print_by = Auth()->guard('admin')->user()->id;
        $group->medical_print_date = now();

        $group->save();

        if ($group['uploaded_report']) {
            GroupsController::printer($group['report_pdf'],'report');
        }

        //categories
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done',1)
                // ->whereIn('id', explode(',', $request['tests']))
                ->orderBy('sort')
                ->get();

            $category['tests'] = $tests;


            $category['cultures'] = GroupCulture::whereHas('culture', function (
                $query
            ) use ($category) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done',1)
                // ->whereIn('id', explode(',', $request['cultures']))
                ->get();

            $rays = GroupRay::where('group_id', $group['id'])->get();
            if($rays){
                $category['rays'] = $rays;
            }

        }

        //find group
        if ($request['tests'] || $request['cultures']) {

            $group = Group::with([
                'all_tests' => function ($q) use ($request) {
                    return $q->whereIn('id', explode(',', $request['tests']))->where('done',1) ;
                },
                'all_cultures' => function ($q) use ($request) {
                    return $q->whereIn('id', explode(',', $request['cultures']))->where('done',1);
                },
            ])
                ->where('id', $id)
                ->first();
        } else {
            $group = Group::with([
                'all_tests',
                'all_cultures'
            ])
                ->where('id', $id)
                ->first();
        }

        // session put report_design
        session()->put('report_design', $request['report_design']);

        // dd($request->all());

        //generate pdf
        $data = ['group' => $group, 'categories' => $categories];
        $pdf = generate_pdf_2($data);

        GroupsController::printer($pdf,'report');

        return redirect($pdf); //return pdf url
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $group = Group::with(['all_tests' => function ($q) {
            return $q->with('test.components');
        }, 'all_cultures' , 'rays'])->where('id', $id)
            // ->where('branch_id')
            ->firstOrFail();

            $user = User::find(auth()->guard('admin')->user()->id);

            $branchIds = [];

            foreach($user->branches as $branch){
                $branchIds[] = $branch->branch_id;
            }

            if(!in_array($group->branch_id,$branchIds)){
                session()->flash('failed',__("You Done Have Access To This Branch"));
                return redirect()->back(); 
            }

        $select_antibiotics = Antibiotic::select('id','name','shortcut','commercial_name','created_at','updated_at')->get();

        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();


        foreach ($group->all_tests as $test) {
            foreach ($test['results'] as $results) {
                foreach ($results['component']['reference_ranges'] as $result) {
                    //dd($result , $result['gender'] , $result['gender'] !== 'both' ,$results['component']);
                    // if(empty( $results['component']['reference_range'] )){
                    if ($result['gender'] != 'both') {
                        $db = $result
                            ->where('test_id', $result['test_id'])
                            ->where('gender', $group->patient->gender)
                            ->where('age_from_days', '<=', (int) $group->patient->age_days)
                            ->where('age_to_days', '>=', (int) $group->patient->age_days)
                            ->first();
                        if ($db !== null) {
                            // $results['component']->update(['reference_range' => $db->normal_from . ':' . $db->normal_to]);
                        }
                    } else {
                        $db = $result
                            ->where('test_id', $result['test_id'])
                            ->where('age_from_days', '<=', (int) $group->patient->age_days)
                            ->where('age_to_days', '>=', (int) $group->patient->age_days)
                            ->first();
                        if ($db !== null) {
                            // $results['component']->update(['reference_range' => $db->normal_from . ':' . $db->normal_to]);
                        }
                    }
                    //}
                }
            }
        }

        //medical_settings
        $medical_settings=setting('medical');

        return view(
            'admin.medical_reports.edit',
            compact('group', 'select_antibiotics', 'next', 'previous','medical_settings')
        );
    }
    /**
     * Update analysis report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $group_test = GroupTest::where('id', $id)->firstOrFail();

        $group = Group::where('id', $group_test['group_id'])
            // ->where('branch_id', session('branch_id'))
            ->firstOrFail();

        $user = User::find(auth()->guard('admin')->user()->id);

        $branchIds = [];

        foreach($user->branches as $branch){
            $branchIds[] = $branch->branch_id;
        }

        if(!in_array($group->branch_id,$branchIds)){
            session()->flash('failed',__("You Done Have Access To This Branch"));
            return redirect()->back(); 
        }

        $group->update([
            'uploaded_report' => false,
        ]);

        GroupTest::where('id', $id)->update([
            'done' => true,
            'results_by' => auth()->guard('admin')->user()->id,
            'comment' => $request['comment'],
        ]);

        $group = Group::find($group_test['group_id']);

        $patientGroups = Patient::with('groups.all_tests')
            ->find($group['patient_id'])
            ->groups()
            ->with('all_tests')
            ->where('id','<',$group['id'])
            ->where('done',1)
            ->orderBy('id','desc')
            ->get();
            // dd($request->test_id);
            // dd($patientGroups->toArray());
        $m_id = '';
        foreach ($patientGroups as $gro) {
            $gro->tests = $gro->all_tests->where('test_id',$request->test_id);
            if($gro->tests->isNotEmpty()){
                $m_id = $gro->id;
                break;
            }
        }
        
        $resultes = GroupTest::with('results.component')->where('group_id',$m_id)->where('test_id',$request->test_id)->get();
        if($resultes->isNotEmpty() ){
            $resultes1 = $resultes[0];

            $resultes1->newResults = GroupTestResult::where('group_test_id',$resultes1->id)->whereHas('component' ,function($q){
                return  $q->where('title',0);
            } ) ->get();
        }

        //check if all reports done
        check_group_done($group_test['group_id']);

        //update result
        // dd($request->result);
        if ($request->has('result')) {
            $i = 0;
            $string = '';
            foreach ($request['result'] as $key => $result) {

                $group_test_result = GroupTestResult::with('component')->where(
                    'id',
                    $key
                )->first();

                $test = Test::where(
                    'id',
                    $group_test_result['test_id']
                )->first();

                //add if new option created
                if (isset($test) && $test['type'] == 'select') {
                    $option = TestOption::where([
                        ['test_id', $test['id']],
                        ['name', $result['result']],
                    ])->first();

                    if (!isset($option)) {
                        TestOption::create([
                            'name' => $result['result'],
                            'test_id' => $test['id'],
                        ]);
                    }
                }

                if (!isset($result['status'])) {
                    $result['status'] = '';
                }

                if (!isset($result['result'])) {
                    $result['result'] = '';
                }

                //update result
                // if (array_key_exists('component', $result)) {
                //     $ref_ranges = Test::find($result['component'])->reference_ranges;
                //     if(count($ref_ranges)) {
                //         foreach ($ref_ranges as $ref_range) {
                //             if($group_test_result->comment == null){
                //                 if (($ref_range->gender == $group->patient->gender OR $ref_range->gender == 'both') &&
                //                     (int)$group->patient->age <=($ref_range->age_to_days /365)
                //                     && (int)$group->patient->age >=($ref_range->age_from_days/365)
                //                 ) {
                //                     $group_test_result->update([
                //                         'result' => $result['result'],
                //                         'status' => $result['status'],
                //                         'comment' => $ref_range->normal_from . ':' .$ref_range->normal_to
                //                     ]);
                //                 }
                //             }else{
                //                 // dd($group_test_result->comment);
                //                 $group_test_result->update([
                //                     'result' => $result['result'],
                //                     'status' => $result['status'],
                //                 ]);
                //             }
                //         }
                //     } else {

                //         $group_test_result->update([
                //             'result' => $result['result'],
                //             'status' => $result['status'],
                //             'comment' => $result['comment']
                //         ]);
                //     }

                // } 
                // else {
                //     $group_test_result->update([
                //         'result' => $result['result'],
                //         'status' => $result['status'],
                //         'comment' => $result['comment']
                //     ]);
                // }

                $group_test_result->update([
                    'result' => $result['result'],
                    'status' => $result['status'],
                    'comment' => $result['comment']
                ]);
                
                if(isset($resultes1) && isset($resultes1->newResults[$i]) &&  $this->calcPersentage($resultes1->newResults[$i]->result,$group_test_result->result )  ){
                    $string .= $group_test_result->component->name . " is diffrent of last resulte " . "<br>" ;
                }
                $i++;

            }
            if($string != ''){
                session()->flash('warning', $string);
            }
        }

        //generate pdf
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done',1)
                ->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function (
                $query
            ) use ($category) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->get();
        }

        $pdf = generate_pdf([
            'categories' => $categories,
            'group' => $group,
        ]);

        if (isset($pdf)) {
            $group->update(['report_pdf' => $pdf]);
        }

        // $gro = Group::find($request->group_id);

        // $gro->reference_range_new ? $gro->reference_range_new()->delete(): null;


        // if($request->component_id){
        //     foreach($request->component_id as $key => $comp)
        //     {
        //         ReportReferanceRange::create([
        //             'test_id' => $comp,
        //             'group_id' => $request->group_id,
        //             'referance_range' => $request->reference_range_new[$key],
        //         ]);
        //     }

        // }


        session()->flash('success', __('Test result saved successfully'));

        return redirect()->back();
    }

    /**
     * Update culture report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_culture(UpdateCultureResultRequest $request, $id)
    {

        $group_culture = GroupCulture::findOrFail($id);

        $group = Group::where('id', $group_culture['group_id'])
            ->where('branch_id', session('branch_id'))
            ->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        GroupCultureResult::where('group_culture_id', $id)->delete();

        $group_culture->update([
            'done' => true,
            'results_by' => auth()->guard('admin')->user()->id,
            'comment' => $request['comment'],
        ]);

        //save options
        if ($request->has('culture_options')) {
            foreach ($request['culture_options'] as $key => $value) {
                GroupCultureOption::where('id', $key)->update([
                    'value' => $value,
                ]);
            }
        }

        //save antibiotics
        if ($request->has('antibiotic')) {
            foreach ($request['antibiotic'] as $antibiotic) {
                if (
                    !empty($antibiotic['antibiotic']) &&
                    !empty($antibiotic['sensitivity'])
                ) {
                    GroupCultureResult::create([
                        'group_culture_id' => $id,
                        'antibiotic_id' => $antibiotic['antibiotic'],
                        'sensitivity' => $antibiotic['sensitivity'],
                    ]);
                }
            }
        }

        //check if all reports done
        check_group_done($group_culture['group_id']);

        //generate pdf
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done',1)
                ->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function (
                $query
            ) use ($category) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->get();
        }

        $pdf = generate_pdf([
            'categories' => $categories,
            'group' => $group,
        ]);

        if (isset($pdf)) {
            $group->update(['report_pdf' => $pdf]);
        }

        session()->flash('success', __('Culture result saved successfully'));

        return redirect()->back();
    }
    /**
     * Update ray report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_ray(Request $request, $id)
    {

        $group_ray = GroupRay::findOrFail($id);

        $group = Group::where('id', $group_ray['group_id'])
            ->where('branch_id', session('branch_id'))
            ->firstOrFail();

        $group->update([
            'uploaded_report' => false,
            'done' => true
        ]);


        // GroupRayResult::where('group_ray_id', $id)->delete();

        // $group_ray->update([
        //     // 'checked' => true,
        //     // 'comment' => $request['comment'],
        // ]);

        //update result
        if ($request->has('comment')) {
            // foreach ($request['comment'] as $key => $result) {

            $group_ray_result = GroupRayResult::where(
                'group_ray_id',
                $id
            )->first();

            $group_ray_result->comment = $request->comment;
            $group_ray_result->save();
            // }
        }


        //generate pdf
        // $categories = Category::all();

        // foreach ($categories as $category) {
        //     $tests = GroupTest::whereHas('test', function ($query) use (
        //         $category
        //     ) {
        //         return $query->where('category_id', $category['id']);
        //     })
        //         ->where('group_id', $group['id'])
        //         ->get();

        //     $category['tests'] = $tests->sortBy(function ($test) {
        //         return $test->test->components->count();
        //     });

        //     $category['cultures'] = GroupCulture::whereHas('culture', function (
        //         $query
        //     ) use ($category) {
        //         return $query->where('category_id', $category['id']);
        //     })
        //         ->where('group_id', $group['id'])
        //         ->get();
        // }

        // $pdf = generate_pdf([
        //     'categories' => $categories,
        //     'group' => $group,
        // ]);

        // if (isset($pdf)) {
        //     $group->update(['report_pdf' => $pdf]);
        // }

        session()->flash('success', __('Ray result saved successfully'));

        return redirect()->back();
    }

    /**
     * Sign report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sign($id)
    {
        $group = Group::where('id', $id)->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        if (!empty(auth()->guard('admin')->user()->signature)) {
            //add signature
            if($group->review_by == null){
                session()->flash('failed', __('Please review this testes first'));

                return redirect()->back();
            }
            $group->update([
                'signed_by' => auth()
                    ->guard('admin')
                    ->user()->id,
                'signed_date' => now(),
            ]);

            // $group->all_tests()->whereHas('test',function($q){
            //     return $q->where('done',1);
            // })->update([
            //     'signed_by' => Auth()->guard('admin')->user()->id ,
            //     'signed_date' => now()
            // ]);

            //generate pdf
            $categories = Category::all();

            foreach ($categories as $category) {
                $tests = GroupTest::whereHas('test', function ($query) use (
                    $category
                ) {
                    return $query->where('category_id', $category['id']);
                })
                    ->where('group_id', $group['id'])
                    ->where('done',1)
                    ->get();

                $category['tests'] = $tests->sortBy(function ($test) {
                    return $test->test->components->count();
                });

                $category['cultures'] = GroupCulture::whereHas(
                    'culture',
                    function ($query) use ($category) {
                        return $query->where('category_id', $category['id']);
                    }
                )
                    ->where('group_id', $group['id'])
                    ->get();
            }

            $pdf = generate_pdf([
                'group' => $group,
                'categories' => $categories,
            ]);

            if (isset($pdf)) {
                $group->update(['report_pdf' => $pdf]);
            }

            //send notification to patient
            send_notification('tests_notification', $group['patient']);

            session()->flash('success', __('Report signed successfully'));

            return redirect()->back();
        }

        session()->flash('failed', __('Please select your signature first'));

        return redirect()->back();
    }

    public function review($id)
    {
        $group = Group::with('all_tests.test','all_tests.results')->where('id', $id)->firstOrFail();

        // foreach($group->all_tests as $test){

        //     if($test->review_by == null){
        //         session()->flash('failed', __($test->test->name . " Has Not Reviewed"));

        //         return redirect()->back();
        //     }
        // }
        $group->review_by = Auth()->guard('admin')->user()->id;
        $group->review_date = now();

        $group->save();

        session()->flash('success', __('Report Reviewed successfully'));

        return redirect()->back();
    }
    public function reviewTest($id)
    {
        $test = GroupTest::with('test','results')->findOrFail($id);

        foreach($test->results()->whereHas('component' ,function($q){ return  $q->where('title',0);} ) as $res){
            if( $res->result == null || $res->status == null) {
                session()->flash('failed', __($test->test->name . " Has Not Resultes "));

                return redirect()->back();
            }
        }

        $test->review_by = Auth()->guard('admin')->user()->id;
        $test->review_date = now();

        $test->save();

        session()->flash('success', __($test->test->name . " Reviewed successfully"));

        return redirect()->back();
    }
    public function signTest($id)
    {
        $test = GroupTest::with('test','results')->findOrFail($id);

            if( $test->review_by == null ) {
                session()->flash('failed', __($test->test->name . " Has Not Reviewed "));

                return redirect()->back();
            }
        

        $test->signed_by = Auth()->guard('admin')->user()->id;
        $test->signed_date = now();

        $test->save();

        session()->flash('success', __($test->test->name . " Signed successfully"));

        return redirect()->back();
    }



    /**
     * Send report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send_report_mail(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $patient = $group['patient'];

        send_notification('report', $patient, $group);

        session()->flash('success', __('Mail sent successfully'));

        return redirect()->route('admin.medical_reports.index');
    }

    /**
     * upload report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload_report(UploadReportRequest $request, $id)
    {
        $group = Group::findOrFail($id);

        if ($request->has('report')) {
            $report = $request->file('report');

            $report->move('uploads/pdf', 'report_' . $group['id'] . '.pdf');

            $group->update([
                'uploaded_report' => true,
                'report_pdf' => url(
                    'uploads/pdf/report_' . $group['id'] . '.pdf'
                ),
            ]);
        }

        session()->flash('success', __('Report updated successfully'));

        return redirect()->back();
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
                GroupTestResult::where(
                    'group_test_id',
                    $group_test['id']
                )->delete();
            }
            GroupTest::where('group_id', $id)->delete();

            //delete group cultures
            $group_cultures = GroupCulture::where('group_id', $id)->get();
            foreach ($group_cultures as $group_culture) {
                GroupCultureResult::where(
                    'group_culture_id',
                    $group_culture['id']
                )->delete();
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

        return redirect()->route('admin.medical_reports.index');
    }

    /**
     * Bulk print report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_print_report(BulkActionRequest $request)
    {
        $pdf = PDFMerger::init();

        foreach ($request['ids'] as $id) {
            $group = Group::find($id);

            //generate pdf
            $categories = Category::all();

            foreach ($categories as $category) {
                $tests = GroupTest::whereHas('test', function ($query) use (
                    $category
                ) {
                    return $query->where('category_id', $category['id']);
                })
                    ->where('group_id', $group['id'])
                    ->where('done',1)
                    ->get();

                $category['tests'] = $tests->sortBy(function ($test) {
                    return $test->test->components->count();
                });

                $category['cultures'] = GroupCulture::whereHas(
                    'culture',
                    function ($query) use ($category) {
                        return $query->where('category_id', $category['id']);
                    }
                )
                    ->where('group_id', $group['id'])
                    ->get();
            }

            $pdf_url = generate_pdf([
                'categories' => $categories,
                'group' => $group,
            ]);

            $pdf->addString(file_get_contents($pdf_url));
        }

        $pdf->merge();
        $pdf->save('uploads/pdf/bulk.pdf');

        return redirect('uploads/pdf/bulk.pdf');
    }

    /**
     * Bulk print barcode
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
     * Bulk sign report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_sign_report(BulkActionRequest $request)
    {
        if (
            !empty(auth()
                ->guard('admin')
                ->user()->signature)
        ) {
            $groups = Group::whereIn('id', $request['ids'])->get();

            $categories = Category::all();

            foreach ($groups as $group) {
                $group->update([
                    'uploaded_report' => false,
                ]);

                //add signature
                $group->update([
                    'signed_by' => auth()
                        ->guard('admin')
                        ->user()->id,
                ]);

                //generate pdf
                foreach ($categories as $category) {
                    $tests = GroupTest::whereHas('test', function ($query) use (
                        $category
                    ) {
                        return $query->where('category_id', $category['id']);
                    })
                        ->where('group_id', $group['id'])
                        ->where('done',1)
                        ->get();

                    $category['tests'] = $tests->sortBy(function ($test) {
                        return $test->test->components->count();
                    });

                    $category['cultures'] = GroupCulture::whereHas(
                        'culture',
                        function ($query) use ($category) {
                            return $query->where(
                                'category_id',
                                $category['id']
                            );
                        }
                    )
                        ->where('group_id', $group['id'])
                        ->get();
                }

                $pdf = generate_pdf([
                    'group' => $group,
                    'categories' => $categories,
                ]);

                if (isset($pdf)) {
                    $group->update(['report_pdf' => $pdf]);
                }

                //send notification to patient
                send_notification('tests_notification', $group['patient']);
            }

            session()->flash('success', __('Reports signed successfully'));

            return redirect()->back();
        }

        session()->flash('failed', __('Please select your signature first'));

        return redirect()->back();
    }

    /**
     * Bulk send report mail
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_send_report_mail(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])
            ->where('signed_by', '!=', null)
            ->get();

        if (!count($groups)) {
            session()->flash(
                'failed',
                __('You should sign the reports to be sent')
            );
            return redirect()->back();
        }

        foreach ($groups as $group) {
            $patient = $group['patient'];
            send_notification('report', $patient, $group);
        }

        session()->flash('success', __('Report mails sent successfully'));

        return redirect()->route('admin.medical_reports.index');
    }

    // get comment of group
    public function getComment(Request $request)
    {
        $test = Test::find($request['component_id']);

        if ($request->status == 'Normal') {
            $case = 1;
        } elseif ($request->status == 'High') {
            $case = 2;
        } elseif ($request->status == 'Low') {
            $case = 3;
        } elseif ($request->status == 'Critical high') {
            $case = 4;
        } elseif ($request->status == 'Critical low') {
            $case = 5;
        }

        return response()->json([
            'comments' => TestComment::where([
                ['case_id', $case],
                ['component_id', $request['component_id']],
            ])->get(),
        ]);
    }

    // get comment test
    public function addComment(Request $request)
    {
        $test = Test::find($request['test_id']);

        $comments = [];

        foreach ($request->status as $key => $status) {
            if ($status == 'Normal') {
                $case = 1;
            } elseif ($status == 'High') {
                $case = 2;
            } elseif ($status == 'Low') {
                $case = 3;
            } elseif ($status == 'Critical high') {
                $case = 4;
            } elseif ($status == 'Critical low') {
                $case = 5;
            }

            $comments[$key] = TestComment::where('test_id', $request['test_id'])
                ->whereHas('components', function ($query) use (
                    $case,
                    $request,
                    $key
                ) {
                    $query->where([
                        ['case_id', $case],
                        ['component_id', $request['component'][$key]],
                    ]);
                })
                ->first();
        }

        // get comment with distinct
        $comments = array_unique($comments);

        $comments = array_values($comments);

        return response()->json([
            'comments' => $comments,
        ]);
    }

    // saveReferenceRange
    public function saveReferenceRange(Request $request)
    {
        //  Test::find($request['component_id']);
         $test = GroupTestResult::find($request->test_resulte_id);
         $test->comment = $request->reference;
         $test->save();

        // save reference range
        // $test->update([
        //     'reference_range' => $request->reference,
        // ]);

        

        // $test->reference_range_new_component()->create([
        //     'referance_range' => $request->reference,
        //     'test_id' => $request['component_id'],
        //     'group_id' => $request->group_id
        // ]);

        // falsh message
        session()->flash('success', __('new Reference range saved successfully'));

        return response()->json([
            'status' => 'success',
        ]);
    }

    // includeHistory
    public function includeHistory(Request $request,$id)
    {

        // settion get
        $session = session()->get('history');
        // session put
        if (isset($session) && $session == $id) {
            session()->put('history', false);
            return response()->json([
                'message' => "تم حذف سجل المريض بنجاح $id",
                'code' => '201',
            ]);
        } else {
            session()->put('history', $id);
            return response()->json([
                'message' => "تم اضافة سجل المريض بنجاح $id" ,
                'code' => '200',
            ]);
        }
    }


    public function sendToLab(Request $request)
    {
        if ($request->ajax()) {
            $model = Group::query()->with(
                'patient',
                'tests',
                'cultures',
                'branch',
                'contract',
                'signed_by_user',
                'created_by_user'
            );

            $model->whereHas('tests',function($q){
                return $q->where('send_status','!=',null);
            });

            // if ($request['filter_status'] != '') {
            //     $model->where('done', $request['filter_status']);
            // }

            // if ($request['filter_barcode'] != '') {
            //     $model->where('barcode', $request['filter_barcode']);
            // }

            // if ($request['filter_created_by'] != '') {
            //     $model->whereIn('created_by', $request['filter_created_by']);
            // }

            // if ($request['filter_signed_by'] != '') {
            //     $model->whereIn('signed_by', $request['filter_signed_by']);
            // }

            // if ($request['filter_contract'] != '') {
            //     $model->whereIn('contract_id', $request['filter_contract']);
            // }

            // if ($request['filter_date'] != '') {
            //     $date = explode('-', $request['filter_date']);
            //     $from = date('Y-m-d', strtotime($date[0]));
            //     $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //     $date[0] == $date[1]
            //         ? $model->whereDate('created_at', $from)
            //         : $model->whereBetween('created_at', [$from, $to]);
            // }

            return DataTables::eloquent($model)
                ->editColumn('patient.gender', function ($group) {
                    return __(ucwords($group['patient']['gender']));
                })
                ->editColumn('tests', function ($group) {
                    return view(
                        'admin.send_test_lab._tests',
                        compact('group')
                    );
                })
                ->addColumn('status', function ($group) {
                    return view(
                        'admin.send_test_lab._status_send',
                        compact('group')
                    );
                })
                ->addColumn('cost', function ($group) {
                    return view(
                        'admin.send_test_lab._cost',
                        compact('group')
                    );
                })
                ->editColumn('send_date', function ($group) {
                    return view(
                        'admin.send_test_lab._send_date',
                        compact('group')
                    );
                })
                ->editColumn('lab_out', function ($group) {
                    return view(
                        'admin.send_test_lab._lab_out',
                        compact('group')
                    );
                })
                ->addColumn('signed', function ($group) {
                    return view(
                        'admin.send_test_lab._signed',
                        compact('group')
                    );
                })
                ->editColumn('done', function ($group) {
                    return view(
                        'admin.send_test_lab._status',
                        compact('group')
                    );
                })
                ->addColumn('notes', function ($group) {
                    return view(
                        'admin.send_test_lab._notes',
                        compact('group')
                    );
                })
                ->editColumn('created_at', function ($group) {
                    return date('Y-m-d H:i', strtotime($group['created_at']));
                })
                ->toJson();
        }
        // $type = $request['type'] ?: 'all';
        return view('admin.send_test_lab.index');
    }

    public function sendToLabSubmit(Request $request)
    {
        // dd($request->toArray());
        if($request->has('checkbox')){
            foreach($request->checkbox as $key => $val){
                GroupTest::find($key)->update(['send_status' => 1,'send_date' => now()]);
            }
        }

        if($request->has('note')){
            foreach($request->note as $key => $val){
                GroupTest::find($key)->update(['notes' => $val]);
            }
        }

        session()->flash('success', __('Saved successfully'));
        return redirect()->route('admin.send_to_lab.index');
    }

    public function calcPersentage($old , $new){
        if(!is_numeric($new) || !is_numeric($new)){
            return false;
        }
        $medical_settings=setting('medical');

        $medical_pars = $medical_settings['report_notice'];
        try{
            $res = $new - $old;
        }catch(Throwable $e){
            return false;
        }


        $res2 = ($medical_pars * $old) / 100;

        if( abs($res) > $res2 ){
            return true;
        }else{
            return false;
        }
    }
}
