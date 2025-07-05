<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ray;
class OfferRays extends Model
{
    public $guarded=[];
    public function Ray(){
        return $this->belongsTo(Ray::class , 'rays_id' , 'id');
    }
}
