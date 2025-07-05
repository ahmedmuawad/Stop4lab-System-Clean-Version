<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipsAndOffer;
use Illuminate\Http\Request;

class TipController extends Controller
{
    // index
    public function index()
    {

        $tips = TipsAndOffer::where('type' , 'tips')->get();

        $data = [];

        foreach($tips as $tip)
        {
            $data[] = [
                'id' => $tip->id,
                'title' => $tip->title,
                'description' => $tip->description,
                'image' => url('uploads/tips-avatar/' . $tip->image),
                'created_at' => $tip->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $tip->updated_at->format('Y-m-d H:i:s'),
            ];
        }

        return Response::response(200,'success',$data);

    }
}
