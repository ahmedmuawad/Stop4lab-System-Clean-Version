<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Test;
use App\Models\Culture;
use App\Models\Branch;
use App\Models\PackagePrice;
use App\Models\ContractPrice;
use App\Models\Contract;
use App\Models\Ray;
use DataTables;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PackagesController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_package',     ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_package',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_package',     ['only' => ['edit', 'updae']]);
        $this->middleware('can:delete_package',   ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Package::with('tests', 'cultures', 'package_price', 'category');

            return DataTables::eloquent($model)
                ->editColumn('price', function ($package) {
                    if (!setting('medical')['samePrice']) {
                        return formated_price($package->package_price['price']);
                    } else {
                        return formated_price($package['price']);
                    }
                })
                ->addColumn('tests', function ($package) {
                    return view('admin.packages._tests', compact('package'));
                })
                ->addColumn('action', function ($package) {
                    return view('admin.packages._action', compact('package'));
                })
                ->addColumn('bulk_checkbox', function ($item) {
                    return view('partials._bulk_checkbox', compact('item'));
                })
                ->toJson();
        }

        return view('admin.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        $package = Package::create([
            'name' => $request['name'],
            'shortcut' => $request['shortcut'],
            'price' => $request['price'],
            'precautions' => $request['precautions'],
        ]);

        //create package price
        $branches = Branch::all();
        foreach ($branches as $branch) {
            PackagePrice::create([
                'branch_id' => $branch['id'],
                'package_id' => $package['id'],
                'price' => $request['price']
            ]);
        }

        //contracts prices
        $contracts = Contract::all();
        foreach ($contracts as $contract) {
            $contract->packages()->create([
                'priceable_type' => 'App\Models\Package',
                'priceable_id' => $package['id'],
                'price' => ($contract['discount_type'] == 1) ? ($request['price'] * $contract['discount_percentage'] / 100) : $request['price']
            ]);
        }

        //tests
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test_id) {
                $test = Test::find($test_id);

                if (isset($test)) {
                    $package->tests()->create([
                        'testable_id' => $test['id'],
                        'testable_type' => 'App\Models\Test'
                    ]);
                }
            }
        }

        //cultures
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture_id) {
                $culture = Culture::find($culture_id);

                if (isset($culture)) {
                    $package->cultures()->create([
                        'testable_id' => $culture['id'],
                        'testable_type' => 'App\Models\Culture'
                    ]);
                }
            }
        }

        if ($request->has('rays')) {
            foreach ($request['rays'] as $ray_id) {
                $ray = Ray::find($ray_id);

                if (isset($ray)) {
                    $package->rays()->create([
                        'testable_id' => $ray['id'],
                        'testable_type' => 'App\Models\Ray'
                    ]);
                }
            }
        }

        session()->flash('success', __('Package created successfully'));

        return redirect()->route('admin.packages.index');
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
        $branch_id = session()->get('branch_id');

        $package_price = null;

        if (!setting('medical')['samePrice']) {
            $package_price = PackagePrice::where('branch_id', $branch_id)->where('package_id', $id)->first();
        }

        $package = Package::findOrFail($id);

        return view('admin.packages.edit', compact('package', 'package_price'));
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
        $package = Package::findOrFail($id);

        $branch_id = session()->get('branch_id');

        //update package
        $package->update([
            'name' => $request['name'],
            'shortcut' => $request['shortcut'],
            'price' => $request['price'],
            'precautions' => $request['precautions']
        ]);


        $package_price = PackagePrice::where('branch_id', $branch_id)->where('package_id', $id)->update([
            'price' => $request['price'],
        ]);

        //update contract prices
        $contracts = Contract::all();
        foreach ($contracts as $contract) {
            $package_contract = ContractPrice::firstOrCreate([
                'contract_id' => $contract['id'],
                'priceable_type' => 'App\Models\Package',
                'priceable_id' => $id,
            ]);

            if ($contract['discount_type'] == 1) {
                $package_contract->update([
                    'price' => ($request['price'] * $contract['discount_percentage'] / 100)
                ]);
            }
        }

        $package->tests()->delete();
        $package->cultures()->delete();

        if ($request->has('tests')) {
            foreach ($request['tests'] as $test_id) {
                $test = Test::find($test_id);

                if (isset($test)) {
                    $package->tests()->create([
                        'testable_id' => $test['id'],
                        'testable_type' => 'App\Models\Test'
                    ]);
                }
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture_id) {
                $culture = Culture::find($culture_id);

                if (isset($culture)) {
                    $package->cultures()->create([
                        'testable_id' => $culture['id'],
                        'testable_type' => 'App\Models\Culture'
                    ]);
                }
            }
        }

        if ($request->has('rays')) {
            foreach ($request['rays'] as $ray_id) {
                $ray = Ray::find($ray_id);

                if (isset($ray)) {
                    $package->rays()->create([
                        'testable_id' => $ray['id'],
                        'testable_type' => 'App\Models\Ray'
                    ]);
                }
            }
        }

        session()->flash('success', __('Package updated successfully'));

        return redirect()->route('admin.packages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        $package->tests()->delete();
        $package->cultures()->delete();
        $package->prices()->delete();
        $package->contract_prices()->delete();
        $package->delete();

        session()->flash('success', __('Package deleted successfully'));

        return redirect()->route('admin.packages.index');
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
            $package = Package::find($id);
            $package->tests()->delete();
            $package->cultures()->delete();
            $package->prices()->delete();
            $package->contract_prices()->delete();
            $package->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.packages.index');
    }

    public function addPackageToPortal(Request $request)
    {
        $ids = $request->ids;
        $packagies = Package::whereIn('id', $ids)->get();
        $portalSetting = setting('portal');
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);
        foreach ($packagies as $pakage) {
            $gpc = 'EG-' . $portalSetting['registerationNumber'] . '-' . $pakage->id . 'package';
            $addProduct = '{
                "items": [
                    {
                        "codeType": "' . "EGS" . '",
                        "parentCode": "10001688",
                        "itemCode": "' . $gpc . '",
                        "codeName": "' . $pakage->name . '",
                        "codeNameAr": "' . $pakage->name . '",
                        "activeFrom": "' . Carbon::now()->subDay(1) . '",
                        "activeTo": "",
                        "description": "' . $pakage->name . '",
                        "descriptionAr": "' . $pakage->name . '",
                        "requestReason": "' . "Request reason text" . '",
                    },
                ]
            }';
            $product = Http::withHeaders([
                "Authorization" => 'Bearer ' . $response['access_token'],
                "Content-Type" => "application/json",
            ])->withBody($addProduct, "application/json")->post('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/codes');
            if ($product["passedItemsCount"] === 0) {
                return redirect()->back()->with('error', $product['failedItems'][0]['errors'][0] . 'For Package ' . $pakage->name);
            }
        }
        return redirect()->route('admin.portal.packages')->with('success', "تم ارسال الحزم (قيد الإنتظار)");
    }
}
