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

Route::get('/home', function () {
    return view('welcome');
});
Route::get('/responseMsg','Auth\RegisterController@responseMsg');
//首页加菜单
Route::get('/','Auth\RegisterController@zhuce');
Route::any('/wechat', 'WechatController@serve');
Route::get('/menu/new','MenuController@addmenu');
Route::get('/menu/del','MenuController@delmenu');
Route::get('/menu/edit','MenuController@editmenu');
Route::get('/menu/find','MenuController@findmenu');
Route::get('linkflnet','Auth\LoginController@linkflnet');
// 註冊頁提交註冊
Route::post('/register','Auth\RegisterController@index');
Route::post('/fastRegister','Auth\RegisterController@fastRegister');
Route::get('/resetpass','Auth\RegisterController@resetpass');
Route::get('/forgetPass','Auth\RegisterController@forgetPass');
Route::get('/forgetcode','Auth\RegisterController@sendTelCodeForget');
Route::post('/forget','Auth\RegisterController@forget');
Route::post('/reset','Auth\RegisterController@reset');
Route::get('/reback','Auth\RegisterController@reback');
// 登入頁提交登入
Route::post('/login','Auth\LoginController@index');
Route::get('/sendcode','Auth\RegisterController@sendTelCode');
Route::get('/sendFastCode','Auth\RegisterController@sendFastTelCode');
Route::get('/zhuce','Auth\RegisterController@zhuce');
Route::get('/returnUrl','Auth\RegisterController@returnUrl');
Route::get('/succUrl','Auth\RegisterController@succUrl');
Route::post('/fastLogin','Auth\LoginController@fastLogin');
// 登入頁
Route::get('/newLogin','Auth\LoginController@newLogin');
Route::get('/weibo','Auth\LoginController@weibo');
Route::get('/weixin','Auth\LoginController@weixin');
Route::get('/qq','Auth\LoginController@qq');
// 註冊頁
Route::get('/display','Auth\RegisterController@display');
Route::get('/displayManage','Auth\RegisterController@displayManage');
Route::get('/modifyPass','Auth\RegisterController@modifyPass');
Route::post('/handleModifyPass','Auth\RegisterController@handleModifyPass');
Route::get('service-terms','Auth\LoginController@serviceterms');
Route::get('privacy','Auth\LoginController@privacy');
Route::get('aboutflnet','Auth\LoginController@aboutflnet');
Route::get('/logout','Auth\RegisterController@logout');
Route::get('/accountDetail','Auth\RegisterController@accountDetail');
Route::get('/editnick','Auth\RegisterController@editnick');
Route::get('/recharge','Auth\RegisterController@recharge');
Route::get('/unlogin','Auth\RegisterController@unlogin');
Route::get('/nothingPay','Auth\RegisterController@nothingPay');
Route::get('/notPayMonth','Auth\RegisterController@notPayMonth');
Route::get('/payMonth','Auth\RegisterController@payMonth');
Route::get('/pay','Auth\RegisterController@pay');
Route::post('/nick','Auth\RegisterController@nick');
Route::get('/wrong','Auth\RegisterController@wrong');
Route::get('/tvShow','Auth\RegisterController@tvShow');
Route::get('/airFresh','Auth\RegisterController@airFresh');
Route::get('/mobileShow','Auth\RegisterController@mobileShow');
Route::get('/vipserv','Auth\RegisterController@vipserv');
Route::get('/captcha/{tmp}', 'Auth\RegisterController@captcha');
Route::get('/captchaUpdate/{tmp}', 'Auth\RegisterController@captchaUpdate');
Route::get('/captchaCreate/{tmp}', 'Auth\RegisterController@captchaCreate');
// 管理頁
Route::get('/newDisplay','Auth\RegisterController@newDisplay');
Route::post('/autoRenew','Auth\RegisterController@autoRenew');
Route::post('/notAutoRenew','Auth\RegisterController@notAutoRenew');
Route::get('/getop','Auth\RegisterController@xinop');
Route::get('/newRegister','Auth\RegisterController@newRegister');
//创建扫码二维码
Route::get('/createTempTicket','Auth\QrcodeController@createTempTicket');
Route::get('/createForeverTicket','Auth\QrcodeController@createForeverTicket');
//支付回调
Route::get('/notify','Auth\RegisterController@notify');
Route::get('/actionNotifyurl','Auth\RegisterController@actionNotifyurl');
Route::get('/fzfNotify','Auth\RegisterController@fzfNotify');
Route::get('/fzfNotifys','Auth\RegisterController@fzfNotifys');
//自动续费
Route::get('/jspay','Auth\RegisterController@jspay');
Route::post('/autoPay','Auth\RegisterController@autoPay');
Route::get('/wxAutoPay','Auth\RegisterController@wxAutoPay');
//加解密
Route::get('/encrypt','RsaController@index');
//退款
Route::get('/refund','Auth\RegisterController@refund');
Route::get('/refunds','Auth\RegisterController@refunds');
//充值页面
Route::get('/iqiyis','Auth\RegisterController@iqiyis');
Route::get('/iqiyi','Auth\RegisterController@iqiyi');
Route::get('/youku','Auth\RegisterController@youku');
Route::get('/baishitong','Auth\RegisterController@baishitong');
Route::get('/nba','Auth\RegisterController@nba');
//积分商城
Route::group(['middleware'=>['LoginAuth']],function(){
    Route::any('InteMall/index','InteMallController@index');
    Route::any('InteMall/getStatus','InteMallController@getStatus');
    Route::any('InteMethod/index',['uses'=>'InteMethodController@index']);
    Route::any('InteRecord/index',['uses'=>'InteRecordController@index']);
    Route::any('InteList/index',['uses'=>'InteListController@index']);
    Route::any('InteProduct/index',['uses'=>'InteProductController@index']);
    Route::get('InteProduct/addr','InteProductController@addr');
    Route::get('InteProduct/exchange','InteProductController@exchange');
    Route::get('InteProduct/newexchange','InteProductController@newexchange');
    Route::get('InteProduct/getInte','InteProductController@getInte');
    Route::any('InteDetails/index',['uses'=>'InteDetailsController@index']);
    Route::any('InteDetails/resContents',['uses'=>'InteDetailsController@resContents']);
    Route::any('InteDetails/curve',['uses'=>'InteDetailsController@curve']);
});
//banner上传
Route::any('InteBanner/index',['uses'=>'InteBannerController@index']);
Route::any('InteBanner/upload1',['uses'=>'InteBannerController@upload1']);
Route::any('InteBanner/upload2',['uses'=>'InteBannerController@upload2']);
Route::any('InteBanner/upload3',['uses'=>'InteBannerController@upload3']);
//分享测试
Route::any('InteTest/index',['uses'=>'InteTestController@index']);
//新增选择url路径
Route::get('/skipUrl','Auth\RegisterController@skipUrl');




