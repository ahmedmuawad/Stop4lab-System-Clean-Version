<?php

namespace App\Imports;

use App\Models\Culture;
use App\Models\Contract;
use App\Models\CulturePrice;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
class CulturePriceImport implements ToModel,WithStartRow,WithValidation
{
    /**
     * @param array $row
     *
     * @return Patient|null
     */
    public function model(array $row)
    {
        $branch_id = session()->get('branch_id');
        if(isset($row[0]))
        {
            $test=CulturePrice::where('culture_id',$row[0])
            ->where('branch_id' , $branch_id)
            ->first();
            Log::Info($test);
            // Contract::all();
            if(isset($test))
            {
                Log::Info(['price'=>$row[2]]);
                // $status = ($row[4] == 'In' || $row[4] == null )?$status = 0:$status = 1;
                $test->update([
                    'price'=>$row[2],
                ]);

                CulturePrice::where('culture_id' , $row[0])->where('branch_id' , $branch_id)->update([
                    'price'=>$row[2]
                ]);

                
            }
        }
    }


    /**
     * @return int
     */
    public function startRow(): int
    {
        return 4;
    }


    public function rules(): array
    {
        return [

        ];
    }

    public function customValidationAttributes()
    {
        return [

        ];
    }
}