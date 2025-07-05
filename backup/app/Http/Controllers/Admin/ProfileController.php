<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\EmployeeSchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;

class ProfileController extends Controller
{

    public function index()
    {
        $toDay = Carbon::today();
        $employee = Employee::where('user_id',auth()->guard('admin')->user()->id)->first();
        if($employee == NULL){
            return redirect()->back();
        }
        $attendance=EmployeeSchedule::with('employee.user')
                                ->where('created_at','>=',$toDay)
                                ->where('employee_id',$employee->id)
                                ->first();
                                
        return view('admin.profile.index',compact('employee','attendance'));
    }
    /**
     * Show the form for editing profile
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.profile.edit');
    }

    /**
     * Update profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request)
    {
        //update user
        $user=User::findOrFail(auth()->guard('admin')->user()->id);
        $user->name=$request->name;
        $user->email=$request->email;
    
        //optional updating password
        if(!empty($request['password']))
        {
            $user->password=bcrypt($request->password);
        }

        //signature
        if($request->hasFile('signature'))
        {
            //upload signature
            $signature=$request->file('signature');
            $signature_name=auth()->guard('admin')->user()->id.'.'.$signature->getClientOriginalExtension();
            $signature->move('uploads/signature',$signature_name);
            $user->signature=$signature_name;
        }

        //avatar
        if($request->hasFile('avatar'))
        {
            //upload avatar
            $avatar=$request->file('avatar');
            $avatar_name=time().auth()->guard('admin')->user()->id.'.'.$avatar->getClientOriginalExtension();
            $avatar->move('uploads/user-avatar',$avatar_name);
            $user->avatar=$avatar_name;
        }
        
        $user->save();

        session()->flash('success',__('Profile updated successfully'));

        return redirect()->route('admin.profile.edit');
        
    }    
}
