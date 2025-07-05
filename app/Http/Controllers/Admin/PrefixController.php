<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prefix;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use Illuminate\Support\Facades\Log;
class PrefixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $model=Prefix::query();

            return DataTables::eloquent($model)
            ->addColumn('action',function($prefix){
                return view('admin.prefix._action',compact('prefix'));
            })
            ->addColumn('gender' , function($prefix){
                // Log::info(['gender'=>$gender]);
                return $prefix->gender;
            })
            ->addColumn('bulk_checkbox',function($item){
                return view('partials._bulk_checkbox',compact('item'));
            })
            ->toJson();
        }
        return view('admin.prefix.index');
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.prefix.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prefix=Prefix::create($request->except('_token','_method','files'));
    
        session()->flash('success',__('prefix created successfully'));

        return redirect()->route('admin.prefix.index');
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
        $prefix=Prefix::findOrFail($id);
        return view('admin.prefix.edit',compact('prefix'));
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

        $prefix=Prefix::findOrFail($id);
        $prefix->update($request->except('_token','_method','files'));

        session()->flash('success',__('prefix updated successfully'));

        return redirect()->route('admin.prefix.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prefix=Prefix::findOrFail($id);
        $prefix->delete();

        session()->flash('success',__('prefix deleted successfully'));

        return redirect()->route('admin.prefix.index');
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
            $prefix=Prefix::findOrFail($id);
            $prefix->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.prefix.index');
    }
}
