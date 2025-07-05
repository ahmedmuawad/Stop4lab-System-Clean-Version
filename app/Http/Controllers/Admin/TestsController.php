<?php

namespace App\Http\Controllers\Admin;

use out;
use Excel;
use DataTables;
use App\Models\Test;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Labs_out;
use App\Models\TestPrice;
use App\Models\TestOption;
use App\Exports\TestExport;
use App\Imports\TestImport;
use App\Models\TestComment;
use Illuminate\Http\Request;
use App\Models\ContractPrice;
use App\Models\TestReferenceRange;
use App\Http\Controllers\Controller;
use App\Models\testOptionAdditional;
use App\Http\Requests\Admin\TestRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Models\SampleType;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class TestsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_test',     ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_test',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_test',     ['only' => ['edit']]);
        // $this->middleware('can:update_test',     ['only' => ['update']]);
        $this->middleware('can:delete_test',   ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.tests.index');
    }


    /**
     * get tests datatable
     *
     * @access public
     * @var  @Request $request
     */
    public function ajax(Request $request)
    {
        $model = Test::with('category.parent', 'test_price')->where(function ($q) {
            return $q->where('parent_id', 0)->orWhere('separated', true);
        });

        return DataTables::eloquent($model)
            ->editColumn('price', function ($test) {
                if (auth()->guard('admin')->user()->lab_id  == null) {
                    if ($test->test_price == null) {
                        return formated_price($test['price']);
                    } else {
                        if (setting('medical')['samePrice']) {
                            return formated_price($test['price']);
                        }
                        return formated_price($test->test_price['price']);
                    }
                }
            })
            ->addColumn('action', function ($test) {
                return view('admin.tests._action', compact('test'));
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

        $contracts = Contract::all();
        $labs_out = Labs_out::all();
        $samplesTypes = SampleType::where('parent_id', '!=', 0)->get();
        return view('admin.tests.create', compact('contracts', 'labs_out', 'samplesTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestRequest $request)
    {
        $test = Test::create([
            'category_id' => $request['category_id'],
            'name' => $request['name'],
            'shortcut' => $request['shortcut'],
            'sample_type' => $request['sample_type'],
            'price' => $request['price'],
            'precautions' => $request['precautions'],
            'parent_id' => 0,
            'num_day_receive' => $request['num_day_receive'],
            'num_hour_receive' => $request['num_hour_receive'],
            'details' => $request['details'],
            'decreased_in' => $request['decreased_in'],
            'increased_in' => $request['increased_in'],
            // 'min' => $request['min'],
            // 'max' => $request['max'],
            'lab_to_lab_cost' => ($request['lab_to_lab_cost']) ? $request['lab_to_lab_cost'] : 0,
            'lab_out_id' => ($request['lab_out_id']) ? $request['lab_out_id'] : null,
            'lab_to_lab_status' => $request['lab_to_lab_status'],
            'sample_type_id' => $request['sample_type_id'],

        ]);

        //create test price

        $branches = Branch::all();

        foreach ($branches as $branch) {
            TestPrice::create([
                'branch_id' => $branch['id'],
                'test_id' => $test['id'],
                'price' => $request['price']
            ]);
        }

        //create components
        if ($request->has('component')) {
            foreach ($request->component as $component) {
                if (isset($component['title'])) {
                    Test::create([
                        'category_id' => $request['category_id'],
                        'parent_id' => $test['id'],
                        'name' => $component['name'],
                        'title' => true,
                    ]);
                } else {
                    $test_component = Test::create([
                        'category_id' => $request['category_id'],
                        'parent_id' => $test['id'],
                        'type' => $component['type'],
                        'name' => $component['name'],
                        // 'min' => $component['min'],
                        // 'max' => $component['max'],
                        'unit' => (isset($component['unit'])) ? $component['unit'] : '',
                        'reference_range' => (isset($component['reference_range'])) ? $component['reference_range'] : '',
                        'title' => (isset($component['title'])) ? true : false,
                        'separated' => (isset($component['separated'])),
                        'price' => (isset($component['price'])) ? $component['price'] : 0,
                        'status' => (isset($component['status'])),
                        'sample_type' => $test['sample_type']
                    ]);

                    if (isset($component['separated'])) {
                        //create test price
                        foreach ($branches as $branch) {
                            TestPrice::create([
                                'branch_id' => $branch['id'],
                                'test_id' => $test_component['id'],
                                'price' => $component['price']
                            ]);
                        }
                    }

                    //assign options to component
                    if (isset($component['options'])) {
                        foreach ($component['options'] as $option) {
                            TestOption::create([
                                'name' => $option['name'],
                                'status' => isset($option['status']) ? $option['status'] : null,
                                'gender' => isset($option['gender']) ? $option['gender'] : null,
                                'test_id' => $test_component['id']
                            ]);
                        }
                    }
                    if (isset($component['options_additional'])) {
                        foreach ($component['options_additional'] as $option) {
                            testOptionAdditional::create([
                                'name' => $option['name'],
                                'status' => isset($option['status']) ? $option['status'] : null,
                                'gender' => isset($option['gender']) ? $option['gender'] : null,
                                'test_id' => $test_component['id']
                            ]);
                        }
                    }

                    //reference ranges
                    if (isset($component['reference_ranges'])) {
                        foreach ($component['reference_ranges'] as $reference_range) {
                            $multiplication = 1;

                            if ($reference_range['age_unit'] == 'month') {
                                $multiplication = 30;
                            } elseif ($reference_range['age_unit'] == 'year') {
                                $multiplication = 365;
                            }

                            $test_component->reference_ranges()->create([
                                'gender' => $reference_range['gender'],
                                'age_unit' => $reference_range['age_unit'],
                                'age_from' => $reference_range['age_from'],
                                'age_to' => $reference_range['age_to'],
                                'age_from_days' => $reference_range['age_from'] * $multiplication,
                                'age_to_days' => $reference_range['age_to'] * $multiplication,
                                'critical_low_from' => $reference_range['critical_low_from'],
                                'normal_from' => $reference_range['normal_from'],
                                'normal_to' => $reference_range['normal_to'],
                                'critical_high_from' => $reference_range['critical_high_from'],
                                'comment' => $reference_range['comment'],
                                'show_status' => (isset($reference_range['show_status'])) ? 1 : 0
                            ]);
                        }
                    }
                }
            }
        }

        //comments
        if ($request->has('comments')) {
            foreach ($request['comments'] as $comment) {
                $test->comments()->create([
                    'comment' => $comment
                ]);
            }
        }

        // questions 

        if ($request->has('questions')) {
            foreach ($request['questions'] as $question) {
                $test->questions()->create([
                    'question' => $question
                ]);
            }
        }


        //consumptions
        if ($request->has('consumption')) {
            foreach ($request['consumptions'] as $consumption) {
                $test->consumptions()->create([
                    'product_id' => $consumption['product_id'],
                    'quantity' => $consumption['quantity']
                ]);
            }
        }

        session()->flash('success', __('Test created successfully'));

        return redirect()->route('admin.tests.index');
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
        $branch_id = session::get('branch_id');

        Log::Info(['branch_id' => $branch_id]);

        $test_Price = null;
        if (!setting('medical')['samePrice']) {
            $test_Price = TestPrice::where('branch_id', $branch_id)->where('test_id', $id)->first();
        }
        Log::Info(['price' => $test_Price]);

        $test = Test::with(['components', 'components.reference_ranges', 'reference_ranges'])->where('id', $id)->firstOrFail();

        // Log::Info(['tst'=>$test->components]);

        $labs_out = Labs_out::all();
        $contracts = Contract::all();
        $samplesTypes = SampleType::where('parent_id', '!=', 0)->get();

        return view('admin.tests.edit', compact('test', 'test_Price', 'contracts', 'labs_out', 'samplesTypes'));
    }

    public function consumptions($id)
    {
        $tests = Test::where('id', $id)->orWhere([
            ['parent_id', $id],
            ['separated', true]
        ])->get();

        return view('admin.tests.consumptions', compact('tests'));
    }

    public function consumptions_submit(Request $request)
    {
        if ($request->has('consumption')) {
            foreach ($request['consumption'] as $test_id => $consumptions) {
                $test = Test::find($test_id);

                if (isset($test)) {
                    $test->consumptions()->delete();

                    foreach ($consumptions as $consumption) {
                        $test->consumptions()->create([
                            'product_id' => $consumption['product_id'],
                            'quantity' => $consumption['quantity']
                        ]);
                    }
                }
            }
        }

        session()->flash('success', __('Consumptions assigned successfully'));
        return redirect()->route('admin.tests.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestRequest $request, $id)
    {
        // dd($request->toArray());

        $branch_id = session()->get('branch_id');
        Log::Info(["Branch_id" => session()->get('branch_id')]);

        // dd($request->all());
        $test = Test::findOrFail($id);
        $branches = Branch::all();

        //update test basic info
        $test->update([
            'category_id' => $request['category_id'],
            'name' => $request['name'],
            'shortcut' => $request['shortcut'],
            'sample_type' => $request['sample_type'],
            'price' => $request['price'],
            'precautions' => $request['precautions'],
            'parent_id' => 0,
            'num_day_receive' => $request['num_day_receive'],
            'num_hour_receive' => $request['num_hour_receive'],
            'details' => $request['details'],
            'sample_type_id' => $request['sample_type_id'],
            'decreased_in' => $request['decreased_in'],
            'increased_in' => $request['increased_in'],
            'lab_out_id' => ($request['lab_out_id']) ? $request['lab_out_id'] : null,
            'lab_to_lab_status' => $request['lab_to_lab_status'],
            'lab_to_lab_cost' => ($request['lab_to_lab_status'] == 1) ? $request['lab_to_lab_cost'] : 0.00,
        ]);

        $test_Price = TestPrice::where('branch_id', $branch_id)->where('test_id', $id)->update([
            'price' => $request['price'],
        ]);


        // delete old component

        //components
        if ($request->has('component')) {

            $oldComponent = [];
            foreach ($request->component as $component) {
                if (isset($component['id'])) {
                    $oldComponent[] =  $component['id'];
                }
            }
            foreach ($test->components as $testComponent) {
                if (!in_array($testComponent->id, $oldComponent)) {
                    $testComponent->delete();
                }
            }
            foreach ($request->component as $component) {
                Log::Info(['com' => $component]);
                if (isset($component['title'])) {
                    if (isset($component['id'])) {
                        Test::where('id', $component['id'])->update([
                            'category_id' => $request['category_id'],
                            'name' => $component['name'],

                            'sort' => isset($component['sort']) ? $component['sort'] : 0,
                        ]);
                    } else {
                        Test::create([
                            'category_id' => $request['category_id'],
                            'parent_id' => $id,
                            'name' => $component['name'],
                            'title' => true,

                            'sort' => isset($component['sort']) ? $component['sort'] : 0,
                        ]);
                    }
                } else {
                    if (isset($component['id'])) {
                        $test_component = Test::where('id', $component['id'])->first();

                        $test_component->update([
                            'category_id' => $request['category_id'],
                            'parent_id' => $id,
                            'type' => $component['type'],
                            'name' => $component['name'],
                            'sort' => isset($component['sort']) ? $component['sort'] : 0,
                            // 'min' => $component['min'],
                            // 'max' => $component['max'],
                            'default' => $component['default'],
                            'unit' => (isset($component['unit'])) ? $component['unit'] : '',
                            'reference_range' => (isset($component['reference_range'])) ? $component['reference_range'] : '',
                            'title' => (isset($component['title'])) ? true : false,
                            'separated' => (isset($component['separated'])) ? true : false,
                            'price' => (isset($component['price'])) ? $component['price'] : 0,
                            'status' => (isset($component['status'])),
                            'sample_type' => $test['sample_type']
                        ]);

                        //separated
                        if ($test_component['separated']) {
                            //create test price
                            foreach ($branches as $branch) {
                                $test_price = TestPrice::firstOrCreate([
                                    'branch_id' => $branch['id'],
                                    'test_id' => $test_component['id'],
                                ]);

                                $test_price->update([
                                    'price' => $test_component['price']
                                ]);
                            }
                        } else {
                            $test_component->prices()->delete();
                            $test_component->contract_prices()->delete();
                        }

                        //delete options if not select type
                        if ($component['type'] == 'text') {
                            $test_component->options()->delete();
                        }

                        //update old options
                        if (isset($component['old_options'])) {
                            foreach ($component['old_options'] as $option_id => $option) {
                                TestOption::where('id', $option_id)->update([
                                    'name' => $option['name'],
                                    'status' => isset($option['status']) ? $option['status'] : null,
                                    'gender' => isset($option['gender']) ? $option['gender'] : null
                                ]);
                            }
                        }


                        if (isset($component['old_options_additional'])) {
                            foreach ($component['old_options_additional'] as $option_id => $option) {
                                testOptionAdditional::where('id', $option_id)->update([
                                    'name' => $option['name'],
                                    'status' => isset($option['status']) ? $option['status'] : null,
                                    'gender' => isset($option['gender']) ? $option['gender'] : null
                                ]);
                            }
                        }

                        //assign options to component
                        if (isset($component['options'])) {
                            foreach ($component['options'] as $option) {
                                TestOption::create([
                                    'name' => $option['name'],
                                    'status' =>  isset($option['status']) ? $option['status'] : null,
                                    'gender' => isset($option['gender']) ? $option['gender'] : null,
                                    'test_id' => $test_component['id']
                                ]);
                            }
                        }
                        if (isset($component['options_additional'])) {
                            foreach ($component['options_additional'] as $option) {
                                testOptionAdditional::create([
                                    'name' => $option['name'],
                                    'status' => isset($option['status']) ? $option['status'] : null,
                                    'gender' => isset($option['gender']) ? $option['gender'] : null,
                                    'test_id' => $test_component['id']
                                ]);
                            }
                        }
                        //reference ranges

                        if (isset($component['reference_ranges'])) {

                            $old_reference_ranges_ids = [];
                            foreach ($component['reference_ranges'] as $Key => $reference_range) {
                                $old_reference_ranges_ids[] = $Key;
                            }

                            $old_reference_ranges = $test_component->reference_ranges()->whereNotIn('id', $old_reference_ranges_ids)->get();

                            // dd(key($component['reference_ranges']));
                            foreach ($old_reference_ranges as $ref) {
                                $ref->delete();
                            }

                            foreach ($component['reference_ranges'] as $refKey => $reference_range) {
                                $multiplication = 1;

                                if ($reference_range['age_unit'] == 'month') {
                                    $multiplication = 30;
                                } elseif ($reference_range['age_unit'] == 'year') {
                                    $multiplication = 365;
                                }
                                Log::Info(["test_id" => $test_component->id]);

                                $branchRefRange = setting('medical')['sameRefRang'];
                                if ($branchRefRange) {
                                    $test_reference_ranges = TestReferenceRange::where('test_id', $test_component->id)
                                        ->where('id', $refKey)->first();
                                } else {
                                    $test_reference_ranges = TestReferenceRange::where('test_id', $test_component->id)
                                        ->where('id', $refKey)
                                        ->where('branch_id', $branch_id)->first();
                                }


                                if ($test_reference_ranges) {
                                    $test_reference_ranges->update([
                                        'gender' => $reference_range['gender'],
                                        'age_unit' => $reference_range['age_unit'],
                                        'age_from' => $reference_range['age_from'],
                                        'age_to' => $reference_range['age_to'],
                                        'age_from_days' => $reference_range['age_from'] * $multiplication,
                                        'age_to_days' => $reference_range['age_to'] * $multiplication,
                                        'critical_low_from' => $reference_range['critical_low_from'],
                                        'normal_from' => $reference_range['normal_from'],

                                        'normal_to' => $reference_range['normal_to'],
                                        'critical_high_from' => $reference_range['critical_high_from'],
                                        'comment' => $reference_range['comment'],
                                        'show_status' => (isset($reference_range['show_status'])) ? 1 : 0
                                    ]);
                                } else {
                                    $test_component->reference_ranges()->create([
                                        'gender' => $reference_range['gender'],
                                        "branch_id" => $branch_id,
                                        'age_unit' => $reference_range['age_unit'],
                                        'age_from' => $reference_range['age_from'],
                                        'age_to' => $reference_range['age_to'],
                                        // 'reference_range' => (isset($component['reference_range'])) ? $component['reference_range'] : '',
                                        // 'reference_range' => (isset($component['reference_range'])) ? $component['reference_range'] : '',
                                        'age_from_days' => $reference_range['age_from'] * $multiplication,
                                        'age_to_days' => $reference_range['age_to'] * $multiplication,
                                        'critical_low_from' => $reference_range['critical_low_from'],
                                        'normal_from' => $reference_range['normal_from'],
                                        'normal_to' => $reference_range['normal_to'],
                                        'critical_high_from' => $reference_range['critical_high_from'],
                                        'comment' => $reference_range['comment'],
                                        'show_status' => (isset($reference_range['show_status'])) ? 1 : 0
                                    ]);
                                }
                            }
                        }
                    } else {
                        $test_component = Test::create([
                            'category_id' => $request['category_id'],
                            'parent_id' => $id,
                            'type' => $component['type'],
                            'name' => $component['name'],
                            'unit' => (isset($component['unit'])) ? $component['unit'] : '',
                            'reference_range' => (isset($component['reference_range'])) ? $component['reference_range'] : '',
                            'title' => (isset($component['title'])) ? true : false,
                            'separated' => (isset($component['separated'])) ? true : false,
                            'price' => (isset($component['price'])) ? $component['price'] : 0,
                            'status' => (isset($component['status'])),
                            'sample_type' => $test['sample_type']
                        ]);

                        //separated
                        if ($test_component['separated']) {
                            //create test price
                            foreach ($branches as $branch) {
                                $test_price = TestPrice::firstOrCreate([
                                    'branch_id' => $branch['id'],
                                    'test_id' => $test_component['id'],
                                ]);

                                $test_price->update([
                                    'price' => $test_component['price']
                                ]);
                            }
                        } else {
                            $test_component->prices()->delete();
                        }

                        //assign options to component
                        if (isset($component['options'])) {
                            foreach ($component['options'] as $option) {
                                TestOption::create([
                                    'name' => $option['name'],
                                    'status' => isset($option['status']) ? $option['status'] : null,
                                    'gender' => isset($option['gender']) ? $option['gender'] : null,
                                    'test_id' => $test_component['id']
                                ]);
                            }
                        }

                        //reference ranges
                        if (isset($component['reference_ranges'])) {
                            foreach ($component['reference_ranges'] as $reference_range) {
                                $multiplication = 1;

                                if ($reference_range['age_unit'] == 'month') {
                                    $multiplication = 30;
                                } elseif ($reference_range['age_unit'] == 'year') {
                                    $multiplication = 365;
                                }

                                $test_component->reference_ranges()->create([
                                    'gender' => $reference_range['gender'],
                                    'age_unit' => $reference_range['age_unit'],
                                    'age_from' => $reference_range['age_from'],
                                    'age_to' => $reference_range['age_to'],
                                    'age_from_days' => $reference_range['age_from'] * $multiplication,
                                    'age_to_days' => $reference_range['age_to'] * $multiplication,
                                    'critical_low_from' => $reference_range['critical_low_from'],
                                    'normal_from' => $reference_range['normal_from'],
                                    'normal_to' => $reference_range['normal_to'],
                                    'critical_high_from' => $reference_range['critical_high_from'],
                                    'comment' => $reference_range['comment']
                                ]);
                            }
                        }
                    }
                }
            }
        }

        // comments
        $test->comments()->delete();

        if ($request->has('comments')) {
            foreach ($request['comments'] as $key => $comment) {
                $comm = $test->comments()->create([
                    'comment' => $comment,
                ]);
            }
        }

        //questions

        $test->questions()->delete();

        if ($request->has('questions')) {
            foreach ($request['questions'] as $question) {
                $test->questions()->create([
                    'question' => $question
                ]);
            }
        }

        //consumptions
        $test->consumptions()->delete();
        if ($request->has('consumptions')) {
            foreach ($request['consumptions'] as $consumption) {
                $test->consumptions()->create([
                    'product_id' => $consumption['product_id'],
                    'quantity' => $consumption['quantity']
                ]);
            }
        }

        session()->flash('success', __('Test updated successfully'));

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
        $test = Test::findOrFail($id);

        //delete old components
        $components = Test::with('groups')->where('parent_id', $id)->get();

        // stop delete if test belonge to groups
        if ($test->groups->isNotEmpty()) {
            $ids = '';
            foreach ($test->groups as $group) {
                $ids .= '#' . $group->group_id . ' ';
            }
            session()->flash('failed', __("This Test belonge to invoices, $ids  :you can not delete"));
            return redirect()->route('admin.tests.index');
        }

        foreach ($components as $component) {
            $component->options()->delete();
            $component->prices()->delete();
            $component->reference_ranges()->delete();
            // ($component->reference_ranges()->count())? $component->reference_ranges()->get()->delete() : null;
            $component->contract_prices()->delete();
            $component->delete();
        }

        $test->options()->delete();
        $test->prices()->delete();
        $test->contract_prices()->delete();
        $test->comments()->delete();
        $test->delete();

        session()->flash('success', __('Test deleted successfully'));

        return redirect()->route('admin.tests.index');
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
            $test = Test::find($id);

            //delete old components
            $components = Test::where('parent_id', $id)->get();

            foreach ($components as $component) {
                $component->options()->delete();
                $component->prices()->delete();
                // ($component->reference_ranges()->count())? $component->reference_ranges()->get()->delete() : null;
                $component->reference_ranges()->delete();
                $component->contract_prices()->delete();
                $component->delete();
            }
            if ($test) {
                $test->options()->delete();
                $test->prices()->delete();
                $test->contract_prices()->delete();
                $test->comments()->delete();
                $test->delete();
            }
            // $test->options()->delete();

        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.tests.index');
    }


    /**
     * Export tests
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export($id = null)
    {
        ob_end_clean(); // this
        ob_start(); // and this
        if ($id != null) {
            $test = Test::find($id);
            return Excel::download(new TestExport($id), $test->name . '.xlsx');
        } else {
            return Excel::download(new TestExport($id), 'tests.xlsx');
        }
    }

    /**
     * Import tests
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new TestImport, $request->file('import'));
        }

        session()->flash('success', __('Tests imported successfully'));

        return redirect()->back();
    }

    /**
     * Download tests template
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download_template()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return response()->download(storage_path('app/public/tests_template.xlsx'), 'tests_template.xlsx');
    }

    // get components of a test
    public function get_component(Request $request)
    {
        $components = Test::where('parent_id', $request->id)->get();
        $data = [];
        foreach ($components as $component) {
            $data[] = [
                'id' => $component['id'],
                'name' => $component['name'],
                'price' => $component['price'],
                'price_type' => $component['price_type'],
                'options' => $component['options'],
                'reference_ranges' => $component['reference_ranges'],
                'contract_prices' => $component['contract_prices'],
                'comments' => $component['comments'],
            ];
        }

        return response()->json($data);
    }

    public function settingTest(Request $request, $id)
    {
        // dd($request->all());
        $test = Test::find($id);

        $request['show_status'] = ($request->has('show_status')) ? true : false;
        $request['show_range'] = ($request->has('show_range')) ? true : false;
        $request['show_unit'] = ($request->has('show_unit')) ? true : false;

        $setting = json_encode($request->except('_token', "setting_test_$id"));


        $test->update(['setting' => $setting]);


        session()->flash('success', __('Saved successfully'));
        return redirect()->back();
    }

    public function addTestToPortal(Request $request)
    {
        $ids = $request->ids;
        $tests = Test::whereIn('id', $ids)->get();
        $portalSetting = setting('portal');

        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);
        foreach ($tests as $test) {
            $gpc = 'EG-' . $portalSetting['registerationNumber'].'-'.$test->id.'test';
            $addProduct = '{
                "items": [
                    {
                        "codeType": "' . "EGS" . '",
                        "parentCode": "10001688",
                        "itemCode": "'.$gpc.'",
                        "codeName": "' . $test->name . '",
                        "codeNameAr": "' . $test->name . '",
                        "activeFrom": "' . Carbon::now().'",
                        "activeTo": "",
                        "description": "' . $test->name . '",
                        "descriptionAr": "' . $test->name . '",
                        "requestReason": "' . "Request reason text" . '",
                    },
                ]
            }';
            $product = Http::withHeaders([
                "Authorization" => 'Bearer ' . $response['access_token'],
                "Content-Type" => "application/json",
            ])->withBody($addProduct, "application/json")->post('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/codes');
            if ($product["passedItemsCount"] === 0) {
                return redirect()->back()->with('error', $product['failedItems'][0]['errors'][0].'for Test' . $test->name);
            }
           
        }
        return redirect()->route('admin.portal.tests-portal')->with('success', "تم ارسال الاختبارات (قيد الإنتظار)");

    }
}
