<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group;
use App\Models\GroupTest;
use Illuminate\Support\Arr;
use App\Models\GroupCulture;
use App\Models\GroupPayment;
use Illuminate\Http\Request;
use App\Models\GroupTestResult;
use App\Models\GroupCultureOption;
use App\Http\Controllers\Controller;
use App\Models\GroupCultureResult;
use App\Models\GroupPackage;
use App\Models\Patient;
use Illuminate\Support\Facades\Http;

class UploadDataOnline extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $group = Group::find($id);

        $response = $this->callServer($group->id);

        return $response;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function callServer($id)
    {
        $invoice = Group::find($id);
        // dd(json_encode($invoice));
        $all_tests = GroupTest::where('group_id',$invoice->id)->get();
        $all_culture = GroupCulture::where('group_id',$invoice->id)->get();
        // $all_culture_res = GroupCultureResult::whereHas('group_culture',function($q)use($invoice){return $q->where('group_id',$invoice->id);})->get();
        $culture_options = GroupCultureOption::whereHas('group_culture',function($c)use($invoice){return $c->where('group_id',$invoice->id);})->get();
        $all_tests_res = GroupTestResult::whereHas('group_test',function($q)use($invoice){return $q->where('group_id',$invoice->id);})->get();
        // $payments = GroupPayment::where('group_id',$invoice->id)->get();
        // $patient = Patient::find($invoice->patient_id);


        return Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://pre.quickmedicina.com/api/sync_offline', [
            'invoice' => json_encode($invoice),
            // 'all_tests' => json_encode($all_tests),
            // 'all_tests_res' => json_encode($all_tests_res),
            // 'all_culture' => json_encode($all_culture),
            // 'culture_options' => json_encode($culture_options),
            // 'all_culture_res' => json_encode($all_culture_res),
            // 'patient' => json_encode($patient),
            // 'payments' => json_encode($payments),
            // 'packages' => json_encode($packages),
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
