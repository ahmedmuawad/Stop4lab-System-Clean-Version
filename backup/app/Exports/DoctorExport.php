<?php

namespace App\Exports;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DoctorExport implements FromView
{
    public function view(): View
    {
        return view('admin.doctors._export', [
            'doctors' => User::whereHas('roles', function ($q) {
                $q->where('name', 'doctor');
            })->get(),
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