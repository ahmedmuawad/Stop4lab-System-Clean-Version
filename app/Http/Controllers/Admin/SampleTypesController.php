<?php

namespace App\Http\Controllers\Admin;

use App\Models\SampleType;
use Illuminate\Http\Request;
use App\Exports\SampleTypeExport;
use App\Imports\SampleTypeImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExcelImportRequest;

class SampleTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sample=SampleType::where('parent_id',0)->get();

        return view('admin.sample_types.index',compact('sample'));
    }

     /**
    * get culture options datatable
    *
    * @access public
    * @var  @Request $request
    */
    public function ajax(Request $request)
    {
        $model=SampleType::where('parent_id',0);

        return DataTables::eloquent($model)
        ->addColumn('action',function($sample){
            return view('admin.sample_types._action',compact('sample'));
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
      return view('admin.sample_types.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $sample=SampleType::create([
          'name'=>$request['name'],
          'parent_id'=>0
      ]);

      //save new options
      if($request->has('sub'))
      {
        $sample->sub_samples()->createMany($request['sub']);
      }

      session()->flash('success',__('Sample created successfully'));

      return redirect()->route('admin.sample_types.index');
       
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
        $sample=SampleType::with('sub_samples')->where('id',$id)->where('parent_id',0)->firstOrFail();

        return view('admin.sample_types.edit',compact('sample'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sample=SampleType::where([
            ['id',$id],
            ['parent_id',0]
        ])->firstOrFail();
        
        $sample->update([
            'name'=>$request['name']
        ]);

        //old options
        $old_sample=[];
        
        if($request->has('old_sample'))
        {
            foreach($request['old_sample'] as $key => $value)
            {
                array_push($old_sample,$key);

                SampleType::where('id',$key)->update([
                    'name'=>$value
                ]);
            }
        }

        //delete old options not submited
        SampleType::where('parent_id',$id)->whereNotIn('id',$old_sample)->delete();

        //save new options
        if($request->has('sub'))
        {
            $sample->sub_samples()->createMany($request['sub']);

        }
        
        session()->flash('success',__('Sample Type updated successfully'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sample=SampleType::where('id',$id)->firstOrFail();
        
        $sample->sub_samples()->delete();
        $sample->delete();

        session()->flash('success',__('Sample Type deleted successfully'));

        return redirect()->route('admin.sample_types.index');

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
            $sample=SampleType::where('id',$id)->first();
            $sample->sub_samples()->delete();
            $sample->delete();
        }

        session()->flash('success',__('Bulk deleted successfully'));

        return redirect()->route('admin.sample_types.index');
    }

        /**
     * Export tests
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this
        return Excel::download(new SampleTypeExport, 'sample_types.xlsx');
    }

    /**
     * Import tests
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new SampleTypeImport, $request->file('import'));
        }

        session()->flash('success', __('Tests imported successfully'));

        return redirect()->back();
    }
}
