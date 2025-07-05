<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\LabRequest;
use App\Models\Contract;
use App\Models\Government;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class LabController extends Controller
{
     /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_contract',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_contract',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_contract',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_contract',   ['only' => ['destroy','bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.labs.index');
    }

    /**
    * get antibiotics datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=User::where('type' , 'lab')->newQuery();

        return DataTables::eloquent($model)
        ->addColumn('action',function($lab){
            return view('admin.labs._action',compact('lab'));
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lab = User::findOrFail($id);
        
        $contracts = Contract::all();
        $governments = Government::select('id', 'name')->get();

        return view('admin.labs.edit',compact('lab' , 'contracts', 'governments'));
    }

    public function create()
    {
        // $lab = User::findOrFail($id);
        
        $contracts = Contract::all();
        $governments = Government::select('id', 'name')->get();

        return view('admin.labs.add',compact('governments','contracts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LabRequest $request, $id)
    {
       $lab=User::findOrFail($id);
       $lab->update([
           'name'               => $request['name'],
           'email'              => $request['email'],
           'password'           => bcrypt($request->password),
           'lab_id'             => $request['lab_id'],
           'government_id'      => $request['government_id'],
           'region_id'          => $request['region_id'],
        //    'lab_code'           => $request['lab_code']
       ]);


       $lab->roles()->create([
           'role_id' => 5
       ]);

       session()->flash('success',__('Lab updated successfully'));

       return redirect()->route('admin.labs.index');
    }

    public function store(LabRequest $request)
    {
        $lab = User::create([
            'name'               => $request['name'],
            'email'              => $request['email'],
            'password'           => bcrypt($request->password),
            'lab_id'             => $request['lab_id'],
            'government_id'      => $request['government_id'],
            'region_id'          => $request['region_id'],
            'type'               => 'lab',
            // 'lab_code'           => $request['lab_code']
        ]);

        $code = User::where('type','lab')->where('id','!=',$lab->id)->latest()->first();
        if($code == null){
            $lab->update(['lab_code' => 1001]);
        }else{
            $lab->update(['lab_code' => $code->lab_code+1 ]);
        }
        

    //    $lab= new User();
    //    $lab->create([
    //        'name'               => $request['name'],
    //        'email'              => $request['email'],
    //        'lab_id'             => $request['lab_id'],
    //        'government_id'      => $request['government_id'],
    //        'region_id'          => $request['region_id'],
    //        'type'               => 'lab',
    //        'lab_code'           => $request['lab_code']
    //    ]);

       $lab->roles()->create([
           'role_id' => 5
       ]);

       $lab->branches()->create([
        'branch_id' => session('branch_id')
        ]);

       session()->flash('success',__('Lab created successfully'));

       return redirect()->route('admin.labs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lab = User::findOrFail($id);
        $lab->delete();

        session()->flash('success',__('Lab deleted successfully'));

        return redirect()->route('admin.labs.index');
    }


}
