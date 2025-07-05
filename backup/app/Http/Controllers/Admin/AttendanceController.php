<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeeSchedule;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\CreateEmployeeSchedule;
use App\Models\EmployeeRequest;
use App\Models\EmployeeViolation;
use App\Models\EmployeeVocations;
use App\Models\ViolationRole;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $toDay;
    public $now;

    public function __construct()
    {
        $this->middleware('can:view_attendance',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_attendance',   ['only' => ['create', 'store']]);
        $this->toDay = Carbon::today();
        $this->now = Carbon::now()->timezone('Africa/Cairo');
        // $this->middleware('can:edit_violations',     ['only' => ['edit', 'updae']]);
        // $this->middleware('can:delete_violations',   ['only' => ['destroy','bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.attendance.index');
    }
            /**
    * get violations datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=EmployeeSchedule::query()->with('employee.user')
                                ->where('created_at','>=',$this->toDay);

        return DataTables::eloquent($model)

        ->addColumn('action',function($user){
            return view('admin.attendance._action',compact('user'));
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }

    // public function getAttendanceById(Request $request)
    // {
    //     $employee = Employee::where('user_id',auth()->guard('admin')->user()->id)->first();
    //     $model=EmployeeSchedule::query()->with('employee.user')
    //                             ->where('created_at','>=',$this->toDay)
    //                             ->where('employee_id',$employee->id);

    //     return DataTables::eloquent($model)

    //     // ->addColumn('action',function($user){
    //     //     return view('admin.attendance._action',compact('user'));
    //     // })
    //     // ->addColumn('bulk_checkbox',function($item){
    //     //     return view('partials._bulk_checkbox',compact('item'));
    //     // })
    //     ->toJson();
    // }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::with('user')->get();
        return view('admin.attendance.create',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeSchedule $request)
    {
        // condations to check in or ckech out if 0 => check in else check out
        if($request->attendance_type == '0')
        {
            $attendece=new EmployeeSchedule();
            $attendece->employee_id = $request->employee_id;
            $attendece->start_shift = $this->now;
            $attendece->save();
        }
        else
        {
            $this->EmployeeCheckOut($request->employee_id);
        }
        
        session()->flash('success',__('Attendance created successfully'));

        return redirect()->route('admin.index');
    }

    public function EmployeeCheckOut($employee_id)
    {

        $attendace = EmployeeSchedule::where('created_at' ,'>=',$this->toDay)->where('employee_id',$employee_id)->first();

        if($attendace != Null){
            $employee = Employee::find($employee_id);

            $attendace->end_shift = $this->now;

            $to = Carbon::parse($attendace->end_shift);
            $from = Carbon::parse($attendace->start_shift);

            $attendace->work_mins = $to->diffInMinutes($from) ;
  
            
            // calc vocations
            if($attendace->work_mins < $employee->works_mins){
                $this->calcVocations($employee,$attendace);
            }
            
            // calc violations
            if($employee->violation_status == 0){
                $this->clacViolations($employee,$attendace);
            }

            //calc over time
            if($employee->over_time != 0){
                $this->calcOverTime($employee,$attendace);
            }

            $attendace->save();
        }else{
            session()->flash('failed',__('You shoud cheack in firstly'));

            return redirect()->route('admin.attendance.create');
        }
    }


    public function clacViolations($employee,$attendace)
    {
        if($employee->type == '0'){
            $this->calcFilexableViolations($employee,$attendace);
        }else{
            $this->calcFixedViolations($employee,$attendace);
        }
    }


    public function calcFilexableViolations($employee,$attendace)
    {
        
        $diffHours =  $attendace->work_mins - $employee->works_mins ;
        
        if($diffHours < 0){
            $diffHours = abs($diffHours);
            
            $violation = ViolationRole::where('duration','<=',$diffHours)->latest()->first();

            if($violation != NULL){
                $employeeRequest = EmployeeRequest::where('employee_id',$employee->id)->where('day',$this->toDay)->where('status',1)->first();
                if($employeeRequest == NULL){
                    EmployeeViolation::insert(['employee_id'=>$employee->id,'violation'=>$violation->violations_mins]);
                }
            }
        }
        
    }

    public function calcOverTime($employee,$attendace){
        $overTime = (($attendace->work_mins - $employee->works_mins) > 0)  ? $attendace->work_mins - $employee->works_mins : 0  ;

        if($overTime > 0){
            $overTime = (int)($overTime / 60)  * 60;
            $attendace->over_time = $overTime;
        }
    }

    public function calcVocations($employee,$attendace)
    {
        $employeeVocation = EmployeeVocations::where('employee_id',$employee->id)
                                                ->where('day','>=',$this->toDay)
                                                ->first();
        if($employeeVocation != NULL){
            $attendace->work_mins += $employeeVocation->vocation;
        }
    }
    public function calcFixedViolations($employee,$attendace)
    {
        $startTo = Carbon::parse($employee->shift_start);
        $startFrom = Carbon::parse($attendace->start_shift);

        $diffHours = $startTo->diffInMinutes($startFrom) ;

        $violation = ViolationRole::where('duration','<=',$diffHours)->latest()->first();

        if($violation != NULL){
            EmployeeViolation::insert(['employee_id'=>$employee->id,'violation'=>$violation->violations_mins]);
        }

        $endTo = Carbon::parse($employee->shift_end);
        $endFrom = Carbon::parse($attendace->end_shift);

        $diffHours = $endTo->diffInMinutes($endFrom) ;

        $violation = ViolationRole::where('duration','<=',$diffHours)->latest()->first();

        if($violation != NULL){
            EmployeeViolation::insert(['employee_id'=>$employee->id,'violation'=>$violation->violations_mins]);
        }

    }

    public function getUserIpAddr(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';    
        return $ipaddress;
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
            /**
     * Bulk delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(BulkActionRequest $request)
    {

    }
}
