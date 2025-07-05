<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OfferTest;
use App\Models\OfferPackage;
use App\Models\OfferCuluture;
use App\Models\OfferRays;
class Offers extends Model
{
    public $guarded=[];

    public function tests(){
        return $this->hasMany(OfferTest::class , 'offer_id' , 'id')->with('test');
    }

    public function packages(){
        return $this->hasMany(OfferPackage::class , 'offer_id' , 'id')->with('package');
    }

    public function culturies(){
        return $this->hasMany(OfferCuluture::class , 'offer_id' , 'id')->with('culature');
    }

    public function rays(){
        return $this->hasMany(OfferRays::class , 'offer_id' , 'id')->with('Ray');
    }
}

