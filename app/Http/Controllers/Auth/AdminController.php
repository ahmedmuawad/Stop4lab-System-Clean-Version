<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Http\Requests\Admin\ResetMailRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Lab\RegisterLabRequest;
use App\Mail\ResetPassword;
use App\Models\User;
use App\Models\Setting;
use App\Models\UserBranch;
use App\Models\Branch;
use App\Models\Government;
use App\Models\UserRole;
use App\Models\Region;
use Hash;
use Auth;
use Mail;
use Str;

class AdminController extends Controller
{
    /**
    * show login form
    *
    * @access public
    */
    public function login()
    {
        $info=setting('info');

        return view('auth.admin.login',compact('info'));
    }

    public function lab_login()
    {
        $info=setting('info');

        return view('auth.admin.lab_login',compact('info'));
    }

    public function register()
    {
        $info = setting('info');
        $governments = Government::select('id', 'name')->get();

        return view('auth.admin.register-lab',compact('info','governments'));
    }

    public function register_submit(RegisterLabRequest $request)
    {
        
        $data = $request->except('password');

        $data['password'] = bcrypt($request->password);
        $data['type'] = 'lab';
        
        $user = User::create($data);

        UserRole::firstOrCreate([
            'user_id'=>$user['id'],
            'role_id'=>5
        ]);
        
        $user->branches()->create([
            'branch_id' => session('branch_id')
        ]);

        Auth::guard('admin')->login($user);

        return redirect('admin');

    }

    public function getRegion(int $id): \Illuminate\Http\JsonResponse
    {
        $regions = Region::select('id', 'name')->where('government_id', $id)->get();
        return response()->json([
            'data'      => $regions,
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8'],
            JSON_UNESCAPED_UNICODE);
    }



    /**
    * submit login form
    * @request $request
    * @access public
    */
    public function login_submit(LoginRequest $request)
    {
        //logout from patient
        auth()->guard('patient')->logout();
        auth()->guard('admin')->logout();
        
        $user=User::where('email',$request['email'])->first();
        //check if email exist
        if(isset($user)&&Hash::check($request['password'],$user['password']))
        {
            $remember=($request->has('remeber'))?true:false;

            Auth::guard('admin')->login($user,$remember);


            $user_branch=UserBranch::where('user_id',auth()->guard('admin')->user()->id)
                                    ->first();

            session()->put('branch_id',$user_branch['branch_id']);
            session()->put('branch_name',$user_branch['branch']['name']);


            Auth::shouldUse('admin');

            return redirect('admin');
        }
        else{
            session()->flash('failed',__('Wrong email or password'));
            return redirect()->route('admin.auth.login');
        }
    }

    public function lab_login_submit(Request $request)
    {
        //logout from patient
        // dd($request->all());
        auth()->guard('patient')->logout();
        auth()->guard('admin')->logout();
        
        $user=User::where('lab_code',$request['email_or_code'])->orwhere('email',$request['email_or_code'])->first();
        // dd($user);
        //check if email exist
        // dd($user);
        if(isset($user)&&Hash::check($request['password'],$user['password']))
        {
            $remember=($request->has('remeber'))?true:false;

            Auth::guard('admin')->login($user,$remember);

            $user_branch=UserBranch::where('user_id',auth()->guard('admin')->user()->id)
                                    ->first();

            session()->put('branch_id',$user_branch['branch_id']);
            session()->put('branch_name',$user_branch['branch']['name']);

            Auth::shouldUse('admin');

            return redirect('admin');
        }
        else{
            session()->flash('failed',__('Wrong email or password'));
            return redirect()->route('admin.auth.lab_login');
        }
    }

    

    /**
    * logout admin
    * @request $request
    * @access public
    */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.auth.login');
    }


    /**
    * 
    * show ressetting mail form
    * @access public
    */
    public function mail()
    {
        $info=setting('info');

        return view('auth.admin.mail',compact('info'));
    }

    /**
    * 
    * sending resetting mail
    * @access public
    */
    public function mail_submit(ResetMailRequest $request)
    {
        $user=User::where('email',$request['email'])->first();

        if(isset($user))
        {
          //generate new user token
          $user->token=Str::random(32);
          $user->save();

          //send mail
          send_notification('reset_password',null,null,$user);
          session()->flash('success',__('Please check your email to complete resetting your password'));

          return redirect()->route('admin.reset.mail');
        }
        else{
            session()->flash('failed',__('Email not found'));
            return redirect()->route('admin.reset.mail');
        }
    }

    /**
    * 
    * show resetting password form
    * @access public
    */
    public function reset_password_form($token)
    {
        $user=User::where('token',$token)->first();
        
        if(isset($user))
        {
            session()->put('token',$token);

            $info=Setting::where('key','info')->first();

            $info=json_decode($info['value'],true);

            return view('auth.admin.reset_password',compact('info'));
        }
        else{
            return abort(403);
        }
    }

    /**
    * 
    * resetting password
    * @access public
    */
    public function reset_password_submit(ResetPasswordRequest $request)
    {
        $user=User::where('token',session('token'))->first();

        //update user password
        $user->password=bcrypt($request['password']);

        //regenerate token
        $user->token=Str::random(32);
        $user->save();

        session()->flash('success',__('Password reset successfully'));

        return redirect()->route('admin.auth.login');
    }
}
