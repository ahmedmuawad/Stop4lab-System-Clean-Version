<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use DataTables;
class PrescriptionsController extends Controller
{

    public function index()
    {
        $prescriptions = Prescription::all();
        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    public function ajax(Request $request)
    {
        $model = Prescription::query();

        return DataTables::eloquent($model)
            ->addColumn('action', function ($prescription) {
                return view('admin.prescriptions._action', compact('prescription'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->toJson();
    }

    // create
    public function create()
    {
        return view('admin.prescriptions.create');
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required',
        ]);

        $prescriptions = Prescription::create([
            'price' => $request->price,
        ]);

        session()->flash('success', 'created successfully');

        return redirect()->route('admin.prescriptions.index');
    }

    // edit 
    public function edit(Prescription $prescription)
    {
        return view('admin.prescriptions.edit', compact('prescription'));
    }

    // update
    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'price' => 'required',
        ]);

        $prescription->update([
            'price' => $request->price,
        ]);

        session()->flash('success', 'updated successfully');

        return redirect()->route('admin.prescriptions.index');
    }

    // destroy
    public function destroy(prescription $prescription)
    {
        $prescription->delete();
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.prescriptions.index');
    }

    // bulk_delete
    public function bulk_delete(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);
        $ids = $request->ids;
        foreach ($ids as $id) {
            $prescription = Prescription::find($id);
            $prescription->delete();
        }
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.prescriptions.index');
    }

}
