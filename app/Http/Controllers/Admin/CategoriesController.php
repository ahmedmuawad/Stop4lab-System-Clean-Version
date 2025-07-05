<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Government;
use Illuminate\Http\Request;
use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExcelImportRequest;

class CategoriesController extends Controller
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
            $model=Category::query()->with('parent');

            return DataTables::eloquent($model)
            ->addColumn('action',function($category){
                return view('admin.categories._action',compact('category'));
            })
            ->addColumn('bulk_checkbox',function($item){
                return view('partials._bulk_checkbox',compact('item'));
            })
            ->toJson();
        }

        return view('admin.categories.index');
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();
        return view('admin.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category=Category::create($request->except('_token','_method','files'));
    
        session()->flash('success',__('Category created successfully'));

        return redirect()->route('admin.categories.index');
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
        $category=Category::findOrFail($id);
        $categories = Category::all();
        return view('admin.categories.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {

        $category=Category::findOrFail($id);
        $category->update($request->except('_token','_method','files'));

        session()->flash('success',__('Category updated successfully'));

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $category->delete();

        session()->flash('success',__('Category deleted successfully'));

        return redirect()->route('admin.categories.index');
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
            $category=Category::findOrFail($id);
            $category->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.categories.index');
    }

    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }

    /**
     * Import tests
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new CategoryImport, $request->file('import'));
        }

        session()->flash('success', __('categories imported successfully'));

        return redirect()->back();
    }
}
