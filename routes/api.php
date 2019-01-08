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

// 幫助電視端獲取夏普服務號微信access_token
Route::get('/sharp_china/wechat/token', 'Api\SharpChinaController@getWechatAccessTokenApi')->name('get-wechat-token');
Route::get('/sharp_china/wechat/menu', 'Api\SharpChinaController@getMenuApi')->name('get-menu');
Route::post('/sharp_china/wechat/menu', 'Api\SharpChinaController@createMenuApi')->name('create-menu');
