<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\UserShift;
class Shift extends Model
{
    public $guarded = [];

    public function Branch(){
        return $this->belongsTo(Branch::class , 'branch_id' , 'id');
    }

    public function Usershift(){
        return $this->hasMany(UserShift::class , 'shift_id' , 'id')->with('employees');
    }
}
