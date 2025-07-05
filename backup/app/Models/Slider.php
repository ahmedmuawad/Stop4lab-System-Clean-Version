<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
class Slider extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'image',
    ];

    // lang title
    public function getTitleAttribute()
    {
        return $this->{'title_'.App::getLocale()};
    }
}
