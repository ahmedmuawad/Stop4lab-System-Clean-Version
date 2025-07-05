<?php

namespace App\Http\Controllers;

use App\Models\SampleType;
use App\Models\Test;
use Illuminate\Http\Request;

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
}
