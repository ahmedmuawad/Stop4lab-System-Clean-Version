<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\CreateviolationsRequest;
use App\Models\ViolationRole;

class ViolationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('can:view_violations',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_violations',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_violations',     ['only' => ['edit', 'updae']]);
        $this->middleware('can:delete_violations',   ['only' => ['destroy','bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.violations.index');
    }
            /**
    * get violations datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=ViolationRole::query();

        return DataTables::eloquent($model)

        ->addColumn('action',function($user){
            return view('admin.violations._action',compact('user'));
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
        return view('admin.violations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create new vocation
        $violation=new ViolationRole();
        $violation->duration = $request->duration;
        $violation->violations_mins = ($request->hours * 60) + $request->mins ;
        $violation->save();

        //assign weekends to violations
        session()->flash('success',__('Violation Role created successfully'));

        return redirect()->route('admin.violations.index');
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
        $violation=ViolationRole::findOrFail($id);        
        return view('admin.violations.edit',compact('violation'));
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
        $violation= ViolationRole::findOrFail($id);
        $violation->duration = $request->duration;
        $violation->violations_mins = ($request->hours * 60) + $request->mins ;
        $violation->save();

        session()->flash('success',__('Violation role updated successfully'));

        return redirect()->route('admin.violations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $violation=ViolationRole::findorFail($id);
        $violation->delete();

        session()->flash('success',__('Violation deleted successfully'));

        return redirect()->route('admin.violations.index');

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
            ViolationRole::find($id)->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.violations.index');
    }
}
