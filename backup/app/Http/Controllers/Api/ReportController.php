<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Controllers\Api\Response;

class ReportController extends Controller
{
    public function invoices(Request $request)
    {
        if($request->user()->type == 'lab'){
            $groups=Group::with('patient')->where('contract_id',$request->user()->lab_id)->select('id','patient_id','total','discount','paid','due','created_at','done','report_pdf','receipt_pdf')->get();
        }else{
            $groups=Group::with('patient')->where('doctor_id',$request->user()->id)->select('id','patient_id','total','discount','paid','due','created_at','done','report_pdf','receipt_pdf')->get();
        }
        // $groups=Group::with('patient')->where('contract_id',6)->select('id','total','discount','paid','due','created_at','done','report_pdf','receipt_pdf')->get();

        $data = [];
        foreach ($groups as $group) {
            $data[] = [
                'id' => $group->id,
                'total' => (int)$group->total,
                'discount' => (int)$group->discount,
                'paid' => (int)$group->paid,
                'due' => $group->due,
                'created_at' => date('Y-m-d',strtotime($group->created_at)),
                'done' => $group->done,
                'report_pdf' => $group->report_pdf,
                'receipt_pdf' => $group->receipt_pdf,
                'patient' => $group->patient->name
            ];
        }
        
        return Response::response(200,'success',['data'=>$data]);

    }

    public function accounting(Request $request)
    {

        $validation = Response::validation($request, ['from' => 'required','to' => 'required']); //validations

        if (!empty($validation)) {
            return $validation;
        }
        $from = $request->from; 
        $to = $request->to;

        if($request->user()->type == 'lab'){
            $groups=Group::with('patient')->where('contract_id',$request->user()->lab_id)->whereBetween('created_at',[$from,$to])->select('id','patient_id','total','discount','paid','due','created_at','done','report_pdf','receipt_pdf')->get();
        }else{
            $groups=Group::with('patient')->where('doctor_id',$request->user()->id)->whereBetween('created_at',[$from,$to])->select('id','patient_id','total','discount','paid','due','created_at','done','report_pdf','receipt_pdf')->get();
        }
        $data = [];
        $invoices = [];
        foreach ($groups as $group) {
            $invoices[] = [
                'id' => $group->id,
                'total' => (int)$group->total,
                'discount' => (int)$group->discount,
                'paid' => (int)$group->paid,
                'due' => $group->due,
                'created_at' => date('Y-m-d H:i:A',strtotime($group->created_at)),
                'done' => $group->done,
                'report_pdf' => $group->report_pdf,
                'receipt_pdf' => $group->receipt_pdf,
                'patient' => $group->patient->name
            ];
        }
        $summary =[];

        $total =  $groups->sum('total');
        $paid =  $groups->sum('paid');
        $due =  $groups->sum('due');

        $summary['total'] = $total;
        $summary['paid'] = $paid;
        $summary['due'] = $due;

        if($request->user()->commission != null){
            $summary['commission'] = (float)(($summary['total'] / 100) * $request->user()->commission) ;
        }

        $data['invoices'] = $invoices;
        $data['summary'] = $summary;

        return Response::response(200,'success',['data'=>$data]);

    }

    public function get_group(Request $request){
        $id = 70;
        $group=Group::with('patient','tests.test','cultures.culture','packages.package')->select('id','patient_id','total','discount','paid','due','created_at','done','report_pdf','receipt_pdf')->find(70);
        $testsName = [];
        $cultureName = [];
        $packageName = [];
        foreach($group->tests as $test){
             $testsName[] =  $test->test->name;
        }
        foreach($group->cultures as $test){
             $cultureName[] =  $test->culture->name;
        }
        foreach($group->packages as $test){
             $packageName[] =  $test->package->name;
        }

        $group->tests_name = $testsName ;
        $group->cultureName =  $cultureName ;
        $group->packageName =  $packageName ;
        $group->patient =  $group->patient->name ;
        $group->date =  date('Y-m-d H:i:A',strtotime($group->created_at)) ;

        $group->makeHidden('tests','cultures','packages','patient','created_at');


        return Response::response(200,'success',['group'=>$group]);
    }
}
