<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product/all', 'ApiProduct@all');



Route::post('trending', 'JsonController@trendingJson');
Route::post('consumption', 'JsonController@consumptionJson');

Route::get('users', 'UsersApi@index');


Route::get('raw', 'HammerMillController@rawPakan');


Route::post('weight-bridge','ApiWeightBridgeController@index');
Route::post('trf','ApiTrfController@index');
Route::get('adjustment', 'ApiAdjustmentController@index');
Route::get('mixer', 'ApiMixerController@index');
Route::get('hp-mill', 'ApiHpMillController@index');
Route::post('hp-material', 'ApiHpMaterialController@index');