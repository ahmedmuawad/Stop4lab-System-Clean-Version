<?php

namespace App\Exports;

use App\Models\Ray;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RaysExport implements FromView
{
    public function view(): View
    {
        return view('admin.rays._export', [
            'rays' => Ray::get()
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}
