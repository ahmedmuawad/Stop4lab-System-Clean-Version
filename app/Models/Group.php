<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GroupOffer;
use App\Models\GroupImage;
use App\Models\invoiceImages;
class Group extends Model
{
    use LogsActivity,SoftDeletes;

    public $guarded=[];

    protected $dates = ['signed_date'];

    protected static $logName = 'Invoice';

    protected static $logAttributes = ['discount', 'discount_value','subtotal','total','paid','due','delayed_money'];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    // public $appends=['reffered'];

    public function all_tests()
    {
        return $this->hasMany(GroupTest::class,'group_id','id')
                    ->where('is_canceled',0)->with('test');
    }

    public function images(){
        return $this->hasMany(GroupImage::class , 'group_id' , 'id')->orderBy('image_num');
    }


    public function invoiceImage(){
        return $this->hasMany(invoiceImages::class , 'group_id' , 'id')->orderBy('img_name');
    }
    public function tests()
    {
        return $this->hasMany(GroupTest::class,'group_id','id')
                    ->where('package_id',null)
                    ->where('is_canceled',0);
    }

    public function all_tests_with_canceled()
    {
        return $this->hasMany(GroupTest::class,'group_id','id');
    }

    public function tests_with_canceled()
    {
        return $this->hasMany(GroupTest::class,'group_id','id')
                    ->where('package_id',null);
    }

    public function rays()
    {
        return $this->hasMany(GroupRay::class,'group_id','id')
                    ->where('is_canceled',0);
    }
    public function rays_with_canceled()
    {
        return $this->hasMany(GroupRay::class,'group_id','id');
    }

    public function all_cultures_with_canceled()
    {
        return $this->hasMany(GroupCulture::class,'group_id','id');
    }

    public function cultures_with_canceled()
    {
        return $this->hasMany(GroupCulture::class,'group_id','id')
                    ->where('package_id',null);
    }

    public function all_cultures()
    {
        return $this->hasMany(GroupCulture::class,'group_id','id')
                    ->where('is_canceled',0);
    }

    public function cultures()
    {
        return $this->hasMany(GroupCulture::class,'group_id','id')
                    ->where('package_id',null)
                    ->where('is_canceled',0);
    }

    public function packages()
    {
        return $this->hasMany(GroupPackage::class,'group_id','id')
                        ->where('is_canceled',0);
    }


    public function offers(){
        return $this->hasMany(GroupOffer::class , 'group_id' , 'id')->with('offer');
    }

    public function packages_with_canceled()
    {
        return $this->hasMany(GroupPackage::class,'group_id','id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id','id')->withTrashed();
    }

    public function doctor()
    {
        return $this->belongsTo(User::class,'doctor_id','id')->withTrashed();
    }
    public function normalDoctor()
    {
        return $this->belongsTo(Doctor::class,'normal_doctor_id','id')->withTrashed();

    }

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','id')->withTrashed();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class,'contract_id','id')->withTrashed();
    }

    public function payments()
    {
        return $this->hasMany(GroupPayment::class,'group_id','id');
    }

    public function consumptions()
    {
        return $this->hasMany(ProductConsumption::class,'group_id','id');
    }
    public function reference_range_new()
    {
        return $this->hasMany(ReportReferanceRange::class,'group_id','id');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class,'created_by','id')->withTrashed();
    }

    public function deleted_by_user()
    {
        return $this->belongsTo(User::class,'deleted_by','id')->withTrashed();
    }

    public function signed_by_user()
    {
        return $this->belongsTo(User::class,'signed_by','id')->withTrashed();
    }



    public function getDescriptionForEvent(string $eventName): string
    {
        return "Invoice was {$eventName}";
    }
    
     public function user() {
        return $this->belongsTo(User::class);
    }

    public function government() {
        return $this->belongsTo(Government::class);
    }

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function representative() {
        return $this->belongsTo(User::class, 'rep_id');
    }

    public function barcoded_by_user()
    {
        return $this->belongsTo(User::class,'barcoded_by','id');
    }

    public function working_paper_by_user()
    {
        return $this->belongsTo(User::class,'working_paper_by','id');
    }
    public function review_by_user()
    {
        return $this->belongsTo(User::class,'review_by','id');
    }
    public function medical_print_by_user()
    {
        return $this->belongsTo(User::class,'medical_print_by','id');
    }
    public function questions()
    {
        return $this->hasMany(groupQuestion::class,'group_id','id');
    }

    public function sub_contract()
    {
        return $this->belongsTo(SubContract::class,'sub_contract_id','id');
    }

    public function know_by()
    {
        return $this->belongsTo(GroupKnow::class,'knowed_by','id');
    }



    // public function getRefferedAttribute()
    // {
    //     $name = '';
    //     if($this->doctor != null){
    //         $name = $this->doctor->name;
    //     }elseif($this->normalDoctor != null){
    //         $name = $this->normalDoctor->name;
    //     }else{
    //         if($this->patient->gender == 'male'){
    //             $name = 'Himself';
    //         }else{
    //             $name = 'Herself';
    //         }
    //     }

    //     if($this->user_id != null){
    //         $name .= ' - ' . $this->user->name; 
    //     }elseif($this->contract_id != null){
    //         $name .= ' - ' . $this->contract->title;
    //     }

    //     return $name ;

    // }
}
