<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PatientRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Exports\PatientExport;
use App\Imports\PatientImport;
use App\Models\Patient;
use Str;
use DataTables;
use Excel;
use Mpdf\Tag\Dd;

class PatientsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_patient',     ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_patient',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_patient',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_patient',   ['only' => ['destroy','bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients=Patient::all();
        // dd($patients[0]);
        return view('admin.patients.index',compact('patients'));
    }

    /**
    * get patients datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        if(auth()->guard('admin')->user()->lab_id != null)
        {
            $model=Patient::with('contract')->whereHas('contract' , function($q){
                $q->where('id' , auth()->guard('admin')->user()->lab_id);
            });
            if ($request['filter_due'] != '') {
                $model->whereHas('groups',function ($p)use($request){
                    $p->where('due','>=',$request['filter_due']);
                });
            }
        } else
        {
            $model=Patient::with('contract','groups');
            if ($request['filter_due'] != '') {
                $model->whereHas('groups',function ($p)use($request){
                    $p->where('due','>=',$request['filter_due']);
                });
            }
        }
        return DataTables::eloquent($model)
        ->editColumn('total',function($patient){
            return formated_price($patient['total']);
        })
        ->editColumn('paid',function($patient){
            return formated_price($patient['paid']);
        })
        ->editColumn('due',function($patient){
            return view('admin.patients._due',compact('patient'));
        })
        ->addColumn('action',function($patient){
            return view('admin.patients._action',compact('patient'));
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {

        $attr = $request->except('token','age','age_unit','avatar' , 'fluid_patient' , 'diabetic' , 'liver_patient' , 'pregnant' , 'answer_other');
        // dd($request->all());
        $attr['fluid_patient'] = $request->fluid_patient == "0" ? 1 : 0;
        $attr['diabetic'] = $request->diabetic == "0" ? 1 : 0;
        $attr['liver_patient'] = $request->liver_patient == "0" ? 1 : 0;
        $attr['gland'] = $request->gland == "0" ? 1 : 0;
        $attr['tumors'] = $request->tumors == "0" ? 1 : 0;
        $attr['antibiotic'] = $request->antibiotic == "0" ? 1 : 0;
        $attr['iron'] = $request->iron == "0" ? 1 : 0;
        $attr['cortisone'] = $request->cortisone == "0" ? 1 : 0;
        $attr['date_pms'] = $request->gender != "male" ? $request->date_pms : null;
        // $attr['pregnant'] = $request->pregnant == "0" ? 1 : 0;
        $attr['answer_other'] = $request->answer_other ? $request->answer_other : null;

        $patient=Patient::create($attr);

        $patient->update([
            'contract_id'=>(isset($request['contract_id']))?$request['contract_id']:null,
            'country_id'=>(isset($request['country_id']))?$request['country_id']:null,
        ]);

        patient_code($patient['id']);

        if($request->hasFile('avatar'))
        {
            $avatar=$request->file('avatar');
            $avatar->move('uploads/patient-avatar/',$patient['id'].'.png');
            $patient->update([
                'avatar'=>$patient['id'].'.png'
            ]);
        }

        //send patient code notification
        $patient=Patient::find($patient['id']);
        send_notification('patient_code',$patient);

        session()->flash('success','Patient created successfully');

        return redirect()->route('admin.patients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient=Patient::findOrFail($id);
        return view('admin.patients.edit',compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $id)
    {
        $patient=Patient::findOrFail($id);

        // dd($request->all());
        $attr = $request->except('_token','age','age_unit','avatar' , 'fluid_patient' , 'diabetic' , 'liver_patient' , 'pregnant' , 'answer_other');

        $attr['fluid_patient'] = $request->fluid_patient == 1 ? 1 : 0;
        $attr['diabetic'] = $request->diabetic == 1 ? 1 : 0;
        $attr['liver_patient'] = $request->liver_patient == 1 ? 1 : 0;
        $attr['gland'] = $request->gland == 1 ? 1 : 0;
        $attr['tumors'] = $request->tumors == 1 ? 1 : 0;
        $attr['antibiotic'] = $request->antibiotic == 1 ? 1 : 0;
        $attr['iron'] = $request->iron == 1 ? 1 : 0;
        $attr['cortisone'] = $request->cortisone == 1 ? 1 : 0;
        $attr['date_pms'] = $request->gender != "male" ? $request->date_pms : null;
        // $attr['pregnant'] = $request->pregnant == 1 ? 1 : 0;
        $attr['answer_other'] = $request->answer_other ? $request->answer_other : null;

        $patient->update($attr);



        $patient->update([
            'contract_id'=>(isset($request['contract_id']))?$request['contract_id']:null,
            'country_id'=>(isset($request['country_id']))?$request['country_id']:null,
        ]);

        if($request->hasFile('avatar'))
        {
            $avatar=$request->file('avatar');
            $avatar->move('uploads/patient-avatar/',$patient['id'].'.png');
            $patient->update([
                'avatar'=>$patient['id'].'.png'
            ]);
        }

        session()->flash('success','Patient data updated successfully');

        return redirect()->route('admin.patients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient=Patient::findOrFail($id);//get patient
        $patient->groups()->delete();//delete groups
        $patient->delete();//delete patient
        session()->flash('success',__('Patient deleted successfully'));
        return redirect()->route('admin.patients.index');
    }

    /**
     * Bulk delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(BulkActionRequest $request)
    {
        foreach($request['ids'] as $id)
        {
            $patient=Patient::find($id);
            $patient->groups()->delete();
            $patient->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.patients.index');
    }

    /**
    * Export patients
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new PatientExport, 'patients.xlsx');
    }

    /**
    * Import patients
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function import(ExcelImportRequest $request)
    {
        if($request->hasFile('import'))
        {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new PatientImport, $request->file('import'));
        }

        session()->flash('success',__('Patients imported successfully'));

        return redirect()->back();
    }

    /**
    * Download patients template
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function download_template()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return response()->download(storage_path('app/public/patients_template.xlsx'),'patients_template.xlsx');
    }
}
