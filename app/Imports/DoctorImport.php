<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Doctor;
use App\Models\User;

class DoctorImport implements ToModel,WithStartRow,WithValidation,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Doctor|null
     */
    public function model(array $row)
    {
        if(isset($row['id']))
        {
            $doctor=User::find($row['id']);

            if(isset($doctor))
            {
                $doctor->update([
                    'name'=>$row['name'],
                    'phone'=>$row['phone'],
                    'email'=>$row['email'],
                    'address'=>$row['address'],
                    'commission'=>$row['commission'],
                ]);
            }
            else{
                return User::create([
                    'code'=>time(),
                    'name'=>$row['name'],
                    'phone'=>$row['phone'],
                    'email'=>$row['email'],
                    'address'=>$row['address'],
                    'commission'=>$row['commission'],
                ]);
            }
        }
        else{
            return User::create([
                'code'=>time(),
                'name'=>$row['name'],
                'phone'=>$row['phone'],
                'email'=>$row['email'],
                'address'=>$row['address'],
                'commission'=>$row['commission'],
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


    public $id='';
    
    public function rules(): array
    {
        return [
            'id'=>function($attribute, $value, $onFailure) {
                $this->id=$value;
            },
            'name'=>[
                'required',
                function($attribute, $value, $onFailure) {
                    $doctor=User::where('name',$value)->where('id','!=',$this->id)->first();
                    if (isset($doctor)) {
                         $onFailure('Name has already been taken');
                    }
                }
            ],
            'phone'=>[
                'nullable',
                function($attribute, $value, $onFailure) {
                    $doctor=User::where('phone',$value)->where('id','!=',$this->id)->first();
                    if (isset($doctor)) {
                         $onFailure('Phone has already been taken');
                    }
                }
            ],
            'email'=>[
                'nullable',
                'email',
                function($attribute, $value, $onFailure) {
                    $doctor=User::where('email',$value)->where('id','!=',$this->id)->first();
                    if (isset($doctor)) {
                         $onFailure('Email has already been taken');
                    }
                }
            ],
            'address'=>[
                'nullable',
            ],
            'commission'=>[
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],
        ];
    }

   
}