<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViolationRole extends Model
{
    public $table = 'violations_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'duration','violations_mins',
    ];
}
