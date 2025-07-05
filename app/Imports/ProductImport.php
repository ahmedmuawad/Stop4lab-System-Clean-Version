<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;



class ProductImport implements ToModel, WithStartRow, WithValidation
{



    public function __construct()
    {

    }
    /**
     * @param array $row
     *
     * @return Test|null
     */
    public function model(array $row)
    {

        if (isset($row[0])) {

            $product = Product::firstOrCreate([
                'name' => $row[0],
                'sku' => $row[1],
                'type' => $row[2],
            ]);

            //branch products
            if (isset($row[5])) {
                $branchId = Branch::where('name',$row[5])->first()->id;


                $product->branches()->firstOrCreate([
                    'branch_id' => $branchId,
                    'initial_quantity' => $row[3],
                    'alert_quantity' => 0
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
            '0' => [
                'required'
            ],
        ];
    }
}
