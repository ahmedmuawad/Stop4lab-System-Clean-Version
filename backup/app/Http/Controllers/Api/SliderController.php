<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    // index
    public function index()
    {
        $sliders = Slider::all();

        $data = [];
        foreach($sliders as $slider)
        {
            $data[] = [
                'id' => $slider->id,
                'title' => $slider->title,
                'image' => url('uploads/sliders-avatar/' . $slider->image),
                'created_at' => $slider->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $slider->updated_at->format('Y-m-d H:i:s'),
            ];
        }

        return Response::response(200,'success',$data);

    }
}
