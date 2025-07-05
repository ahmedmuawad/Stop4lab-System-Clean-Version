<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
class OfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $testsValidator = [];


        return [
            'name'=>'required',
            'shortcut'=>'required',
            'cost_afetr'=>'required',
            // "tests"=>$testsValidator,
        ];
    }

    public function attributies(){
        return [
            'tests'=>'Tests Or Cluturies Or Packagies Or Rays Are Rquired'
        ];
    }
}
