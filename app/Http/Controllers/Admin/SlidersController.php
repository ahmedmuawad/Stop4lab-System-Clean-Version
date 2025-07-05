<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use DataTables;

class SlidersController extends Controller
{

    public function index()
    {
        $sliders = Slider::all();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function ajax(Request $request)
    {
        $model = Slider::query();

        return DataTables::eloquent($model)
            ->addColumn('action', function ($slider) {
                return view('admin.sliders._action', compact('slider'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->toJson();
    }

    // create
    public function create()
    {
        return view('admin.sliders.create');
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $sliders = Slider::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar->move('uploads/sliders-avatar/', $sliders['id'] . '.png');
            $sliders->update([
                'image' => $sliders['id'] . '.png'
            ]);
        }
        session()->flash('success', 'created successfully');

        return redirect()->route('admin.sliders.index');
    }

    // edit 
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    // update
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title_ar' => 'required',
            'title_en' => 'required',
            'avatar' => 'nullable|image',
        ]);

        $slider->update([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $rand = rand(1111, 9999);
            $avatar->move('uploads/sliders-avatar/', $rand . '.png');
            $slider->update([
                'image' => $rand . '.png'
            ]);
        }
        session()->flash('success', 'updated successfully');

        return redirect()->route('admin.sliders.index');
    }

    // destroy
    public function destroy(Slider $slider)
    {
        $slider->delete();
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.sliders.index');
    }

    // bulk_delete
    public function bulk_delete(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);
        $ids = $request->ids;
        foreach ($ids as $id) {
            $slider = Slider::find($id);
            $slider->delete();
        }
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.sliders.index');
    }
}
