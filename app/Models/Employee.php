<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use App\Models\salaryDetails;
use App\Models\Pentality;
use App\Models\allowances;
use App\Models\EmployeeDeduction;
class Employee extends Model
{
    use Notifiable,LogsActivity;

    public $table = 'employees';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','user_id', 'salary', 'type','shift_start','shift_end', 'job_start' , 'age','works_mins','violation_status','over_time'
    ];


    /**
     * roles relationship
     *
     * @var array
     */

    public function weekends()
    {
        return $this->hasMany(EmployeeWeekend::class,'employee_id','id')->groupBy('weekend');
    }

    public function employeeSalary(){
        return $this->belongsTo(salaryDetails::class , 'id' ,'employee_id');
    }

    public function employeePlentiy(){
        return $this->hasMany(Pentality::class , 'employee_id' , 'id');
    }

    public function allowances(){
        return $this->hasMany(allowances::class , 'employee_id' , 'id');
    }

    public function EmployeeDeduction(){
        return $this->hasMany(EmployeeDeduction::class , 'employee_id' , 'id')->with('deductions');
    }

    public function violation()
    {
        return $this->hasMany(EmployeeViolation::class,'employee_id','id');
    }

    
    public function attendance()
    {
        return $this->hasMany(EmployeeSchedule::class,'employee_id','id');
    }
    public function vocation()
    {
        return $this->hasMany(EmployeeVocations::class,'employee_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    // public function branches()
    // {
    //     return $this->hasMany(UserBranch::class,'user_id','id');
    // }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "User was {$eventName}";
    }
}
