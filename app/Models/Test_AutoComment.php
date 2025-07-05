<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AutoComment;
class Test_AutoComment extends Model
{
    protected $table = "test_auto_comments";
    public function Comment(){
        return $this->belongsTo(AutoComment::class , 'test_id' , 'id');
    }

}
