<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointSale extends Model
{
    
    protected $table = 'point_sales';
    
    protected $fillable = [
        'total_sale',
        'point_sale',
    ];
    
}
