<?php

namespace App\Imports;

use App\Models\Contract;
use App\Models\TestPrice;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContractPricesImport implements ToModel,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Patient|null
     */

    public function model(array $row)
    {
        // dd($row);

        // $contract = Contract::where('title',$row);
       
        // $contract->tests()->create([
        //     'priceable_type' => 'App\Models\Test',
        //     'priceable_id' => $row['test_id'],
        //     'price' => $row['lab_to_lab']
        // ]);

            
    }


}
