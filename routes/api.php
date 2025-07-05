<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;


use Symfony\Component\Console\Output\Output;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//authorization
Route::post('register', 'Auth\ApiController@register')->name('register');
Route::post('login', 'Auth\ApiController@login')->name('login');
Route::post('lab_login', 'Auth\ApiController@lab_login_submit');
Route::post('forget_code', 'Auth\ApiController@forget_code');
Route::get('static-pages', 'Api\StaticPageController@index');
// route sliders
Route::get('sliders', 'Api\SliderController@index');
// route offers
Route::get('offers', 'Api\OfferController@index');
// route introduction
Route::get('introduction', 'Api\StaticPageController@intro');
// route tips
Route::get('tips', 'Api\TipController@index');
//patient dashboard
Route::group(['namespace' => 'Api', 'prefix' => 'patient', 'middleware' => 'auth:api'], function () {

    Route::get('dashboard', 'ProfileController@dashboard');
    Route::post('update_profile', 'ProfileController@update_profile');
    Route::get('group_tests', 'GroupTestsController@group_tests');
    Route::post('visit', 'VisitsController@store');
    Route::get('branches', 'BranchesController@index');
    Route::get('tests', 'TestsLibraryController@testsPatient');
    Route::get('cultures', 'TestsLibraryController@culturesPatient');
    Route::get('packages', 'TestsLibraryController@packagesPatient');
    // create prescription
    Route::post('create-prescription', 'PrescriptionController@store');
    // get all prescriptions
    Route::get('prescriptions', 'PrescriptionController@index');
    // create booking
    Route::post('create-booking', 'BookingController@store');
    // get all bookings
    Route::get('bookings', 'BookingController@index');
});

Route::group(['namespace' => 'Api', 'prefix' => 'lab', 'middleware' => 'auth:apilab'], function () {

    Route::get('branches', 'BranchesController@index');
    Route::get('tests', 'TestsLibraryController@testsLab');
    Route::get('cultures', 'TestsLibraryController@culturesLab');
    Route::get('packages', 'TestsLibraryController@packagesLab');
});

Route::group(['namespace' => 'Api', 'prefix' => 'patient', 'middleware' => 'auth:api'], function () {
    // active notify
    Route::get('/active-notify', 'NotificationAPIController@activeNotify');
    // get all notification of user
    Route::get('/get-all-notification-of-user', 'NotificationAPIController@getAllNotificationOfUser');
    // delete notification of user
    Route::get('/delete-notification-of-user/{id}', 'NotificationAPIController@deleteNotificationOfUser');
    // delete all notification of user
    Route::get('/delete-all-notification-of-user', 'NotificationAPIController@deleteAllNotificationOfUser');
});

Route::group(['namespace' => 'Api', 'prefix' => 'lab', 'middleware' => 'auth:apilab'], function () {
    // active notify
    Route::get('/active-notify', 'NotificationAPIController@activeNotify');
    // get all notification of user
    Route::get('/get-all-notification-of-user', 'NotificationAPIController@getAllNotificationOfUser');
    // delete notification of user
    Route::get('/delete-notification-of-user/{id}', 'NotificationAPIController@deleteNotificationOfUser');
    // delete all notification of user
    Route::get('/delete-all-notification-of-user', 'NotificationAPIController@deleteAllNotificationOfUser');
});

// Route::get('/invoices','Api\ReportController@invoices');
Route::group(['namespace' => 'Api', 'prefix' => 'lab', 'middleware' => 'auth:apilab'], function () {
    Route::get('invoices', 'ReportController@invoices');
    Route::post('accounting', 'ReportController@accounting');
    Route::get('get_group/{id}', 'ReportController@get_group');
});


// group 
Route::group(['namespace' => 'Auth', 'middleware' => 'auth:api'], function () {
    // create password
    Route::post('create-password', 'ApiController@create_password');
    // secondLogin
    Route::post('secondLogin', 'ApiController@secondLogin');
});

//get countries
Route::get('get_countries', 'Api\HomeController@get_countries');
Route::get('sync_offline', 'Api\SyncOffline@index');

// Route::get('chcking-Invoice-Portal' , '');

Route::post('/get_token', 'Admin\Portal\InvoiceController@apiLogin');

Route::post('/check_portal' , 'Admin\Portal\InvoiceController@chckingPortalInvoice');

// function (Request $request) {
    // return $request;
    // if (!$request->has('email') || !$request->has('password')) {
    //     $output['success'] = false;
    //     $output['message'] = "Missing Inputs";
    //     return $output;
    // } else {
    //     $hashedPassword = Hash::make($request->password);
    //     $user = User::where('email', $request->email)->where('password', $hashedPassword)->first();
    //     if (!$user) {
    //         $output['success'] = false;
    //         $output['message'] = "User Not Found";
    //         return $output;
    //     } else {
    //         $token = base64_encode($user);
    //         $output['success'] = true;
    //         $output['message'] = "Data Readed Succefully";
    //         $output['token'] = $token;
    //         return $output;
    //     }
    // }