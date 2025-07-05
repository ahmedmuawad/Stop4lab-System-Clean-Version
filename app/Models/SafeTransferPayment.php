<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafeTransferPayment extends Model
{
    public $table = "safe_transfers_payments";
    public $guarded = [];

    public function safe()
    {
        return $this->belongsTo(SafeTransfer::class,'safe_id','id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id','id');
    }
}
