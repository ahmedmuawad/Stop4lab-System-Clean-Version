<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'patient_id',
        'prescription_name',
        'price',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class , 'patient_id' , 'id');
    }
}
