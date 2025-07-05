<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeeWeekend extends Model
{
    public $guarded=[];

    public $table = 'employee_weekends';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'weekend'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withTrashed();
    }
    // public $guarded=[];

    // public function user()
    // {
    //     return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    // }
}
