<?php

namespace App\Exports;

use App\Models\Ray;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RayPriceExport implements FromView
{
    public function view(): View
    {
        $rays = Ray::with('category')->get();
        
        return view('admin.prices._rays_export', [
            'rays' =>$rays,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}
