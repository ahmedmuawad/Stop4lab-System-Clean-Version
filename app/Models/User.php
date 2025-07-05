<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\salaryDetails;
class User extends Authenticatable
{
    use Notifiable,SoftDeletes,LogsActivity,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $guarded=[];

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
        return $this->hasMany(UserRole::class,'user_id','id')->with('role');
    }

   public function hasRole($code){
    foreach($this->roles as $role){
        foreach($role->role->permissions as $key=>$value){
            if($value->permission->key==$code){
                return true;
            }
        }
    }
       return false;
        // return $this->hasMany(UserRole::class,'user_id','id');
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
    
    // relationships firebase_tokens
    public function firebase_tokens()
    {
        return $this->hasMany(FirebaseToken::class, 'user_id', 'id')->where('type' , 'user');
    }
    // relationship with notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')->where('type' , 'user');
    }
}
