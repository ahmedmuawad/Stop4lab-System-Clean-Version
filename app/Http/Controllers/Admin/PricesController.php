<?php

namespace App\Http\Controllers\Admin;

use Excel;
use DataTables;
use App\Models\Ray;
use App\Models\Test;
use App\Models\Culture;
use App\Models\Package;
use App\Models\TestPrice;
use App\Models\CulturePrice;
use App\Models\PackagePrice;
use Illuminate\Http\Request;
use App\Models\ContractPrice;
use App\Exports\RayPriceExport;
use App\Imports\RayPriceImport;
use App\Exports\TestPriceExport;
use App\Imports\TestPriceImport;
use App\Exports\CulturePriceExport;
use App\Exports\PackagePriceExport;
use App\Imports\CulturePriceImport;
use App\Imports\PackagePriceImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExcelImportRequest;

class PricesController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_test_prices',     ['only' => ['tests']]);
        $this->middleware('can:update_test_prices',   ['only' => ['tests_submit']]);
        $this->middleware('can:view_package_prices',     ['only' => ['packages']]);
        $this->middleware('can:update_pacakage_prices',   ['only' => ['pacakages_submit']]);
        $this->middleware('can:view_culture_prices',     ['only' => ['cultures']]);
        $this->middleware('can:update_culture_prices',   ['only' => ['cultures_submit']]);
    }

    /**
     * tests price list
     *
     * @return \Illuminate\Http\Response
     */
    public function tests(Request $request)
    {
        if ($request->ajax()) {
            $model = Test::with('category', 'contract_prices', 'test_price')->where('parent_id', 0)->orWhere('separated', true);
            // Log::Info($model);
            return DataTables::eloquent($model)
                ->editColumn('price', function ($test) {
                    if (auth()->guard('admin')->user()->lab_id != null) {
                        $contract = auth()->guard('admin')->user()->lab_id;
                        $price = ContractPrice::where('priceable_id', $test->id)->where('priceable_type', 'App\Models\Test')->where('contract_id', $contract)->first();
                        if ($price) {
                            $test->price = $price->price;
                        }
                    }
                    // if (setting('medical')['samePrice']) {
                    //     $test->test_price = null;
                    // }
                    return view('admin.prices._test_price', compact('test'));
                })->editColumn('cost', function ($test) {
                    return view('admin.prices._test_cost', compact('test'));
                })
                ->toJson();
        }

        return view('admin.prices.tests');
    }

    /**
     * update tests prices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tests_submit(Request $request)
    {
        // dd($request);
        if ($request->has('tests')) {
            if (isset($request['tests']['price'])) {
                foreach ($request['tests']['price'] as $key => $value) {
                    Test::where('id', $key)->update(['price' => $value]);
                    $price = TestPrice::where('test_id', $key)
                        ->where('branch_id', session('branch_id'))->first();
                    if ($price) {
                        TestPrice::where('test_id', $key)
                            ->where('branch_id', session('branch_id'))
                            ->update([
                                'price' => $value,
                            ]);
                    } else {
                        TestPrice::create([
                            'test_id' => $key,
                            'branch_id' => session('branch_id'),
                            "price" => $value,
                        ]);
                    }
                    Log::Info(['Updated']);
                }
            }
            // dd(isset($request['tests']['cost']));
            if (isset($request['tests']['cost'])) {
                foreach ($request['tests']['cost'] as $key => $value) {
                    $price = TestPrice::where('test_id', $key)
                        ->where('branch_id', session('branch_id'))->first();
                    $test = Test::select('price')->where('id' , $key)->first();
                    // dd($test->price);
                    if ($price) {
                        TestPrice::where('test_id', $key)
                            ->where('branch_id', session('branch_id'))
                            ->update([
                                'cost' => $value,
                                'price'=>$price->price,
                            ]);
                    } else {
                        TestPrice::create([
                            'test_id' => $key,
                            'branch_id' => session('branch_id'),
                            "cost" => $value,
                            "price"=>$test->price,
                        ]);
                    }
                    Log::Info(['Updated']);
                }
            }
        }

        session()->flash('success', __('Tests prices updated successfully'));

        return redirect()->back();
    }

    /**
     * cultures price list
     *
     * @return \Illuminate\Http\Response
     */
    public function cultures(Request $request)
    {

        if ($request->ajax()) {

            $model = Culture::with('category', 'culture_price');

            return DataTables::eloquent($model)
                ->editColumn('price', function ($culture) {

                    if (auth()->guard('admin')->user()->lab_id  != null) {

                        $contract = auth()->guard('admin')->user()->lab_id;
                        $price = ContractPrice::where('priceable_id', $culture->id)->where('priceable_type', 'App\Models\Culture')->where('contract_id', $contract)->first();
                        if ($price) {
                            $culture->price = $price->price;
                        }
                    }
                    // if (setting('medical')['samePrice']) {
                    //     $culture->culture_price = null;
                    // }
                    return view('admin.prices._culture_price', compact('culture'));
                })
                ->editColumn('cost', function ($culture) {
                    return view('admin.prices._culture_cost', compact('culture'));
                })
                ->toJson();
        }

        return view('admin.prices.cultures');
    }

    /**
     * update cultures prices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cultures_submit(Request $request)
    {

        // dd($request);
        if ($request->has('cultures')) {
            if ($request['cultures']['price']) {
                foreach ($request['cultures']['price'] as $key => $value) {
                    if (CulturePrice::where('culture_id', $key)
                        ->where('branch_id', session('branch_id'))->first()
                    ) {
                        CulturePrice::where('culture_id', $key)
                            ->where('branch_id', session('branch_id'))
                            ->update([
                                'price' => $value
                            ]);
                    } else {
                        CulturePrice::create([
                            'culture_id' => $key,
                            'branch_id' => session('branch_id'),
                            'price' => $value
                        ]);
                    }
                }
            }


            if ($request['cultures']['cost']) {
                foreach ($request['cultures']['cost'] as $key => $value) {

                    if (CulturePrice::where('culture_id', $key)
                        ->where('branch_id', session('branch_id'))->first()
                    ) {
                        CulturePrice::where('culture_id', $key)
                            ->where('branch_id', session('branch_id'))
                            ->update([
                                'cost' => $value
                            ]);
                    } else {
                        CulturePrice::create([
                            'culture_id' => $key,
                            'branch_id' => session('branch_id'),
                            'cost' => $value
                        ]);
                    }
                }
            }
        }

        session()->flash('success', __('Cultures prices updated successfully'));

        return redirect()->back();
    }

    /**
     * packges price list
     *
     * @return \Illuminate\Http\Response
     */
    public function packages(Request $request)
    {
        if ($request->ajax()) {
            $model = Package::with('tests', 'cultures', 'category', 'package_price');
            // Package::with('tests','cultures','category');                        
            return DataTables::eloquent($model)
                ->editColumn('price', function ($package) {
                    if (auth()->guard('admin')->user()->lab_id  != null) {
                        $contract = auth()->guard('admin')->user()->lab_id;
                        $price = ContractPrice::where('priceable_id', $package->id)->where('priceable_type', 'App\Models\Package')->where('contract_id', $contract)->first();
                        if ($price) {
                            $package->price = $price->price;
                        }
                    }
                    if (setting('medical')['samePrice']) {
                        $package->package_price = null;
                    }

                    return view('admin.prices._package_price', compact('package'));
                })
                ->toJson();
        }
        return view('admin.prices.packages');
    }

    /**
     * update packages prices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function packages_submit(Request $request)
    {
        if ($request->has('packages')) {
            foreach ($request['packages'] as $key => $value) {
                Package::where('id', $key)->update([
                    'price' => $value
                ]);
            }
        }

        session()->flash('success', __('Packages prices updated successfully'));

        return redirect()->back();
    }


    public function tests_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new TestPriceExport, 'tests_prices.xlsx');
    }

    public function cultures_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new CulturePriceExport, 'cultures_prices.xlsx');
    }

    public function packages_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new PackagePriceExport, 'packages_prices.xlsx');
    }


    /**
     * Import tests prices
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tests_prices_import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this

            //import tests
            Excel::import(new TestPriceImport, $request->file('import'));
        }

        session()->flash('success', __('Tests prices imported successfully'));

        return redirect()->back();
    }

    /**
     * Import cultures prices
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cultures_prices_import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this

            //import tests
            Excel::import(new CulturePriceImport, $request->file('import'));
        }

        session()->flash('success', __('Cultures prices imported successfully'));

        return redirect()->back();
    }

    /**
     * Import packages prices
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function packages_prices_import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this

            //import packages
            Excel::import(new PackagePriceImport, $request->file('import'));
        }

        session()->flash('success', __('Packages prices imported successfully'));

        return redirect()->back();
    }



    /**
     * tests price list
     *
     * @return \Illuminate\Http\Response
     */
    public function rays(Request $request)
    {
        if ($request->ajax()) {
            $model = Ray::with('category');

            return DataTables::eloquent($model)
                ->editColumn('price', function ($ray) {
                    return view('admin.prices._rays_price', compact('ray'));
                })
                ->toJson();
        }

        return view('admin.prices.rays');
    }

    /**
     * update tests prices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rays_submit(Request $request)
    {
        if ($request->has('rays')) {
            foreach ($request['rays'] as $key => $value) {
                Ray::where('id', $key)->update(['price' => $value]);
            }
        }

        session()->flash('success', __('rays prices updated successfully'));

        return redirect()->back();
    }

    public function rays_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new RayPriceExport, 'rays_prices.xlsx');
    }

    public function rays_prices_import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this

            //import tests
            Excel::import(new RayPriceImport, $request->file('import'));
        }

        session()->flash('success', __('Tests prices imported successfully'));

        return redirect()->back();
    }
}
