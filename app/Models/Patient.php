<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Branch;
class Patient extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    use LogsActivity;
    
    public $guarded=[];
    public $appends=['age','total','paid','due','unit','ageDays'];

    /** 
     * Relations
     * 
     */

    public function groups()
    {
        return $this->hasMany(Group::class,'patient_id','id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class , 'branch_id' , 'id');
    }
    public function contract()
    {
        return $this->belongsTo(Contract::class,'contract_id','id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }


    /** 
     * Accessors
     * 
     */

    public function getAgeAttribute()
    {
        $date = new \DateTime($this->dob);
        $now = new \DateTime();
        $interval = $now->diff($date);
        if($interval->y==0)
        {
            if($interval->m==0)
            {
                return $interval->d." ".__('Days');
            }
            else{
                return $interval->m." ".__('Months');
            }
        }
        else{
            return $interval->y." ".__('Years');
        }
    }

    // public function getNameAttribute(){
    //     return trim($this->name);
    // }
    public function getAge2($da=null)
    {
        $date = new \DateTime($this->dob);
        $now = new \DateTime($da);
        $interval = $now->diff($date);
        if($interval->y==0)
        {
            if($interval->m==0)
            {
                return $interval->d." ".__('Days');
            }
            else{
                return $interval->m." ".__('Months');
            }
        }
        else{
            return $interval->y." ".__('Years');
        }
    }

    public function getUnitAttribute()
    {
        $date = new \DateTime($this->dob);
        $now = new \DateTime();
        $interval = $now->diff($date);

        if($interval->y==0)
        {
            if($interval->m==0)
            {
                return "day";
            }
            else{
                return 'month';
            }
        }
        else{
            return 'year';
        }
    }

    public function getAgeDaysAttribute()
    {
        $date = new \DateTime($this->dob);
        $now = new \DateTime();
        $interval = $now->diff($date)->format("%a");

        return $interval;
    }

    public function getTotalAttribute()
    {
        $total=$this->groups->sum('total');

        return $total;
    }

    public function getPaidAttribute()
    {
        $paid=$this->groups->sum('paid');

        return $paid;
    }

    public function getDueAttribute()
    {
        $due=$this->groups->sum('due');

        return $due;
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Patient was {$eventName}";
    }

    // relation with prescriptions
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class,'patient_id','id');
    }
    
    // relationships firebase_tokens
    public function firebase_tokens()
    {
        return $this->hasMany(FirebaseToken::class, 'user_id', 'id')->where('type' , 'patient');
    }
    
    
    // relationship with notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')->where('type' , 'patient');
    }
}
