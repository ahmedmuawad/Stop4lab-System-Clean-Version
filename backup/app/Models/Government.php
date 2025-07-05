<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    public $guarded=[];

    public function regions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Region::class);
    }
}