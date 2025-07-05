<?php

namespace App\Exports;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
class DoctorExport implements FromView
{
    public function view(): View
    {
        $role = Role::firstOrCreate(['name' => 'doctor']);
        // Log::Info(['Role'=>$role]);
       
        return view('admin.doctors._export', [
            'doctors' => User::whereHas('roles', function ($q) use ($role) {
                $q->where('role_id', $role->id);
            })->get(),
        ]);
    }
//148f48ba5e69e4293d71da46231c407eedf3ed84
    public function columnFormats(): array
    {
        return [
            'I' =>  "0",
        ];
    }
}

?>