<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\EmployeeSchedule;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use Maatwebsite\Excel\Concerns\ToCollection;

class AddendenceImport implements WithStartRow , WithValidation , ToCollection , WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    // public function model(array $row)
    // {
    //    Log::Info(['row'=>$row]);
    // }

    public function collection(Collection $rows)
    {
        // Log::Info(['rows'=>$rows]);
        $index = 0;
        foreach ($rows as $row) 
        {
            Log::Info(['name'=>$row]);
            // Log::Info(['name'=>$row['Department']]);
            Log::Info(['Index'=>$index++]);
        }
    }

    public function sheets(): array
    {
        return [
            new FirstSheetImport(),
            new SecondSheetImport(),
            new ThirdSheetImport(),
        ];
    }


    public function startRow(): int
    {
        return 5;
    }


    public function rules(): array
    {
        return [
          
        ];
    }


}
