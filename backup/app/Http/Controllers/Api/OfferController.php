<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipsAndOffer;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    // index
    public function index()
    {

        $offers = TipsAndOffer::where('type' , 'offer')->get();

        $data = [];

        foreach($offers as $offer)
        {
            $data[] = [
                'id' => $offer->id,
                'title' => $offer->title,
                'description' => $offer->description,
                'image' => url('uploads/tips-avatar/'. $offer->image),
                'created_at' => $offer->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $offer->updated_at->format('Y-m-d H:i:s'),
            ];
        }

        return Response::response(200,'success',$data);

    }
}
