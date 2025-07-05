<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDeduction extends Model
{
    // public $guarded = [];
    public $guarded = [];

    public function deductions(){
        return $this->belongsTo(deductions::class , 'deduction_id' , 'id');
    }

}   
