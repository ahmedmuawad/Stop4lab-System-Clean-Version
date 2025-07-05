<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Response;

class PrescriptionController extends Controller
{
    // store
    public function store(Request $request)
    {

        $validation=Response::validation($request,[
            'prescription_name' => 'required',
        ]);

        if(!empty($validation))
        {
            return $validation;
        }


        if($request->hasFile('prescription_name'))
        {
            $prescription_name=$request->file('prescription_name');
            $rand = rand(1111,9999);
            $prescription_name->move('uploads/prescription/',$rand.'.png');
            $prescription_name = $rand.'.png';
        }
        
        $patient = auth()->user();

        $patient->prescriptions()->create([
            'prescription_name' => $prescription_name,
        ]);

        $data = [
            'prescription_name' => url('uploads/prescription/'.$prescription_name),
        ];

        return Response::response(200,'success',['prescription'=>$data]);

    } // end of store

    // get all prescriptions
    public function index(Request $request)
    {
        $patient = auth()->user();
        $prescriptions = $patient->prescriptions;
        $data = [];
        foreach ($prescriptions as $prescription) {
            $data[] = [
                'id' => $prescription->id,
                'prescription_name' => url('uploads/prescription/'.$prescription->prescription_name),
                'price' => $prescription->price,
            ];
        }
        return Response::response(200,'success',['prescriptions'=>$data]);
    } // end of get all prescriptions
}
