<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Branches_custody;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;

class BranchCustodyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requsts = Branches_custody::with('branche','user')->where('status','0')->get();
        return view('admin.branch_custody.index',compact('requsts'));
    }

        /**
    * get branches datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Branches_custody::query()->with('branche')->where('status','1');

        return DataTables::eloquent($model)
        ->addColumn('action',function($branch){
            return view('admin.branch_custody._action',compact('branch'));
        })
        ->editColumn('created_at',function($branch){
            return date('Y-m-d H:i', strtotime($branch['created_at']));
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
        $branches = Branch::get();
        return view('admin.branch_custody.create',compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->custody_type == '2'){
            if($request->custody > get_cash_vault(null,$request->branche_id)){
                session()->flash('failed',__('Not Enough Cach in Branch'));

                return redirect()->back();
            }
        }
        Branches_custody::create($request->except('_token','_method'));

        session()->flash('success',__('Branch created successfully'));

        return redirect()->route('admin.branches_custody.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
        $custody = Branches_custody::findOrFail($id);
        $custody->status = 1;
        $custody->save();

        session()->flash('success',__('Accpect successfully'));

        return redirect()->back();
    }

    public function refuse($id)
    {
        $custody = Branches_custody::findOrFail($id);
        $custody->delete();

        session()->flash('success',__('Refuse successfully'));

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $custody = Branches_custody::findOrFail($id);
        $custody->delete();

        session()->flash('success',__('Custoday deleted successfully'));

        return redirect()->route('admin.branches_custody.index');
    }

    public function bulk_delete(BulkActionRequest $request)
    {
        foreach($request['ids'] as $id)
        {
            $custody=Branches_custody::findOrFail($id);
            $custody->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.branches_custody.index');
    }
}
