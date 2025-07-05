<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class groupQuestion extends Model
{
    public $table="group_questions";
    public $guarded=[];

    public function question()
    {
        return $this->belongsTo(TestQuestion::class,'question_id','id');
    }
    
}
