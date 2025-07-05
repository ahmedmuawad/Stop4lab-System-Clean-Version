<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Culture;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
class Codeculuture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $culturies;
    public $portalSetting;
    public function __construct()
    {
        $this->culturies = Culture::first();
        $this->portalSetting = setting('portal');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // foreach($this->tests as $test){
            $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->portalSetting['ID'],
                'client_secret' => $this->portalSetting['Secret'],
                'scope' => "InvoicingAPI",
            ]);
            $cult = Culture::first();
            $gpc = 'EG-'.$this->portalSetting['registerationNumber'].'-'.$cult->id.'cult1';
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
            
            // return $response;

            // Log::Info(['response'=>$response]);
            // if(isset($response['access_token'])){
            $product = Http::withHeaders([
                "Authorization" => 'Bearer ' . $response['access_token'],
                "Content-Type" => "application/json",
            ])->withBody($addProduct, "application/json")->post('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/codes');
            if ($product["passedItemsCount"] === 0) {               
                Log::Info(['sucess'=>$product['failedItems'][0]['errors']]);
                return redirect()->route('pending')->with('error', $product['failedItems'][0]['errors'][0]);
            }
            if ($product["passedItemsCount"] > 0) {
                return redirect()->route('admin.portal.culturies')->with('success', "تم ارسال المنتج (قيد الإنتظار)" . ' ' . ($product['passedItems'][0]['itemCode']));

            }
        // }
    }
}
