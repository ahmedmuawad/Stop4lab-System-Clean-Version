<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FixedAsset;
use Illuminate\Http\Request;
use DataTables;
class FixedAssetController extends Controller
{
    
    public function index()
    {
        $fixed_assets = FixedAsset::all();
        return view('admin.fixed_assets.index', compact('fixed_assets'));
    }

    public function ajax(Request $request)
    {
        $model = FixedAsset::query()->with('branche','supplier');

        return DataTables::eloquent($model)
            ->addColumn('action', function ($fixed_asset) {
                return view('admin.fixed_assets._action', compact('fixed_asset'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->toJson();
    }

    // create
    public function create()
    {
        return view('admin.fixed_assets.create');
    }

    // store
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'title_en' => 'required',
        //     'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        $fixed_assets = FixedAsset::create([
            'name' => $request->name,
            'price' => $request->price,
            'branche_id' => $request->branche_id,
            'supplier_id' => $request->supplier_id,
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar->move('uploads/fixed_assets-avatar/', $fixed_assets['id'] . '.png');
            $fixed_assets->update([
                'image' => $fixed_assets['id'] . '.png'
            ]);
        }
        session()->flash('success', 'created successfully');

        return redirect()->route('admin.fixed_assets.index');
    }

    // edit 
    public function edit(FixedAsset $fixed_asset)
    {
        return view('admin.fixed_assets.edit', compact('fixed_asset'));
    }

    // update
    public function update(Request $request, FixedAsset $fixed_asset)
    {
        // $request->validate([
        //     'title_ar' => 'required',
        //     'title_en' => 'required',
        //     'avatar' => 'nullable|image',
        // ]);

        $fixed_asset->update([
            'name' => $request->name,
            'price' => $request->price,
            'branche_id' => $request->branche_id,
            'supplier_id' => $request->supplier_id,
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $rand = rand(1111, 9999);
            $avatar->move('uploads/fixed_assets-avatar/', $rand . '.png');
            $fixed_asset->update([
                'image' => $rand . '.png'
            ]);
        }
        session()->flash('success', 'updated successfully');

        return redirect()->route('admin.fixed_assets.index');
    }

    // destroy
    public function destroy(FixedAsset $fixed_asset)
    {
        $fixed_asset->delete();
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.fixed_assets.index');
    }

    // bulk_delete
    public function bulk_delete(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);
        $ids = $request->ids;
        foreach ($ids as $id) {
            $fixed_asset = FixedAsset::find($id);
            $fixed_asset->delete();
        }
        session()->flash('success', 'deleted successfully');
        return redirect()->route('admin.fixed_assets.index');
    }
}
