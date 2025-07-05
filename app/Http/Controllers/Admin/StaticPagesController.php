<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPagesController extends Controller
{

    public function index()
    {

        $static_pages = StaticPage::all();

        return view('admin.static_pages.create' , compact('static_pages'));
    }

    // store
    public function store(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric',
            'time_work_text' => 'required',
            'whatsapp' => 'required|numeric',
            'facebook' => 'required',
            'instagram' => 'required',
            'messanger' => 'required',
            'youtube' => 'required',
            'twitter' => 'required',
            'about_us' => 'required',
            'our_vision' => 'required',
            'why_choose_us' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title_intro_1_ar' => 'required',
            'title_intro_1_en' => 'required',
            'title_intro_2_ar' => 'required',
            'title_intro_2_en' => 'required',
            'title_intro_3_ar' => 'required',
            'desc_intro_1_ar' => 'required',
            'desc_intro_1_en' => 'required',
            'desc_intro_2_ar' => 'required',
            'desc_intro_2_en' => 'required',
            'desc_intro_3_ar' => 'required',
            'desc_intro_3_en' => 'required',
            'image_intro_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_intro_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_intro_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($request->all());
        $attr = $request->except('image' , 'image_intro_1' ,'image_intro_2' ,'image_intro_2');

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $attr['image'] = $image->move('uploads/static-page-avatar/',rand(1111,9999).'.png');
        }
        if($request->hasFile('image_intro_1'))
        {
            $image_intro_1 = $request->file('image_intro_1');
            $attr['image_intro_1'] = $image_intro_1->move('uploads/static-page-avatar/',rand(1111,9999).'.png');
        }
        if($request->hasFile('image_intro_2'))
        {
            $image_intro_2 = $request->file('image_intro_2');
            $attr['image_intro_2'] = $image_intro_2->move('uploads/static-page-avatar/',rand(1111,9999).'.png');
        }
        if($request->hasFile('image_intro_3'))
        {
            $image_intro_3 = $request->file('image_intro_3');
            $attr['image_intro_3'] = $image_intro_3->move('uploads/static-page-avatar/',rand(1111,9999).'.png');
        }

        foreach ($attr as $key => $value) {
            StaticPage::where('key' , $key)->update(['value' => $value]);
        }

        session()->flash('success','updated successfully');

        return redirect()->back();
    }
}
