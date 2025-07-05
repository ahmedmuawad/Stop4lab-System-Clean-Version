<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCulture extends Model
{
    public $guarded=[];

    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }

    public function culture()
    {
        return $this->belongsTo(Culture::class,'culture_id','id')->withTrashed();
    }

    public function antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class,'group_culture_id','id')->orderBy('id','asc');
    }

    public function high_antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class,'group_culture_id','id')->where('sensitivity',__('High'));
    }

    public function moderate_antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class,'group_culture_id','id')->where('sensitivity',__('Moderate'));
    }

    public function resident_antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class,'group_culture_id','id')->where('sensitivity',__('Resistant'));
    }
    public function low_antibiotics()
    {
        return $this->hasMany(GroupCultureResult::class,'group_culture_id','id')->where('sensitivity','Low');
    }

    public function culture_options()
    {
        return $this->hasMany(GroupCultureOption::class,'group_culture_id','id');
    }

    public function checked_by_user()
    {
        return $this->belongsTo(User::class,'check_test_by','id');
    }

    public function results_by_user()
    {
        return $this->belongsTo(User::class,'results_by','id');
    }
}
