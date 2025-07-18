<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if($this->doctor)
        {
            return [
                'name'=>[
                    'required',
                    Rule::unique('doctors')->ignore($this->doctor)->whereNull('deleted_at')
                ],
                'email'=>[
                    'nullable',                    
                    Rule::unique('doctors')->ignore($this->doctor)->whereNull('deleted_at')
                ],
                'phone'=>[
                    'nullable',
                    Rule::unique('doctors')->ignore($this->doctor)->whereNull('deleted_at')
                ],
                'address'=>'nullable',
                'commission'=>'required|numeric|min:0|max:100',
                'password'=>'nullable|min:6'
            ];
        }
        else{
            return [
                'name'=>[
                    'required',
                    Rule::unique('doctors')->whereNull('deleted_at')
                ],
                'email'=>[
                    'nullable',
                   
                    Rule::unique('doctors')->whereNull('deleted_at')
                ],
                'phone'=>[
                    'nullable',
                    Rule::unique('doctors')->whereNull('deleted_at')
                ],
                'address'=>'nullable',
                'commission'=>'required|numeric|min:0|max:100',
                'password'=>'required|min:6'
            ];
        }

       
    }
}
