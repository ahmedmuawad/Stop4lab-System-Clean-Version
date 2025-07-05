<?php

namespace App\Http\Controllers\Admin;

use Excel;
use DataTables;
use App\Models\Test;
use App\Models\Culture;
use App\Models\Package;
use App\Models\Contract;
use App\Models\TestPrice;
use Illuminate\Http\Request;
use App\Exports\ContractExport;
use App\Exports\ContractPrices;
use App\Exports\TestPriceExport;
use App\Exports\ContractCultures;
use App\Exports\ContractPackages;
use App\Imports\ContactTestsImport;
use App\Http\Controllers\Controller;
use App\Imports\ContractPricesImport;
use App\Http\Requests\Admin\ContractRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExcelImportRequest;

class ContractsController extends Controller
{

    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_contract',     ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_contract',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_contract',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_contract',   ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contracts.index');
    }

    /**
     * get antibiotics datatable
     *
     * @access public
     * @var  @Request $request
     */
    public function ajax(Request $request)
    {
        $model = Contract::query();

        return DataTables::eloquent($model)
            ->editColumn('discount', function ($contract) {
                return $contract['discount'] . ' %';
            })
            ->addColumn('action', function ($contract) {
                return view('admin.contracts._action', compact('contract'));
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
        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $packages = Package::all();

        return view('admin.contracts.create', compact('tests', 'cultures', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request)
    {


        $contract = Contract::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'discount_type' => $request['discount_type'],
            'discount_percentage' => $request['discount_percentage'],
            'government' => $request['government'],
            'is_out' => isset($request['is_out']) ? 1 : 0,
            'region' => $request['region'],
        ]);

        if ($request->has('tests')) {
            foreach ($request['tests'] as $id => $price) {
                $contract->tests()->create([
                    'priceable_type' => 'App\Models\Test',
                    'priceable_id' => $id,
                    'price' => $price
                ]);
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $id => $price) {
                $contract->cultures()->create([
                    'priceable_type' => 'App\Models\Culture',
                    'priceable_id' => $id,
                    'price' => $price
                ]);
            }
        }

        if ($request->has('packages')) {
            foreach ($request['packages'] as $id => $price) {
                $contract->packages()->create([
                    'priceable_type' => 'App\Models\Package',
                    'priceable_id' => $id,
                    'price' => $price
                ]);
            }
        }

        session()->flash('success', __('Contract created successfully'));

        return redirect()->route('admin.contracts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract = Contract::findOrFail($id);

        return view('admin.contracts.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractRequest $request, $id)
    {
        // dd($request->all());
        $contract = Contract::findOrFail($id);
        $contract->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'discount_type' => $request['discount_type'],
            'discount_percentage' => $request['discount_percentage'],
            'government' => $request['government'],
            'region' => $request['region'],
            'is_out' => isset($request['is_out']) ? 1 : 0,
        ]);

        $contract->tests()->delete();
        if ($request->has('tests')) {
            foreach ($request['tests'] as $id => $price) {
                $contract->tests()->create([
                    'priceable_type' => 'App\Models\Test',
                    'priceable_id' => $id,
                    'price' => $price
                ]);
            }
        }

        $contract->cultures()->delete();
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $id => $price) {
                $contract->cultures()->create([
                    'priceable_type' => 'App\Models\Culture',
                    'priceable_id' => $id,
                    'price' => $price
                ]);
            }
        }

        $contract->packages()->delete();
        if ($request->has('packages')) {
            foreach ($request['packages'] as $id => $price) {
                $contract->packages()->create([
                    'priceable_type' => 'App\Models\Package',
                    'priceable_id' => $id,
                    'price' => $price
                ]);
            }
        }

        session()->flash('success', __('Contract updated successfully'));

        return redirect()->route('admin.contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->prices()->delete();
        $contract->delete();

        session()->flash('success', __('Contract deleted successfully'));

        return redirect()->route('admin.contracts.index');
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
            $contract = Contract::findOrFail($id);
            $contract->prices()->delete();
            $contract->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.contracts.index');
    }

    public function contract_prices()
    {
        
        $contracts = Contract::with('tests','cultures','packages')->get();
        
        $testPrice = Test::with('category')->where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $packages = Package::all();

        return view('admin.contract_prices.index',compact('contracts','testPrice','cultures','packages'));
    }

    public function prices_tests_submit(Request $request)
    {
        // dd($request['price']);
        // $contract->tests()->delete();
        if ($request->has('price')) {
            
            foreach ($request['price'] as $key => $pri) {

                $contract = Contract::findOrFail($key);

                $contract->tests()->delete();

                foreach($pri as $id => $end){
                    $contract->tests()->create([
                        'priceable_type' => 'App\Models\Test',
                        'priceable_id' => $id,
                        'price' => $end
                    ]);
                }

            }
        }

        session()->flash('success', __('successfully'));

        return redirect()->route('admin.contract_prices');
    }
    public function prices_culture_submit(Request $request)
    {
        // dd($request['price']);
        // $contract->tests()->delete();
        if ($request->has('price')) {
            
            foreach ($request['price'] as $key => $pri) {

                $contract = Contract::findOrFail($key);

                $contract->cultures()->delete();

                foreach($pri as $id => $end){
                    $contract->cultures()->create([
                        'priceable_type' => 'App\Models\Culture',
                        'priceable_id' => $id,
                        'price' => $end
                    ]);
                }

            }
        }

        session()->flash('success', __('successfully'));

        return redirect()->route('admin.contract_prices');
    }
    public function prices_package_submit(Request $request)
    {
        if ($request->has('price')) {
            
            foreach ($request['price'] as $key => $pri) {

                $contract = Contract::findOrFail($key);

                $contract->packages()->delete();

                foreach($pri as $id => $end){
                    $contract->packages()->create([
                        'priceable_type' => 'App\Models\Package',
                        'priceable_id' => $id,
                        'price' => $end
                    ]);
                }

            }
        }

        session()->flash('success', __('successfully'));

        return redirect()->route('admin.contract_prices');
    }

    public function contractes_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new ContractPrices, 'contracts_prices.xlsx');
    }

    public function contractes_cultures_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new ContractCultures, 'contracts_culture.xlsx');
    }
    public function contractes_packages_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new ContractPackages, 'contracts_package.xlsx');
    }

    public function contractes_prices_import(Request $request)
    {
        if($request->hasFile('import'))
        {
            ob_end_clean(); // this
            ob_start(); // and this

            //import tests
            $contract = Contract::findOrFail(2);
            $contract->tests()->delete();
            Excel::import(new ContractPricesImport, $request->file('import'));        
        }

        session()->flash('success',__('Tests prices imported successfully'));

        return redirect()->back();
    }

    //Refresh tests contract

    public function refresh_tests_contract($id)
    {
        $contract = Contract::findOrFail($id);

        $all_tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();

        if ($all_tests) {
            foreach ($all_tests as $test) {
                $contract_test =  $contract->tests()->where('priceable_id',$test->id)->where('priceable_type','App\Models\Test')->first();
                if(!$contract_test){
                    $contract->tests()->create([
                        'priceable_type' => 'App\Models\Test',
                        'priceable_id' => $test->id,
                        'price' => $test->price
                    ]);
                }
            }
        }

        session()->flash('success',__('Contract Refreach successfully'));

        return redirect()->back();

    }

    //Refresh culture contract

    public function refresh_cultures_contract($id)
    {
        $contract = Contract::findOrFail($id);

        $cultures = Culture::get();

        if ($cultures) {
            foreach ($cultures as $culture) {
                $contract_culture =  $contract->cultures()->where('priceable_id',$culture->id)->where('priceable_type','App\Models\Culture')->first();
                if(!$contract_culture){
                    $contract->cultures()->create([
                        'priceable_type' => 'App\Models\Culture',
                        'priceable_id' => $culture->id,
                        'price' => $culture->price
                    ]);
                }
            }
        }

        session()->flash('success',__('Contract Refreach successfully'));

        return redirect()->back();

    }
    //Refresh packages contract

    public function refresh_packages_contract($id)
    {
        $contract = Contract::findOrFail($id);

        $packages = Package::get();

        if ($packages) {
            foreach ($packages as $package) {
                $contract_package =  $contract->packages()->where('priceable_id',$package->id)->where('priceable_type','App\Models\Package')->first();
                if(!$contract_package){
                    $contract->packages()->create([
                        'priceable_type' => 'App\Models\Package',
                        'priceable_id' => $package->id,
                        'price' => $package->price
                    ]);
                }
            }
        }

        session()->flash('success',__('Contract Refreach successfully'));

        return redirect()->back();

    }

    public function export($id)
    {
        $name = Contract::find($id)->title;
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new ContractExport($id), "$name.xlsx");

    }


        /**
     * Import tests for contract
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(ExcelImportRequest $request,$id)
    {
        // dd($request->all());
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new ContactTestsImport($id), $request->file('import'));
        }

        session()->flash('success', __('Contract imported successfully'));

        return redirect()->back();
    }


}
