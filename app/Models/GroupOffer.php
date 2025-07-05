<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Offers;
class GroupOffer extends Model
{
    public $guarded= [];

    public function offer(){
        return $this->belongsTo(Offers::class , 'offer_id' , 'id');
    }
    
}
