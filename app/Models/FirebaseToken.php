<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirebaseToken extends Model
{

    protected $fillable = [
        'token_firebase',
        'device_id',
        'user_id',
        'type',
    ];

    // relation with user
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    // relation with patient
    public function patient()
    {
        return $this->belongsTo(Patient::class , 'user_id' , 'id');
    }
}
