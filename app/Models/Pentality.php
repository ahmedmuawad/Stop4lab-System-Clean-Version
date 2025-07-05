<?php

namespace App\Models;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class Pentality extends Model
{
    protected $table = "pentalities";

    public function employee(){
        return $this->belongsTo(Employee::class , 'employee_id' , 'id');

    }
}
