<?php

namespace App\Imports;

use App\Models\Ray;
use App\Models\Ray_category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RayPriceImport implements ToModel,WithStartRow,WithValidation
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
            $ray=Ray::with('category')->where('id',$row[0])->first();

            
            if(isset($ray))
            {
                $ray_categroy = Ray_category::firstOrCreate(['name' => $row[2] ]);

                $ray->update([
                    'price' =>  $row[3],
                    'category_id' =>  $ray_categroy->id
                ]);               
            }else{

            $ray_categroy = Ray_category::firstOrCreate(['name' => $row[2] ]);


            Ray::create(['name' => $row[1] ,'category_id' => $ray_categroy->id , 'price' => $row[3] ]);
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
