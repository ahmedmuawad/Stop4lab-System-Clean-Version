<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
class TipsAndOffer extends Model
{
    protected $table = 'tips_and_offers';

    protected $fillable = [
        'type',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'image',
    ];

    public function getTitleAttribute()
    {
        return $this->{'title_'.App::getLocale()};
    }

    public function getDescriptionAttribute()
    {
        return $this->{'description_'.App::getLocale()};
    }
}
