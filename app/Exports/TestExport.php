<?php

namespace App\Exports;

use App\Models\Test;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Log;

class TestExport implements FromView
{

    public $id;
    public function __construct($id)
    {
        $this->id = $id;
        Log::Info(['ID'=>$id]);
    }


    public function view(): View
    {
        if ($this->id != null) {
            $tests = Test::where('id', $this->id)->get();
            Log::Info(['Tests'=>$tests]);
            return view('admin.tests.test_export', [
                'tests' => Test::where('id', $this->id)->get()
            ]);
        } else {
            return view('admin.tests._export', [
                'tests' => Test::where('parent_id', 0)->get()
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
