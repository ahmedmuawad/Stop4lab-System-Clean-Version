<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Culture;
use App\Models\Test;
use Illuminate\Http\Request;
use DataTables;

class BookingController extends Controller
{

    public function index()
    {
        return view('admin.bookings.index');
    }

    public function ajax(Request $request)
    {
        $model = Booking::with('branche', 'package', 'patient');

        return DataTables::eloquent($model)
            ->addColumn('action', function ($booking) {
                return view('admin.bookings._action', compact('booking'));
            })
            ->addColumn('test_id', function ($item) {
                // foreach json_decode 
                $test_ids = json_decode($item->test_id);
                $test = [];
                if(is_array($test_ids)){
                    foreach ($test_ids as $test_id) {
                        $te = Test::find($test_id);
                        $test[] = $te->name . '-';
                    }
                }else{
                    $test[] = (Test::find($item->test_id))? Test::find($item->test_id)->name : '';
                }
                

                return $test;

            })
            ->addColumn('culture_id', function ($item) {
                // foreach json_decode 
                $culture_ids = json_decode($item->culture_id);
                $culture = [];
                if(is_array($culture_ids)){
                    foreach ($culture_ids as $culture_id) {
                        $cul = Culture::find($culture_id);
                        $culture[] = $cul->name . '-';
                    }
                }else{
                    $culture[] = (Culture::find($item->culture_id))?  Culture::find($item->culture_id)->name : '';
                }
                return $culture;

            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })->toJson();
    }

    // create
    public function create()
    {
        return view('admin.bookings.create');
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $bookings = booking::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar->move('uploads/bookings-avatar/', $bookings['id'] . '.png');
            $bookings->update([
                'image' => $bookings['id'] . '.png'
            ]);
        }
        session()->flash('success', 'created successfully');

        return redirect()->route('admin.bookings.index');
    }

    // edit 
    public function edit(Booking $booking)
    {
        $booking->showing = 1;
        $booking->save();
        return view('admin.bookings.edit', compact('booking'));
    }

    // update
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'avatar' => 'nullable|image',
        ]);

        $booking->update([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $rand = rand(1111, 9999);
            $avatar->move('uploads/bookings-avatar/', $rand . '.png');
            $booking->update([
                'image' => $rand . '.png'
            ]);
        }
        session()->flash('success', 'updated successfully');

        return redirect()->route('admin.bookings.index');
    }

    // destroy
    public function destroy(Booking $booking)
    {
        $booking->delete();
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.bookings.index');
    }

    // bulk_delete
    public function bulk_delete(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);
        $ids = $request->ids;
        foreach ($ids as $id) {
            $booking = Booking::find($id);
            $booking->delete();
        }
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.bookings.index');
    }
}
