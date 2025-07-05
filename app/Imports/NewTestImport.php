<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Test;
use App\Models\Category;
use App\Models\Branch;
use App\Models\TestPrice;
use App\Models\ContractPrice;
use App\Models\Contract;
use App\Models\Labs_out;


class NewTestImport implements ToModel,WithStartRow,WithValidation,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Test|null
     */
    public function model(array $row)
    {
        
        

        if($row['lab_to_lab_status'] != "IN"){
            $lab = Labs_out::where('name',$row['lab'])->first();
            $test =  Test::where('name',$row['test_name'])->first();
            if($test){
                $test->update([
                    "shortcut" => $row['shortcut'] ,
                    "price" =>$row['price'] ,
                    "unit" =>$row['unit'] ,
                    "sample_type" =>$row['sample_type'] ,
                    "lab_to_lab_status" =>($row['lab_to_lab_status'] == "IN" ) ? 0 : 1  ,
                    "lab_to_lab_cost" =>$row['cost'] ,
                    "num_hour_receive" =>$row['num_hour_receive'] ,
                    "num_day_receive" =>$row['num_day_receive'] ,
                    "lab_out_id" => (isset($lab->id))?$lab->id:null
                ]);
            }

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
            // 'sub_category'=>'required',
            // 'test_name'=>'required',
            // 'component_name'=>'required',
        ];
    }

   
}
