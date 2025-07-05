<?php

namespace App\Exports;

use App\Models\Test;
use App\Models\TestPrice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TestPriceExport implements FromView
{
    public function view(): View
    {
        
        return view('admin.prices._tests_export', [
            'tests' => Test::with('lab_out')->where('parent_id', 0)->orWhere('separated', true)->get(),
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}

?>