<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
class Incentive extends Model
{
    public $guarded = [];

    public function branch(){
        return $this->belongsTo(Branch::class , 'branch_id' , 'id');
    }
}
