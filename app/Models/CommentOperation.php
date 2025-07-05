<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Operation;
class CommentOperation extends Model
{
    protected $guarded = [];

    public function operation(){
        return $this->belongsTo(Operation::class , 'operation_id' , 'id');
    }

}
