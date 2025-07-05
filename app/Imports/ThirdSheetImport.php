<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\EmployeeSchedule;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
class ThirdSheetImport implements ToCollection , WithStartRow
{
    /**
    * @param Collection $collection
    */
    public $startDate;
    public $endDate;
    public $employee;
    public function collection(Collection $collection)
    {
        $index = 3;
        foreach($collection as $row){
            if($index%2!=0 && $index>=5){
                $name = $row[10];
                $user = User::where('name' , $name)->first();
                if($user==null){
                    $user = User::create([
                        'name'=>$name,
                        "email"=>$name.'@gmail.com',
                        "password"=>"123456",
                        "user_type"=>"normal",
                    ]);
                    $this->employee = Employee::create([
                        'user_id'=>$user->id,
                        "salary"=>12000,
                        "type"=>0,
                        "works_mins"=>480
                    ]);

                }else{
                    $this->employee = Employee::where('user_id' , $user->id)->first();
                }
            }
            if($index%2==0 && $index>5){
                $startDate = $this->startDate;
                foreach($row as $ele){
                    if($ele!=null){
                        $PresenceTime = substr($ele , 0 , 5);
                        $start_shift = $startDate . ' ' . $PresenceTime;
                        $end_shift = null;
                        if(strlen($ele)  > 5){
                            $departure  = substr($ele , 5 , 5);
                            $end_shift = $startDate . ' ' . $departure;
                        }else{
                            $start_shift = null;
                            $end_shift = null;
                        }
                        $work_mins = Carbon::parse($start_shift)->diffInMinutes(Carbon::parse($end_shift));
                        EmployeeSchedule::create([
                            'employee_id'=>$this->employee->id,
                            "work_mins"=>$work_mins,
                            "over_time"=>$work_mins - 8 > 0 ? $work_mins - 8*60 : 0,
                            "start_shift"=>$start_shift,
                            "end_shift"=>$end_shift
                        ]);
                        Carbon::parse($startDate)->copy()->addDay(1);
                    }else{
                        Log::Info(['This Employee My absent']);
                    }
                   
                }
            }

            if($index==3){
                $dates = $row[2];
                $dates = explode("~" , $dates);
                $this->startDate = $dates[0];
                $this->endDate = $dates[1];
            }
            $index++;
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
