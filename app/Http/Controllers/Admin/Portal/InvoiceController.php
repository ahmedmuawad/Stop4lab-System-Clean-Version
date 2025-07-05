<?php

namespace App\Http\Controllers\Admin\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch;

class InvoiceController extends Controller
{
    public function sentInvoices()
    {
        $portalSetting = setting('portal');
        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);

        // dd($response['access_token']);

        $showInvoices = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
        ])->get('https://api.preprod.invoicing.eta.gov.eg/api/v1.0/documents/recent?pageSize=10');

// dd($showInvoices);
        $allInvoices = $showInvoices['result'];
        $allMeta = $showInvoices['metadata'];
        $taxId = $portalSetting['registerationNumber'];
        // dd("this");
        Log::Info(['showInvoice' => $allInvoices]);

        return view('admin.groups.portal.index', compact('allInvoices', 'allMeta', 'taxId'));
    }


    // public function sendInvoice($group_id){
    //     //send_Invoice
    //     $invoice = Group::find($group_id);


    // }

    public function sendInvoice($group_id)
    {
        $group = Group::where('id', $group_id)->with('tests', 'patient')->first();

        $branchId = session()->get('branch_id');
        $branchData = Branch::where('id', $branchId)->first();


        $portalSetting = setting('portal');
        $taxType1 = 0.0;
        $taxType2 = 0.0;
        if (isset($portalSetting['taxType1'])) {
            $taxType1 = number_format($portalSetting['taxType1']['value'], 2);
            $taxType1 = number_format((float)$taxType1, 2, '.', '');
        }

        if (isset($portalSetting['taxType2'])) {
            $taxType2 = number_format($portalSetting['taxType2']['value'], 2);
            $taxType2 = number_format($taxType2, 2, '.', '');
        }


        Log::Info(['tax_type1' => $taxType1]);
        Log::Info(['tax_type2' => $taxType2]);
        Log::Info(['totalAmount' => $group->subtotal * 1.04]);

        // $totaal = $group->subtotal * 1.04;
        $invoice =
            [
                "documents" => [
                    [
                        "issuer" => array(
                            "address" => array(
                                "branchID" => "0",
                                "country" => $branchData->country,
                                "governate" => $branchData->gov,
                                "regionCity" => $branchData->city,
                                "street" => $branchData->street,
                                "buildingNumber" => '-',
                            ),
                            "type" => 'B',
                            "id" => $portalSetting['registerationNumber'],
                            "name" => $portalSetting['name'],
                        ),

                        "receiver" => array(
                            "address" => array(
                                "country" => $group->patient->country,
                                "governate" => $group->patient->gov,
                                "regionCity" => $group->patient->city,
                                "street" => $group->patient->street,
                                "buildingNumber" => $group->patient->building,
                                "postalCode" => '',
                                "floor" => '',
                                "room" => '',
                                "landmark" => '',
                                "additionalInformation" => '',
                            ),
                            "type" => 'P',
                            "id" => $group->patient->national_id, //Tax ID
                            "name" => $group->patient->name,
                        ),

                        "documentType" => 'I',
                        "documentTypeVersion" => "0.9",
                        "dateTimeIssued" => '2023-01-29T01:00:35Z',
                        "taxpayerActivityCode" => '4690',
                        "internalID" => '' . rand(1, 105140) . '',
                        "totalAmount" => (float)floatval($group->subtotal),
                        "totalDiscountAmount" => 0.00,
                        "totalSalesAmount" => (float)number_format($group->subtotal, 5),
                        "netAmount" => (float)number_format($group->subtotal, 5),
                        "taxTotals" => array(
                            array(
                                "taxType" => "T4",
                                "amount" => 0.00,
                            ),
                            array(
                                "taxType" => "T1",
                                "amount" => 0.00
                            ),
                        ),
                        // "totalAmount" => floatval($group->subtotal * ),
                        "extraDiscountAmount" => 0.00,
                        "totalItemsDiscountAmount" => 0.00,
                        "signatures" => [[
                            "signatureType" => "I",
                            "value" => "ANY",
                        ]],
                    ]
                ]
            ];
        $index = 0;
        foreach ($group->tests as $key => $test) {
            $Data = [
                "description" => "cjsu",
                "itemType" => "EGS",
                "itemCode" => 'EG-' . $portalSetting['registerationNumber'] . '-' . $test['id'] . 'test',
                "itemCode" => "EG-483895180-375test",
                "unitType" => "EA",
                "quantity" => 1,
                "internalCode" => "1000",
                "salesTotal" => (float)number_format($test->price, 5),
                "total" => (float)number_format($test->price, 5),
                "valueDifference" => 0.00,
                "totalTaxableFees" => 0.00,
                "netTotal" =>  (float)number_format($test->price, 5),
                "itemsDiscount" => 0.00,

                "unitValue" => [
                    "currencySold" => "EGP",
                    "amountSold" => 0.00,
                    "currencyExchangeRate" => 0.00,
                    "amountEGP" => (float)number_format($test->price, 5),
                ],
                "discount" => [
                    "rate" => 0.00,
                    "amount" => floatval(0.00),
                ],

                "taxableItems" => [
                    [
                        'taxType' => 'T4',
                        'amount' => 0.00,
                        'subType' => 'W001',
                        'rate' => 0.00,
                    ],
                    [
                        'taxType' => 'T1',
                        'amount' => 0.00,
                        'subType' => 'V001',
                        'rate' => 0.00,
                    ],
                ],
            ];
            $invoice["documents"][0]['invoiceLines'][0] = $Data;
        }

        Log::Info(['invoice' => $invoice["documents"][0]]);
        // ($request->referencesInvoice ? $invoice["documents"][0]['references'] = [$request->referencesInvoice] : "");

        $trnsformed = json_encode($invoice, JSON_UNESCAPED_UNICODE);


        $response = Http::asForm()->post('https://id.preprod.eta.gov.eg/connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $portalSetting['ID'],
            'client_secret' => $portalSetting['Secret'],
            'scope' => "InvoicingAPI",
        ]);

        $senInvoice = Http::withHeaders([
            "Authorization" => 'Bearer ' . $response['access_token'],
            "Content-Type" => "application/json",
        ])->withBody($trnsformed, "application/json")->post('https://api.preprod.invoicing.eta.gov.eg/api/v1/documentsubmissions');

        if ($senInvoice['submissionId'] == !null) {
            // return true;
            // return $senInvoice->body();
            return redirect()->route('admin.invoice.index')->with('success', 'تم تسجيل الفاتورة بنجاح ');
        } else {
            Log::Info(['error' => $senInvoice]);
            // return $senInvoice;
            return $senInvoice->body();

            return redirect()->route('admin.invoice.index')->with('error', "يوجد خطأ فى الفاتورة من فضلك اعد تسجيلها");
        }
    }


    public function apiLogin(Request $request)
    {
        if (!$request->has('email') || !$request->has('password')) {
            $output['success'] = false;
            $output['message'] = "Missing Inputs";
            return $output;
        } else {


            $user = User::where('email', $request->email)->first();
            if (!$user && Hash::check($request['password'], $user['password'])) {
                $output['success'] = false;
                $output['message'] = "User Not Found";
                return $output;
            } else {
                $token = base64_encode($user);
                $output['success'] = true;
                $output['message'] = "Data Readed Succefully";
                $output['token'] = $token;
                return $output;
            }
        }
    }


    public function chckingPortalInvoice(Request $request)
    {

        if ($request['token']) {
            $userObj = json_decode(base64_decode($request['token']));
            Log::Info(['userObjec' => $userObj]);
            $user = User::where('email', $userObj->email)->first();
            if ($user) {
                $groups = Group::where('status', 'pending')->with('tests', 'patient')->get();
                // return (count($groups));
                if (count($groups) == 0) {
                    $output['success'] = false;
                    $output['message'] = "No Invoice To Sended";
                    return $output;
                }

                $branchId = session()->get('branch_id');
                $branchData = Branch::where('id', $branchId)->first();
                $portalSetting = setting('portal');
                $taxType1 = 0.0;
                $taxType2 = 0.0;
                if (isset($portalSetting['taxType1'])) {
                    $taxType1 = number_format($portalSetting['taxType1']['value'], 2);
                    $taxType1 = number_format((float)$taxType1, 2, '.', '');
                }

                if (isset($portalSetting['taxType2'])) {
                    $taxType2 = number_format($portalSetting['taxType2']['value'], 2);
                    $taxType2 = number_format($taxType2, 2, '.', '');
                }
                $index1 = 0;
                $index2 = 0;
                foreach ($groups as $group) {
                    $invoice[$index1] =
                        [
                            "documents" => [
                                [
                                    "issuer" => array(
                                        "address" => array(
                                            "branchID" => "0",
                                            "country" => isset($branchData->country) ? $branchData->country : 'EG',
                                            "governate" => isset($branchData->gov) ? $branchData->gov : "ESM",
                                            "regionCity" => isset($branchData->city) ? $branchData->city : "Cario",
                                            "street" => "-",
                                            "buildingNumber" => '-',
                                        ),
                                        "type" => 'B',
                                        "id" => $portalSetting['registerationNumber'],
                                        "name" => $portalSetting['name'],
                                    ),

                                    "receiver" => array(
                                        "address" => array(
                                            "country" => $group->patient->country,
                                            "governate" => $group->patient->gov,
                                            "regionCity" => $group->patient->city,
                                            "street" => $group->patient->street,
                                            "buildingNumber" => $group->patient->building,
                                            "postalCode" => '',
                                            "floor" => '',
                                            "room" => '',
                                            "landmark" => '',
                                            "additionalInformation" => '',
                                        ),
                                        "type" => 'P',
                                        "id" => $group->patient->national_id, //Tax ID
                                        "name" => $group->patient->name,
                                    ),

                                    "documentType" => 'I',
                                    "documentTypeVersion" => "0.9",
                                    "dateTimeIssued" => '2023-01-29T01:00:35Z',
                                    "taxpayerActivityCode" => '4690',
                                    "internalID" => '' . rand(1, 105140) . '',
                                    "totalAmount" => (float)floatval($group->subtotal),
                                    "totalDiscountAmount" => 0.00,
                                    "totalSalesAmount" => (float)number_format($group->subtotal, 5),
                                    "netAmount" => (float)number_format($group->subtotal, 5),
                                    "taxTotals" => array(
                                        array(
                                            "taxType" => "T4",
                                            "amount" => 0.00,
                                        ),
                                        array(
                                            "taxType" => "T1",
                                            "amount" => 0.00
                                        ),
                                    ),
                                    // "totalAmount" => floatval($group->subtotal * ),
                                    "extraDiscountAmount" => 0.00,
                                    "totalItemsDiscountAmount" => 0.00,
                                    "signatures" => [[
                                        "signatureType" => "I",
                                        "value" => "ANY",
                                    ]],
                                ]
                            ]
                        ];
                    foreach ($group->tests as $key => $test) {
                        $Data = [
                            "description" => "cjsu",
                            "itemType" => "EGS",
                            "itemCode" => 'EG-' . $portalSetting['registerationNumber'] . '-' . $test['id'] . 'test',
                            "itemCode" => "EG-483895180-375test",
                            "unitType" => "EA",
                            "quantity" => 1,
                            "internalCode" => "1000",
                            "salesTotal" => (float)number_format($test->price, 5),
                            "total" => (float)number_format($test->price, 5),
                            "valueDifference" => 0.00,
                            "totalTaxableFees" => 0.00,
                            "netTotal" =>  (float)number_format($test->price, 5),
                            "itemsDiscount" => 0.00,

                            "unitValue" => [
                                "currencySold" => "EGP",
                                "amountSold" => 0.00,
                                "currencyExchangeRate" => 0.00,
                                "amountEGP" => (float)number_format($test->price, 5),
                            ],
                            "discount" => [
                                "rate" => 0.00,
                                "amount" => floatval(0.00),
                            ],

                            "taxableItems" => [
                                [
                                    'taxType' => 'T4',
                                    'amount' => 0.00,
                                    'subType' => 'W001',
                                    'rate' => 0.00,
                                ],
                                [
                                    'taxType' => 'T1',
                                    'amount' => 0.00,
                                    'subType' => 'V001',
                                    'rate' => 0.00,
                                ],
                            ],
                        ];

                        $invoice[$index1]['invoiceLines'][] = $Data;
                    }

                    
                    $index1 += 1;
                }
                $output['success'] = true;
                $output['message'] = "Invoice Readed Succeffuly";
                $output['documents'] = $invoice;
                return $output;
                // return $invoice;
            } else {
                $output['success'] = false;
                $output['message'] = "Invalid Token";
                return $output;
            }
        } else {
            $output['success'] = false;
            $output['message'] = "Missing Token";
            return $output;
        }
    }
}
