<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleType extends Model
{
    public $table = 'sample_types';
    public $guarded=[];

    public function sub_samples()
    {
        return $this->hasMany(SampleType::class,'parent_id','id');
    }
    public function parent()
    {
        return $this->belongsTo(SampleType::class,'parent_id','id');
    }
    
}
