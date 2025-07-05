<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use App;
class StaticPageController extends Controller
{
    
    // index
    public function index()
    {

        $phone = StaticPage::where('key','phone')->first();
        $time_work_text = StaticPage::where('key','time_work_text')->first();
        $whatsapp = StaticPage::where('key','whatsapp')->first();
        $youtube = StaticPage::where('key','youtube')->first();
        $instagram = StaticPage::where('key','instagram')->first();
        $facebook = StaticPage::where('key','facebook')->first();
        $twitter = StaticPage::where('key','twitter')->first();
        $about_us = StaticPage::where('key','about_us')->first();
        $our_vision = StaticPage::where('key','our_vision')->first();
        $why_choose_us = StaticPage::where('key','why_choose_us')->first();
        $image = StaticPage::where('key','image')->first();



        $static_pages = [
            'phone' => $phone->value,
            'time_work_text' => $time_work_text->value,
            'whatsapp' => $whatsapp->value,
            'youtube' => $youtube->value,
            'instagram' => $instagram->value,
            'facebook' => $facebook->value,
            'twitter' => $twitter->value,
            'about_us' => $about_us->value,
            'our_vision' => $our_vision->value,
            'why_choose_us' => $why_choose_us->value,
            'image' => url($image->value),
        ];


        return Response::response(200,'success',$static_pages);

    }

    // introduction
    public function intro()
    {



        $static_pages = [
            [
                'title' => StaticPage::where('key','title_intro_1_'.App::getLocale())->first()['value'],
                'desc' => StaticPage::where('key','desc_intro_1_'.App::getLocale())->first()['value'],
                'image' => url(StaticPage::where('key','image_intro_1')->first()['value']),
            ],
            [
                'title' => StaticPage::where('key','title_intro_2_'.App::getLocale())->first()['value'],
                'desc' => StaticPage::where('key','desc_intro_2_'.App::getLocale())->first()['value'],
                'image' => url(StaticPage::where('key','image_intro_2')->first()['value']),
            ],
            [
                'title' => StaticPage::where('key','title_intro_3_'.App::getLocale())->first()['value'],
                'desc' => StaticPage::where('key','desc_intro_3_'.App::getLocale())->first()['value'],
                'image' => url(StaticPage::where('key','image_intro_3')->first()['value']),
            ],
        ];

        return Response::response(200,'success',$static_pages);
    }

}
