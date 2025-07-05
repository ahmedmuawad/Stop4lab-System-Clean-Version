<?php

namespace App\Imports;

use App\Models\Contract;
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
        $branch_id = session()->get('branch_id');

        if(isset($row[0]))
        {
            $test=Test::where('id',$row[0])->first();
            if(isset($test))
            {
                $status = ($row[3] == 'In' || $row[3] == null )?$status = 0:$status = 1;
                $test->update([
                    'lab_to_lab_status'=>$status,
                    'lab_to_lab_cost'=>$row[4],
                    // 'num_day_receive' => $row[],
                    // 'num_hour_receive' => $row[8],
                ]);

                if(setting('medical')['samePrice']){
                    $test->update([
                        'price'=>$row[6] ,
                        'lab_to_lab_status'=>$status,
                        'lab_to_lab_cost'=>$row[4]
                    ]);
                }
                    
                
                $test_price = TestPrice::firstOrCreate(['test_id' => $row[0] , 'branch_id' => $branch_id ]);
                $test_price->update([ 'price'=>$row[6] ]);
                // where('test_id' , $row[0])->where('branch_id' , $branch_id)->
                // update(['price'=>$row[5]]);

                // if($row[5]!= ''){
                //     $lab =  Labs_out::firstOrCreate(['name'=>$row[4]]);
                //     if($lab){
                //         $test->update(['lab_out_id' => $lab->id ]);
                //     }
                // }

                // if($row[9] != '' || $row[9] == null ){
                //     $test->update(['sample_type' => $row[9]] );
                // }
                // $i = 10;
                // dd($test->contract_prices->sortBy('contract_id'));

                // foreach($test->contract_prices->sortBy('contract_id') as $contract){
                //     $contract->update(['price' => $row[$i]]);
                //     $i++;
                // }
                
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
            '6'=>[
                'required',
                'numeric'
            ],
            // '3'=>[
            //     'required',
            //     'numeric'
            // ],
            // '2'=>[
            //     'required'
            // ],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            // '0' => __('Test id'),
            // '1' => __('Name'),
            // '2' => __('Lab to Lab Status'),
            // '3' => __('Lab to Lab Cost'),
            // '4' => __('Lab to Lab'),
            // '5' => __('Price'),
        ];
    }
}