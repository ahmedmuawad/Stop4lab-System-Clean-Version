<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Culture;
use App\Models\Test;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Booking;
use \App\Notify;

class NotificationController extends Controller
{

    public function index()
    {
        return view('admin.notifications.index');
    }

    public function ajax(Request $request)
    {
        $model = Notification::with('user');

        return DataTables::eloquent($model)
            ->addColumn('action', function ($notification) {
                return view('admin.notifications._action', compact('notification'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })->toJson();
    }

    // create
    public function create()
    {
        
        $users = User::all();
        $patients = Patient::all();
        return view('admin.notifications.create' , compact('users' , 'patients'));
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'type' => 'required',
            'user_ids' => 'required_if:type,users',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->type == 'all_users') {

            $users = User::all();
            
        } elseif ($request->type == 'all_patients') {

            $users = Patient::all();
            
        } elseif ($request->type == 'users') {

            $users = User::whereIn('id', $request->user_ids)->get();
        } elseif ($request->type == 'patients') {

            $users = Patient::whereIn('id', $request->patient_ids)->get();
        }elseif($request->type == 'current_branch'){
            $users = Patient::where('branch_id', session('branch_id'))->get();
        }
        
        $rand = rand(111111,999999);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar->move('uploads/notifications-avatar/', $rand . '.png');
        }

        $msg_arr = [];

        if ($users) {

            foreach ($users as $user) {

                $arr = [
                    'content' => $request->content,
                    'image' => $request->hasFile('avatar') ? $rand . '.png' : null,
                    'user_id'    => $user->id,
                    'type'    => $request->type == 'patients' || $request->type == 'all_patients' ? 'patient' : 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                ]; // end of arr

                array_push($msg_arr, $arr);
            } // end of foreach

            if (count($msg_arr) > 0) {
                foreach ($msg_arr as $msg_ar) {
                    Notification::create($msg_ar);
                }
            } // end of if

            if($request->type == 'all_patients' || $request->type == 'patients')
            {
                Notify::NotifyMobile('title', $request->content, 'patients', $users, null);
            } else {
                Notify::NotifyMobile('title', $request->content, 'users', $users, null);
            }

        } else {
            return redirect()->back()->with('error', __('models.notfound_user'));
        } // end of if

        session()->flash('success', 'created successfully');

        return redirect()->route('admin.notifications.index');
    }

    // edit 
    public function edit(Notification $booking)
    {
        return view('admin.notifications.edit', compact('booking'));
    }

    // update
    public function update(Request $request, Notification $booking)
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
    public function destroy(Notification $booking)
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
            $booking = Notification::find($id);
            $booking->delete();
        }
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.bookings.index');
    }
}
