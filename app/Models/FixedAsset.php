<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    protected $fillable = [
        'name',
        'price',
        'branche_id',
        'supplier_id',
        'image',
    ];

    public function branche()
    {
        return $this->belongsTo(Branch::class , 'branche_id' , 'id');
    } // end of branche()

    public function supplier()
    {
        return $this->belongsTo(Supplier::class , 'supplier_id' , 'id');
    } // end of supplier()
}
