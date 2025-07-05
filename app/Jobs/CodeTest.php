<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Test;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
class CodeTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $tests;
    public $portalSetting;
    public $ids = [];
    public function __construct($ids)
    {
        // dd($ids);
        $this->tests = Test::whereIn('id' , $ids)->get();
        // dd($this->tests);
        $this->portalSetting = setting('portal');
    }


    public function handle()
    {
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->portalSetting['ID'],
            'client_secret' => $this->portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);
        foreach($this->tests as $test){
            $gpc = 'EG-'.$this->portalSetting['registerationNumber'].'-'.$test->id.'test';
            $addProduct = '{
                "items": [
                    {
                        "codeType": "' . "EGS" . '",
                        "parentCode": "10001688",
                        "itemCode": "'.$gpc.'",
                        "codeName": "' . $test->name . '",
                        "codeNameAr": "' . $test->name . '",
                        "activeFrom": "' . Carbon::now()->subDay(2) . '",
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
                Log::Info(['sucess'=>$product['failedItems'][0]['errors']]);
                return redirect()->route('admin.portal.tests-portal')->with('error', $product['failedItems'][0]['errors'][0]);
            }
            if ($product["passedItemsCount"] > 0) {
                return redirect()->route('admin.portal.tests-portal')->with('success', "تم ارسال المنتج (قيد الإنتظار)" . ' ' . ($product['passedItems'][0]['itemCode']));
            }
        }
    }
}
