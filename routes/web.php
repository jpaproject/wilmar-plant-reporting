<?php

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

Route::get('/', function () {
    return redirect('/dashboard');
    // return view('landing');
});


// Dashboard
Route::get('/dashboard', 'DashboardController@index');

// TRENDING REPORT



// REPORT 
Route::prefix('report')->group(function () {
    Route::get('/weight-bridge', 'WeightBridgeController@index');


    Route::get('/intake', 'IntakeController@index');
    Route::post('/intake', 'IntakeController@store');
    Route::get('/intake/create', 'IntakeController@create');
    Route::get('/transfer', 'TransferController@index');


    Route::get('/hammer-mill', 'HammerMillController@index');
    Route::get('/hammer-mill/trend', 'HammerMillController@trend');

    Route::get('/pellet-mill', 'PelletMillController@index');
    Route::get('/pellet-mill/trend', 'PelletMillController@trend');

    Route::get('/mixer', 'MixerController@index');

    Route::get('/pellet', 'ReportController@pellet');
    Route::get('/mixer/detail/{id}', 'ReportController@mixerDetail');

    Route::get('/alarm-list', 'AlarmListController@index');

    Route::get('/history-log', 'HistoryLogController@index');
});


Route::prefix('setting')->group(function () {
    Route::get('/silo-adjustment', 'SiloAdjustment@index');
    Route::get('/silo-adjustment/create', 'SiloAdjustment@create');
    Route::post('/silo-adjustment', 'SiloAdjustment@store');
    Route::get('/silo-adjustment/{id}/edit', 'SiloAdjustment@edit');
    Route::post('/silo-adjustment', 'SiloAdjustment@store');
    Route::put('/silo-adjustment/{id}/update', 'SiloAdjustment@update')->name('silo-adjustment.update');
    Route::delete('/silo-adjustment/{id}', 'SiloAdjustment@destroy')->name('silo-adjustment.destroy');


    Route::get('/silo-actual', 'ActualSiloController@index');
    Route::get('/silo-actual/create', 'ActualSiloController@create');
    Route::post('/silo-actual', 'ActualSiloController@store');
    Route::get('/silo-actual/{id}/edit', 'ActualSiloController@edit');
    Route::put('/silo-actual/{id}/update', 'ActualSiloController@update')->name('silo-actual.update');
    Route::delete('/silo-actual/{id}', 'ActualSiloController@destroy')->name('silo-actual.destroy');

    Route::get('/silo-manual', 'ManualSiloController@index');
    Route::get('/silo-manual/create', 'ManualSiloController@create');
    Route::post('/silo-manual', 'ManualSiloController@store');
    Route::get('/silo-manual/{id}/edit', 'ManualSiloController@edit');
    Route::put('/silo-manual/{id}/update', 'ManualSiloController@update')->name('silo-manual.update');
    Route::delete('/silo-manual/{id}', 'ManualSiloController@destroy')->name('silo-manual.destroy');

    Route::get('/silo-setting', 'SiloSettingController@index');
    Route::get('/silo-setting/create', 'SiloSettingController@create');
    Route::post('/silo-setting', 'SiloSettingController@store');
    Route::get('/silo-setting/{id}/edit', 'SiloSettingController@edit');
    Route::put('/silo-setting/{id}/update', 'SiloSettingController@update')->name('silo-setting.update');
    Route::delete('/silo-setting/{id}', 'SiloSettingController@destroy')->name('silo-setting.destroy');

    Route::get('/silo-alarm', 'SiloAlarmController@index');
    Route::get('/silo-alarm/create', 'SiloAlarmController@create');
    Route::post('/silo-alarm', 'SiloAlarmController@store');
    Route::get('/silo-alarm/{id}/edit', 'SiloAlarmController@edit');
    Route::put('/silo-alarm/{id}/update', 'SiloAlarmController@update')->name('silo-alarm.update');
    Route::delete('/silo-alarm/{id}', 'SiloAlarmController@destroy')->name('silo-alarm.destroy');

    Route::get('/dashboard-alarm', 'DashboardAlarmController@index');
    Route::get('/dashboard-alarm/create', 'DashboardAlarmController@create');
    Route::post('/dashboard-alarm', 'DashboardAlarmController@store');
    Route::get('/dashboard-alarm/{id}/edit', 'DashboardAlarmController@edit');
    Route::post('/dashboard-alarm', 'DashboardAlarmController@store');
    Route::delete('/dashboard-alarm/{id}', 'DashboardAlarmController@destroy')->name('dashboard-alarm.destroy');

    Route::get('/mill-alarm', 'AlarmMillController@index');
    Route::get('/mill-alarm/create', 'AlarmMillController@create');
    Route::post('/mill-alarm', 'AlarmMillController@store');
    Route::put('/mill-alarm/{id}/update', 'AlarmMillController@update')->name('mill-alarm.update');
    Route::get('/mill-alarm/{id}/edit', 'AlarmMillController@edit');
    Route::delete('/mill-alarm/{id}', 'AlarmMillController@destroy')->name('mill-alarm.destroy');


    Route::get('/wb-alarm', 'AlarmWBController@index');
    Route::get('/wb-alarm/create', 'AlarmWBController@create');
    Route::post('/wb-alarm', 'AlarmWBController@store');
    Route::get('/wb-alarm/{id}/edit', 'AlarmWBController@edit');
    Route::put('/wb-alarm/{id}/update', 'AlarmWBController@update')->name('wb-alarm.update');
    Route::delete('/wb-alarm/{id}', 'AlarmWBController@destroy')->name('mill-alarm.destroy');


    Route::get('/voltage-alarm', 'AlarmVoltageController@index');
    Route::get('/voltage-alarm/create', 'AlarmVoltageController@create');
    Route::post('/voltage-alarm', 'AlarmVoltageController@store');
    Route::get('/voltage-alarm/{id}/edit', 'AlarmVoltageController@edit');
    Route::put('/voltage-alarm/{id}/update', 'AlarmVoltageController@update')->name('voltage-alarm.update');
    Route::delete('/voltage-alarm/{id}', 'AlarmVoltageController@destroy')->name('voltage-alarm.destroy');

    Route::get('/mixer-alarm', 'AlarmMixerController@index');
    Route::get('/mixer-alarm/create', 'AlarmMixerController@create');
    Route::post('/mixer-alarm', 'AlarmMixerController@store');
    Route::get('/mixer-alarm/{id}/edit', 'AlarmMixerController@edit')->name('mixer-alarm.edit');
    Route::put('/mixer-alarm/{id}/update', 'AlarmMixerController@update')->name('mixer-alarm.update');
    Route::delete('/mixer-alarm/{id}', 'AlarmMixerController@destroy')->name('mixer-alarm.destroy');

    Route::get('/sync', 'SyncController@sync');



    Route::get('/notification/email', 'NotificationController@email');
    Route::post('/notification/test-email', 'NotificationController@emailTest')->name('test_email');
    Route::post('/notification/store', 'NotificationController@emailStore')->name('store_email');

    Route::get('/notification/telegram', 'NotificationController@telegram');
    Route::get('/notification/telegram/create', 'NotificationController@telegramCreate')->name('create_telegram');
    Route::post('/notification/store-telegram', 'NotificationController@telegramStore')->name('store_telegram');
    Route::get('/notification/telegram/{id}/edit', 'NotificationController@telegramEdit')->name('edit_telegram');
    Route::put('/notification/telegram/{id}/update', 'NotificationController@telegramUpdate')->name('update_telegram');
    Route::delete('/notification/telegram/delete/{id}', 'NotificationController@telegramDelete')->name('delete_telegram');
    Route::post('/notification/test-telegram', 'NotificationController@telegramTest')->name('test_telegram');
});

// ALARM
Route::delete('/alarm-setting/{id}', 'AlarmSettingController@destroy')->name('alarm-setting.destroy');
Route::get('/alarm-setting', 'AlarmSettingController@index');
Route::get('/alarm-setting/create', 'AlarmSettingController@create');
Route::get('/alarm-setting/{id}/edit', 'AlarmSettingController@edit')->name('alarm-setting.edit');
Route::post('/alarm-setting/store', 'AlarmSettingController@store')->name('alarm-setting.store');
Route::put('/alarm-setting/{id}/update', 'AlarmSettingController@update')->name('alarm-setting.update');

Auth::routes();



// --USER RESOURCE
Route::resource('/users', 'UserController');

// --DEPARTEMENT RESOURCE
Route::resource('/departements', 'DepartementController');

// --PRIVILEGES RESOURCE
Route::resource('/privileges', 'PrivilegesController');

// --TONNAGE RESOURCE
Route::resource('/tonnages', 'TonnageHMController');


// Route::get('send', 'HomeController@sendNotification');


Route::get('send', function () {
});
