<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ray_category extends Model
{
    public $tabel = 'ray_categories';
    public $guarded=[];

    public function rays()
    {
        return $this->hasMany(Ray::class,'category_id','id');
    }
}
