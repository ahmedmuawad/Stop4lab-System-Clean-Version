<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocationRole extends Model
{
    public $table = 'vocations_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Duration','vocations_days',
    ];
}
