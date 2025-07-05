<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware'=>['Install','Locale']],function(){
  include('admin.php');
  include('ajax.php');
  include('patient.php');
});

Route::get('change_locale/{lang}','HomeController@change_locale')->name('change_locale');


Route::get('clear-cache',function(){
  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('view:clear');
  Artisan::call('route:clear');


  session()->flash('success', __('Clear Cache Successfully'));

  return redirect()->back();


});

Route::get('sample_id','Solve@convertSampleTypeToSampleId');
Route::get('kits','Solve@Kits');
Route::get('noty','Solve@sendNoty');
Route::get('report','Solve@report');
Route::get('rays','Solve@rays');
Route::get('barcode','Solve@barcode');
Route::get('convert_patient','Solve@patient');
Route::get('unic_doctors','Solve@unic_doctors');
Route::get('calcDue','Solve@calcDue');

