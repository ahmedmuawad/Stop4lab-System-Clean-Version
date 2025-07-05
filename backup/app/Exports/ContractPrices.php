<?php

namespace App\Exports;

use App\Models\Test;
use App\Models\Contract;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContractPrices implements FromView
{

    public function view(): View
    {
        $contracts = Contract::with('tests')->get();
        
        $testPrice = Test::with('category')->where('parent_id', 0)->orWhere('separated', true)->get();

        return view('admin.contract_prices._tests_export',['contracts' => $contracts , 'testPrice' => $testPrice]);

    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}
