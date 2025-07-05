<?php

namespace App\Http\Controllers\Admin;

use App\Models\KnowsBy;
use Illuminate\Http\Request;
use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExcelImportRequest;

class KnowsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_category',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_category',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_category',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_category',   ['only' => ['destroy','bulk_delete']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $model=KnowsBy::query();

            return DataTables::eloquent($model)
            ->addColumn('action',function($knows){
                return view('admin.knows_by._action',compact('knows'));
            })
            ->addColumn('bulk_checkbox',function($item){
                return view('partials._bulk_checkbox',compact('item'));
            })
            ->toJson();
        }

        return view('admin.knows_by.index');
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.knows_by.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        KnowsBy::create($request->except('_token','_method','files'));
    
        session()->flash('success',__('Know By created successfully'));

        return redirect()->route('admin.knows.index');
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
        $know=KnowsBy::findOrFail($id);
        return view('admin.knows_by.edit',compact('know'));
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

        $category=KnowsBy::findOrFail($id);
        $category->update($request->except('_token','_method','files'));

        session()->flash('success',__(' updated successfully'));

        return redirect()->route('admin.knows.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=KnowsBy::findOrFail($id);
        $category->delete();

        session()->flash('success',__(' deleted successfully'));

        return redirect()->route('admin.knows.index');
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
            $category=KnowsBy::findOrFail($id);
            $category->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.knows.index');
    }


}
