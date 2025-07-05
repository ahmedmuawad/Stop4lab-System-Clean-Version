<?php

namespace App\Imports;

use App\Models\Labs_out;
use App\Models\SampleType;
use App\Models\Test;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\TestPrice;

class SampleTypeImport implements  ToModel,WithStartRow,WithValidation
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
            $main =  SampleType::where('name',$row[2])->first();

            if($main){
                SampleType::create(['name' => $row[1] , 'parent_id' => $main->id ]);
            }else{
                $newMain =  SampleType::create(['name' => $row[2] , 'parent_id' => 0]);
                SampleType::create(['name' => $row[1] , 'parent_id' => $newMain->id ]);
            }

            
            // $sample = SampleType::find($row[0]);
            // if($sample){
            //     $main = SampleType::where('name',$row[2])->first();
            //     if($main){
            //         $sample->update(['parent_id' => $main->id ]);

            //     }else{
            //         $newMain = SampleType::create(['name' => $row[2]]);
            //         $sample->update(['parent_id' => $newMain->id ]);
            //         // $sample->save();
            //     }
            // }

            // $sample->parent_id =  (SampleType::where('name',$row[2])->first())? SampleType::where('name',$row[2])->first()->id : SampleType::create(['name' => $row[2]])->id ;
           
            
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
            '0'=>[
                'required'
            ],
            '1'=>[
                'required'
            ],
            '2'=>[
                'required'
            ],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => __('Sample id'),
            '1' => __('Sub Name'),
            '2' => __('Main Name'),
        ];
    }
}
