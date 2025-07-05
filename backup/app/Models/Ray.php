<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ray extends Model
{
    public $guarded=[];

    public function category()
    {
        return $this->belongsTo(Ray_category::class,'category_id','id');
    }

    public function groups()
    {
        return $this->hasMany(GroupRay::class , 'ray_id','id');
    }
}
