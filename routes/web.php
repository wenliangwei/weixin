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
    return view('welcome');
});
//——————————————————————————————————————————————————————
Route::prefix('wechat')->group(function(){
    Route::get('get_user_list','WechatController@get_user_list');
    Route::get('get_user_info','WechatController@get_user_info');
    Route::get('get_access_token','WechatController@get_access_token');
});
//——————————————————————————————————————————————————————

