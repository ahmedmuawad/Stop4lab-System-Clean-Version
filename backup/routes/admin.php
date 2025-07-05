<?php

//login admin

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
// use PDF;
Route::group(['namespace'=>'Auth','prefix'=>'admin/auth','middleware'=>'AdminGuest','as'=>'admin.auth.'],function(){
    Route::get('/login','AdminController@login')->name('login');
    Route::get('/lab_login','AdminController@lab_login')->name('lab_login');
    Route::post('/lab_login','AdminController@lab_login_submit')->name('lab_login_submit');
    Route::get('/register','AdminController@register')->name('register');
    Route::get('government/{id}/get-regions','AdminController@getRegion')->name('get-regions');
    Route::post('/register_submit','AdminController@register_submit')->name('register_submit');
    Route::post('/login','AdminController@login_submit')->name('login_submit');
});
//logout admin
Route::post('admin/logout','Auth\AdminController@logout')->name('admin.logout')->middleware('Admin');

//reset admin users password
Route::group(['namespace'=>'Auth','prefix'=>'admin/reset','as'=>'admin.reset.'],function(){
    Route::get('/mail','AdminController@mail')->name('mail');
    Route::post('/mail_submit','AdminController@mail_submit')->name('mail_submit');
    Route::get('/reset_password_form/{token}','AdminController@reset_password_form')->name('reset_password_form');
    Route::post('/reset_password_submit','AdminController@reset_password_submit')->name('reset_password_submit');
});

//admin controls
Route::group(['prefix'=>'admin','as'=>'admin.','namespace'=>'Admin','middleware'=>['Admin','Branch']],function(){
    //dashboard
    Route::get('/','IndexController@index')->name('index');

    //change branch
    Route::get('change_branch/{lang}','IndexController@change_branch')->name('change_branch');

    //profile
    Route::group(['prefix'=>'profile','as'=>'profile.'],function(){
        Route::get('edit','ProfileController@edit')->name('edit');
        Route::get('/','ProfileController@index')->name('index');
        Route::post('update','ProfileController@update')->name('update');
    });

    //categories
    Route::resource('categories','CategoriesController');
    Route::post('categories/bulk/delete','CategoriesController@bulk_delete')->name('categories.bulk_delete');

    //tests and its components
    Route::resource('tests','TestsController');
    Route::get('get_tests','TestsController@ajax')->name('get_tests');//datatable
    Route::get('tests/consumptions/{id}','TestsController@consumptions')->name('tests.consumptions');//consumptions
    Route::post('tests/consumptions','TestsController@consumptions_submit')->name('tests.consumptions.submit');//consumptions
    Route::get('tests_export','TestsController@export')->name('tests.export');
    Route::get('tests_download_template','TestsController@download_template')->name('tests.download_template');
    Route::post('tests_import','TestsController@import')->name('tests.import');
    Route::post('tests/bulk/delete','TestsController@bulk_delete')->name('tests.bulk_delete');
    Route::get('get_component','TestsController@get_component')->name('get_component');

    //cultures
    Route::resource('cultures','CulturesController');
    Route::get('get_cultures','CulturesController@ajax')->name('get_cultures');//datatable
    Route::get('cultures_export','CulturesController@export')->name('cultures.export');
    Route::get('cultures_download_template','CulturesController@download_template')->name('cultures.download_template');
    Route::post('cultures_import','CulturesController@import')->name('cultures.import');
    Route::post('cultures/bulk/delete','CulturesController@bulk_delete')->name('cultures.bulk_delete');

    //packages
    Route::resource('packages','PackagesController');
    Route::post('packages/bulk/delete','PackagesController@bulk_delete')->name('packages.bulk_delete');

    //culture options
    Route::resource('culture_options','CultureOptionsController');
    Route::get('get_culture_options','CultureOptionsController@ajax')->name('culture_options.ajax');
    Route::post('culture_options/bulk/delete','CultureOptionsController@bulk_delete')->name('culture_options.bulk_delete');

    //antibiotics
    Route::resource('antibiotics','AntibioticsController');
    Route::get('get_antibiotics','AntibioticsController@ajax')->name('get_antibiotics');//datatable
    Route::get('antibiotics_export','AntibioticsController@export')->name('antibiotics.export');
    Route::get('antibiotics_download_template','AntibioticsController@download_template')->name('antibiotics.download_template');
    Route::post('antibiotics_import','AntibioticsController@import')->name('antibiotics.import');
    Route::post('antibiotics/bulk/delete','AntibioticsController@bulk_delete')->name('antibiotics.bulk_delete');

    //patients
    Route::resource('patients','PatientsController');
    Route::get('get_patients','PatientsController@ajax')->name('get_patients');
    Route::get('patients_export','PatientsController@export')->name('patients.export');
    Route::get('patients_download_template','PatientsController@download_template')->name('patients.download_template');
    Route::post('patients_import','PatientsController@import')->name('patients.import');
    Route::post('patients/bulk/delete','PatientsController@bulk_delete')->name('patients.bulk_delete');

    //groups
    Route::resource('groups','GroupsController');
    Route::resource('ray_groups','GroupsController');
    Route::post('groups/send_receipt_mail/{id}','GroupsController@send_receipt_mail')->name('groups.send_receipt_mail');
    Route::post('groups/delete_analysis/{id}','GroupsController@delete_analysis');
    Route::get('get_groups','GroupsController@ajax')->name('get_groups');
    Route::get('/calce','GroupsController@Calculator');
    Route::get('/cycle/{id}','GroupsController@cycle')->name('cycle');
    Route::post('groups/print_barcode/{group_id}','GroupsController@print_barcode')->name('groups.print_barcode');
    Route::get('groups/working_paper/{group_id}','GroupsController@working_paper')->name('groups.working_paper');
    Route::post('groups/bulk/delete','GroupsController@bulk_delete')->name('groups.bulk_delete');
    Route::post('groups/bulk/print_barcode','GroupsController@bulk_print_barcode')->name('groups.bulk_print_barcode');
    Route::post('groups/bulk/print_receipt','GroupsController@bulk_print_receipt')->name('groups.bulk_print_receipt');
    Route::post('groups/bulk/print_working_paper','GroupsController@bulk_print_working_paper')->name('groups.bulk_print_working_paper');
    Route::post('groups/bulk/send_receipt_mail','GroupsController@bulk_send_receipt_mail')->name('groups.bulk_send_receipt_mail');
    Route::post('group/check/test/{id}','GroupsController@checkTest')->name('group.check.test');

    Route::post('pay-delayed-money', 'GroupsController@payDelayedMoney')->name('group.pay_delayed_money');
    Route::post('retrieve/{id}', 'GroupsController@retrieve')->name('group.retrieve');
    Route::get('get_retrieved', 'GroupsController@getGroupsRetrieved');
    Route::get('retrieved', 'GroupsController@retrieved');

    //Medical reports
    Route::resource('medical_reports','MedicalReportsController');
    Route::post('medical_reports/upload_report/{id}','MedicalReportsController@upload_report')->name('medical_reports.upload_report');
    Route::post('medical_reports/pdf/{id}','MedicalReportsController@pdf')->name('medical_reports.pdf');
    Route::post('medical_reports/update_culture/{id}','MedicalReportsController@update_culture')->name('medical_reports.update_culture');//update cultures
    Route::post('medical_reports/update_ray/{id}','MedicalReportsController@update_ray')->name('medical_reports.update_ray');//update cultures
    Route::get('sign_medical_report/{id}','MedicalReportsController@sign')->name('medical_reports.sign');
    Route::get('review_medical_report/{id}','MedicalReportsController@review')->name('medical_reports.review');
    Route::get('sign_test/{id}','MedicalReportsController@signTest')->name('tests.sign');
    Route::get('review_test/{id}','MedicalReportsController@reviewTest')->name('tests.review');
    Route::get('medical_reports/print_report/{id}','MedicalReportsController@print_report')->name('medical_reports.print_report');
    Route::get('medical_reports/print_show_report/{id}','MedicalReportsController@print_show_report')->name('medical_reports.print_show_report');
    Route::get('medical_reports/print_report_2/{id}','MedicalReportsController@print_report_2')->name('medical_reports.print_report_2');
    Route::post('medical_reports/send_report_mail/{id}','MedicalReportsController@send_report_mail')->name('medical_reports.send_report_mail');
    Route::post('medical_reports/bulk/delete','MedicalReportsController@bulk_delete')->name('groups.bulk_delete');
    Route::post('medical_reports/bulk/print_barcode','MedicalReportsController@bulk_print_barcode')->name('groups.bulk_print_barcode');
    Route::post('medical_reports/bulk/sign_report','MedicalReportsController@bulk_sign_report')->name('groups.bulk_sign_report');
    Route::post('medical_reports/bulk/print_report','MedicalReportsController@bulk_print_report')->name('groups.bulk_print_report');
    Route::post('medical_reports/bulk/send_report_mail','MedicalReportsController@bulk_send_report_mail')->name('groups.bulk_send_report_mail');
    Route::get('medical_report/get-comment','MedicalReportsController@getComment')->name('medical_report.get-comment');
    Route::get('medical_report/add_comment','MedicalReportsController@addComment')->name('medical_report.add_comment');
    Route::get('medical_report/save/reference/range','MedicalReportsController@saveReferenceRange')->name('medical_report.save.reference.range');
    Route::get('medical_report/include/history/{id}','MedicalReportsController@includeHistory')->name('medical_report.include.history');



    //doctors
    Route::resource('doctors','DoctorsController');
    Route::get('get_doctors','DoctorsController@ajax')->name('get_doctors');
    Route::get('doctors_export','DoctorsController@export')->name('doctors.export');
    Route::get('doctors_download_template','DoctorsController@download_template')->name('doctors.download_template');
    Route::post('doctors_import','DoctorsController@import')->name('doctors.import');
    // Route::post('doctors/bulk/delete','DoctorsController@bulk_delete')->name('doctors.bulk_delete');

    // normal doctors
    Route::resource('normal_doctors','NormalDoctorsController');
    Route::get('get_normal_doctors','NormalDoctorsController@ajax')->name('get_normal_doctors');
    Route::post('get_normal_doctors/bulk/delete','NormalDoctorsController@bulk_delete')->name('normal_doctors.bulk_delete');


    //roles
    Route::resource('roles','RolesController');
    Route::get('get_roles','RolesController@ajax')->name('get_roles');
    Route::post('roles/bulk/delete','RolesController@bulk_delete')->name('roles.bulk_delete');

    //users
    Route::resource('users','UsersController');
    Route::get('get_users','UsersController@ajax')->name('get_users');
    Route::get('blocked_users','UsersController@getUsersBlocked')->name('blocked_users');
    Route::get('unblock_user/{id}','UsersController@userUnBlocked')->name('unblock_user');
    Route::post('users/bulk/delete','UsersController@bulk_delete')->name('users.bulk_delete');

    //tests price list
    Route::get('prices/tests','PricesController@tests')->name('prices.tests');
    Route::post('prices/tests','PricesController@tests_submit')->name('prices.tests_submit');
    Route::get('tests_prices_export','PricesController@tests_prices_export')->name('prices.tests_prices_export');
    Route::post('tests_prices_import','PricesController@tests_prices_import')->name('prices.tests_prices_import');

    //cultures price list
    Route::get('prices/cultures','PricesController@cultures')->name('prices.cultures');
    Route::post('prices/cultures','PricesController@cultures_submit')->name('prices.cultures_submit');
    Route::get('cultures_prices_export','PricesController@cultures_prices_export')->name('prices.cultures_prices_export');
    Route::post('cultures_prices_import','PricesController@cultures_prices_import')->name('prices.cultures_prices_import');

    //packages price list
    Route::get('prices/packages','PricesController@packages')->name('prices.packages');
    Route::post('prices/packages','PricesController@packages_submit')->name('prices.packages_submit');
    Route::get('packages_prices_export','PricesController@packages_prices_export')->name('prices.packages_prices_export');
    Route::post('packages_prices_import','PricesController@packages_prices_import')->name('prices.packages_prices_import');

    //accounting reports
    Route::resource('payment_methods','PaymentMethodsController');
    Route::get('accounting','AccountingController@index')->name('accounting.index');
    Route::get('generate_report','AccountingController@generate_report')->name('accounting.generate_report');
    Route::get('doctor_report','AccountingController@doctor_report')->name('accounting.doctor_report');
    Route::get('generate_doctor_report','AccountingController@generate_doctor_report')->name('accounting.generate_doctor_report');

    //chat
    Route::get('chat','ChatController@index')->name('chat.index');

    //visits
    Route::resource('visits','VisitsController');
    Route::get('visits/{id}/get-regions','VisitsController@getRegions')->name('visits.get-regions');
    Route::get('visits/get-users/lab-to-lab','VisitsController@getUsers')->name('visits.get-users');
    Route::get('visits/create_tests/{id}','VisitsController@create_tests')->name('visits.create_tests');
    Route::get('get_visits','VisitsController@ajax')->name('get_visits');
    Route::post('visits/bulk/delete','VisitsController@bulk_delete')->name('visits.bulk_delete');

    //branches
    Route::resource('branches','BranchesController');
    Route::get('get_branches','BranchesController@ajax')->name('get_branches');
    Route::post('branches/bulk/delete','BranchesController@bulk_delete')->name('branches.bulk_delete');

    //contracts
    Route::resource('governments','GovernmentController')->except('show');

    Route::get('government/{id}/regions','RegionController@index')->name('regions.index');
    Route::get('government/{id}/regions/create','RegionController@create')->name('regions.create');
    Route::post('government/{id}/regions/store','RegionController@store')->name('regions.store');
    Route::get('regions/{id}/edit','RegionController@edit')->name('regions.edit');
    Route::post('regions/{id}/update','RegionController@update')->name('regions.update');
    Route::delete('regions/{id}/destroy','RegionController@destroy')->name('regions.destroy');

    Route::resource('contracts','ContractsController');
    Route::get('get_contracts','ContractsController@ajax')->name('get_contracts');
    Route::get('contract_export/{id}','ContractsController@export')->name('contract.export');
    Route::post('contract_import/{id}','ContractsController@import')->name('contract.import');
    Route::get('refresh_tests_contract/{id}','ContractsController@refresh_tests_contract')->name('refresh_tests_contract');
    Route::get('refresh_cultures_contract/{id}','ContractsController@refresh_cultures_contract')->name('refresh_cultures_contract');
    Route::get('refresh_packages_contract/{id}','ContractsController@refresh_packages_contract')->name('refresh_packages_contract');
    Route::get('contract_prices','ContractsController@contract_prices')->name('contract_prices');
    Route::get('contractes_prices_export','ContractsController@contractes_prices_export')->name('contractes_prices_export');
    Route::get('contractes_cultures_export','ContractsController@contractes_cultures_export')->name('contractes_cultures_export');
    Route::get('contractes_packages_export','ContractsController@contractes_packages_export')->name('contractes_packages_export');
    Route::post('contractes_prices_import','ContractsController@contractes_prices_import')->name('contractes_prices_import');
    Route::post('contract_prices','ContractsController@prices_tests_submit')->name('contract_prices_submit');
    Route::post('contract_prices_culture','ContractsController@prices_culture_submit')->name('contract_prices_culture_submit');
    Route::post('contract_prices_package','ContractsController@prices_package_submit')->name('contract_prices_package_submit');
    Route::post('contracts/bulk/delete','ContractsController@bulk_delete')->name('contracts.bulk_delete');

    //labs
    Route::resource('labs','LabController');
    Route::get('get_labs','LabController@ajax')->name('get_labs');
    Route::post('labs/bulk/delete','LabController@bulk_delete')->name('labs.bulk_delete');

    //expenses
    Route::resource('expenses','ExpensesController');
    Route::get('get_expenses','ExpensesController@ajax')->name('get_expenses');
    Route::post('expenses/bulk/delete','ExpensesController@bulk_delete')->name('expenses.bulk_delete');

    //expense categories
    Route::resource('expense_categories','ExpenseCategoriesController');
    Route::get('get_expense_categories','ExpenseCategoriesController@ajax')->name('get_expense_categories');
    Route::post('expense_categories/bulk/delete','ExpenseCategoriesController@bulk_delete')->name('expense_categories.bulk_delete');

    //backups
    Route::resource('backups','BackupsController');

    //activity logs
    Route::resource('activity_logs','ActivityLogsController');
    Route::post('activity_logs_clear','ActivityLogsController@clear')->name('activity_logs.clear');
    Route::get('get_activity_logs','ActivityLogsController@ajax')->name('get_activity_logs');

    //settings
    Route::group(['prefix'=>'settings','as'=>'settings.'],function(){
        Route::get('/','SettingsController@index')->name('index');
        Route::post('medical_submit','SettingsController@medical_submit')->name('medical_submit');
        Route::post('info','SettingsController@info_submit')->name('info_submit');
        Route::post('emails','SettingsController@emails_submit')->name('emails_submit');
        Route::post('reports','SettingsController@reports_submit')->name('reports_submit');
        Route::post('sms','SettingsController@sms_submit')->name('sms_submit');
        Route::post('whatsapp','SettingsController@whatsapp_submit')->name('whatsapp_submit');
        Route::post('api_keys','SettingsController@api_keys_submit')->name('api_keys_submit');
        Route::post('barcode','SettingsController@barcode_submit')->name('barcode_submit');
        Route::post('printer','SettingsController@printer_submit')->name('printer_submit');
    });

    //inventory module
    Route::group(['prefix'=>'inventory','as'=>'inventory.','namespace'=>'Inventory'],function(){
        Route::resource('suppliers','SuppliersController');
        Route::resource('products','ProductsController');
        Route::resource('purchases','PurchasesController');
        Route::resource('adjustments','AdjustmentsController');
        Route::resource('transfers','TransfersController');
        Route::get('product_alerts','ProductsController@product_alerts');
    });
    Route::post('adjustments/bulk/delete','Inventory\AdjustmentsController@bulk_delete')->name('adjustments.bulk_delete');
    Route::post('purchases/bulk/delete','Inventory\PurchasesController@bulk_delete')->name('purchases.bulk_delete');
    Route::post('suppliers/bulk/delete','Inventory\SuppliersController@bulk_delete')->name('suppliers.bulk_delete');
    Route::post('transfers/bulk/delete','Inventory\TransfersController@bulk_delete')->name('transfers.bulk_delete');
    Route::post('products/bulk/delete','Inventory\ProductsController@bulk_delete')->name('products.bulk_delete');

    //Reports module
    Route::group(['prefix'=>'reports','as'=>'reports.'],function(){
        Route::get('accounting','ReportsController@accounting')->name('accounting');
        Route::get('patient','ReportsController@patient')->name('patient');
        Route::get('normal_doctor','ReportsController@normal_doctor')->name('normal_doctor');
        Route::get('doctor','ReportsController@doctor')->name('doctor');
        Route::get('supplier','ReportsController@supplier')->name('supplier');
        Route::get('employee','ReportsController@employee')->name('employee');
        Route::get('purchase','ReportsController@purchase')->name('purchase');
        Route::get('inventory','ReportsController@inventory')->name('inventory');
        Route::get('product','ReportsController@product')->name('product');
        Route::get('contract','ReportsController@contract')->name('contract');
        Route::get('branch_products','ReportsController@branch_products')->name('branch_products');
        Route::get('representative','ReportsController@representativeReports')->name('rep');
        Route::get('labs','ReportsController@labReports')->name('lab');
        Route::get('delayed-money','ReportsController@delayedMoney')->name('delayed_money');
        // Route::get('work_load_month','ReportsController@workLoadMonth')->name('work_load_month');
        // Route::get('work_load_day','ReportsController@workLoadDay')->name('work_load_day');
    });

    //Reports Details module
    Route::group(['prefix'=>'reports','as'=>'reports.'],function(){
        Route::get('work_load_month','ReportsDetialsController@workLoadMonth')->name('work_load_month');
        Route::get('work_load_day','ReportsDetialsController@workLoadDay')->name('work_load_day');
        Route::get('work_one_day','ReportsDetialsController@workOneDay')->name('work_one_day');
        Route::get('expenses','ReportsDetialsController@expenses')->name('expenses');
        Route::get('payments','ReportsDetialsController@payments')->name('payments');
        Route::get('testes_branch','ReportsDetialsController@testesBranch')->name('testes_branch');
        Route::get('contract_details','ReportsDetialsController@contract')->name('contract_details');
        Route::get('vault','ReportsDetialsController@vault')->name('vault');
        Route::get('custody','ReportsDetialsController@custody')->name('custody');
    });

    // update_patient_contract_id
    Route::get('update_patient_contract_id','GroupsController@updatePatientContractId')->name('update_patient_contract_id');
    Route::get('calculate_contract_id','GroupsController@CalcContractId')->name('calculate_contract_id');

    // add_point_sale
    Route::put('add_point_sale','IndexController@addPointSale')->name('add_point_sale');

    // tips and offers module
    Route::resource('tips','TipsController');
    Route::get('tip/get_tips','TipsController@ajax')->name('get_tips');
    // route bulk/delete
    Route::post('tips/bulk/delete','TipsController@bulk_delete')->name('tips.bulk_delete');

    // staticPages
    Route::resource('static_pages','StaticPagesController');
    // sliders
    Route::resource('sliders','SlidersController');
    Route::get('slider/get_sliders','SlidersController@ajax')->name('get_sliders');
    Route::post('sliders/bulk/delete','SlidersController@bulk_delete')->name('sliders.bulk_delete');

    // prescriptions
    Route::resource('prescriptions','PrescriptionsController');
    // get_prescriptions
    Route::get('prescription/get_prescriptions','PrescriptionsController@ajax')->name('get_prescriptions');
    Route::post('prescriptions/bulk/delete','PrescriptionsController@bulk_delete')->name('prescriptions.bulk_delete');

    //translations
    Route::resource('translations','TranslationsController');
    // bookings
    Route::resource('bookings','BookingController');
    Route::get('booking/get_bookings','BookingController@ajax')->name('get_bookings');
    Route::post('bookings/bulk/delete','BookingController@bulk_delete')->name('bookings.bulk_delete');


    Route::resource('employees','EmployeesController');
    Route::get('get_employees','EmployeesController@ajax')->name('get_employees');
    Route::post('employees/bulk/delete','EmployeesController@bulk_delete')->name('employees.bulk_delete');


    //vocations
    Route::resource('vocations','VocationsController');
    Route::get('get_vocations','VocationsController@ajax')->name('get_vocations');
    Route::get('accept/{id}','VocationsController@accepte')->name('vocation_accepte');
    Route::get('refuse/{id}','VocationsController@refuse')->name('vocation_refuser');
    Route::post('vocations/bulk/delete','VocationsController@bulk_delete')->name('vocations.bulk_delete');

    //violations
    Route::resource('violations','ViolationsController');
    Route::get('get_violations','ViolationsController@ajax')->name('get_violations');
    Route::post('violations/bulk/delete','ViolationsController@bulk_delete')->name('violations.bulk_delete');

    //violations
    Route::resource('attendance','AttendanceController');
    Route::get('get_attendance','AttendanceController@ajax')->name('get_attendance');
    Route::get('get_attendance_by_id','AttendanceController@getAttendanceById')->name('getAttendanceById');
    Route::post('attendance/bulk/delete','AttendanceController@bulk_delete')->name('attendance.bulk_delete');

    //rays and its components
    Route::resource('rays','RaysController');
    Route::get('get_rays','RaysController@ajax')->name('get_rays');
    Route::get('rays_export','RaysController@export')->name('rays.export');
    Route::post('rays_import','RaysController@import')->name('rays.import');


    //rays and its components
    Route::resource('rays_categories','RaysCategoryController');
    Route::get('get_rays_categories','RaysCategoryController@ajax')->name('get_rays_categories');
    Route::post('rays_categories/bulk/delete','RaysCategoryController@bulk_delete')->name('rays_categories.bulk_delete');

    // route
    Route::resource('fixed_assets','FixedAssetController');
    // fixed_asset/get_fixed_assets
    Route::get('fixed_asset/get_fixed_assets','FixedAssetController@ajax')->name('get_fixed_assets');
    Route::post('fixed_assets/bulk/delete','FixedAssetController@bulk_delete')->name('fixed_assets.bulk_delete');

    //vault
    Route::resource('vault','CashVaultController');
    Route::get('get_vault','CashVaultController@ajax');
    Route::get('request_custody','CashVaultController@requestCustody');
    Route::post('vault/custody','CashVaultController@custody')->name('vault.custody');

    //branch custody
    Route::resource('branches_custody','BranchCustodyController');
    Route::get('get_branches_custody','BranchCustodyController@ajax');
    Route::get('branches_custody_accept/{id}','BranchCustodyController@accept')->name('branches_custody_accept');
    Route::get('branches_custody_refuse/{id}','BranchCustodyController@refuse')->name('branches_custody_refuse');
    Route::get('get_branches_custody','BranchCustodyController@ajax');
    Route::post('branches_custody/bulk/delete','BranchCustodyController@bulk_delete')->name('branches_custody.bulk_delete');


    //Lab Outs
    Route::resource('labs_out','LabsOutController');
    Route::post('labs_out/bulk/delete','LabsOutController@bulk_delete');

   // send to lab
   Route::get('send_to_lab','MedicalReportsController@sendToLab')->name('send_to_lab.index');
   Route::post('send_test_submit','MedicalReportsController@sendToLabSubmit')->name('send_test_submit');
   
    //sample types
    Route::resource('sample_types','SampleTypesController');
    Route::get('get_sample_types','SampleTypesController@ajax')->name('sample_types.ajax');
    Route::post('sample_types_import','SampleTypesController@import')->name('sample_types.import');
    Route::get('sample_types_export','SampleTypesController@export')->name('sample_types.export');
    Route::post('sample_types/bulk/delete','SampleTypesController@bulk_delete')->name('sample_types.bulk_delete');

    Route::resource('prefix','PrefixController');
    Route::post('prefix/bulk/delete','PrefixController@bulk_delete')->name('prefix.bulk_delete');

});
