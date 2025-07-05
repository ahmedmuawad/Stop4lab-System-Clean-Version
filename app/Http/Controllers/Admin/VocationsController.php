<?php

namespace App\Http\Controllers\Admin;

use App\Models\VocationRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\CreateVocationsRequest;
use App\Models\Employee;
use App\Models\EmployeeRequest;
use App\Models\EmployeeViolation;
use App\Models\EmployeeVocations;
use App\Http\Requests\Admin\BulkActionRequest;
use Illuminate\Support\Facades\Auth;

class VocationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('can:view_vocations',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_vocations',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_vocations',     ['only' => ['accepte', 'refuse']]);
        $this->middleware('can:delete_vocations',   ['only' => ['refuse','bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.vocations.index');
    }
            /**
    * get vocations datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=EmployeeRequest::query()->with('employee','employee.user');

        return DataTables::eloquent($model)

        ->addColumn('action',function($user){
            return view('admin.vocations._action',compact('user'));
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
        return view('admin.vocations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateVocationsRequest $request)
    {
        $employeeId = auth()->guard('admin')->user()->id;
        //create new vocation
        $employeeRequest=new EmployeeRequest();
        $employeeRequest->employee_id = Employee::where('user_id',$employeeId)->first()->id ;
        $employeeRequest->request_from = $request->request_from ;
        $employeeRequest->request_to = $request->request_to ;
        $employeeRequest->durations = $request->durations ;
        $employeeRequest->day = $request->day ;
        $employeeRequest->notes = $request->notes ;
        $employeeRequest->type = $request->type ;

        $employeeRequest->save();

        //assign weekends to vocations
        session()->flash('success',__('Vocation Request created successfully'));

        return redirect()->back();
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
    // public function edit($id)
    // {
    //     $vocation=VocationRole::findOrFail($id);        
    //     return view('admin.vocations.edit',compact('vocation'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        // $vocation = EmployeeRequest::findOrFail($id);
        // $vocation->status = 1;
        // $vocation->save();

        // session()->flash('success',__('Vocation accepte successfully'));

        // return redirect()->route('admin.vocations.index');
    }
    public function accepte($id)
    {
        $employeeRequest = EmployeeRequest::findOrFail($id);
        $employee = Employee::findOrFail($employeeRequest->employee_id);

        $employeeRequest->status = 1;
        $employeeRequest->save();

        if($employeeRequest->type == 0 && $employee->violation_status == 0){
            if($employeeRequest->durations >= 60){
                $data = [
                    'employee_id' => $employeeRequest->employee_id,
                    'violation' => $employeeRequest->durations,
                    'created_at' => $employeeRequest->day,
                ];
                EmployeeViolation::insert($data);
            }else{
                $data = [
                    'employee_id' => $employeeRequest->employee_id,
                    'vocation' => $employeeRequest->durations,
                    'day' => $employeeRequest->day,
                ];
                EmployeeVocations::insert($data);
            }
        }

        session()->flash('success',__('Vocation accepte successfully'));

        return redirect()->route('admin.vocations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refuse($id)
    {
        $vocation=EmployeeRequest::findorFail($id);
        $vocation->status = 0;
        $vocation->save();

        session()->flash('success',__('Vocation refuse successfully'));

        return redirect()->route('admin.vocations.index');

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
            EmployeeRequest::where('id',$id)->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.vocations.index');
    }
}
