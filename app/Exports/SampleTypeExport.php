<?php

namespace App\Exports;

use App\Models\SampleType;
use App\Models\Test;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// class SampleTypeExport implements FromCollection
class SampleTypeExport implements FromView
{
    public function view(): View
    {
        return view('admin.sample_types._export', [
            'samples' => SampleType::with('parent')->where('parent_id','>',0)->get()
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}
