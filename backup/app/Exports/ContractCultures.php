<?php

namespace App\Exports;

use App\Models\Test;
use App\Models\Contract;
use App\Models\Culture;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContractCultures implements FromView
{
    public function view(): View
    {
        $contracts = Contract::with('cultures')->get();
        
        $cultures = Culture::get();

        return view('admin.contract_prices._cultures_export',['contracts' => $contracts , 'cultures' => $cultures]);

    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}
