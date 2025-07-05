<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Models\Government;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GovernmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $governments = Government::paginate(12);
        return view('admin.governments.index', compact('governments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.governments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|min:3']);
        Government::create([
            'name' => $request['name'],
        ]);

        session()->flash('success', __('Government created successfully'));

        return redirect()->route('admin.governments.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id): View
    {
        $government = Government::findOrFail($id);

        return view('admin.governments.edit', compact('government'));
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
        $government = Government::findOrFail($id);
        $government->update([
            'name' => $request['name'],
        ]);

        session()->flash('success', __('Government updated successfully'));

        return redirect()->route('admin.governments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $government = Government::findOrFail($id);
        $government->delete();

        session()->flash('success', __('Government deleted successfully'));

        return redirect()->route('admin.governments.index');
    }
}
