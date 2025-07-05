<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Middleware\Ajax;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Models\Group;
use Illuminate\Support\Facades\DB;

class NormalDoctorsController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view_doctor',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_doctor',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_doctor',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_doctor',   ['only' => ['destroy','bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function ajax()
    {
        $model = Doctor::query();

        return DataTables::eloquent($model)
        
        ->addColumn('action',function($doctor){
            return view('admin.normal_doctors._action',compact('doctor'));
        })
        // ->addColumn('bulk_checkbox',function($item){
        //     return  `<input type="checkbox" name="" class="bulk_checkbox"  id="" value="{{$item['id']}}">`;
        //     // return view('partials._bulk_checkbox',compact('item'));
        // })
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.normal_doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr = $request->except('_token');

        $doctor= Doctor::create($attr);

        session()->flash('success',__(' Normal Doctor created successfully'));
        return redirect()->route('admin.doctors.index');
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
        $doctor=Doctor::findOrFail($id);

        return view('admin.normal_doctors.edit',compact('doctor'));
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

        if($request->has('convert')){
            $validated = $request->validate([
                'email' => 'required|unique:users|max:255',
                'password' => 'required|min:6',
            ]);

            $attr = $request->except('_token' , 'password','code','convert');

            $attr['password'] = bcrypt($request->password);
    
            $newDoctor= User::create($attr);
    
            // assign role newDoctor

            $role = Role::firstOrCreate(['name' => 'doctor']);

            $newDoctor->roles()->create([
                'role_id' => $role->id
            ]);
    
            $newDoctor->branches()->create([
                'branch_id' => session('branch_id')
            ]);
    
            doctor_code($newDoctor['id']);

            Group::where('normal_doctor_id',$id)->update(['doctor_id' => $newDoctor->id , 'normal_doctor_id' => null ]);

            Doctor::find($id)->delete();

            session()->flash('success',__('Doctor Converted successfully'));

            return redirect()->route('admin.doctors.index');


        }
        $doctor = Doctor::findOrFail($id);

        $doctor->name = $request->name;
        $doctor->code = $request->code;
        $doctor->save();

        session()->flash('success',__('Doctor updated successfully'));

        return redirect()->route('admin.doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor=Doctor::findOrFail($id);
        $doctor->delete();

        session()->flash('success',__('Doctor deleted successfully'));

        return redirect()->route('admin.doctors.index');
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
            $doctor=Doctor::find($id);
            $doctor->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.doctors.index');
    }
}
