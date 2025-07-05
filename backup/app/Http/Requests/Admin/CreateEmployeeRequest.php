<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
        return [
            'user_id'=>'required|unique:employees',
            'salary'=>'required|numeric',
            'type'=>'required',
            'job_start'=>'required|date',
            'age'=>'required|numeric',
            'weekends'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'user_id.unique'=>'this employee is exist',
        ];
    }
}
