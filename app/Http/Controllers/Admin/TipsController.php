<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipsAndOffer;
use Illuminate\Http\Request;
use DataTables;
class TipsController extends Controller
{
    
    public function index()
    {
        $tips = TipsAndOffer::all();
        return view('admin.tips.index', compact('tips'));
    }

    public function ajax(Request $request)
    {
        $model = TipsAndOffer::query();                   

        return DataTables::eloquent($model)
        ->addColumn('action',function($tip){
            return view('admin.tips._action', compact('tip'));
        })
        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }

    // create
    public function create()
    {
        return view('admin.tips.create');
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'title_ar' => 'required',
            'title_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $tips = TipsAndOffer::create([
            'type' => $request->type,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
        ]);

        if($request->hasFile('avatar'))
        {
            $avatar=$request->file('avatar');
            $avatar->move('uploads/tips-avatar/',$tips['id'].'.png');
            $tips->update([
                'image'=>$tips['id'].'.png'
            ]);
        }
        session()->flash('success','created successfully');

        return redirect()->route('admin.tips.index');
    }

    // edit 
    public function edit(TipsAndOffer $tip)
    {
        return view('admin.tips.edit', compact('tip'));
    }

    // update
    public function update(Request $request, TipsAndOffer $tip)
    {
        $request->validate([
            'type' => 'required',
            'title_ar' => 'required',
            'title_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $tip->update([
            'type' => $request->type,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
        ]);

        if($request->hasFile('avatar'))
        {
            $avatar=$request->file('avatar');
            $rand = rand(1111,9999);
            $avatar->move('uploads/tips-avatar/',$rand.'.png');
            $tip->update([
                'image'=>$rand.'.png'
            ]);
        }
        session()->flash('success','updated successfully');

        return redirect()->route('admin.tips.index');
    }

    // destroy
    public function destroy(TipsAndOffer $tip)
    {
        $tip->delete();
        session()->flash('success','deleted successfully');
        return redirect()->route('admin.tips.index');
    }

    // bulk_delete
    public function bulk_delete(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);
        $ids = $request->ids;
        foreach ($ids as $id) {
            $tip = TipsAndOffer::find($id);
            $tip->delete();
        }
        session()->flash('success','deleted successfully');
        return redirect()->route('admin.tips.index');
    }
}
