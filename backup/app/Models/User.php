<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes,LogsActivity,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','theme','avatar', 'lab_id' , 'type' , 'phone' , 'address' , 'commission', 'government_id', 'region_id','lab_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * roles relationship
     *
     * @var array
     */

    public function roles()
    {
        return $this->hasMany(UserRole::class,'user_id','id');
    }

    public function branches()
    {
        return $this->hasMany(UserBranch::class,'user_id','id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "User was {$eventName}";
    }

    public function government() {
        return $this->belongsTo(Government::class);
    }

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function lab_groups() {
        return $this->hasMany(Group::class, 'user_id');
    }

    public function rep_groups() {
        return $this->hasMany(Group::class, 'rep_id');
    }
  
}
