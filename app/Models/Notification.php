<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    
    protected $fillable = [
        'user_id',
        'content',
        'type',
        'report_id',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }


}
