<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\deductions;
use App\Http\Requests\Admin\DeductionRequest;
use Illuminate\Support\Facades\Log;
class DeductionsController extends Controller
{
    public function index(){
        return view('admin.deductions.index');
    }

    public function ajax(Request $request){
        $model=deductions::query();
        Log::Info(['$re'=>$request]);
        return DataTables::eloquent($model)
        ->addColumn('action',function($deduction){
            return view('admin.deductions._action',compact('deduction'));
        })
        
        ->addColumn('name', function (deductions $deduction) {
            return $deduction->name;
        })

        ->addColumn('type', function (deductions $deduction) {
            return $deduction->type;
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }

    public function get(){
        $deduction = deductions::all();
        return response()->json($deduction);
    }
    public function create(){
        return view('admin.deductions.create');
    }

    public function store(DeductionRequest $request){
        Log::Info('request');
        $deduction = deductions::create([
            'name'=>$request->name,
            "type"=>$request->type,
        ]);

        if($deduction){
            session()->flash('success',__('Deduction created successfully'));
            return redirect()->route('admin.deductions.index');
        }else{
            session()->flash('error',__('Error In Creating Deduction'));
            return redirect()->route('admin.deductions.index');
        }
    }

    public function edit($id){
        $deduction = deductions::where('id' , $id)->first();
        return view('admin.deductions.edit')->with(['deduction'=>$deduction]);
    }

    public function update(DeductionRequest $request , $id){
        $deduction = deductions::where('id' , $id)->update([
            'name'=>$request->name,
            "type"=>$request->type,
        ]);

        if($deduction){
            session()->flash('success',__('Deduction Deleted successfully'));
            return redirect()->route('admin.deductions.index');
        }else{
            session()->flash('error',__('Error In DeletIng Deduction'));
            return redirect()->route('admin.deductions.index');
        }
    }

    public function destroy($id){
        $deduction = deductions::where('id' , $id)->delete();
        if($deduction){
            session()->flash('success',__('Deduction updated successfully'));
            return redirect()->route('admin.deductions.index');
        }else{
            session()->flash('error',__('Error In Updating Deduction'));
            return redirect()->route('admin.deductions.index');
        }
    }
}
