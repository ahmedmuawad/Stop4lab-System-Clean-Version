<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    
    protected $fillable = [
        'patient_id',
        'address',
        'branche_id',
        'test_id',
        'culture_id',
        'package_id',
        'type',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class , 'patient_id' , 'id');
    }
    
    public function branche()
    {
        return $this->belongsTo(Branch::class , 'branche_id' , 'id');
    }


    public function package()
    {
        return $this->belongsTo(Package::class , 'package_id' , 'id');
    }

}
