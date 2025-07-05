<?php

namespace App\Exports;
use App\Models\Test;
use App\Models\Contract;
use App\Models\Culture;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContractPackages implements FromView
{
    public function view(): View
    {
        $contracts = Contract::with('packages')->get();
        
        $packages = Package::get();

        return view('admin.contract_prices._packages_export',['contracts' => $contracts , 'packages' => $packages]);

    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}
