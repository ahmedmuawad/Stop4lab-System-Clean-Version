<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Test;
use App\Models\User;
use App\Models\Branch;
use App\Models\UserRole;
use App\Models\Government;
use App\Models\UserBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class UsersController extends Controller
{

    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_user',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_user',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_user',     ['only' => ['edit', 'updae']]);
        $this->middleware('can:delete_user',   ['only' => ['destroy','bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.users.index');
    }

    /**
    * get users datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=User::query()->with('roles','branches')
        ->whereHas('roles', function ($q) {
            $q->where('role_id','!=' ,6);
        })->newQuery();

        return DataTables::eloquent($model)
        ->addColumn('roles',function($user){
            return view('admin.users._roles',compact('user'));
        })
        ->addColumn('branches',function($user){
            return view('admin.users._branches',compact('user'));
        })
        ->addColumn('action',function($user){
            return view('admin.users._action',compact('user'));
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::all();
        $branches=Branch::all();
        $governments = Government::select('id', 'name')->get();
        return view('admin.users.create',compact('roles','branches', 'governments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        //create new user
        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->government_id=$request->government_id;
        $user->region_id=$request->region_id;
        $user->sgin_name = $request->sgin_name;
        $user->randamaize = 1?$request->random_including=='on':0;
        $user->save();

        //assign roles to user
        if($request->has('roles'))
        {
            foreach($request['roles'] as $role)
            {
                if ($role == 9) {
                    $user->user_type = 'representative';
                    $user->save();
                }
                UserRole::firstOrCreate([
                    'user_id'=>$user['id'],
                    'role_id'=>$role
                ]);
                
            }
        }

        if($request->has('branches'))
        {
            foreach($request['branches'] as $branch)
            {
                UserBranch::firstOrCreate([
                    'user_id'=>$user['id'],
                    'branch_id'=>$branch
                ]);
                
            }
        }

        session()->flash('success',__('User created successfully'));

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $roles=Role::all();
        $branches=Branch::all();
        $governments = Government::select('id', 'name')->get();
        
        return view('admin.users.edit',compact('user','roles','branches', 'governments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update 
        // dd($request->random_including=='on');
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->government_id=$request->government_id;
        $user->region_id=$request->region_id;
        $user->sgin_name = $request->sgin_name;
        $user->randamaize = 1?$request->random_including=='on':0;
        //optional updating password
        if(!empty($request['password']))
        {
            $user->password=bcrypt($request->password);
        }
        
        $user->save();

        if($user['id']!=1)
        {
            //assign roles to user
            $user->roles()->delete();

            if($request->has('roles'))
            {
                foreach($request['roles'] as $role)
                {
                    if ($role == 12) {
                        $user->user_type = 'representative';
                        $user->save();
                    }
                    $user->roles()->create([
                        'user_id'=>$id,
                        'role_id'=>$role
                    ]);
                }
            }

            //assign branches for user
            $user->branches()->delete();

            if($request->has('branches'))
            {
                foreach($request['branches'] as $branch)
                {
                    $user->branches()->create([
                        'user_id'=>$user['id'],
                        'branch_id'=>$branch
                    ]);
                }
            }
        }
       
        session()->flash('success',__('User updated successfully'));

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id==1)
        {
            session()->flash('failed',__('You can\'t delete super admin user'));
            
            return redirect()->back();
        }

        $user=User::findorFail($id);
        
        $user->delete();

        session()->flash('success',__('User deleted successfully'));

        return redirect()->route('admin.users.index');
    }

    public function getUsersBlocked()
    {
        $users = DB::table('users')->whereNotNull('deleted_at')->get();
        return view('admin.users.blocked',compact('users'));
    }

    public function userUnBlocked($id)
    {   
        DB::table('users')->where('id',$id)->update(['deleted_at'=>NULL]);
        return redirect()->route('admin.users.index');

    }

    /**
     * Bulk delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(BulkActionRequest $request)
    {
        foreach($request['ids'] as $id)
        {
            if($id!=1)
            {
                $user=User::find($id);
                //delete assigned roles
                UserRole::where('user_id',$id)->delete();
                //delete user finally
                $user->branches()->delete();
                $user->delete();
            } 
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.users.index');
    }
}
