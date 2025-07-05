<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupRay extends Model
{
    public $guarded=[];

    public function ray()
    {
        return $this->belongsTo(Ray::class,'ray_id','id');
    }

    public function result()
    {
        return $this->hasOne(GroupRayResult::class,'group_ray_id','id');
    }
}
