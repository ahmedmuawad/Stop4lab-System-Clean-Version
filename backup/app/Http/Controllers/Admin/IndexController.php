<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use App\Models\Group;
use App\Models\Visit;
use App\Models\Branch;
use App\Models\Culture;
use App\Models\Expense;
use App\Models\Patient;
use App\Models\Contract;
use App\Models\GroupTest;
use App\Models\PointSale;
use App\Models\Antibiotic;
use App\Models\UserBranch;
use App\Models\GroupCulture;
use App\Models\Branches_custody;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class IndexController extends Controller
{
    /**
     * admin dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //todays visits
        $today_visits=Visit::with('patient')
                            ->where('branch_id',session('branch_id'))
                            ->whereDate('visit_date',now())
                            ->get();

        //all branches
        $all_branches=Branch::all();

        $patient = Patient::with('contract')->whereHas('contract' , function($q){
            $q->where('id' , auth()->guard('admin')->user()->lab_id);
        });

        $group = Group::with('patient','contract','branch','created_by_user')
        ->where('branch_id',session('branch_id'))->whereHas('contract' , function($q){
            $q->where('id' , auth()->guard('admin')->user()->lab_id);
        });

        $activity = Activity::with('causer')->orderBy('id','desc')->limit(8)->get();
        
        $expenses = Expense::where('branch_id', session('branch_id'))
                            ->where( 'date', '>', Carbon::now()->subDays(7))
                            ->sum('amount');

        $custoday = Branches_custody::where('branche_id', session('branch_id'))
                                        ->where('custody_type','>',0)
                                        ->sum('custody') ;
        if($custoday == 0){
            $persentageOfCustoday = 0; 
        }else{
            $persentageOfCustoday = 100 - (get_custody_branch() / $custoday) * 100 ;
        }

        // $to = date('Y-m-d');//returns current day
        $from = Carbon::now()->firstOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth()->format('Y-m-d');
// dd($from);
        $paid = Group::where('branch_id', session('branch_id'))->whereBetween('created_at',[$from,$to])->sum('paid');
        // dd($paid);
        $due = Group::where('branch_id', session('branch_id'))->whereBetween('created_at',[$from,$to])->sum('due');

        $totalToday = Group::where('branch_id', session('branch_id'))->whereDate('created_at', Carbon::now())->sum('total');


        return view('admin.index',compact(
            'patient',
            'group',
            'today_visits',
            'activity',
            'expenses',
            'paid',
            'due',
            'totalToday',
            'persentageOfCustoday',
            'all_branches'
        ));
    }

    public function change_branch(Request $request,$id)
    {
        $branch=UserBranch::where([
            ['branch_id',$id],
            ['user_id',auth()->guard('admin')->user()->id]
        ])->first();

        if($branch)
        {
            session()->put('branch_id',$branch['branch_id']);
            session()->put('branch_name',$branch['branch']['name']);

            session()->flash('success',__('Branch changed successfully'));

            return redirect()->back();
        }
        else{
            session()->flash('failed',__('You aren\'t authorized to browse this branch'));

            return redirect()->back();
        }
    }

    // addPointSale
    public function addPointSale(Request $request)
    {
        $request->validate([
            'point_sale' => 'required|numeric',
        ]);

        // update point sale
        $point_sale = PointSale::whereDate('created_at', today())->first();

        if($point_sale)
        {
            $point_sale->update([
                'total_sale' => $point_sale->total_sale + $request->point_sale,
                'point_sale' => $request->point_sale,
            ]);
        }
        else
        {
            PointSale::create([
                'total_sale' => $request->point_sale,
                'point_sale' => $request->point_sale,
            ]);
        }

        session()->flash('success',__('Point sale added successfully'));
        return redirect()->back();
    }
}
