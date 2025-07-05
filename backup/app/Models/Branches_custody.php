<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branches_custody extends Model
{
    public $table = 'branches_custody';
    public $guarded=[];

    public function branche()
    {
        return $this->belongsTo(Branch::class,'branche_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
