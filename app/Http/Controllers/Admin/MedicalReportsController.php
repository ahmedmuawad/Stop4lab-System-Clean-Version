<?php

namespace App\Http\Controllers\Admin;
use PDF;
use Throwable;
use App\Models\Test;
use App\Models\User;
use App\Models\Group;
use App\Models\Patient;
use App\Models\Category;
use App\Models\Contract;
use App\Models\GroupRay;
use App\Models\GroupTest;
use App\Models\Antibiotic;
use App\Models\TestOption;
use App\Models\TestComment;
use Illuminate\Support\Str;
use App\Models\GroupCulture;
use Illuminate\Http\Request;
use App\Models\GroupRayResult;
use App\Models\commentComponet;
use App\Models\GroupTestResult;
use App\Models\GroupCultureOption;
use App\Models\GroupCultureResult;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Controllers\Admin\GroupsController;
use App\Http\Requests\Admin\UploadReportRequest;
use App\Http\Requests\Admin\UpdateCultureResultRequest;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use App\Models\GroupImage;

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
        $categories = Category::get();
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
                        $q->where('id', auth()->guard('admin')->user()->lab_id);
                    });
                $userContract = Contract::find(auth()->guard('admin')->user()->lab_id);
                if ($userContract) {
                    if ($userContract->type == "lab_to_lab") {
                        $model->where('user_id', auth()->guard('admin')->user()->id);
                    }
                }
            } elseif (
                auth()
                ->guard('admin')
                ->user()->commission != null
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
                    'all_tests',
                    'signed_by_user',
                    'created_by_user'
                );

                if (isset(setting('account')['show_medical']) && setting('account')['show_medical'] == 'current') {
                    $model->where('branch_id', session('branch_id'));
                } elseif (isset(setting('account')['show_medical']) && setting('account')['show_medical'] == 'available') {
                    $user = User::with('branches')->find(auth()->guard('admin')->user()->id);

                    $branchIds = array_column($user->branches->toArray(), 'branch_id');

                    $model->whereIn('branch_id', $branchIds);
                }
            }

            if ($request['type'] == 'done') {
                // dd($model->where('done', 1)->get());
                $model->where('done', 1)->whereNotNull('signed_by')->whereNotNull('review_by')->whereNotNull('medical_print_by');
                // $model->
            } else if ($request['type'] == 'pending') {
                $model->where(function($query) {
                 $query->where('done', 0)->orwhereNull('signed_by')->orwhereNull('review_by');
             });
            } else if ($request['type'] == 'sample_status') {
                $model->whereHas('all_tests', function ($q) {
                    $q->where('sample_status', '1');
                })->orWhereHas('all_cultures', function ($q) {
                    $q->where('sample_status', '1');
                });
            } else if ($request['type'] == 'unsigned') {
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
            // Log::Info($request['filter_category']);
            if ($request['filter_category'] != '') {
                Log::Info($request['filter_category']);
                $model->whereHas('all_tests', function ($q) use ($request) {
                    $q->whereHas('test', function ($q) use ($request) {
                        $q->whereIn('category_id', $request['filter_category']);
                    });
                });
            }


            if ($request['filter_unit'] != '') {
                $model->whereHas('all_tests', function ($q) use ($request) {
                    $q->whereHas('test', function ($q) use ($request) {
                        $q->where('unit', $request['filter_unit']);
                    });
                });
            }

            Log::Info(['req' => $request['filter_test']]);
            if ($request['filter_test'] != '') {
                $model->whereHas('all_tests', function ($q) use ($request) {
                    $q->whereHas('test', function ($q) use ($request) {
                        $q->whereIn('id', $request['filter_test']);
                    });
                });
            }


            if ($request['filter_patient'] != '') {
                $model->whereHas('patient', function ($q) use ($request) {
                    $q->where('code', $request['filter_patient'])->orwhere('name', $request['filter_patient']);
                });
            }

            if ($request['filter_from_num'] != '') {
                $model->where('id', '>=', $request['filter_from_num']);
            }

            if ($request['filter_to_num'] != '') {
                $model->where('id', '<=', $request['filter_to_num']);
            }

            if ($request['filter_invoice_num'] != '') {
                $model->where('id', $request['filter_invoice_num']);
            }


            // if ($request['filter_printed'] == 'on') {
            //     Log::Info(['Filter_Prinbt'=>$request['filter_printed']]);
            //     $model->whereNotnull('medical_print_date');
            // }
            if ($request['filter_culture'] != null) {
                $model->whereHas('all_cultures', function ($q) use ($request) {
                    $q->whereHas('culture', function ($q) use ($request) {
                        $q->whereIn('id', $request['filter_culture']);
                    });
                });
            }
            if ($request['filter_doctor'] != '') {
                $model->whereHas('doctor', function ($q) use ($request) {
                    $q->whereIn('id', $request['filter_doctor']);
                });
            }

            if ($request['filter_gender'] != '') {
                $model->whereHas('patient', function ($q) use ($request) {
                    $q->where('gender', $request['filter_gender']);
                });
            }
            if ($request['filter_sorting'] != '') {
                // dd($request['filter_sorting']);
                $model->orderBy($request['filter_sorting'] , 'desc');
            }
            return DataTables::eloquent($model)
                ->editColumn('patient.age', function ($group) {
                    // $group['patient']['age'] = 
                    return $group->patient->getAge2($group->created_at);
                })
                ->editColumn('newDoctor', function ($group) {

                    if ($group['doctor'] != null) {
                        return $group['doctor']['name'];
                    } elseif ($group['normalDoctor'] != null) {
                        return $group['normalDoctor']['name'];
                    } else {
                        return '';
                    }
                })
                ->editColumn('contract', function ($group) {
                    if ($group->user_id != null) {
                        return $group->user->name;
                    } else {
                        return ($group->contract != null) ? $group->contract->title : '';
                    }
                })
                ->editColumn('tests', function ($group) use ($type) {
                    return view(
                        'admin.medical_reports._tests',
                        compact('group', 'type')
                    );
                })
                ->editColumn('is_receive', function ($group) use ($type) {
                    return view(
                        'admin.medical_reports._is_receive',
                        compact('group', 'type')
                    );
                })
                ->addColumn('signed', function ($group) {
                    return view(
                        'admin.medical_reports._signed',
                        compact('group')
                    );
                })
                ->addColumn('printed', function ($group) {

                    return view(
                        'admin.medical_reports._printed',
                        compact('group')
                    );
                })
                ->addColumn('whats_app_send', function ($group) {

                    return view(
                        'admin.medical_reports._whats_app_send',
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
                    $reports_settings = setting('reports');

                    return view(
                        'admin.medical_reports._action',
                        compact('group', 'reports_settings')
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

        return view('admin.medical_reports.index', compact('type', 'categories'));
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

        foreach ($user->branches as $branch) {
            $branchIds[] = $branch->branch_id;
        }

        if (!in_array($group->branch_id, $branchIds)) {
            session()->flash('failed', __("You Done Have Access To This Branch"));
            return redirect()->back();
        }

        $categories = Category::get();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done', 1)
                ->get();
            foreach ($tests as $test) {
                $test->setting = json_decode($test->setting, true);
            }

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $rays = GroupRay::where('group_id', $group['id'])->get();

            if ($rays) {
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

        $next = Group::where('id', '>', $id)
            ->orderBy('id', 'asc')
            ->first();
        $previous = Group::where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->first();

        $group->patient['age2'] = $group->patient->getAge2($group->created_at);

        return view(
            'admin.medical_reports.show',
            compact('group', 'next', 'previous', 'categories')
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
        // dd($id);
        $group = Group::with('images')->findOrFail($id);
        // dd($group->images);
        $group->medical_print_by = Auth()->guard('admin')->user()->id;
        $group->medical_print_date = now();

        $group->save();

        if ($group['uploaded_report']) {
            GroupsController::printer($group['report_pdf'], 'report');;
        }

        //set null if no analysis or cultures selected
        if (empty($request['tests'])) {
            $request['tests'] = [-1];
        }
        if (empty($request['cultures'])) {
            $request['cultures'] = [-1];
        }

        $group->all_tests()->update(['sort' => 0, 'new_line' => 0]);
        $group->all_cultures()->update(['sort' => 0, 'new_line' => 0]);

        if ($request->has('sort_test')) {
            foreach ($request->sort_test as $key => $val) {
                $gt = GroupTest::find($key);
                $gt->sort = $val;
                $gt->save();
            }
        }

        if ($request->has('new_line_test')) {
            foreach ($request->new_line_test as $key => $val) {
                $gt = GroupTest::find($key);
                $gt->new_line = $val;
                $gt->save();
            }
        }
        if ($request->has('sort_culture')) {

            foreach ($request->sort_culture as $key => $val) {
                $gt = GroupCulture::find($key);
                $gt->sort = $val;
                $gt->save();
            }
        }

        if ($request->has('new_line_culture')) {
            foreach ($request->new_line_culture as $key => $val) {
                $gt = GroupCulture::find($key);
                $gt->new_line = $val;
                $gt->save();
            }
        }

        $pdf = $this->prePrintPdfWithRequest($group, $request, false);

        return redirect($pdf); //return pdf url
    }
    public function print_report(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $group->medical_print_by = Auth()->guard('admin')->user()->id;
        $group->medical_print_date = now();

        $group->save();

        if ($group['uploaded_report']) {
            GroupsController::printer($group['report_pdf'], 'report');
        }


        $request['tests'] = empty($request['tests']) ? [-1] : explode(',', $request['tests']);


        $request['cultures'] = empty($request['cultures']) ? [-1] : explode(',', $request['cultures']);


        $pdf = $this->prePrintPdfWithRequest($group, $request, true);

        return redirect($pdf); //return pdf url
    }
    public function print_show_report($id)
    {
        $group = Group::findOrFail($id);

        $pdf = $this->prePrintPdf2($group, true, true);

        return redirect($pdf); //return pdf url
    }
    public function print_report_with_header_action($id)
    {
        $group = Group::findOrFail($id);

        GroupTest::whereIn('id', $group['all_tests']->pluck('id')->toArray())->where('done', 1)->update(['is_printed' => 1]);
        GroupCulture::whereIn('id', $group['all_cultures']->pluck('id')->toArray())->where('done', 1)->update(['is_printed' => 1]);

        $pdf = $this->prePrintPdf2($group, true);

        return redirect($pdf); //return pdf url
    }
    public function print_report_without_header_action($id)
    {
        $group = Group::findOrFail($id);

        GroupTest::whereIn('id', $group['all_tests']->pluck('id')->toArray())->where('done', 1)->update(['is_printed' => 1]);
        GroupCulture::whereIn('id', $group['all_cultures']->pluck('id')->toArray())->where('done', 1)->update(['is_printed' => 1]);

        $pdf = $this->prePrintPdf2($group, false);

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
        }, 'all_cultures', 'rays'])->where('id', $id)
            ->firstOrFail();

        // dd($group->all_tests->toArray());

        $user = User::find(auth()->guard('admin')->user()->id);

        $branchIds = [];

        foreach ($user->branches as $branch) {
            $branchIds[] = $branch->branch_id;
        }

        if (!in_array($group->branch_id, $branchIds)) {
            session()->flash('failed', __("You Done Have Access To This Branch"));
            return redirect()->back();
        }

        $select_antibiotics = Antibiotic::select('id', 'name', 'shortcut', 'commercial_name', 'created_at', 'updated_at')->get();

        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();

        //medical_settings
        $medical_settings = setting('medical');

        $based_arr = [];
        foreach ($group->rays as $ray) {
            $based_arr[] = $ray->based_by;
        }
        if (!in_array(auth()->guard('admin')->user()->id, $based_arr) && $group->rays->count()) {
            session()->flash('failed', __("You Done Have Access To Edit This Report"));
            return redirect()->back();
        }

        $group->patient['age2'] = $group->patient->getAge2($group->created_at);
        Log::Info(['age' => $group->patient['age2']]);
        $collections = $group->all_tests->groupby('test.parent_id');
        // dd($collections->toArray());
        return view(
            'admin.medical_reports.edit',
            compact('group', 'select_antibiotics','collections','next', 'previous', 'medical_settings')
        );
    }
    /**
     * Update analysis report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submit_ajax(Request $request, $id)
    {
        //  dd($request->toArray());

        $group_test = GroupTest::where('id', $id)->with('test')->firstOrFail();

        if ($group_test->test_id = 855) {
            $index = 0;
            if ($request->hasFile('image1')) {
                $image = $request->file('image1');
                Log::Info($image);
                $image_name = $id . '.' . 'image_' . $index++ . ' ' . $image->getClientOriginalExtension();
                $image->move('uploads/semen', $image_name);

                $image = GroupImage::where('group_id', $group_test->group_id)->where('test_id', 855)
                    ->where('image_num', 3)
                    ->first();

                if ($image) {
                    GroupImage::where('group_id', $group_test->group_id)->where('test_id', 855)
                        ->where('image_num', 1)
                        ->update([
                            'image_name' => $image_name,
                        ]);
                } else {
                    GroupImage::create([
                        'group_id' => $group_test->group_id,
                        'test_id' => 855,
                        'image_num' => 1,
                        'image_name' => $image_name,
                    ]);
                }
            }
            if ($request->hasFile('image2')) {

                $image = $request->file('image2');
                Log::Info($image);
                $image_name = $id . '.' . 'image_' . $index++ . ' ' . $image->getClientOriginalExtension();
                $image->move('uploads/semen', $image_name);

                $image = GroupImage::where('group_id', $group_test->group_id)
                    ->where('image_num', 2)
                    ->where('test_id', 855)->first();

                if ($image) {
                    GroupImage::where('group_id', $group_test->group_id)->where('test_id', 855)
                        ->where('image_num', 2)
                        ->update([
                            'image_name' => $image_name,
                        ]);
                } else {
                    GroupImage::create([
                        'group_id' => $group_test->group_id,
                        'test_id' => 855,
                        'image_num' => 2,
                        'image_name' => $image_name,
                    ]);
                }
            }
            if ($request->hasFile('image3')) {

                $image = $request->file('image3');
                Log::Info($image);
                $image_name = $id . '.' . 'image_' . $index++ . ' ' . $image->getClientOriginalExtension();
                $image->move('uploads/semen', $image_name);

                $image = GroupImage::where('group_id', $group_test->group_id)->where('test_id', 855)
                    ->where('image_num', 3)
                    ->first();

                if ($image) {
                    GroupImage::where('group_id', $group_test->group_id)->where('test_id', 855)
                        ->where('image_num', 3)
                        ->update([
                            'image_name' => $image_name,
                        ]);
                } else {
                    GroupImage::create([
                        'group_id' => $group_test->group_id,
                        'test_id' => 855,
                        'image_num' => 3,
                        'image_name' => $image_name,
                    ]);
                }
            }
        }



        // Log::Info();
        $group = Group::where('id', $group_test['group_id'])->firstOrFail();

        $user = User::find(auth()->guard('admin')->user()->id);

        $branchIds = [];

        foreach ($user->branches as $branch) {
            $branchIds[] = $branch->branch_id;
        }

        if (!in_array($group->branch_id, $branchIds)) {
            session()->flash('failed', __("You Done Have Access To This Branch"));
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
            ->where('id', '<', $group['id'])
            ->where('done', 1)
            ->orderBy('id', 'desc')
            ->get();
        $m_id = '';
        foreach ($patientGroups as $gro) {
            $gro->tests = $gro->all_tests->where('test_id', $request->test_id);
            if ($gro->tests->isNotEmpty()) {
                $m_id = $gro->id;
                break;
            }
        }

        $resultes = GroupTest::with('results.component')->where('group_id', $m_id)->where('test_id', $request->test_id)->get();
        if ($resultes->isNotEmpty()) {
            $resultes1 = $resultes[0];

            $resultes1->newResults = GroupTestResult::where('group_test_id', $resultes1->id)->whereHas('component', function ($q) {
                return  $q->where('title', 0);
            })->get();
        }

        //check if all reports done
        check_group_done($group_test['group_id']);

        //update result
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

                    //$result['status'] = '';
                    $result['status']  = $this->findStatus($result);
                }

                if (!isset($result['result'])) {
                    $result['result'] = '';
                }

                $group_test_result->update([
                    'result' => $result['result'],
                    'show' => isset($result['show'])?1:0,
                    'status' => $result['status'],
                    'comment' => $result['comment']
                ]);

                if (isset($resultes1) && isset($resultes1->newResults[$i]) &&  $this->calcPersentage($resultes1->newResults[$i]->result, $group_test_result->result)) {
                    $string .= $group_test_result->component->name . " is diffrent of last resulte " . "<br>";
                }
                $i++;
            }
            if ($string != '') {
                session()->flash('warning', $string);
            }
        }

        MedicalReportsController::prePrintPdf2($group, true);
        MedicalReportsController::prePrintPdf2($group, false);

        $next = $id + 1;

        session()->flash('success', __('Test result saved successfully'));
        return response()->json([
            'success' => 'Test result saved successfully',
            "current" => $id,
            "next" => $next,
            "warning" => $string,
        ]);
    }


    // public function componentComment($comment){
    //     Log::Info(['comment'=>$comment]);
    //     Log::Info("There Exist");
    // }
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
        $pdf = $this->prePrintPdf2($group, true);

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

        //update result
        if ($request->has('comment')) {

            $group_ray_result = GroupRayResult::where(
                'group_ray_id',
                $id
            )->first();

            $group_ray_result->comment = $request->comment;
            $group_ray_result->save();
        }


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

        //add signature
        if ($group->review_by == null) {
            session()->flash('failed', __('Please review this testes first'));

            return redirect()->back();
        }
        $signd_user = Auth()->guard('admin')->user();
        $group->save();
        $group->update([
            'signed_by' => $signd_user->id,
            'signed_date' => now(),
        ]);
        // check_group_done($id);
        //send notification to patient
        send_notification('tests_notification', $group['patient']);

        session()->flash('success', __('Report signed successfully'));

        return redirect()->back();

        // return redirect()->back();
    }

    public function review($id)
    {
        $group = Group::with('all_tests.test', 'all_tests.results')->where('id', $id)->firstOrFail();



        $group->review_by = Auth()->guard('admin')->user()->id;


        $group->review_date = now();

        $group->save();

        // check_group_done($id);

        session()->flash('success', __('Report Reviewed successfully'));

        return redirect()->back();
    }
    public function reviewTest($id)
    {
        $test = GroupTest::with('test', 'results')->findOrFail($id);

        foreach ($test->results()->whereHas('component', function ($q) {
            return  $q->where('title', 0);
        }) as $res) {
            if ($res->result == null || $res->status == null) {
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
        $test = GroupTest::with('test', 'results')->findOrFail($id);

        if ($test->review_by == null) {
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
    $pdfMerger = PDFMerger::init();

    foreach ($request['ids'] as $id) {
        $group = Group::find($id);

        // احصل على رابط ملف PDF
        $pdf_url = $this->prePrintPdf2($group, false);

        // أضف الملف إلى PDFMerger بالطريقة الصحيحة
        $pdfMerger->addPDF(public_path(parse_url($pdf_url, PHP_URL_PATH)), 'all');
    }

    $pdfMerger->merge();
    $pdfMerger->save('uploads/pdf/bulk.pdf');

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

    $categories = $this->prePrintPdf2($group, true); // <-- تم إضافة الباراميتر الثاني
    $pdf = generate_pdf_2([
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

    public function evaluteComment($request, $comment, $key)
    {
        
        $firstCondition = false;
        $secondCondition = false;
        $thirdCondition = false;
        if (isset($comment->operationComments->operation)) {
            switch ($comment->operationComments->operation->id) {
                case 1:
                    if ($request->values[$key] < (int)$comment->operationComments->value1) {
                        $firstCondition = $request->values[$key] < (int)$comment->operationComments->value1;
                    }
                    break;
                case 2:
                    if ($request->values && $request->values[$key] <= (int)$comment->operationComments->value1) {
                        $firstCondition = $request->values[$key] <= (int)$comment->operationComments->value1;
                    }
                    break;
                case 3:
                    Log::Info(["Here" => "Yes"]);
                    if ($request->values[$key] > (int)$comment->operationComments->value1) {

                        $firstCondition = $request->values[$key] > (int)$comment->operationComments->value1;
                    }
                    break;
                case 4:
                    if ($request->values && $request->values[$key] >= (int)$comment->operationComments->value1) {
                        $firstCondition = $request->values[$key] >= (int)$comment->operationComments->value1;
                    }
                    break;
                // case 5:
                //     if ($request->values && $request->values[$key] <= (int)$comment->operationComments->value1 && $values[$key] >= (int)$comment->operationComments->value2) {

                //         $firstCondition = $request->values[$key] <= $comment->operationComments->value1 && $values[$key] >= $comment->operationComments->value2;
                //     }
                    break;
            }
        }
        if (isset($comment->condition_id)) {
            switch ($comment->condition_id) {
                case 1:
                    if ($request->status && $request->status[$key] == 'Critical low') {
                        $secondCondition = $request->status[$key] == 'Critical low';
                    }
                    break;
                case 2:
                    if ($request->status && $request->status[$key] == 'Low') {
                        $secondCondition =  $request->status[$key] == 'Low';
                    }
                    break;
                case 3:
                    if ($request->status[$key] == 'Normal') {
                        $secondCondition = $request->status[$key] == 'Normal';
                    }
                    break;

                case 4:
                    if ($request->status[$key] == 'High') {
                        $secondCondition = $request->status[$key] == 'High';
                    }
                    break;

                case 4:
                    if ($request->status[$key] == 'Critical high') {
                        $secondCondition = $request->status[$key] == 'Critical high';
                    }
                    break;
            }
        }
        
        // return $comment;

        $values = explode("-", $comment->values);
        Log::Info(['values' => $values]);
        Log::Info(['stat' => $request->status[$key]]);
        if ($request->values[$key] == $values[0]) {
            $thirdCondition = $request->values[$key] == $values[0];
        }
        if (count($values) > 1 && $request->values[$key] == $values[1]) {
            $thirdCondition = $request->values[$key] == $values[1];
        }

        Log::Info(['ewgyfrywes' => $thirdCondition]);
        if ($comment->operation_condition_type == 'or') {
            $condition_operation = $firstCondition || $secondCondition;
        } else {
            $condition_operation = $firstCondition && $secondCondition;
        }

        if ($comment->condition_values_type == 'or') {
            $condition_values = $thirdCondition || $secondCondition;
        } else {
            $condition_values = $thirdCondition && $secondCondition;
        }

        if ($comment->operation_values_type == 'or') {
            $operation_values = $thirdCondition || $firstCondition;
        } else {
            $operation_values = $thirdCondition && $firstCondition;
        }
        if ($condition_operation || $condition_values || $operation_values) {
            return true;
        } else {
            return false;
        }
    }
    // get comment test
    public function addComment(Request $request)
    {
        // return $request['data'];
        
        $request['data'] = array_filter($request['data'], fn ($value) => !is_null($value) && $value !== '');

        $evaluated_array_com = [];
        foreach ($request['data'] as $data) {
            $comment = commentComponet::where('test_id', $data['test_id'])->where('component_id', $data['component_id'])->with('test', 'comment')->get();
            foreach ($comment as $commen) {
                if ($commen->count() > 0) {
                    array_push($evaluated_array_com, $commen);
                }
            }
        }

        $data = [];
        $condetions = [];
        // return $evaluated_array_com;
        foreach ($evaluated_array_com as $component) {
            $data[$component->component_id] = $request['data'][$component->component_id];
            if (!in_array($component['comment']['condetion'],$condetions)) {
                array_push($condetions,$component['comment']['condetion']);
            }
        }

        $comments = [];
        foreach ($condetions as $condetion) {
            eval($condetion);
        }
        // return $condetions;
        
        return response()->json([
            'comments' => $comments,
            'request' => $request->all(),
        ]);
    }
    // saveReferenceRange
    public function saveReferenceRange(Request $request)
    {
        // save reference range
        $test = GroupTestResult::find($request->test_resulte_id);
        $test->comment = $request->reference;
        $test->save();


        // falsh message
        session()->flash('success', __('new Reference range saved successfully'));

        return response()->json([
            'status' => 'success',
        ]);
    }

    // includeHistory
    public function includeHistory(Request $request, $id)
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
                'message' => "تم اضافة سجل المريض بنجاح $id",
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

            $model->whereHas('tests', function ($q) {
                return $q->where('send_status', '!=', null);
            });

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
                $date = explode('-', $request['filter_date']);
                $from = date('Y-m-d', strtotime($date[0]));
                $to = date('Y-m-d 23:59:59', strtotime($date[1]));

                $date[0] == $date[1]
                    ? $model->whereDate('created_at', $from)
                    : $model->whereBetween('created_at', [$from, $to]);
            }

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
                ->addColumn('received_date', function ($group) {
                    return view(
                        'admin.send_test_lab._received_date',
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
                    return date('Y-m-d g:i A', strtotime($group['created_at']));
                })
                ->toJson();
        }
        // $type = $request['type'] ?: 'all';
        return view('admin.send_test_lab.index');
    }

    public function sendToLabSubmit(Request $request)
    {
        // dd($request->toArray());
        if ($request->has('checkbox')) {
            foreach ($request->checkbox as $key => $val) {
                GroupTest::find($key)->update(['send_status' => 1, 'send_date' => now()]);
            }
        }

        if ($request->has('note')) {
            foreach ($request->note as $key => $val) {
                GroupTest::find($key)->update(['notes' => $val]);
            }
        }

        session()->flash('success', __('Saved successfully'));
        return redirect()->route('admin.send_to_lab.index');
    }

    public function calcPersentage($old, $new)
    {
        if (!is_numeric($new) || !is_numeric($new)) {
            return false;
        }
        $medical_settings = setting('medical');

        $medical_pars = $medical_settings['report_notice'];
        try {
            $res = $new - $old;
        } catch (Throwable $e) {
            return false;
        }


        $res2 = ($medical_pars * $old) / 100;

        if (abs($res) > $res2) {
            return true;
        } else {
            return false;
        }
    }

    public static function prePrintPdf2($group, $header, $allow = null)
    {
        $categories = Category::get();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->where('group_id', $group['id'])
                ->where('done', 1)
                ->orderBy('sort')
                ->get();
            foreach ($tests as $test) {
                $test->setting = json_decode($test->setting, true);
                $test->results = $test->results->where('show',1);
            }

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $rays = GroupRay::where('group_id', $group['id'])->get();

            if ($rays) {
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

        $reports_settings = setting("reports");
        $info_settings = setting("info");
        $barcode_settings = setting("barcode");
        $type = 1;


        if ($header == false) {
            $setAutoTopMargin = 'stretch';
            $pdf1 = PDF::loadView(
                "pdf.report_pdf",
                compact(
                    "group",
                    "type",
                    "allow",
                    "categories",
                    "reports_settings",
                    "info_settings",
                    "barcode_settings",
                    "header",
                    "setAutoTopMargin",
                )
            );
            if (isset($group['contract'])) {
                $pdf_name = Str::slug("report_" . $group['patient']['name'] . '_' . $group['contract']['title'] . '_' . $group['id']) . ".pdf";
            } else {
                $pdf_name = Str::slug("report_" . $group['patient']['name'] . '_' . $group['id']) . ".pdf";
            }

            $pdf1->save("uploads/pdf/" . $pdf_name);
            return url("uploads/pdf/" . $pdf_name);
        } else {
            $header = true;
            $setAutoTopMargin = 'stretch';
            $pdf1 = PDF::loadView(
                "pdf.report_pdf",
                compact(
                    "group",
                    "type",
                    "allow",
                    "categories",
                    "reports_settings",
                    "info_settings",
                    "barcode_settings",
                    "header",
                    "setAutoTopMargin",
                )
            );
            if (isset($group['contract'])) {
                $pdf_name = Str::slug("report_" . $group['patient']['name'] . '_' . $group['contract']['title'] . '_' . $group['id']) . ".pdf";
            } else {
                $pdf_name = Str::slug("report_" . $group['patient']['name'] . '_' . $group['id']) . ".pdf";
            }

            $pdf1->save("uploads/pdf_/" . $pdf_name);
            return url("uploads/pdf_/" . $pdf_name);
        }
    }

    public static function prePrintPdfWithRequest($group, $request, $header, $allow = null)
    {
        $categories = Category::get();

        if (empty($request['tests'])) {
            $request['tests'] = [-1];
        }
        if (empty($request['cultures'])) {
            $request['cultures'] = [-1];
        }


        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use (
                $category
            ) {
                return $query->where('category_id', $category['id']);
            })
                ->whereIn('id', $request['tests'])
                ->where('done', 1)
                ->orderBy('sort')
                ->get();

            foreach ($tests as $test) {
                $test->setting = json_decode($test->setting, true);
                $test->results = $test->results->where('show',1);
            }

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $rays = GroupRay::where('group_id', $group['id'])->get();

            if ($rays) {
                $category['rays'] = $rays;
            }

            $category['cultures'] = GroupCulture::whereHas('culture', function (
                $query
            ) use ($category) {
                return $query->where('category_id', $category['id']);
            })
                ->whereIn('id', $request['cultures'])
                ->where('done', 1)
                ->get();
        }

        $reports_settings = setting("reports");
        $info_settings = setting("info");
        $barcode_settings = setting("barcode");
        $type = 1;


        // is printed
        GroupTest::whereIn('id', $request['tests'])->update(['is_printed' => 1]);
        GroupCulture::whereIn('id', $request['cultures'])->update(['is_printed' => 1]);

        // return url
        if ($header == false) {
            $setAutoTopMargin = 'stretch';
            $pdf1 = PDF::loadView(
                "pdf.report_pdf",
                compact(
                    "group",
                    "type",
                    "allow",
                    "categories",
                    "reports_settings",
                    "info_settings",
                    "barcode_settings",
                    "header",
                    "setAutoTopMargin",
                )
            );
            if (isset($group['contract'])) {
                $pdf_name = Str::slug("report_" . $group['patient']['name'] . '_' . $group['contract']['title'] . '_' . $group['id']) . ".pdf";
            } else {
                $pdf_name = Str::slug("report_" . $group['patient']['name'] . '_' . $group['id']) . ".pdf";
            }

            $pdf1->save("uploads/pdf/" . $pdf_name);
            return url("uploads/pdf/" . $pdf_name);
        } else {
            $header = true;
            $setAutoTopMargin = 'stretch';
            $pdf1 = PDF::loadView(
                "pdf.report_pdf",
                compact(
                    "group",
                    "type",
                    "allow",
                    "categories",
                    "reports_settings",
                    "info_settings",
                    "barcode_settings",
                    "header",
                    "setAutoTopMargin",
                )
            );
            if (isset($group['contract'])) {
                $pdf_name = Str::slug("report_" . $group['patient']['name'] . '_' . $group['contract']['title'] . '_' . $group['id']) . ".pdf";
            } else {
                $pdf_name = Str::slug("report_" . $group['patient']['name'] . '_' . $group['id']) . ".pdf";
            }

            $pdf1->save("uploads/pdf_/" . $pdf_name);
            return url("uploads/pdf_/" . $pdf_name);
        }
    }

    public function SettingTest(Request $request, $id)
    {
        $test = GroupTest::find($id);

        $request['show_range'] = ($request->has('show_range')) ? true : false;
        $request['show_unit'] = ($request->has('show_unit')) ? true : false;
        $request['show_status'] = ($request->has('show_status')) ? true : false;
        $request['new_line'] = ($request->has('new_line')) ? true : false;
        $request['highlite'] = ($request->has('highlite')) ? true : false;
        $setting = json_encode($request->except('_token'));
        $test->update(['setting' => $setting]);
        session()->flash('success', __('Saved successfully'));
        return redirect()->back();
    }

    public static function findStatus($result)
    {
        // $normal_from = isset($result['normal_from']) ? $result['normal_from'] : null  ;
        // $normal_to = isset($result['normal_to']) ? $result['normal_to'] : null  ;
        // $critical_high_from = isset($result['critical_high_from']) ? $result['critical_high_from'] : 1000000  ;
        // $critical_low_from = isset($result['critical_low_from']) ? $result['critical_low_from'] : -100000  ;

        if (isset($result['normal_from']) && isset($result['normal_to']) && isset($result['critical_high_from']) && $result['critical_high_from']) {
            if ($result['result'] >= $result['normal_from']  && $result['result'] <= $result['normal_to']) {
                return 'Normal';
            } else if ($result['result'] > $result['normal_to'] && $result['result'] < $result['critical_high_from']) {
                return 'High';
            } else if ($result['result'] < $result['normal_from']  && $result['result'] > $result['critical_low_from']) {
                return 'Low';
            } else if ($result['result'] >= $result['critical_high_from']) {
                return 'Critical high';
            } else if ($result['result'] <= $result['critical_low_from']) {
                return 'Critical low';
            }
        } else {
            return '';
        }
    }
    public function getWhatsAppUrl($id)
    {
        $group = Group::find($id);
        $group->whats_app_send = 1;
        $group->save();
        return redirect(whatsapp_notification($group, 'report'));
    }
}