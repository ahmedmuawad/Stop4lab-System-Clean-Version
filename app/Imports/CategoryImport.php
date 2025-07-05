<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToModel, WithStartRow, WithValidation
{


    public function model(array $row)
    {

        if (isset($row[0])) {

            $category = Category::firstOrCreate([
                'name' => $row[1],
            ]);

            if(isset($row[2]) && $row[2] != null ){
                $parent = Category::firstOrCreate([
                    'name' => $row[2],
                ]);
                $category->update(['parent_id' => $parent->id , 'type'=>1 ]);
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

