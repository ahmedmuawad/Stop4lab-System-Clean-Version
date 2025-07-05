<?php

namespace App\Exports;

use App\Models\Contract;
use App\Models\Test;
use App\Models\TestPrice;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TestPriceExport implements FromView
{
    public function view(): View
    {
        $tests = Test::with('lab_out' , 'test_price','contract_prices')->where('parent_id', 0)->orWhere('separated', true)->orderby('category_id')->get();

        $tests = $tests->sortBy(function($te){ return $te->category->name; });
        //  dd($tests->toArray());
        
        if(isset(setting('medical')['samePrice'])){
            $tests->test_price = null;
        }
        if(auth()->guard('admin')->user()->lab_id == null){

            return view('admin.prices._tests_export', [
                'tests' =>$tests,
            ]);
        }else{
            foreach($tests as $test){
                $test->price == $test->contract_prices()->where('contract_id',auth()->guard('admin')->user()->lab_id)->first()->price;
            }
            return view('admin.prices._lab_prices_export', [
                'tests' =>$tests,
            ]);
        }
    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}

?>