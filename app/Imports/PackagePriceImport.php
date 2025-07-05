<?php

namespace App\Imports;

use App\Models\Package;
use App\Models\Contract;
use App\Models\PackagePrice;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PackagePriceImport implements ToModel,WithStartRow,WithValidation
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
            $test=Package::where('id',$row[0])->first();
    
            if(isset($test))
            {
                $test->update([
                    'price'=>$row[2],
                ]);

                PackagePrice::where('package_id' , $row[0])->where('branch_id' , $branch_id)->update([
                    'price'=>$row[2]
                ]);

                // $i = 10;

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
        return 5;
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