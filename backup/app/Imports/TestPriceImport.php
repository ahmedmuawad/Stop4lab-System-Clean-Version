<?php

namespace App\Imports;

use App\Models\Labs_out;
use App\Models\Test;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\TestPrice;

class TestPriceImport implements ToModel,WithStartRow,WithValidation
{
    /**
     * @param array $row
     *
     * @return Patient|null
     */
    public function model(array $row)
    {
        if(isset($row[0]))
        {
            $test=Test::where('id',$row[0])->first();
           

            if(isset($test))
            {
                $status = ($row[2] == 'In')?$status = 0:$status = 1;
                $test->update([
                    'lab_to_lab_status'=>$status,
                    'lab_to_lab_cost'=>$row[3],
                    'price'=>$row[5]
                ]);
                if($row[4] != ''){
                    $lab =  Labs_out::where('name',$row[4])->first();
                    if($lab){
                        // $lab_id = $lab->id;
                        $test->update(['lab_out_id' => $lab->id ]);
                    }
                }
                // $lab =  Labs_out::where('name',$row[4])->first()->id;                

            }
            // dd($row[2]);
        }
    }


    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }


    public function rules(): array
    {
        return [
            '5'=>[
                'required',
                'numeric'
            ],
            '3'=>[
                'required',
                'numeric'
            ],
            '2'=>[
                'required'
            ],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => __('Test id'),
            '1' => __('Name'),
            '2' => __('Lab to Lab Status'),
            '3' => __('Lab to Lab Cost'),
            '4' => __('Lab to Lab'),
            '5' => __('Price'),
        ];
    }
}