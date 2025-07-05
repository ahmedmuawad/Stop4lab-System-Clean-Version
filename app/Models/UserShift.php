<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
class UserShift extends Model
{
    public $guarded = [];
    
    public function employees(){
        return $this->belongsTo(Employee::class  , 'user_id' , 'id')->with('user');
    }
}
