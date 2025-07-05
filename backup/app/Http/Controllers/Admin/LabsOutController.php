<?php

namespace App\Http\Controllers\Admin;

use App\Models\Labs_out;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;

class LabsOutController extends Controller
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
            $model=Labs_out::query();

            return DataTables::eloquent($model)
            ->addColumn('action',function($lab_out){
                return view('admin.labs_out._action',compact('lab_out'));
            })
            ->addColumn('bulk_checkbox',function($item){
                return view('partials._bulk_checkbox',compact('item'));
            })
            ->toJson();
        }
        return view('admin.labs_out.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.labs_out.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lab = new Labs_out();
        $lab->name = $request->name;
        $lab->save();

        session()->flash('success',__('Lab Out created successfully'));

        return redirect()->route('admin.labs_out.index');
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
        $lab_out=Labs_out::findOrFail($id);
        return view('admin.labs_out.edit',compact('lab_out'));
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
        $lab_out=Labs_out::findOrFail($id);
        $lab_out->update($request->except('_token','_method','files'));

        session()->flash('success',__('Lab Out updated successfully'));

        return redirect()->route('admin.labs_out.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lab_out=Labs_out::findOrFail($id);
        $lab_out->delete();

        session()->flash('success',__('Lab deleted successfully'));

        return redirect()->route('admin.labs_out.index');
    }

    public function bulk_delete(BulkActionRequest $request)
    {
        foreach($request['ids'] as $id)
        {
            $lab_out=Labs_out::findOrFail($id);
            $lab_out->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.labs_out.index');
    }
}
