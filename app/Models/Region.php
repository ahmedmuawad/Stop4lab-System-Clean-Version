<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $guarded=[];

    public function government(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Government::class);
    }
}