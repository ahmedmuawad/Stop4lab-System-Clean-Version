<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafeTransfer extends Model
{
    public $table = "safe_transfers";
    public $guarded = [];

    public function fromBrnach()
    {
        return $this->belongsTo(Branch::class,"from_branch_id","id");
    }
    public function toBrnach()
    {
        return $this->belongsTo(Branch::class,"to_branch_id","id");
    }
    public function toUser()
    {
        return $this->belongsTo(User::class,"to_user_id","id");
    }
    public function fromUser()
    {
        return $this->belongsTo(User::class,"from_user_id","id");
    }

    public function payments()
    {
        return $this->hasMany(SafeTransferPayment::class,"safe_id","id");
    }
}
