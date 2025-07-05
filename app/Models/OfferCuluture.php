<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Culture;
class OfferCuluture extends Model
{
    public $guarded=[];

    public function culature(){
        return $this->belongsTo(Culture::class , 'culture_id' , 'id')->withTrashed();
    }
}
