<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ray_category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;

class RaysCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.rays_categories.index');
    }

    public function ajax(Request $request)
    {
        $model=Ray_category::query();

        return DataTables::eloquent($model)
        ->addColumn('action',function($category){
            return view('admin.rays_categories._action',compact('category'));
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
        return view('admin.rays_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category=Ray_category::create($request->except('_token','_method','files'));
    
        session()->flash('success',__('Category created successfully'));

        return redirect()->route('admin.rays_categories.index');
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
        $category = Ray_category::find($id);
        return view('admin.rays_categories.edit',compact('category'));
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
        $category=Ray_category::findOrFail($id);

        $category->update($request->except('_token','_method','files'));

        session()->flash('success',__('Category updated successfully'));

        return redirect()->route('admin.rays_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Ray_category::findOrFail($id);

        if($category->rays->isNotEmpty()){
            session()->flash('failed',__('This Category has tests , you can not delete'));
            return redirect()->route('admin.rays_categories.index');
        }

        $category->delete();

        session()->flash('success',__('Category deleted successfully'));

        return redirect()->route('admin.rays_categories.index');
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
            $category=Ray_category::findOrFail($id);
            $category->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.rays_categories.index');
    }
}
