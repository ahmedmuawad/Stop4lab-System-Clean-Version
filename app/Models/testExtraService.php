<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExtraServices;
class testExtraService extends Model
{
    protected $table = "test_extra_services";
    protected $fillable = ['id' , 'groupId' , 'extraServiceId'];

    public function extraService(){
        return $this->belongsTo(ExtraServices::class , 'extraServiceId' , 'id');
    }
}
