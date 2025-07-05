<?php

namespace App\Http\Controllers;

use App\Notify;
use App\Models\Ray;
use App\Models\Test;
use App\Models\Group;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Culture;
use App\Models\Patient;
use App\Models\Product;
use App\Models\GroupTest;
use App\Models\SampleType;
use App\Models\SafeTransfer;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;

class Solve extends Controller
{
    public function index()
    {
        $tests = Test::where('parent_id', 0)->get();

        $sample = [];
        foreach($tests as $test){
            if(!in_array($test->sample_type,$sample) && $test->sample_type != '' ){
                $sample[] = $test->sample_type;
                SampleType::create(['name' => $test->sample_type , 'parent_id' => 1]);
            }
        }

        session()->flash('success', __('successfully'));

        return redirect()->back();

    }
    public function convertSampleTypeToSampleId()
    {
        $tests = Test::all();

        foreach($tests as $test){
            if($test->sample_type != null){
                $sample = SampleType::where('name',$test->sample_type)->where('parent_id','!=',0)->first();
                
                if($sample){
                    $test->sample_type_id = $sample->id;
                    $test->save();
                }else{
                    $new_sample = SampleType::create(['name' => $test->sample_type ,'parent_id' =>1]);
                    $test->sample_type_id = $new_sample->id;
                    $test->save();
                }
            }

        }
        $culs = Culture::all();

        foreach($culs as $cul){
            if($cul->sample_type != null){
                $sample = SampleType::where('name',$cul->sample_type)->where('parent_id','!=',0)->first();

                if($sample){
                    $cul->sample_type_id = $sample->id;
                    $cul->save();
                }else{
                    $new_sample = SampleType::create(['name' => $cul->sample_type ,'parent_id' =>1]);
                    $cul->sample_type_id = $new_sample->id;
                    $cul->save();
                }
            }

        }

        session()->flash('success', __('successfully Convert'));

        return redirect()->back();

    }
    public function Kits()
    {
        $tests = Test::where('parent_id',0)->orWhere('separated',true)->get();

        foreach($tests as $test){
            $product = Product::firstOrCreate([
                'name' => "Kits of " . $test->name ,
                'sku' => $test->name,
                'type' => 'قطعة',
            ]);

            //branch products

            $branches = Branch::all();

            foreach($branches as $branch){
                $product->branches()->firstOrCreate([
                    'branch_id' => $branch->id,
                    'initial_quantity' => 10,
                    'alert_quantity' => 0
                ]);
            }

            $test->consumptions()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);



            

        }

        session()->flash('success', __('successfully'));

        return redirect()->back();

    }

    public function sendNoty()
    {
        Notify::NotifyWeb("test","test","users",null,null,null,null);
    }
    public function report()
    {
        $reports_settings = setting('reports');
        $test_settings = json_encode($reports_settings);

        $group_tests = GroupTest::all();

        foreach($group_tests as $test){
            $test->setting =  ($test->test->setting == null) ? $test_settings :$test->test->setting;
            $test->save();
        }

        
        session()->flash('success', __('successfully'));

        return redirect()->back();


    }

    public function rays(){
        $rays = Ray::all();

        foreach($rays as $ray){
            $ray->price = $ray->price *1.3;
            $ray->save(); 
        }

        session()->flash('success', __('successfully'));

        return redirect()->back();


    }

    public function barcode()
    {
        $groups = Group::where('barcode',null)->get();

        foreach($groups as $group){
            $group->barcode = $group->id;
            $group->save();
        }

        session()->flash('success', __('successfully'));

        return redirect()->back();
    }
    public  function patient()
    {
        $patients = Patient::with('groups')->where('branch_id',null)->get();
        foreach($patients as $patient){
            foreach($patient->groups as $group){
                $patient->branch_id = $group->branch_id;
                $patient->save();
            }            
        }

        session()->flash('success', __('successfully'));

        return redirect()->back();

    }
    public function unic_doctors(){
        $doctors = Doctor::select(DB::raw('name'),DB::raw('id'))->get()->groupBy('name')->all();

        foreach($doctors as $doctor){
            $docIds = [];
            foreach($doctor as $doc){
                $docIds[] = $doc->id;
            }
            $mainDoc = $docIds[0];
            DB::table('groups')->whereIn('normal_doctor_id',$docIds)->update(['normal_doctor_id' => $mainDoc , 'doctor_id' => null]);

            Doctor::whereIn('id',$docIds)->where('id','!=',$mainDoc)->delete();
        }
        session()->flash('success', __('successfully'));

        return redirect()->back();
    }
    public function calcDue()
    {
        $groups = Group::where('branch_id','4')->where('due','>','0')->get();
        foreach($groups as $group){
            $due = $group->total - $group->paid;
            $group->update(['due'=>$due]);
        }

        session()->flash('success', __('successfully'));

        return redirect()->back();



    }

}
