<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Models\Employee;
use App\Models\UserShift;
use App\Http\Requests\Admin\shiftRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use PDF;
class ShiftController extends Controller
{
    public function index()
    {
        return view('admin.shifts.index');
    }

    public function ajax(Request $request)
    {
        // $model=Employee::query();
        $model = Shift::query();

        // Log::Info($model->get());

        return DataTables::eloquent($model)
            ->addColumn('action', function ($shift) {
                return view('admin.shifts._action', compact('shift'));
            })


            ->addColumn('name', function (Shift $shift) {
                return $shift->name;
            })

            ->addColumn('start_at', function (Shift $shift) {
                return Carbon::parse($shift->start_at)->format('h:m a');
            })

            ->addColumn('end_at', function (Shift $shift) {
                return Carbon::parse($shift->end_at)->format('h:m a');
            })


            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->toJson();
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        return view('admin.shifts.create')->with(['employees' => $employees]);
    }

    public function store(shiftRequest $request)
    {
        $shift = Shift::create([
            'name' => $request->name,
            'start_at' => $request->start_at,
            "end_at" => $request->end_at,
        ]);

        if ($shift) {
            foreach ($request->employees as $employee) {
                UserShift::create([
                    'user_id' => $employee,
                    'shift_id' => $shift->id,
                ]);
            }

            session()->flash('success', __('Shift created successfully'));
            return redirect()->route('admin.shifts.index');
        }
    }
    public function edit($id)
    {
        $shift = Shift::where('id', $id)->with('Usershift')->first();
        $employees = Employee::with('user')->get();
        return view('admin.shifts.edit')->with(['shift' => $shift, 'employees' => $employees]);
    }

    public function update(shiftRequest $request, $id)
    {
        $shift = Shift::where('id', $id)->firstOrFail();
        if ($shift) {
            $shift = Shift::where('id', $id)->update([
                'name' => $request->name,
                'start_at' => $request->start_at,
                "end_at" => $request->end_at,
            ]);

            UserShift::where('shift_id', $id)->delete();

            foreach ($request->employees as $employee) {
                UserShift::create([
                    'user_id' => $employee,
                    'shift_id' => $id,
                ]);
            }
            session()->flash('success', __('Shift Updated successfully'));
            return redirect()->route('admin.shifts.index');
        }
    }

    public function destroy($id){
        Shift::where('id', $id)->delete();
        UserShift::where('shift_id',$id)->delete();
        session()->flash('success', __('Shift Deleted successfully'));
        return redirect()->route('admin.shifts.index');
    }


    public function downloadpdf ($id){
        $type = 3;
        $reports_settings = setting('reports');
        $info_settings = setting('info');
        $shift = Shift::where('id',$id)->with('Usershift')->first();

        $pdf = PDF::loadView(
            "pdf.shiftPdf",
            compact(
                "shift",
                "type",
                "info_settings",
                "reports_settings"
            )
        );

        $pdf->save("uploads/pdf_/shift_".$id.".pdf");
        return   redirect(url("uploads/pdf_/shift_".$id.".pdf"));
    }
}
