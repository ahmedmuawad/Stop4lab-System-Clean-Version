<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vault_payment extends Model
{
    public $table = 'vault_payments';
    public $guarded=[];

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id','id');
    }
}
