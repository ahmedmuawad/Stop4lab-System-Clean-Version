<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Test;
use App\Models\Culture;
use App\Models\Package;
use App\Models\Ray;
use App\Models\Offers;
use App\Models\OfferCuluture;
use App\Models\OfferPackage;
use App\Models\OfferTest;
use App\Models\OfferRays;
use Illuminate\Http\Request;
use  App\Http\Requests\Admin\OfferRequest;
use App\Http\Controllers\Controller;
class CurrentOffersController extends Controller
{
    public function index(){
        return view('admin.CurrentOffers.index');
    }

    public function ajax(Request $request){
        $model=Offers::query();
        return DataTables::eloquent($model)
        ->addColumn('action',function($offer){
            return view('admin.CurrentOffers._action',compact('offer'));
        })
        
        ->addColumn('name', function (Offers $offer) {
            return $offer->name;
        })

        ->addColumn('shortcut', function (Offers $offer) {
            return $offer->shortcut;
        })

        ->addColumn('Tests', function (Offers $offer) {
            return view('admin.CurrentOffers._tests', compact('offer'));
        })

        ->addColumn('cost_after', function (Offers $offer) {
            return $offer->cost_afetr;
        })

        
        ->addColumn('cost_before', function (Offers $offer) {
            return $offer->cost_before;
        })

        ->addColumn('status', function (Offers $offer) {
            return $offer->status;
        })

        ->addColumn('bulk_checkbox',function($item){
            return view('partials._bulk_checkbox',compact('item'));
        })
        ->toJson();
    }
    public function create(){
        return view('admin.CurrentOffers.create');
    }


    public function calculateCost($request){
        $cost =  0.0;
        if($request->has('cultures')){
            foreach($request->cultures as $culuture){
                $cost+=Culture::select('price')->where('id' , $culuture)->first()['price'];

            }
        }
        if($request->has('packagies')){
            foreach($request->packagies as $package){
                $cost+=Package::select('price')->where('id' , $package)->first()['price'];

            }
        }

        if($request->has('tests')){
            foreach($request->tests as $test){
                $cost+=Test::select('price')->where('id' , $test)->first()['price'];
            }
        }

        if($request->has('rays')){
            foreach($request->rays as $ray){
                $cost+=Ray::select('price')->where('id' , $ray)->first()['price'];
                
            }
        }

        return $cost;
    } 

    public function store(OfferRequest $request){
        // Log::Info(['status'=>$request->status]);
        $offer = Offers::create([
            'name'=>$request->name,
            "shortcut"=>$request->shortcut,
            "cost_afetr"=>$request->cost_afetr,
            "cost_before"=>$this->calculateCost($request),
            'status'=>$request->status=='on'?'active':'notActive',
        ]);

        if($offer){
            if($request->has('cultures')){
                foreach($request->cultures as $culuture){
                    OfferCuluture::create([
                        'offer_id'=>$offer->id,
                        'culture_id'=>$culuture,
                    ]);
                }
            }

            if($request->has('packagies')){
                foreach($request->packagies as $package){
                    OfferPackage::create([
                        'offer_id'=>$offer->id,
                        'package_id'=>$package,
                    ]);
                }
            }
            if($request->has('tests')){
                foreach($request->tests as $test){
                    OfferTest::create([
                        'offer_id'=>$offer->id,
                        'test_id'=>$test,
                    ]);
                }
            }

            if($request->has('rays')){
                foreach($request->rays as $ray){
                    OfferRays::create([
                        'offer_id'=>$offer->id,
                        'rays_id'=>$ray,
                    ]);
                }
            }
            session()->flash('success',__('Offer added successfully'));
            return redirect()->route('admin.current_offers.index');
        }else{
            session()->flash('eror',__('Missing Data'));
            return redirect()->route('admin.current_offers.index');
        }
    }

    public function edit($id){
        $offer = Offers::where('id',$id)->with('tests' ,'packages' , 'culturies')->first();
        return view('admin.CurrentOffers.edit')->with(['offer'=>$offer]);
    }

    public function update(OfferRequest $request , $id){
        $offer = Offers::where('id',$id)->first();

        if($offer){
            Offers::where('id', $id)->update([
                'name'=>$request->name,
                "shortcut"=>$request->shortcut,
                "cost_afetr"=>$request->cost_afetr,
                "cost_before"=>$this->calculateCost($request),
                'status'=>$request->status=='on'?'active':'notActive',
            ]);

            OfferCuluture::where('offer_id', $id)->delete();
            if($request->has('cultures')){
                foreach($request->cultures as $culuture){
                    OfferCuluture::create([
                        'offer_id'=>$id,
                        'culture_id'=>$culuture,
                    ]);
                }
            }
            OfferPackage::where('offer_id', $id)->delete();

            if($request->has('packagies')){
                foreach($request->packagies as $package){
                    OfferPackage::create([
                        'offer_id'=>$id,
                        'package_id'=>$package,
                    ]);
                }
            }
            OfferTest::where('offer_id', $id)->delete();
            if($request->has('tests')){
                foreach($request->tests as $test){
                    OfferTest::create([
                        'offer_id'=>$id,
                        'test_id'=>$test,
                    ]);
                }
            }
            OfferRays::where('offer_id' , $id)->delete();

            if($request->has('rays')){
                foreach($request->rays as $ray){
                    OfferRays::create([
                        'offer_id'=>$offer->id,
                        'rays_id'=>$ray,
                    ]);
                }
            }
            session()->flash('success',__('Offer added successfully'));
            return redirect()->route('admin.current_offers.index');
        }else{
            session()->flash('eror',__('Missing Data'));
            return redirect()->route('admin.current_offers.index');
        }
    }

    public function destroy($id){
        Offers::where('id' , $id)->delete();
        OfferTest::where('offer_id' , $id)->delete();
        OfferPackage::where('offer_id' , $id)->delete();
        OfferCuluture::where('offer_id' , $id)->delete();
        OfferRays::where('offer_id' , $id)->delete();
        session()->flash('success',__('Offer Delete successfully'));
        return redirect()->route('admin.current_offers.index');
    }   
}
