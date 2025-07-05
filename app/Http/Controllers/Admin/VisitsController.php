<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Government;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\VisitRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Group;
use App\Models\Test;
use App\Models\Culture;
use App\Models\Package;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\KnowsBy;
use Str;
use DataTables;

class VisitsController extends Controller
{
     /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_visit',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_visit',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_visit',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_visit',   ['only' => ['destroy','bulk_delete']]);
        $this->middleware('can:create_group',   ['only' => ['create_tests']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.visits.index');
    }

     /**
    * get visits datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=Visit::with('patient')
                    ->where('branch_id',session('branch_id'))
                    ->orderBy('id','desc');

        if($request['filter_read']!=null)
        {
            $model->where('read',$request['filter_read']);
        }

        if($request['filter_status']!=null)
        {
            $model->where('status',$request['filter_status']);
        }

        return DataTables::eloquent($model)

        ->editColumn('read',function($visit){
            return view('admin.visits._read',compact('visit'));
        })
        ->editColumn('status',function($visit){
            return view('admin.visits._status',compact('visit'));
        })
        ->addColumn('action',function($visit){
            return view('admin.visits._action',compact('visit'));
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
        return view('admin.visits.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->has('patient_id'))
        {
            $patient=Patient::find($request['patient_id']);
        }
        else{
            $patient=Patient::create([
             'code'=>time(),
             'name'=>$request['name'],
             'phone'=>$request['phone'],
             'dob'=>$request['dob'],
             'address'=>$request['address'],
             'gender'=>$request['gender'],
             'email'=>$request['email'],
             'api_token'=>Str::random(32)
            ]);
        }

        $visit=Visit::create([
            'patient_id'=>$patient['id'],
            'lat'=>$request['lat'],
            'lng'=>$request['lng'],
            'zoom_level'=>$request['zoom_level'],
            'visit_date'=>$request['visit_date'],
            'visit_address'=>$request['visit_address'],
            'branch_id'=>session('branch_id')
        ]);

        //tests
        if($request->has('tests'))
        {
            foreach($request['tests'] as $test)
            {
                $visit->visit_tests()->create([
                    'testable_id'=>$test,
                    'testable_type'=>'App\Models\Test'
                ]);
            }
        }
        if($request->has('rays'))
        {
            foreach($request['rays'] as $ray)
            {
                $visit->visit_rays()->create([
                    'testable_id'=>$ray,
                    'testable_type'=>'App\Models\Ray'
                ]);
            }
        }

        if($request->has('cultures'))
        {
            foreach($request['cultures'] as $culture)
            {
                $visit->visit_tests()->create([
                    'testable_id'=>$culture,
                    'testable_type'=>'App\Models\Culture'
                ]);
            }
        }

        if($request->has('packages'))
        {
            foreach($request['packages'] as $package)
            {
                $visit->visit_tests()->create([
                    'testable_id'=>$package,
                    'testable_type'=>'App\Models\Package'
                ]);
            }
        }

        if($request->has('attach'))
        {
            $attach=$request->file('attach');
            $name=time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/visits',$name);
            $visit->update(['attach'=>$name]);
        }

        session()->flash('success',__('Visit saved successfully'));

        return redirect()->route('admin.visits.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visit=Visit::where('branch_id',session('branch_id'))
                    ->findOrFail($id);

        $visit->update(['read'=>true]);

        return view('admin.visits.show',compact('visit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visit=Visit::where('branch_id',session('branch_id'))
                    ->findOrFail($id);

        $visit->update(['read'=>true]);

        return view('admin.visits.edit',compact('visit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VisitRequest $request, $id)
    {
        $visit=Visit::where('branch_id',session('branch_id'))
                    ->findOrFail($id);

        $visit->update($request->except('_token','_method','patient_type','tests','cultures','packages'));

        //tests
        $visit->visit_tests()->delete();
        if($request->has('tests'))
        {
            foreach($request['tests'] as $test)
            {
                $visit->visit_tests()->create([
                    'testable_id'=>$test,
                    'testable_type'=>'App\Models\Test'
                ]);
            }
        }

        //rays
        $visit->visit_rays()->delete();
        if($request->has('rays'))
        {
            foreach($request['rays'] as $ray)
            {
                $visit->visit_rays()->create([
                    'testable_id'=>$ray,
                    'testable_type'=>'App\Models\Ray'
                ]);
            }
        }

        if($request->has('cultures'))
        {
            foreach($request['cultures'] as $culture)
            {
                $visit->visit_tests()->create([
                    'testable_id'=>$culture,
                    'testable_type'=>'App\Models\Culture'
                ]);
            }
        }

        if($request->has('packages'))
        {
            foreach($request['packages'] as $package)
            {
                $visit->visit_tests()->create([
                    'testable_id'=>$package,
                    'testable_type'=>'App\Models\Package'
                ]);
            }
        }

        if($request->has('attach'))
        {
            $attach=$request->file('attach');
            $name=time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/visits',$name);
            $visit=Visit::find($id);
            $visit->update(['attach'=>$name]);
        }

        session()->flash('success',__('Visit updated successfully'));

        return redirect()->route('admin.visits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visit=Visit::where('branch_id',session('branch_id'))
                    ->findOrFail($id);

        $visit->visit_tests()->delete();
        $visit->delete();

        session()->flash('success',__('Visit deleted successfully'));

        return redirect()->route('admin.visits.index');

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
            $visit=Visit::where('branch_id',session('branch_id'))->find($id);
            $visit->visit_tests()->delete();
            $visit->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.visits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function create_tests($visit_id)
    {
        $visit=Visit::with('tests.test','cultures.culture','packages.package')
                    ->where('branch_id',session('branch_id'))
                    ->findOrFail($visit_id);

        $visit->update([
            'read'=>true,
            'status'=>true,
        ]);

        $visitTests= $visit->tests;
        $visitCultures=$visit->cultures;
        $visitPackages=$visit->packages;
        $contracts=Contract::all();
        $governments = Government::select('id', 'name')->get();
        $knows = KnowsBy::all();


        return view('admin.groups.create',compact('visit','visitTests','visitCultures','visitPackages','contracts', 'governments','knows'));
    }

    public function getRegions(int $id): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data'      => Region::select('id', 'name')->where('government_id', $id)->get(),
            'rep'      => User::where('government_id', $id)->where('user_type', 'representative')->get(),
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public function getUsers(Request $request): \Illuminate\Http\JsonResponse
    {

        return response()->json([
            'data'      => User::where('government_id', $request->government_id)
                ->where('user_type', '!=', 'representative')
                ->where('region_id', $request->region_id)
                ->select('id','name','email','lab_code')
                ->get(),

        ], 200, ['Content-Type' => 'application/json;charset=UTF-8'],
            JSON_UNESCAPED_UNICODE);
    }

}
