<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
class salaryDetails extends Model
{
    protected $table = "salary_details";

    protected $fillable = [
        "employee_id"
    ];
    public function user(){
        return $this->belongsTo(Employee::class , 'user_id' , 'id');
    }

}
