<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Models\Government;
use App\Models\Region;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function index(int $id)
    {
        $government = Government::findOrFail($id);
        $regions = $government->regions()->paginate(12);
        return view('admin.regions.index', compact('government', 'regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return View
     */
    public function create(int $id): View
    {
        $government = Government::findOrFail($id);
        return view('admin.regions.create', compact('government'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function store(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|min:3',
        ]);
        Region::create([
            'name'              => $request['name'],
            'government_id'     => $id
        ]);

        session()->flash('success', __('Region created successfully'));

        return redirect()->route('admin.regions.index', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $region = Region::findOrFail($id);
        return view('admin.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $region = Region::findOrFail($id);
        $region->update([
            'name' => $request['name'],
        ]);

        session()->flash('success', __('Region updated successfully'));

        return redirect()->route('admin.regions.index', $region->government_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $region = Region::findOrFail($id);
        $government_id = $region->government_id;
        $region->delete();

        session()->flash('success', __('Region deleted successfully'));
        return redirect()->route('admin.regions.index', $government_id);
    }
}
