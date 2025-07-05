<?php

namespace App\Http\Controllers\Admin;

use Excel;
use DataTables;
use App\Models\Branch;
use App\Models\Culture;
use App\Models\Contract;
use App\Models\SampleType;
use App\Models\CulturePrice;
use Illuminate\Http\Request;
use App\Models\ContractPrice;
use App\Exports\CultureExport;
use App\Imports\CultureImport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CultureRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
class CulturesController extends Controller
{

    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_culture',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_culture',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_culture',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_culture',   ['only' => ['destroy','bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cultures=Culture::with('category.parent')->get();
        return view('admin.cultures.index',compact('cultures'));
    }

    /**
    * get cultures datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Culture::with('category' , 'culture_price');

        return DataTables::eloquent($model)
        ->editColumn('price',function($culture){
            if(setting('medical')['samePrice']){
                return formated_price($culture['price']);
            }else{
                return formated_price($culture->culture_price['price']);
            }
        })
        ->addColumn('action',function($culture){
            return view('admin.cultures._action',compact('culture'));
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
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
        $samplesTypes = SampleType::where('parent_id','!=',0)->get();

        return view('admin.cultures.create',compact('samplesTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CultureRequest $request)
    {
        $branches=Branch::all();

        $culture=Culture::create($request->except('_token','comments','consumptions','lab_to_lab_cost'));
        $lab_to_lab_cost = ($request['lab_to_lab_cost']) ? $request['lab_to_lab_cost'] : 0 ;
        $culture->update(['lab_to_lab_cost' =>$lab_to_lab_cost ]);


        //assign prices to branches
        foreach($branches as $branch)
        {
            CulturePrice::create([
                'branch_id'=>$branch['id'],
                'culture_id'=>$culture['id'],
                'price'=>$request['price']
            ]);
        }

        //contracts prices
        $contracts=Contract::all();
        foreach($contracts as $contract)
        {
            $contract->cultures()->create([
                'priceable_type'=>'App\Models\Culture',
                'priceable_id'=>$culture['id'],
                'price'=>($contract['discount_type']==1)?($culture['price']*$contract['discount_percentage']/100):$culture['price']
            ]);
        }

        //comments
        if($request->has('comments'))
        {
            foreach($request['comments'] as $comment)
            {
                $culture->comments()->create([
                    'comment'=>$comment
                ]);
            }
        }

        //consumptions
        if($request->has('consumption'))
        {
            foreach($request['consumptions'] as $consumption)
            {
                $culture->consumptions()->create([
                   'product_id'=>$consumption['product_id'],
                   'quantity'=>$consumption['quantity']
               ]);
            }
        }

        session()->flash('success','Culture saved successfully');
        return redirect()->route('admin.cultures.index');
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

        $culture_price = null;
        if(!setting('medical')['samePrice']){
            $culture_price = CulturePrice::where('branch_id' , $branch_id)->where('culture_id' , $id)->first();
        }

        // Log::Info(['price'=>$culture_price]);

        $culture=Culture::findOrFail($id);

        $samplesTypes = SampleType::where('parent_id','!=',0)->get();

        return view('admin.cultures.edit',compact('culture' ,'culture_price','samplesTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CultureRequest $request, $id)
    {
        // dd($request->except('_token','_method','comments','consumptions'));
        $branch_id = session()->get('branch_id');

        $culture=Culture::findOrFail($id);

        $culture->category_id = $request->category_id;
        $culture->name = $request->name;
        $culture->sample_type = $request->sample_type;
        $culture->price = $request->price;
        $culture->num_day_receive = $request->num_day_receive;
        $culture->num_hour_receive = $request->num_hour_receive;
        $culture->sample_type_id = $request->sample_type_id;
        $culture->lab_to_lab_status = $request->lab_to_lab_status;
        $culture->lab_to_lab_cost = ($request->lab_to_lab_status == 0) ? 0.00 : $request->lab_to_lab_cost;
        $culture->precautions = $request->precautions;

        $culture->save();
        

        $culture_price = CulturePrice::where('branch_id' , $branch_id)->where('culture_id' , $id)->update([
            'price'=>$request->price
        ]);


        //contracts prices
        $contracts=Contract::all();
        foreach($contracts as $contract)
        {
            $culture_contract=ContractPrice::firstOrCreate([
                'contract_id'=>$contract['id'],
                'priceable_type'=>'App\Models\Culture',
                'priceable_id'=>$id,
            ]);

            if($contract['discount_type']==1)
            {
                $culture_contract->update([
                    'price'=>($request['price']*$contract['discount_percentage']/100)
                ]);
            }
        }

        //comments
        $culture->comments()->delete();
        if($request->has('comments'))
        {
            foreach($request['comments'] as $comment)
            {
                $culture->comments()->create([
                    'comment'=>$comment
                ]);
            }
        }

        //consumptions
        $culture->consumptions()->delete();
        if($request->has('consumptions'))
        {
            foreach($request['consumptions'] as $consumption)
            {
                $culture->consumptions()->create([
                   'product_id'=>$consumption['product_id'],
                   'quantity'=>$consumption['quantity']
               ]);
            }
        }

        session()->flash('success','Culture updated successfully');
        return redirect()->route('admin.cultures.index');
    }

    /**
    * Export cultures
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new CultureExport, 'cultures.xlsx');
    }

    /**
    * Import cultures
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function import(ExcelImportRequest $request)
    {
        if($request->hasFile('import'))
        {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new CultureImport, $request->file('import'));
        }

        session()->flash('success',__('Cultures imported successfully'));

        return redirect()->back();
    }

    /**
    * Download cultures template
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function download_template()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return response()->download(storage_path('app/public/cultures_template.xlsx'),'cultures_template.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $culture=Culture::findOrFail($id);

        // stop delete if test belonge to groups
        if($culture->groups->isNotEmpty()){
            $ids = '';
            foreach($culture->groups as $group){
                $ids .= '#' . $group->group_id . ' ';
            }
            session()->flash('failed',__("This Culture belonge to invoices, $ids  :you can not delete"));
            return redirect()->route('admin.cultures.index');
        }

        $culture->contract_prices()->delete();
        $culture->delete();

        session()->flash('success','Culture deleted successfully');
        return redirect()->route('admin.cultures.index');
    }

    /**
     * Bulk delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(BulkActionRequest $request)
    {
        foreach($request['ids'] as $id)
        {
            $culture=Culture::find($id);
            
            // stop delete if test belonge to groups
            
            if($culture->groups->isNotEmpty()){
                $ids = '';
                foreach($culture->groups as $group){
                    $ids .= '#' . $group->group_id . ' ';
                }
                session()->flash('failed',__("This Culture belonge to invoices, $ids  :you can not delete"));
                return redirect()->route('admin.cultures.index');
            }
            $culture->contract_prices()->delete();
            $culture->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.cultures.index');
    }


    public function addCultureToPortal(Request $request){
        $ids = $request->ids;
        $culturies = Culture::whereIn('id' , $ids)->get();
        $portalSetting = setting('portal');
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);
        foreach($culturies as $cult){
            $gpc = 'EG-'.$portalSetting['registerationNumber'].'-'.$cult->id.'cult';
            $addProduct = '{
                "items": [
                    {
                        "codeType": "' . "EGS" . '",
                        "parentCode": "10001688",
                        "itemCode": "'.$gpc.'",
                        "codeName": "' . $cult->name . '",
                        "codeNameAr": "' . $cult->name . '",
                        "activeFrom": "' . Carbon::now()->subDay(2) . '",
                        "activeTo": "",
                        "description": "' . $cult->name . '",
                        "descriptionAr": "' . $cult->name . '",
                        "requestReason": "' . "Request reason text" . '",
                    },
                ]
            }';
            
            $product = Http::withHeaders([
                "Authorization" => 'Bearer ' . $response['access_token'],
                "Content-Type" => "application/json",
            ])->withBody($addProduct, "application/json")->post('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/codes');
            if ($product["passedItemsCount"] === 0) {               
                return redirect()->back()->with('error', $product['failedItems'][0]['errors'][0] . 'for Culture ' . $cult->name);
            }
        }
        return redirect()->route('admin.portal.culturies')->with('success', "تم ارسال المزارع (قيد الإنتظار)");
    }
}
