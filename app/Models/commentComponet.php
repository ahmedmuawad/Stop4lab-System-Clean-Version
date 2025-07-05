<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
use App\Models\CommentOperation;
use App\Models\AutoComment;
class commentComponet extends Model
{
    protected $guarded = [];

    public function test(){
        return $this->belongsTo(Test::class , 'component_id' , 'id')->with('components');
    }

    public function operationComments(){
        return $this->belongsTo(CommentOperation::class , 'component_id' , 'test_id')->with('operation');
    }

    public function comment(){
        return $this->belongsTo(AutoComment::class , 'comment_id' , 'id');
    }
}
