<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\salaryDetails;
use App\Models\Pentality;
use App\Models\allowances;
use Illuminate\Support\Carbon;
use App\Models\EmployeeWeekend;
use App\Models\EmployeeSchedule;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\CreateEmployeeRequest;
use App\Models\EmployeeViolation;
use App\Models\EmployeeVocations;
use Illuminate\Support\Facades\Log;
use Session;
use App\Models\deductions;
use App\Models\EmployeeDeduction;
use Auth;
use App\Imports\AddendenceImport;
use out;
use Excel;
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
        $model=Employee::query()->with('user' , 'employeeSalary' , 'employeePlentiy');


        return DataTables::eloquent($model)
        ->addColumn('action',function($user){
            return view('admin.employees._action',compact('user'));
        })
        
     
        ->addColumn('seniority', function (Employee $employee) {
            if(isset($employee->employeeSalary)){
                return $employee->employeeSalary->seniority;
            }else{
                return 0;
            }
        })

        ->addColumn('certificate_allowance', function (Employee $employee) {
            if(isset($employee->employeeSalary)){
            return $employee->employeeSalary->certificate_allowance;
            }else{
                return 0;
            }
        })

        ->addColumn('Management_commitment', function (Employee $employee) {
            if(isset($employee->employeeSalary)){
                return $employee->employeeSalary->Management_commitment;
            }else{
                return 0;
            }
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
        $deductions = deductions::all();
        return view('admin.employees.create',compact('users' , 'deductions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
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

        /* 
         * Employee Salary Details
         */
        $salaryDetails = new salaryDetails();
        $salaryDetails->employee_id = $employee->id;
        $salaryDetails->base_salary = $request->salary;
        $salaryDetails->seniority = $request->seniority;
        $salaryDetails->certificate_allowance = $request->certificate_allowance;

        if(isset($request->penalities['values']) && $request->penalities['values']!=null){
            $salaryDetails->Management_commitment = 0;
        }else{
            $salaryDetails->Management_commitment = $request->Management_commitment;
        }

       
        $salaryDetails->save();
        
        /**
         * End Employee Salary Details
         */


        /**
         * Emplpyee Plaentalies
         */
        if(!empty($request->penalities['values'])){
            foreach (array_combine($request->penalities['values'], $request->penalities['reasons']) as $value => $reason) {
                $EmployeePenality = new Pentality();
                $EmployeePenality->employee_id = $employee->id;
                $EmployeePenality->value = $value;
                $EmployeePenality->reason = $reason;
                $EmployeePenality->save();
            }
        }

        if(!empty($request->allowances['amount'])){
            foreach (array_combine($request->allowances['amount'], $request->allowances['description']) as $value => $reason) {
                $EmployeeAllowence = new allowances();
                $EmployeeAllowence->employee_id = $employee->id;
                $EmployeeAllowence->amount = $value;
                $EmployeeAllowence->description = $reason;
                $EmployeeAllowence->save();
            }
        }
        if(!empty($request->deductions['type']) && !empty($request->deductions['value'])){
            foreach (array_combine($request->deductions['type'], $request->deductions['value']) as $type => $value) {
                $EmployeeDeduction = new EmployeeDeduction();
                $EmployeeDeduction->employee_id = $employee->id;
                $EmployeeDeduction->deduction_id = $type;
                $EmployeeDeduction->value = $value;
                $EmployeeDeduction->save();
            }
        }

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
        $employee=Employee::with('weekends','violation','vocation','attendance','user.roles.role' , 'employeeSalary' , 
        'EmployeeDeduction','allowances','employeePlentiy')->findOrFail($id);
        
        Log::Info(['employee'=>$employee]);

        $employee->violation = $employee->violation->where('created_at','>=',$thisMonth)->sum('violation');
        $employee->vocation = $employee->vocation->where('created_at','>=',$thisMonth)->sum('vocation');
        $employee->attendance = $employee->attendance->where('start_shift','>=',$thisMonth)->sum('over_time');
        $weekends = [];
        foreach($employee->weekends as $week){
            array_push($weekends,$week->weekend);
        }
        $employee->weekends = $weekends;
        $users=User::all();
        $deductions = deductions::all();
        return view('admin.employees.edit',compact('employee','users' , 'deductions'));
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

        /**
         * 
         * Employee Salary Details
         */
        $Management_commitment = 0.0;
        if(isset($request->penalities['values'])&& $request->penalities['values']!=null){
            $Management_commitment = 0.0;
        }else{
            $Management_commitment = $request->Management_commitment;
        }
        $salaryDetails = salaryDetails::where('employee_id' , $id)->first();
        if($salaryDetails==null){
            salaryDetails::create([
                'employee_id'=>$id,
                "base_salary"=>$request->salary,
                "seniority"=>$request->seniority,
                "certificate_allowance"=>$request->certificate_allowance,
                'Management_commitment'=>$Management_commitment
            ]);
        }else{
            $salaryDetails->base_salary = $request->salary;
            $salaryDetails->seniority = $request->seniority;
            $salaryDetails->certificate_allowance = $request->certificate_allowance;
            $salaryDetails->Management_commitment = $Management_commitment;
            $salaryDetails->save();
        }
       
        /**
         * 
         * 
         * End Employee Salary Details
         */

         if(isset($request->penalities['values']) && isset($request->penalities['reasons'])){
            Pentality::where('employee_id' , $employee->id)->delete();
         }

         if(!empty($request->penalities['values'])){
            foreach (array_combine($request->penalities['values'], $request->penalities['reasons']) as $value => $reason) {
                $EmployeePenality = new Pentality();
                $EmployeePenality->employee_id = $employee->id;
                $EmployeePenality->value = $value;
                $EmployeePenality->reason = $reason;
                $EmployeePenality->save();
            }
        }

        // if(isset($request->allowances['amount']) && isset($request->allowances['description'])){
            allowances::where('employee_id' , $employee->id)->delete();
        //  }
        Log::Info(['re'=>$request->allowances['amount']]);
        if(!empty($request->allowances['amount'])){
            foreach (array_combine($request->allowances['amount'], $request->allowances['description']) as $value => $reason) {
                $EmployeeAllowence = new allowances();
                $EmployeeAllowence->employee_id = $employee->id;
                $EmployeeAllowence->amount = $value;
                $EmployeeAllowence->description = $reason;
                $EmployeeAllowence->save();
            }
        }

        EmployeeDeduction::where('employee_id' , $id)->delete();
        if(!empty($request->deductions['type']) && !empty($request->deductions['value'])){
            foreach (array_combine($request->deductions['type'], $request->deductions['value']) as $type => $value) {
                $EmployeeDeduction = new EmployeeDeduction();
                $EmployeeDeduction->employee_id = $employee->id;
                $EmployeeDeduction->deduction_id = $type;
                $EmployeeDeduction->value = $value;
                $EmployeeDeduction->save();
            }
        }
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
        allowances::where('employee_id' , $id)->delete();
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


    public function salaryDeatils(){
        $id = Auth::guard('admin')->id();

        Log::Info(['Id'=>$id]);
        $empolyee = Employee::where('user_id' , $id)->with('user' ,'weekends', 'employeeSalary' , 'employeePlentiy')->first();
        Log::Info(['empolyee'=>$empolyee]);
        
        $employeeSchedule = EmployeeSchedule::where('employee_id' , $empolyee->id)->
        whereMonth('updated_at' , Carbon::now()->month)->get();

        
        $object = $this->chechInOut();
        $netSalay = $this->calculateSalary($empolyee);

        Session::put('object' , $object);
        return view('admin.employees.salaryDetails')->
        with(['employee'=>$empolyee , 'netSalary'=>$netSalay]);
    }


    public function calculateSalary(Employee $employee){
        $netSalay = $employee['salary'];
        if(isset($employee->employeeSalary)){
            $netSalay+=($employee['salary'] * $employee->employeeSalary['seniority']/100) 
                + ($employee['salary'] * $employee->employeeSalary['certificate_allowance']/100)
                + ($employee['salary'] * $employee->employeeSalary['Management_commitment']/100);
        }


        if(isset($employee->employeePlentiy)){
            foreach($employee->employeePlentiy as $penality){
                $netSalay-=$penality['value'];
            }
        }
        return $netSalay;
    }

    public function chechInOut(){
        
        $now = Carbon::now();
        $id = Auth::guard('admin')->id();
        $dilysHours = 0;
        $holidayDays = 0;
        $empolyee = Employee::where('user_id' , $id)->with('user' ,'weekends', 'employeeSalary' , 'employeePlentiy')->first();
        if(request()->date!=null){
            $dates = explode(' - ' , request()->date);
            $start_date = Carbon::parse($dates[0]);
            $end_date = Carbon::parse($dates[1]);
        }else{
            $start_date = Carbon::parse($empolyee->job_start);
            $end_date = Carbon::now();
        }
        if($start_date < $empolyee->job_start){
            $start_date = Carbon::parse($empolyee->job_start);
        }

        if($end_date > $now){
            $end_date = $now;
        }

        // $weekends = $empolyee->weekends->toArray();
        $weekends = array_column($empolyee->weekends->toArray() , 'weekend');

        $days = $start_date->diffInDaysFiltered(function (Carbon $date) use($weekends){
            return in_array($date , $weekends);
            // return !$date->isWeekday();
        }, $end_date);

           
        $month_days = Carbon::now()->month($start_date->month)->daysInMonth; 
        $expectedWorkingDates = $start_date->diffInDays($end_date);
    
        $deBonus = EmployeeSchedule::where('employee_id' , $empolyee->id)->
        whereRaw('start_shift >= ?' , $start_date)->
        whereNotNull('end_shift')->
        get();

        // Log::Info(['id'=>$id]);
        $holidayDays = $expectedWorkingDates - count($deBonus);

        foreach($deBonus as $deb){
            if(Carbon::parse($deb->start_shift)->diffInHours(
                Carbon::parse($deb->end_shift)
            )<8){
                $dilysHours+=(8 -
                Carbon::parse($deb->start_shift)->diffInHours(
                    Carbon::parse($deb->end_shift)));

            }
        }
  
        $object = collect();
        $object->Monthly_holidys = $days;
        $object->unexpected_holidy = $holidayDays;
        $object->daily_Housr = $dilysHours;
        $object->debouns = $holidayDays*($empolyee->salary / $month_days) 
                            +($dilysHours * ($empolyee->salary / ($month_days*8)));

            if(request()->date!=null){
                return redirect()->back()->with(['object'=>$object]);
            }else{
                return $object;
            }
    }

    public function import(Request $request){
        if ($request->hasFile('import')) {
            ob_end_clean();
            ob_start();
            Excel::import(new AddendenceImport, $request->file('import'));
        }
        session()->flash('success', __('Addencence imported successfully'));
        return redirect()->back();
    }
}

