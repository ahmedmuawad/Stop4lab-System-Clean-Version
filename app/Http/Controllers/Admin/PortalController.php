<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Jobs\Codeculuture;
use App\Jobs\CodeExtraService;
use App\Jobs\CodePackage;
use App\Jobs\CodeTest;
use App\Jobs\raysCode;

class PortalController extends Controller
{


    public function tests()
    {
        $portalSetting = setting('portal');
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' =>  $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);
        $product = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
            "Content-Type" => "application/json",
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/my?Active=true&PS=1000');
        $products = array_filter($product['result'], function ($elem) {
            return strpos($elem['itemCode'], 'test');
        });

        return view('admin.portal.tests', compact('products'));
    }



    public function culturies()
    {
        $portalSetting = setting('portal');
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' =>  $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);

        $product = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
            "Content-Type" => "application/json",
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/my?Active=true&PS=1000');

        $culturies = array_filter($product['result'], function ($elem) {
            return strpos($elem['itemCode'], 'cult');
        });
        return view('admin.portal.culturies', compact('culturies'));
    }
    public function packages()
    {
        $portalSetting = setting('portal');
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' =>  $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);
        $product = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
            "Content-Type" => "application/json",
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/my?Active=true&PS=1000');

        $packagies = array_filter($product['result'], function ($elem) {
            return strpos($elem['itemCode'], 'package');
        });
        Log::Info(['package' => $product['result'][count($product['result']) - 1]]);
        return view('admin.portal.packages', compact('packagies'));
    }

    public function rays()
    {
        $portalSetting = setting('portal');
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' =>  $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);

        $product = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
            "Content-Type" => "application/json",
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/codetypes/requests/my?Active=true&PS=1000');

        $rayies = array_filter($product['result'], function ($elem) {
            return strpos($elem['itemCode'], 'ray');
        });
        return view('admin.portal.rays', compact('rayies'));
    }
}
