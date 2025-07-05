<?php

namespace App\Http\Controllers\Admin;

use App\Models\SafeTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Branches_custody;


class SafeRefusedController extends Controller
{

    public function index()
    { 
        return view('admin.safe_transfer.refused');
    }
    
    public function ajax(Request $request)
    {
    
        $model=SafeTransfer::query()->with('payments','fromBrnach','toBrnach','toUser','fromUser')->where('from_branch_id',session('branch_id'))->where('accept','Refused');


        if ($request['filter_to_user'] != '') {
            $model->where('to_user_id', $request['filter_to_user']);
        }
        if ($request['filter_from_user'] != '') {
            $model->where('from_user_id', $request['filter_from_user']);
        }
        if ($request['filter_to_branch'] != '') {
            $model->where('to_branch_id', $request['filter_to_branch']);
        }
        if ($request['filter_from_branch'] != '') {
            $model->where('from_branch_id', $request['filter_from_branch']);
        }
        if ($request['filter_date'] != '') {
            //format date
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select groups of date between
            $date[0] == $date[1]
                ? $model->whereDate('created_at', $from)
                : $model->whereBetween('created_at', [$from, $to]);
        }
        
        
        return DataTables::eloquent($model)
        ->addColumn('payments',function($safe){
            $custody = Branches_custody::where('priceable_type','App\Models\SafeTransfer')->where('priceable_id',$safe->id)->sum('custody');
            return view('admin.safe_transfer._payment',compact('safe','custody'));
        })
        ->addColumn('from_to',function($safe){
            return date('Y-m-d',strtotime($safe->from_date)) . " : " . date('Y-m-d',strtotime($safe->to_date)); 
        })
        ->editColumn('created_at',function($safe){
            return date('Y-m-d h:i A',strtotime($safe->created_at)); 
        })
        ->addColumn('action',function($safe)use($request){
            $type = 'refused';
            return view('admin.safe_transfer._action',compact('safe','type'));
        })
        ->addColumn('bulk_checkbox', function ($item) {
            return view('partials._bulk_checkbox', compact('item'));
        })
        ->toJson();
    }
}
