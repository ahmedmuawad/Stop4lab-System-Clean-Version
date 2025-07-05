<?php

namespace App\Http\Controllers\Admin;

use App\Models\Incentive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
class IncentiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.incentives.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.incentives.create');
        
    }

    public function ajax(Request $request){
        $model=Incentive::query()->with("branch");
        return DataTables::eloquent($model)
        ->addColumn('action',function($incentive){
            return view('admin.incentives._action',compact('incentive'));
        })
        
        ->addColumn('type', function (Incentive $incentive) {
            return $incentive->type;
        })

        ->addColumn('Period', function (Incentive $incentive) {
            return $incentive->period;
        })

        ->addColumn('target', function (Incentive $incentive) {
            return $incentive->target;
        })

        
        ->addColumn('precentage', function (Incentive $incentive) {
            return $incentive->precentage . '%';
        })

        ->addColumn('branch_id', function (Incentive $incentive) {
            return $incentive->branch->name;
        })

        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::Info(['re'=>$request]);
        $branch_id = session()->get('branch_id');
        if($request->has('incentives')){
            foreach($request['incentives'] as $incentive){
                Incentive::create([
                    'type'=>$incentive['type'],
                    "period"=>$incentive['type']=='monthly'?1:2,
                    "target"=>$incentive['target'],
                    "Precentage"=>$incentive['Precentage'],
                    "branch_id"=>$branch_id,
                ]);
                // $index++;
            }
        }

        session()->flash('success',__('incentive added successfully'));
        return redirect()->route('admin.incentives.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incentive  $incentive
     * @return \Illuminate\Http\Response
     */
    public function show(Incentive $incentive)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Incentive  $incentive
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Log::Info(['id'=>$id]);
        $incentive=Incentive::where('id' , $id)->first();
        return view('admin.incentives.edit')->with(['incentive'=>$incentive]);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incentive  $incentive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $branch_id = session()->get('branch_id');
        if($request->has('incentives')){
            foreach($request['incentives'] as $incentive){
        Incentive::where('id' , $id)->update([
            'type'=>$incentive['type'],
            "period"=>$incentive['type']=='monthly'?1:2,
            "target"=>$incentive['target'],
            "Precentage"=>$incentive['Precentage'],
            "branch_id"=>$branch_id,
        ]);
        }   
    }
    session()->flash('success',__('incentive Updated successfully'));
    return redirect()->route('admin.incentives.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incentive  $incentive
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $incentive = Incentive::where('id' , $id)->delete();

        if($incentive){
            session()->flash('success',__('incentive Deleted successfully'));
            return redirect()->route('admin.incentives.index');
        }

    }
}
