<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportReferanceRange extends Model
{
    protected $fillable=[
        'test_id',
        'referance_range',
        'group_id'
    ];
}
