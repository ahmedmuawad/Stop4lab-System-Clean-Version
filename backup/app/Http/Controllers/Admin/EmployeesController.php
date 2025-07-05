<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use App\Models\EmployeeWeekend;
use App\Models\EmployeeSchedule;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\CreateEmployeeRequest;
use App\Models\EmployeeViolation;
use App\Models\EmployeeVocations;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('can:view_hr',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_hr',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_hr',     ['only' => ['edit', 'updae']]);
        $this->middleware('can:delete_hr',   ['only' => ['destroy','bulk_delete']]);
    }
    public function index()
    {
        return view('admin.employees.index');
    }

        /**
    * get employees datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        // $model=Employee::query();
        $model=Employee::query()->with('user');

        return DataTables::eloquent($model)
        ->addColumn('action',function($user){
            return view('admin.employees._action',compact('user'));
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
        $users=User::all();
        return view('admin.employees.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        //create violations and vocations 
        $violations = new EmployeeViolation();
        $vocations = new EmployeeVocations();
        
        
        //create new employee
        $employee=new Employee();

        $employee->user_id = $request->user_id;
        $employee->salary = $request->salary;
        $employee->type = $request->type;
        $employee->shift_start = $request->shift_start;
        $employee->shift_end = $request->shift_end;
        $employee->job_start = $request->job_start;
        $employee->age = $request->age;
        $employee->over_time = ($request->over_time != NULL) ? $request->over_time : 0;
        $employee->violation_status = ($request->violation_status != NULL) ? $request->violation_status : 0;

        if($request->type == '0'){
           $employee->works_mins = $request->works_mins * 60 ;
        }else{
            $to = Carbon::parse($request->shift_end);
            $from = Carbon::parse($request->shift_start);
            
            $employee->works_mins = $to->diffInMinutes($from) ;
        }

        $employee->save();

        //assign violations to employee
        $violations->employee_id = $employee->id;
        $violations->violation = ($request->violations != NULL) ? $request->violations : 0;
        $violations->save();

        //assign violations to employee
        $vocations->employee_id = $employee->id;
        $vocations->vocation = ($request->vocations != NULL) ? $request->vocations : 0;
        $vocations->save();

        //assign weekends to employee
        if($request->has('weekends'))
        {
            foreach($request['weekends'] as $weekend)
            {
                EmployeeWeekend::firstOrCreate([
                    'employee_id'=>$employee->id,
                    'weekend'=>$weekend
                ]);
                
            }
        }
        session()->flash('success',__('Employee created successfully'));

        return redirect()->route('admin.employees.index');
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
        $thisMonth = Carbon::now()->startOfMonth();
        $employee=Employee::with('weekends','violation','vocation','attendance','user.roles.role')->findOrFail($id); 
        $employee->violation = $employee->violation->where('created_at','>=',$thisMonth)->sum('violation');
        $employee->vocation = $employee->vocation->where('created_at','>=',$thisMonth)->sum('vocation');
        $employee->attendance = $employee->attendance->where('start_shift','>=',$thisMonth)->sum('over_time');
        $weekends = [];
        foreach($employee->weekends as $week){
            array_push($weekends,$week->weekend);
        }
        $employee->weekends = $weekends;
        $users=User::all();     
        return view('admin.employees.edit',compact('employee','users'));
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
        //update employee
        $employee=Employee::findOrFail($id);
        $employee->salary = $request->salary;
        $employee->type = $request->type;
        $employee->shift_start = $request->shift_start;
        $employee->shift_end = $request->shift_end;
        $employee->job_start = $request->job_start;
        $employee->age = $request->age;
        $employee->over_time = ($request->over_time != NULL) ? $request->over_time : 0;
        $employee->violation_status = ($request->violation_status != NULL) ? $request->violation_status : 0;

        $employee->save();

        //assign weekends to employee
        if($request->has('weekends'))
        {
            foreach($request['weekends'] as $weekend)
            {
                EmployeeWeekend::firstOrCreate([
                    'employee_id'=>$employee->id,
                    'weekend'=>$weekend
                ]);
                
            }
        }
        
        session()->flash('success',__('Employee updated successfully'));

        return redirect()->route('admin.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $employee=Employee::findorFail($id);
        
        //delete assigned weekends & Schedule
        EmployeeWeekend::where('employee_id',$id)->delete();
        EmployeeSchedule::where('employee_id',$id)->delete();
        //delete employee finally
        $employee->delete();

        session()->flash('success',__('employee deleted successfully'));

        return redirect()->route('admin.employees.index');
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
            if($id!=1)
            {
                $employee=Employee::find($id);
        
                //delete assigned weekends & Schedule
                EmployeeWeekend::where('employee_id',$id)->delete();
                EmployeeSchedule::where('employee_id',$id)->delete();
        
                //delete employee finally
                $employee->delete();
            } 
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.employees.index');
    }
}
