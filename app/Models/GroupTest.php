<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTest extends Model
{
    public $guarded=[];

    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class,'test_id','id')->with('components');
    }

    public function results()
    {
        return $this->hasMany(GroupTestResult::class,'group_test_id','id')->orderBy('id','asc');
    }

    public function checked_by_user()
    {
        return $this->belongsTo(User::class,'check_test_by','id');
    }

    public function results_by_user()
    {
        return $this->belongsTo(User::class,'results_by','id');
    }

}
