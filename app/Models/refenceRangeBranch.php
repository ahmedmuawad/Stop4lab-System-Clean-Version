<?php

namespace App\Models;
use App\Models\Test;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;

class refenceRangeBranch extends Model
{
    protected $table = "refenceRangeBranch";

    public function branch(){
        return $this->belonsTo(Branch::class , 'branch_id' , 'id');
    }

    public function test(){ 
        return $this->belonsTo(Test::class , 'test_id' , 'id');

    }
}
