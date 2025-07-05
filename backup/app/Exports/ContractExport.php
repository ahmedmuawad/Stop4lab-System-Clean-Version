<?php

namespace App\Exports;

use App\Models\Contract;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContractExport implements FromView
{
    public $id ;
    public function __construct($id)
    {
        $this->id = $id;

    }
    public function view(): View
    {
        return view('admin.contracts._export', [
            'name' => Contract::findOrFail($this->id)->title,
            'contract' => Contract::findOrFail($this->id)
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}
