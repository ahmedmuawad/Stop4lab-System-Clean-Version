<?php

namespace App\Imports;

use App\Models\Ray;
use App\Models\Ray_category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RaysImport implements ToModel,WithStartRow,WithValidation
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
            $category = Ray_category::firstOrCreate([
                'name'=>$row[1]
            ]);
            str_replace($row[2],',','');
            Ray::create([
                'category_id' => $category->id,
                'name' => $row[0],
                'price' => $row[2],
                'num_day_receive' => 1,
            ]);
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
            '0' => __('name'),
            '2' => __('Price'),
        ];
    }
}
