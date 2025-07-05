<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Culture;
use App\Models\Test;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    // store booking
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required_if:type,home',
            'branche_id' => 'required',
            // 'test_id.*' => 'required',
            // 'culture_id.*' => 'required',
            'package_id' => 'required',
            'type' => 'required',
        ]);

        $booking = new Booking();
        $booking->patient_id = auth()->user()->id;
        $booking->address = $request->address;
        $booking->branche_id = $request->branche_id;
        $booking->test_id = json_encode($request->test_id);
        $booking->culture_id = json_encode($request->culture_id);
        $booking->package_id = $request->package_id;
        $booking->type = $request->type;

        $booking->save();

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => null,
        ], 201);
    }

    // index
    public function index()
    {
        $bookings = Booking::where('patient_id', auth()->user()->id)->get();
        $data = [];
        foreach ($bookings as $booking) {

            // get culture from booking culture_id json
            $culture_ids = json_decode($booking->culture_id);
            $culture = [];
            foreach ($culture_ids as $culture_id) {
                $culture[] = Culture::find($culture_id);
            }

            // get test from booking test_id json
            $test_ids = json_decode($booking->test_id);
            $test = [];
            foreach ($test_ids as $test_id) {
                $test[] = Test::find($test_id);
            }

            $data[] = [
                'address' => $booking->address,
                'branche' => $booking->branche->name,
                'package' => $booking->package->name,
                'tests' => $test,
                'cultures' => $culture,
            ];
        }

        return response()->json([
            'message' => 'Bookings retrieved successfully',
            'bookings' => $data,
        ], 200);
    }
}
