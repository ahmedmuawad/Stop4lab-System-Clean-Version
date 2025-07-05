<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExtraServices;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
class ExtraServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.extra_services.index');
    }

    public function ajax(Request $request)
    {
        // $model=Employee::query();
        $model=ExtraServices::query();

        return DataTables::eloquent($model)
        ->addColumn('action',function($user){
            return view('admin.extra_services._action',compact('user'));
        })
        
        ->addColumn('name', function (ExtraServices $extra) {
            return $extra->name;
        })

        ->addColumn('Description', function (ExtraServices $extra) {
            return $extra->descript;
        })

        ->addColumn('Price', function (ExtraServices $extra) {
            return $extra->price;
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
        return view('admin.extra_services.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all_branchies = Branch::all();


        // foreach($all_branchies as $branch){
            ExtraServices::create([
                'name'=>$request['Name'],
                'descript'=>$request['Desription'],
                'price'=>$request['Price'],
                'branch_id'=>session('branch_id')
            ]);
        // }

        return view('admin.extra_services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExtraServices  $extraServices
     * @return \Illuminate\Http\Response
     */
    public function show(ExtraServices $extraServices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExtraServices  $extraServices
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraServices $extraServices , $id)
    {   
        $extra = ExtraServices::where('id' , $id)->first();

        return view('admin.extra_services.edit')->with(['extraService'=>$extra]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExtraServices  $extraServices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $branch_id = session()->get('branch_id');
        

        $extra = ExtraServices::where('id' , $id)->update([
            'price'=>$request->Price,
            'descript'=>$request->Description,
            'name'=>$request->Name
        ]);
        return view('admin.extra_services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExtraServices  $extraServices
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $extra=ExtraServices::findorFail($id);
        $employee->delete();
        session()->flash('success',__('extraService deleted successfully'));
        return redirect()->route('admin.extra_services.index');
    }
}
