<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentComponent extends Model
{
    
    protected $table = 'comment_components';
    protected $fillable = ['comment_id','component_id','case_id'];
    public $timestamps = false;
    
    public function comment()
    {
        return $this->belongsTo(TestComment::class,'comment_id','id');
    }
    
    public function component()
    {
        return $this->belongsTo(Test::class,'component_id','id');
    }

}
