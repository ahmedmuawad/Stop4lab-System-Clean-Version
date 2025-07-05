<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cash_in_vault extends Model
{
    public $table = 'cash_vault';
    public $guarded=[];

    public function payments()
    {
        return $this->hasMany(Vault_payment::class,'vault_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branche_id','id');
    }
}
