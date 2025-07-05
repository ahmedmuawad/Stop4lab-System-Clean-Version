<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Test_AutoComment;
use App\Models\Test;
use App\Models\CommentOperation;
class AutoComment extends Model
{
    protected $guarded = [];

    public function test(){
        return $this->belongsTo(Test::class , 'component_id' , 'id')->with('components');
    }

   

    public function operationComments(){
        return $this->belongsTo(CommentOperation::class , 'id' , 'comment_id')->with('operation');
    }

}
