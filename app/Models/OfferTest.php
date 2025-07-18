<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
class OfferTest extends Model
{
    public $guarded=[];
    
    public function test(){
        return $this->belongsTo(Test::class , 'test_id' , 'id')->withTrashed();
    }
}
