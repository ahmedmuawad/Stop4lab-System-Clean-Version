<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Package;
class OfferPackage extends Model
{
    public $guarded=[];
    public function package(){
        return $this->belongsTo(Package::class , 'package_id' , 'id');
    }
}
