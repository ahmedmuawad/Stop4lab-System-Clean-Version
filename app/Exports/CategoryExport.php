<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CategoryExport implements FromView
{
    public function view(): View
    {
        return view('admin.categories._export', [
            'categories' => Category::all()
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}
