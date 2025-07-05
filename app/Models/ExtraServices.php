<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraServices extends Model
{
    protected $table = "extra_services";

    protected $fillable = [
        'id' , 'name' , 'price' , 'descript' , 'branch_id'
    ];

}
