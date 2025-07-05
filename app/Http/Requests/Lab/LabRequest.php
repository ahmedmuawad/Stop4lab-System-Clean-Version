<?php

namespace App\Http\Requests\Lab;

use Illuminate\Foundation\Http\FormRequest;

class LabRequest extends FormRequest
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
            'name' => 'required',
            // 'password' => 'required',
            'email' => 'required|unique:users,email,'.request()->item,
            // 'lab_id' => 'required|unique:users,lab_id,'.request()->item,
            'lab_id' => 'required',
        ];
    }
}
