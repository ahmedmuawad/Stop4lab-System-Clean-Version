<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeeSchedule extends Model
{
    public $table = 'employees_schedules';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id','start_shift','end_shift','work_mins','over_time'
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }
}
