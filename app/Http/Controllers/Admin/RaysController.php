<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ray;
use App\Exports\RaysExport;
use App\Imports\RaysImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\ExcelImportRequest;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class RaysController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view_test',     ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_test',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_test',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_test',   ['only' => ['destroy', 'bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.rays.index');
    }

    /**
     * get rays datatable
     *
     * @access public
     * @var  @Request $request
     */
    public function ajax(Request $request)
    {
        $model = Ray::with('category');

        return DataTables::eloquent($model)
            ->editColumn('price', function ($ray) {
                return formated_price($ray['price']);
            })
            ->addColumn('action', function ($ray) {
                return view('admin.rays._action', compact('ray'));
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
        return view('admin.rays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ray = Ray::create($request->except('_token', '_method', 'files', 'consumptions'));

        if ($request->has('consumptions')) {
            foreach ($request['consumptions'] as $consumption) {
                $ray->consumptions()->create([
                    'product_id' => $consumption['product_id'],
                    'quantity' => $consumption['quantity']
                ]);
            }
        }

        session()->flash('success', __('Ray test created successfully'));

        return redirect()->route('admin.rays.index');
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
        $test = Ray::find($id);
        return view('admin.rays.edit', compact('test'));
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
        $ray = Ray::findOrFail($id);

        $ray->update($request->except('_token', '_method', 'files', 'consumptions'));

        $ray->consumptions()->delete();
        if ($request->has('consumptions')) {
            foreach ($request['consumptions'] as $consumption) {
                $ray->consumptions()->create([
                    'product_id' => $consumption['product_id'],
                    'quantity' => $consumption['quantity']
                ]);
            }
        }

        session()->flash('success', __('ray test updated successfully'));

        return redirect()->route('admin.rays.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ray = Ray::findOrFail($id);



        if ($ray->groups->isNotEmpty()) {
            $ids = '';
            foreach ($ray->groups as $group) {
                $ids .= '#' . $group->group_id . ' ';
            }
            session()->flash('failed', __("This rays belonge to invoices, $ids  :you can not delete"));
            return redirect()->route('admin.rays.index');
        }

        $ray->delete();

        session()->flash('success', __('ray test deleted successfully'));

        return redirect()->route('admin.rays.index');
    }

    /**
     * Export tests
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new RaysExport, 'rays.xlsx');
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
            Excel::import(new RaysImport, $request->file('import'));
        }

        session()->flash('success', __('Rays imported successfully'));

        return redirect()->back();
    }

    public function addRaysToPortal(Request $request)
    {
        $ids = $request->ids;
        $rays = Ray::whereIn('id', $ids)->get();
        $portalSetting = setting('portal');

        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);

        foreach ($rays as $ray) {
            $gpc = 'EG-' . $portalSetting['registerationNumber'] . '-' . $ray->id . 'ray';
            $addProduct = '{
            "items": [
                {
                    "codeType": "' . "EGS" . '",
                    "parentCode": "10001688",
                    "itemCode": "' . $gpc . '",
                    "codeName": "' . $ray->name . '",
                    "codeNameAr": "' . $ray->name . '",
                    "activeFrom": "' . Carbon::now()->subDay(1) . '",
                    "activeTo": "",
                    "description": "' . $ray->name . '",
                    "descriptionAr": "' . $ray->name . '",
                    "requestReason": "' . "Request reason text" . '",
                },
            ]
        }';

            $product = Http::withHeaders([
                "Authorization" => 'Bearer ' . $response['access_token'],
                "Content-Type" => "application/json",
            ])->withBody($addProduct, "application/json")->post('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/codes');
            if ($product["passedItemsCount"] === 0) {
                dd($product['failedItems'][0]['errors']);
                return redirect()->back()->with('error', $product['failedItems'][0]['errors'][0] . 'For Ray ' . $ray->name);
            }
        }
        // dd("Done");
        return redirect()->route('admin.portal.rays_portal')->with('success', "تم ارسال الإشاعات (قيد الإنتظار)");
    }
}
