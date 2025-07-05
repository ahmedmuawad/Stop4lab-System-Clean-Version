<?php

namespace App\Imports;

use App\Models\Contract;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContactTestsImport implements ToModel,WithStartRow,WithValidation
{

    public $id ;
    public function __construct($id)
    {
        $this->id = $id;

    }
    /**
     * @param array $row
     *
     * @return Test|null
     */
    public function model(array $row)
    {
        $contract = Contract::find($this->id);

        if (isset($row[0])) {
            $contract->tests()->where('priceable_type','App\Models\Test')
                            ->where('priceable_id',$row[0])
                            ->update(['price' => $row[5] ]);
        }
    }


    /**
     * @return int
     */
    public function startRow(): int
    {
        return 3;
    }


    public function rules(): array
    {
        return [
            '5'=>[
                'required',
                'numeric'
            ],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => __('Id'),
            '1' => __('Name'),
            '2' => __('Sample Type'),
            '3' => __('Time'),
            '4' => __('Precautions'),
            '5' => __('Price'),
        ];
    }

}
