<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\FlnetIotMemberApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Jasny\SSO\NotAttachedException;
use Session;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\XcryptController;
use App\Http\Controllers\DesController;
use Jasny\SSO\Broker;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function fzfNotifys()
    {
        $pointClientId=config('wechat.official_account.default.point_client_id');
        $pointClientSecret=config('wechat.official_account.default.point_client_secret');
        //支付查询结果
        $inner_interface="http://open.fujinfu.cn:8888/aliwxpay/api/getway";
        $params=array('orderid'=>'ZNJJ832715415985851662');
       /* if(session('orderprovider')=='YOUKU')
        {
            $result=$this->checksign_INs($inner_interface,'PayQuery',json_encode($params));echo "<pre>";print_r($result);echo "<br>";
        }
        else
        {
            $result=$this->checksign_IN($inner_interface,'PayQuery',json_encode($params));echo "<pre>";print_r($result);echo "<br>";
        }*/
        $result=$this->checksign_IN($inner_interface,'PayQuery',json_encode($params));echo "<pre>";print_r($result);echo "<br>";
        if($result['resultcode']==1 && $result['result'])
        {
            if(($result['result']['orderstatus']==1)  && ($result['result']['status']==1))
            {
                $order_id='ZNJJ669115416552458808';
                $order_price='249';
                $order_provider='IQIYI';
                $order_model='60SU465A';
                $order_accountid='AIDMDSOLOUSHUTTBXLLU';
                $order_deviceid='77L9W55L9D2Z8KAF7T3P';
                $order_openid='oi0KU0bsy8WPS34YFjW-MfzAuc4o';
                $order_time='2018-11-08 13:34:05';
                $order_packageid='TPSP2K';
                $pointUserId='888056';
                $pointUseruuid='abf3ad00-dc6b-11e7-a3fa-0b181ed80828';
                $pointAccessToken='eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImJjOTFhZTM2Y2Y2OTkyZjEyZWRiNzE4OGNhMjI0MWIwYTljOGM5YTdmNjNmYWNkMmQ2NzE4YzI2OTFhN2Y2Yzg4ZWY3YjdjOTIxMTk1ODA4In0.eyJhdWQiOiIxNzAzODg4MDAxIiwianRpIjoiYmM5MWFlMzZjZjY5OTJmMTJlZGI3MTg4Y2EyMjQxYjBhOWM4YzlhN2Y2M2ZhY2QyZDY3MThjMjY5MWE3ZjZjODhlZjdiN2M5MjExOTU4MDgiLCJpYXQiOjE1NDE2NjQ4MTksIm5iZiI6MTU0MTY2NDgxOSwiZXhwIjoxNTQ0MjU2ODE3LCJzdWIiOiI4ODgwNTYiLCJzY29wZXMiOltdfQ.Ez_RSJXMAEL6w8ewmVZb7WX53QHkXOGC2j5Jfa_1nK5dh-kcuAVNpjD8lb7V-c3-zAv8wd9BxhiwXApatRQ7hP9JmYaCc19fgYZJd5xQ82WzJJne6bh5WW-D0oESqApEKqxHJDIQF6GXcOfTMHyj8SqfLjFM2ZaD9-PVIi4qU5sZJ-5XtMFLIpIHmPZIjsbd2Ssv87fTFjQcLxWglopc-eHGpvJvVRnl7KFq8lXQrUwCoJwfGICD_SuzSCYa_4VzPLE_KTMLChcSk7DV_1Z8HnIfX9eTHYEJ3-5-d6CJUZueIdOJ4Vudsc1pEVnfja2WtNL0cLn3YES1mt_etoPXheShdmA_KELYr7VD-adzTiqgocTAVOYFDoXWzbJ2mpQPH6DQ2coq2bCUcF2C2bbK_76qLPZV6rpY-FZBOV_mmVI1zW30otZel1_nSGcztR6eN0HMfDsWT3zDzFE0sSxUjAKuzkaamZUHRk5XPjNU4gcQpowz0jkX9kEv5vRJ-nh7Tyd_r0F_wkWo5U3ipqUbCniw-jxhQVIcl_nW0n_8Nb4omtNLZd5g6gVepTwrucIuhZT4-SeUXHzhh6Zav3AxurdVWykEjqgkLCjXuHdcNti3gFeOHpbo6Yx0jCFku_n3mauEUi4AUTmoYjdfFRB9ucBbahu7EwGE_xoGl6KCIcw';
                $nickname='黄尉峰';
                //更新显示账号权益信息
                //display展示url
                $md5account_id = md5('accountId=' . $order_accountid);
                // 使用私钥加密
                openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
                //base64以防乱码
                $signature = base64_encode($encrypted);
                $movieDisplayUrl = config('wechat.official_account.default.display_url');
                $movarray = array(
                    'accountId' => $order_accountid,
                );
                $movieArr = array(
                    'Data' => base64_encode(json_encode($movarray)),
                    'Signature' => $signature,
                );
                $movieResult = json_encode($movieArr);
                $movRes = $this->curl_movie($movieDisplayUrl, $movieResult);
                if($movRes!=='{}')
                {
                    $newMovieRess = json_decode($movRes, true);
                    if(empty($newMovieRess['vipRight']))
                    {
                        session(['res' =>'']);
                    }
                    else
                    {
                        session(['res' => $newMovieRess['vipRight']]);
                    }
                }
                $results=DB::table('cancel_order')->insert(['orderid'=>$order_id,'ordertotal'=>$order_price,'packagename'=>$order_provider,'model'=>$order_model,'accountid'=>$order_accountid,'deviceid'=>$order_deviceid,'openid'=>$order_openid,'refundstatus'=>1,'createtime'=>$order_time]);
                //支付成功后获得相应的积分，获得积分如下：
                $platformParam=config('wechat.official_account.default.platform_param');$succParam=config('wechat.official_account.default.point_return_param');
                if($order_provider=='IQIYI')
                {
                    $iqiyiIntegration=$order_price*$platformParam*$succParam;
                    $tim = time();
                    $randNum15=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum15,
                        'definition'=>'vip影视充值权益',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$pointUserId,
                        'user_uuid'=>$pointUseruuid,
                        'user_name'=>$nickname,
                        'access_token'=>$pointAccessToken,
                        'bonus_point'=>round($iqiyiIntegration),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);
                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum15,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>5,'bonus_point'=>$iqiyiIntegration,'orderid'=>$order_id,'definition'=>'购买爱奇艺影视权益','createtime'=>$tim]);
                }
                if($order_provider=='YOUKU')
                {
                    $youkuIntegration=$order_price*$platformParam*$succParam;
                    $tim = time();

                    $randNum16=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum16,
                        'definition'=>'vip影视充值权益',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$pointUserId,
                        'user_uuid'=>$pointUseruuid,
                        'user_name'=>$nickname,
                        'access_token'=>$pointAccessToken,
                        'bonus_point'=>round($youkuIntegration),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);
                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum16,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>5,'bonus_point'=>$youkuIntegration,'orderid'=>$order_id,'definition'=>'购买优酷影视权益','createtime'=>$tim]);
                }
                if($order_provider=='BESTV:PPTV')
                {
                    $pptvIntegration=$order_price*$platformParam*$succParam;
                    $tim = time();

                    $randNum17=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum17,
                        'definition'=>'vip影视充值权益',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$pointUserId,
                        'user_uuid'=>$pointUseruuid,
                        'user_name'=>$nickname,
                        'access_token'=>$pointAccessToken,
                        'bonus_point'=>round($pptvIntegration),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);
                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum17,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>5,'bonus_point'=>$pptvIntegration,'orderid'=>$order_id,'definition'=>'购买百视通影视权益','createtime'=>$tim]);
                }
                if($order_provider=='BESTV')
                {
                    $bestvIntegration=$order_price*$platformParam*$succParam;
                    $tim = time();

                    $randNum18=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum18,
                        'definition'=>'vip影视充值权益',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$pointUserId,
                        'user_uuid'=>$pointUseruuid,
                        'user_name'=>$nickname,
                        'access_token'=>$pointAccessToken,
                        'bonus_point'=>round($bestvIntegration),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);
                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum18,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>5,'bonus_point'=>$bestvIntegration,'orderid'=>$order_id,'definition'=>'购买百视通NBA权益','createtime'=>$tim]);
                }
                //orderID，packageID，accountID，deviceID，payOrderNO（即fzforderid=1808310257603456844),payTime
                //将正常的时间格式转化为毫秒级的时间格式
                $tis=strtotime($result['result']['payendtime']);
                $newtim = $this->get_microtime_format($tis);//2018-07-17 09:03:39.000
                //将毫秒级时间格式转化为毫秒级的时间戳
                $netime = $this->get_data_format($newtim);//1531818148000
                //先md5加密
                $Encode = md5('accountID='.$order_accountid.'deviceID='.$order_deviceid.'orderID=' . $order_id.'packageID='.$order_packageid.'payOrderNO='.$result['result']['fzforderid'].'payTime='.$netime);
                // 使用私钥加密
                openssl_sign($Encode, $encrypted, config('wechat.official_account.default.private_key'));
                //base64以防乱码
                $signature = base64_encode($encrypted);
                //价格展示url
                $moviePriceUrl = config('wechat.official_account.default.order_url');
                $movarray = array(
                    'orderID' => $order_id,
                    'packageID'=>$order_packageid,
                    'accountID'=>$order_accountid,
                    'deviceID'=>$order_deviceid,
                    'payOrderNO'=>$result['result']['fzforderid'],
                    'payTime'=>$netime,
                );
                $movieArr = array(
                    'Data' => base64_encode(json_encode($movarray)),
                    'Signature' => $signature,
                );
                $movieResult = json_encode($movieArr);
                $movRes = $this->curl_movie($moviePriceUrl, $movieResult);
                $res = json_decode($movRes, true);echo "<pre>";print_r($res);die;
                return redirect('newDisplay');
            }

        }


    }
    //普通注册时执行方法
    public function index(Request $request)
    {
        $tim = time();
        //将正常的时间格式转化为毫秒级的时间格式
        $newtim = $this->get_microtime_format($tim);//2018-07-17 09:03:39.000
        //将毫秒级时间格式转化为毫秒级的时间戳
        $netime = $this->get_data_format($newtim);//1531818148000
        session(['time'=>$netime]);
        $input = $request->all();
        logger()->debug('register post form');
        $mobile = $input['tel']; // 手機號
        $sendCode = $input['mobile_confirm_code']; // 驗證碼
        $pass = $input['registerPass']; // 密碼
        // 將資訊存到session
        session(['newMobile' => $mobile]);
        session(['newCode' => $sendCode]);
        session(['pass' => $pass]);
        //调用第三方登入，透過微信unionid和手機號成為會員，並直接登入
        /** @var FlnetIotMemberApiService $flnetIotMemberApiService 大會員接口集成服務 */
        $flnetIotMemberApiService = App::make(FlnetIotMemberApiService::class);
        // 調用api/auth/weixinweb/login接口進行登入
        $registerApiInput = array(
            'username' => session('newMobile'),
            'mobile_country_code' => '+86',
            'mobile_confirm_code' => session('newCode'),
            'password' => $pass,
        );
        $flnetIotMemberApiService->register($registerApiInput['username'],$registerApiInput['mobile_confirm_code'], $registerApiInput['password']);
        $registerResponse = $flnetIotMemberApiService->getResponse();
        $registerResponseArray = json_decode($registerResponse->getBody(), true);
        $iotToken = isset($registerResponseArray['access_token']) ? $registerResponseArray['access_token'] : NULL;
        // 若result_code為0或token為NULL，都代表第三方登入失敗，返回原頁面並提示錯誤提示
        if (!isset($registerResponseArray['result_code']) || $registerResponseArray['result_code'] == 0 || !$iotToken) {
            logger()->debug('web login failed : ' . $registerResponseArray['message']);
            session(['newuserlogin' => 1]);
            return Redirect::back()->withInput($input)->withErrors([$registerResponseArray['message']]);
        }
        else
        {
            logger()->debug('$iotToken = ' . $iotToken);
            logger()->debug('user uuid = ' . $registerResponseArray['user']['uuid']);
            logger()->debug('web login success');
            //根据用户的uuid获取所有设备资讯
            $uuidurl = config('flnet-iot-member.base_api_url') . "users/" . $registerResponseArray['user']['uuid'] . "/devices";
            $uuidresult = $this->doGet('Bearer ' . $iotToken, $uuidurl);
            $uuidres = json_decode($uuidresult, true);
            if (isset($uuidres['devices']))
            {
                session(['userdev' => $uuidres['devices']]);
                if(session('userdev') &&  (session('binddevice5') !==1))
                {
                    foreach($uuidres['devices'] as $v) {
                        if ($v['type'] == 5) {
                            $tim = time();
                            $pointClientId = config('wechat.official_account.default.point_client_id');
                            $pointClientSecret = config('wechat.official_account.default.point_client_secret');
                            session(['binddevice5' => 1]);
                            $pointUseruuid = session('useruuid');
                            $pointUserId = $registerResponseArray['user']['user_client']['user_id'];
                            $pointAccessToken = $registerResponseArray['access_token'];
                            $randNum0 = $this->GetRandStr(80);
                            $pointArr = array(
                                'ticket' => $randNum0,
                                'definition' => '绑定设备',
                                'client_id' => config('wechat.official_account.default.point_client_id'),
                                'client_secret' => config('wechat.official_account.default.point_client_secret'),
                                'user_id' => $registerResponseArray['user']['user_client']['user_id'],
                                'user_uuid' => $registerResponseArray['user']['uuid'],
                                'user_name'=>$registerResponseArray['user']['nickname'],
                                'access_token' => $registerResponseArray['access_token'],
                                'bonus_point' => config('wechat.official_account.default.point_bind_device'),
                            );
                            $createPointResult = $this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                            $createPointRes = json_decode($createPointResult, true);
                            $points = config('wechat.official_account.default.point_bind_device');
                            $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum0,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定空气净化器设备','createtime'=>$tim]);

                        }
                    }
                }
                logger()->debug('device count = ' . count($uuidres['devices']));
            }
            session(['status' => 1]);//改变状态为1
            session(['mobile' => $registerResponseArray['user']['mobile']]);
            session(['pass' => $pass]);
            session(['anotherMobile' => $registerResponseArray['user']['mobile']]);
            session(['useruuid' => $registerResponseArray['user']['uuid']]);
            session(['nickname' => $registerResponseArray['user']['nickname']]);
            session(['newimage'=>$registerResponseArray['user']['avatar']]);
            session(['pointUserId' => $registerResponseArray['user']['user_client']['user_id']]);
            session(['pointAccessToken' => $registerResponseArray['access_token']]);

            //用户首次注册成功后新增20积分
            if(session('createPointStatus') !== 1)
            {
                $tim = time();
                $pointClientId=config('wechat.official_account.default.point_client_id');
                $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                $pointUserId=$registerResponseArray['user']['user_client']['user_id'];
                $pointUseruuid=session('useruuid');
                $pointAccessToken=$registerResponseArray['access_token'];
                session(['createPointStatus'=>1]);
                $randNum1=$this->GetRandStr(80);
                $pointArr=array(
                    'ticket'=>$randNum1,
                    'definition'=>'首次登入奖励',
                    'client_id'=>config('wechat.official_account.default.point_client_id'),
                    'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                    'user_id'=>$registerResponseArray['user']['user_client']['user_id'],
                    'user_uuid'=>$registerResponseArray['user']['uuid'],
                    'user_name'=>$registerResponseArray['user']['nickname'],
                    'access_token'=>$registerResponseArray['access_token'],
                    'bonus_point'=>config('wechat.official_account.default.point_register_bounes'),
                );
                $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                $createPointRes=json_decode($createPointResult,true);
                $points = config('wechat.official_account.default.point_bind_device');
                $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum1,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定空气净化器设备','createtime'=>$tim]);
            }
            //调用大会员的mapping映射接口，获取到影视会员id
            $chrageResult=$this->doGet('Bearer ' . $iotToken,config('flnet-iot-member.base_api_url') . 'users/cms-search?user_uuid='.session('useruuid') );
            $chargeRes=json_decode($chrageResult,true);//获得影视会员的信息（包括 id,mobile,nickname);
            //判断是否是夏普影视会员result_code==1而且cms_user['id']存在即为会员
            if($chargeRes['result_code']==1 && $chargeRes['cms_user'])
            {
                $chargeId = $chargeRes['cms_user']['id'];
                $chargeTel = $chargeRes['cms_user']['mobile'];
                $chargeNickName = $chargeRes['cms_user']['nickname'];//$chargeId就是影视会员ID
                //获取到影视会员id，接下来就开始和kidd对接....................................//
                if($chargeId)
                {
                    session(['accountid'=>$chargeId]);//session(['registerIntegration'=>20]);
                    //赋值$chargeId
                    $accountid=$chargeId;
                    //$accountid = 'GIGDTDUMTHQKNVVLJPTO';
                    //先md5加密
                    $md5account_id = md5('accountId=' . $accountid);
                    // 使用私钥加密
                    openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
                    //base64以防乱码
                    $signature = base64_encode($encrypted);
                    //购买展示url
                    $movieRightUrl = config('wechat.official_account.default.display_url');

                    $movarray = array(
                        'accountId' => $accountid,
                    );
                    $movieArr = array(
                        'Data' => base64_encode(json_encode($movarray)),
                        'Signature' => $signature,
                    );


                    //recharge充值url
                    $moviePriceUrl = config('wechat.official_account.default.recharge_url');
                    $movieResults = json_encode($movieArr);
                    $movRess = $this->curl_movie($moviePriceUrl, $movieResults);
                    if($movRess!=='{}')
                    {
                        $newMovieRess = json_decode($movRess, true);
                        if(empty($newMovieRess['vipRight']))
                        {
                            session(['rechargeDisplay'=>'']);
                        }
                        else
                        {
                            session(['rechargeDisplay'=>$newMovieRess['vipRight']]);
                            //绑定夏普电视同一类型时获得的相应积分10积分
                            if(session('rechargeDisplay') &&  (session('bindsharp') !==1))
                            {
                                $tim = time();
                                $pointClientId=config('wechat.official_account.default.point_client_id');
                                $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                                $pointUserId=$registerResponseArray['user']['user_client']['user_id'];
                                session(['bindsharp'=>1]);
                                $pointUseruuid=session('useruuid');
                                $pointAccessToken=$registerResponseArray['access_token'];
                                $randNum2=$this->GetRandStr(80);
                                $pointArr=array(
                                    'ticket'=>$randNum2,
                                    'definition'=>'绑定设备',
                                    'client_id'=>config('wechat.official_account.default.point_client_id'),
                                    'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                                    'user_id'=>$registerResponseArray['user']['user_client']['user_id'],
                                    'user_uuid'=>$registerResponseArray['user']['uuid'],
                                    'user_name'=>$registerResponseArray['user']['nickname'],
                                    'access_token'=>$registerResponseArray['access_token'],
                                    'bonus_point'=>config('wechat.official_account.default.point_bind_device'),
                                );
                                $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                                $createPointRes=json_decode($createPointResult,true);
                                $points = config('wechat.official_account.default.point_bind_device');
                                $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum2,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定夏普电视设备','createtime'=>$tim]);

                            }
                            foreach($newMovieRess['vipRight'] as $v)
                            {
                                if($v['providerName']=='IQIYI' && $v['devices'])
                                {
                                    $iqiyimac=$v['devices'][0]['mac'];$iqiyiprovider=$v['devices'][0]['provider'];$iqiyilimitdate=$v['devices'][0]['limitDate'];$iqiyimodel=$v['devices'][0]['model'];$iqiyideviceid=$v['devices'][0]['deviceId'];
                                    session(['iqiyimac'=>$iqiyimac]);session(['iqiyiprovider'=>$iqiyiprovider]);session(['iqiyilimitdate'=>$iqiyilimitdate]);session(['iqiyimodel'=>$iqiyimodel]);session(['iqiyideviceid'=>$iqiyideviceid]);
                                }
                                if($v['providerName']=='YOUKU' && $v['devices'])
                                {
                                    $youkumac=$v['devices'][0]['mac'];$youkuprovider=$v['devices'][0]['provider'];$youkulimitdate=$v['devices'][0]['limitDate'];$youkumodel=$v['devices'][0]['model'];$youkudeviceid=$v['devices'][0]['deviceId'];
                                    session(['youkumac'=>$youkumac]);session(['youkuprovider'=>$youkuprovider]);session(['youkulimitdate'=>$youkulimitdate]);session(['youkumodel'=>$youkumodel]);session(['youkudeviceid'=>$youkudeviceid]);
                                }
                                if($v['providerName']=='BESTV:PPTV' && $v['devices'])
                                {
                                    $pptvmac=$v['devices'][0]['mac'];$pptvprovider=$v['devices'][0]['provider'];$pptvlimitdate=$v['devices'][0]['limitDate'];$pptvmodel=$v['devices'][0]['model'];$pptvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['pptvmac'=>$pptvmac]);session(['pptvprovider'=>$pptvprovider]);session(['pptvlimitdate'=>$pptvlimitdate]);session(['pptvmodel'=>$pptvmodel]);session(['pptvdeviceid'=>$pptvdeviceid]);
                                }
                                if($v['providerName']=='BESTV' && $v['devices'])
                                {
                                    $bestvmac=$v['devices'][0]['mac'];$bestvprovider=$v['devices'][0]['provider'];$bestvlimitdate=$v['devices'][0]['limitDate'];$bestvmodel=$v['devices'][0]['model'];$bestvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['bestvmac'=>$bestvmac]);session(['bestvprovider'=>$bestvprovider]);session(['bestvlimitdate'=>$bestvlimitdate]);session(['bestvmodel'=>$bestvmodel]);session(['bestvdeviceid'=>$bestvdeviceid]);
                                }
                            }
                        }
                    }

                    $movieResult = json_encode($movieArr);
                    $movRes = $this->curl_movie($movieRightUrl, $movieResult);
                    if($movRes!=='{}')
                    {
                        $newMovieRes = json_decode($movRes, true);
                        if(empty($newMovieRes['vipRight']))
                        {
                            session(['res'=>'']);
                        }
                        else
                        {
                            session(['res'=>$newMovieRes['vipRight']]);
                        }
                    }
                    return redirect('newDisplay');
                }
                else
                {
                    $data = ['res' => ''];
                    return redirect('newDisplay');
                }
            }
            else
            {
                $data = ['res' => ''];
                return redirect('newDisplay');
            }
        }




    }
    //快捷注册刷新图形验证码处理方法
    public function captcha()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        session(['milkcaptcha'=>$phrase]);

        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
    //快捷注册刷新图形验证码处理方法
    public function captchaUpdate()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        session(['milkcaptchas'=>$phrase]);

        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
    public function captchaCreate()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        session(['milkcaptcha'=>$phrase]);

        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
    //vip服务协议
    public function vipserv()
    {
        return view('vipservice');
    }
    //快捷注册处理逻辑
    public function fastRegister(Request $request)
    {
        $tim = time();
        //将正常的时间格式转化为毫秒级的时间格式
        $newtim = $this->get_microtime_format($tim);//2018-07-17 09:03:39.000
        //将毫秒级时间格式转化为毫秒级的时间戳
        $netime = $this->get_data_format($newtim);//1531818148000
        session(['time'=>$netime]);
        $input=$request->all();
        logger()->debug('fast post form');
        $mobile = $input['tels']; // 手机号
        $sendCode = $input['mobile_confirm_codes']; // 短信验证码
        $confirm_code = $input['confirm_code']; // 图形验证码
        /** @var FlnetIotMemberApiService $flnetIotMemberApiService 大會員接口集成服務 */

        $flnetIotMemberApiService = App::make(FlnetIotMemberApiService::class);
        // 調用api/auth/fast-login快捷登录接口進行登入
        $registerApiInput = array(
            'mobile' =>$mobile,
            'mobile_country_code'=>'+86',
            'mobile_confirm_code' => $sendCode,
        );
        $flnetIotMemberApiService->loginFastRegister($registerApiInput['mobile'], $registerApiInput['mobile_confirm_code'], $registerApiInput);
        $registerResponse = $flnetIotMemberApiService->getResponse();
        $registerResponseArray = json_decode($registerResponse->getBody(), true);
        $iotToken = isset($registerResponseArray['access_token']) ? $registerResponseArray['access_token'] : NULL;

        if($confirm_code !== session('milkcaptcha'))
        {
            return Redirect::back()->withInput($input)->withErrors(['图形验证码验证失败！']);
        }
        else
        {
            // 若result_code為0或token為NULL，都代表第三方登入失敗，返回原頁面並提示錯誤提示
            if (!isset($registerResponseArray['result_code']) || $registerResponseArray['result_code'] == 0 || !$iotToken) {
                logger()->debug('fast login failed : ' . $registerResponseArray['message']);
                session(['newuserlogin' => 1]);
                return Redirect::back()->withInput($input)->withErrors([$registerResponseArray['message']]);
            }
            else
            {
                logger()->debug('$iotToken = ' . $iotToken);
                logger()->debug('user uuid = ' . $registerResponseArray['user']['uuid']);
                logger()->debug('fast login success');
                //根据用户的uuid获取所有设备资讯
                $uuidurl = config('flnet-iot-member.base_api_url') . "users/" . $registerResponseArray['user']['uuid'] . "/devices";
                $uuidresult = $this->doGet('Bearer ' . $iotToken, $uuidurl);
                $uuidres = json_decode($uuidresult, true);
                if (isset($uuidres['devices'])) {
                    session(['userdev' => $uuidres['devices']]);
                    if(session('userdev') &&  (session('binddevice5') !==1))
                    {
                        foreach($uuidres['devices'] as $v) {
                            if ($v['type'] == 5) {
                                $tim = time();
                                $pointClientId = config('wechat.official_account.default.point_client_id');
                                $pointClientSecret = config('wechat.official_account.default.point_client_secret');
                                session(['binddevice5' => 1]);
                                $pointUseruuid = $registerResponseArray['user']['uuid'];
                                $pointUserId = $registerResponseArray['user']['user_client']['user_id'];
                                $pointAccessToken = $registerResponseArray['access_token'];
                                $randNum3 = $this->GetRandStr(80);
                                $pointArr = array(
                                    'ticket' => $randNum3,
                                    'definition' => '绑定设备',
                                    'client_id' => config('wechat.official_account.default.point_client_id'),
                                    'client_secret' => config('wechat.official_account.default.point_client_secret'),
                                    'user_id' => $registerResponseArray['user']['user_client']['user_id'],
                                    'user_uuid' => $registerResponseArray['user']['uuid'],
                                    'user_name'=>$registerResponseArray['user']['nickname'],
                                    'access_token' => $registerResponseArray['access_token'],
                                    'bonus_point' => config('wechat.official_account.default.point_bind_device'),
                                );
                                $createPointResult = $this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                                $createPointRes = json_decode($createPointResult, true);
                                $points = config('wechat.official_account.default.point_bind_device');
                                $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum3,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定空气净化器设备','createtime'=>$tim]);

                            }
                        }
                    }
                    logger()->debug('device count = ' . count($uuidres['devices']));
                }
                session(['status' => 1]);//改变状态为1
                session(['mobile' => $registerResponseArray['user']['mobile']]);
                session(['pass' => $sendCode]);//默认密码第一次只有30分钟有效期
                session(['anotherMobile' => $registerResponseArray['user']['mobile']]);
                session(['useruuid' => $registerResponseArray['user']['uuid']]);
                session(['nickname' => $registerResponseArray['user']['nickname']]);
                session(['newimage'=>$registerResponseArray['user']['avatar']]);
                session(['pointUserId' => $registerResponseArray['user']['user_client']['user_id']]);
                session(['pointAccessToken' => $registerResponseArray['access_token']]);
                //用户首次快捷注册成功后新增20积分
                if(session('createPointStatus') !==1)
                {
                    $tim = time();
                    $pointClientId=config('wechat.official_account.default.point_client_id');
                    $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                    $pointUserId=$registerResponseArray['user']['user_client']['user_id'];
                    $pointUseruuid=session('useruuid');
                    $pointAccessToken=$registerResponseArray['access_token'];
                    session(['createPointStatus'=>1]);
                    $randNum4=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum4,
                        'definition'=>'首次登入奖励',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$registerResponseArray['user']['user_client']['user_id'],
                        'user_uuid'=>$registerResponseArray['user']['uuid'],
                        'user_name'=>$registerResponseArray['user']['nickname'],
                        'access_token'=>$registerResponseArray['access_token'],
                        'bonus_point'=>config('wechat.official_account.default.point_register_bounes'),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);
                    $points = config('wechat.official_account.default.point_bind_device');
                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum4,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>1,'bonus_point'=>$points,'orderid'=>'','definition'=>'快捷注册','createtime'=>$tim]);

                }
                // 註冊成功後，導向到管理頁面
                //调用大会员的mapping映射接口，获取到影视会员id
                $chrageResult=$this->doGet('Bearer ' . $iotToken,config('flnet-iot-member.base_api_url') . 'users/cms-search?user_uuid='.session('useruuid') );
                $chargeRes=json_decode($chrageResult,true);//获得影视会员的信息（包括 id,mobile,nickname);
                //判断是否是夏普影视会员result_code==1而且cms_user['id']存在即为会员
                if($chargeRes['result_code']==1 && $chargeRes['cms_user'])
                {
                    $chargeId = $chargeRes['cms_user']['id'];
                    $chargeTel = $chargeRes['cms_user']['mobile'];
                    $chargeNickName = $chargeRes['cms_user']['nickname'];//$chargeId就是影视会员ID
                    //获取到影视会员id，接下来就开始和kidd对接....................................//
                    if($chargeId)
                    {
                        session(['accountid'=>$chargeId]);
                        //赋值$chargeId
                        $accountid=$chargeId;
                        // $accountid = 'GIGDTDUMTHQKNVVLJPTO';
                        //先md5加密
                        $md5account_id = md5('accountId=' . $accountid);
                        // 使用私钥加密
                        openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
                        //base64以防乱码
                        $signature = base64_encode($encrypted);
                        //购买展示url
                        $movieRightUrl = config('wechat.official_account.default.display_url');
                        $movarray = array(
                            'accountId' => $accountid,
                        );
                        $movieArr = array(
                            'Data' => base64_encode(json_encode($movarray)),
                            'Signature' => $signature,
                        );


                        //recharge充值url
                        $moviePriceUrl = config('wechat.official_account.default.recharge_url');
                        $movieResults = json_encode($movieArr);
                        $movRess = $this->curl_movie($moviePriceUrl, $movieResults);
                        if($movRess!=='{}')
                        {
                            $newMovieRess = json_decode($movRess, true);
                            if(empty($newMovieRess['vipRight']))
                            {
                                session(['rechargeDisplay'=>'']);
                            }
                            else
                            {
                                session(['rechargeDisplay'=>$newMovieRess['vipRight']]);
                                if(session('rechargeDisplay') &&  (session('bindsharp') !==1))
                                {
                                    $tim = time();
                                    $pointClientId=config('wechat.official_account.default.point_client_id');
                                    $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                                    $pointUserId=$registerResponseArray['user']['user_client']['user_id'];
                                    session(['bindsharp'=>1]);
                                    $pointUseruuid=session('useruuid');
                                    $pointAccessToken=$registerResponseArray['access_token'];
                                    $randNum5=$this->GetRandStr(80);
                                    $pointArr=array(
                                        'ticket'=>$randNum5,
                                        'definition'=>'绑定设备',
                                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                                        'user_id'=>$registerResponseArray['user']['user_client']['user_id'],
                                        'user_uuid'=>$registerResponseArray['user']['uuid'],
                                        'user_name'=>$registerResponseArray['user']['nickname'],
                                        'access_token'=>$registerResponseArray['access_token'],
                                        'bonus_point'=>config('wechat.official_account.default.point_bind_device'),
                                    );
                                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                                    $createPointRes=json_decode($createPointResult,true);
                                    $points = config('wechat.official_account.default.point_bind_device');
                                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum5,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定夏普电视设备','createtime'=>$tim]);

                                }
                                foreach($newMovieRess['vipRight'] as $v)
                                {
                                    if($v['providerName']=='IQIYI' && $v['devices'])
                                    {
                                        $iqiyimac=$v['devices'][0]['mac'];$iqiyiprovider=$v['devices'][0]['provider'];$iqiyilimitdate=$v['devices'][0]['limitDate'];$iqiyimodel=$v['devices'][0]['model'];$iqiyideviceid=$v['devices'][0]['deviceId'];
                                        session(['iqiyimac'=>$iqiyimac]);session(['iqiyiprovider'=>$iqiyiprovider]);session(['iqiyilimitdate'=>$iqiyilimitdate]);session(['iqiyimodel'=>$iqiyimodel]);session(['iqiyideviceid'=>$iqiyideviceid]);
                                    }
                                    if($v['providerName']=='YOUKU' && $v['devices'])
                                    {
                                        $youkumac=$v['devices'][0]['mac'];$youkuprovider=$v['devices'][0]['provider'];$youkulimitdate=$v['devices'][0]['limitDate'];$youkumodel=$v['devices'][0]['model'];$youkudeviceid=$v['devices'][0]['deviceId'];
                                        session(['youkumac'=>$youkumac]);session(['youkuprovider'=>$youkuprovider]);session(['youkulimitdate'=>$youkulimitdate]);session(['youkumodel'=>$youkumodel]);session(['youkudeviceid'=>$youkudeviceid]);
                                    }
                                    if($v['providerName']=='BESTV:PPTV' && $v['devices'])
                                    {
                                        $pptvmac=$v['devices'][0]['mac'];$pptvprovider=$v['devices'][0]['provider'];$pptvlimitdate=$v['devices'][0]['limitDate'];$pptvmodel=$v['devices'][0]['model'];$pptvdeviceid=$v['devices'][0]['deviceId'];
                                        session(['pptvmac'=>$pptvmac]);session(['pptvprovider'=>$pptvprovider]);session(['pptvlimitdate'=>$pptvlimitdate]);session(['pptvmodel'=>$pptvmodel]);session(['pptvdeviceid'=>$pptvdeviceid]);
                                    }
                                    if($v['providerName']=='BESTV' && $v['devices'])
                                    {
                                        $bestvmac=$v['devices'][0]['mac'];$bestvprovider=$v['devices'][0]['provider'];$bestvlimitdate=$v['devices'][0]['limitDate'];$bestvmodel=$v['devices'][0]['model'];$bestvdeviceid=$v['devices'][0]['deviceId'];
                                        session(['bestvmac'=>$bestvmac]);session(['bestvprovider'=>$bestvprovider]);session(['bestvlimitdate'=>$bestvlimitdate]);session(['bestvmodel'=>$bestvmodel]);session(['bestvdeviceid'=>$bestvdeviceid]);
                                    }
                                }
                            }
                        }

                        $movieResult = json_encode($movieArr);
                        $movRes = $this->curl_movie($movieRightUrl, $movieResult);
                        if($movRes!=='{}')
                        {
                            $newMovieRes = json_decode($movRes, true);
                            if(empty($newMovieRes['vipRight']))
                            {
                                session(['res'=>'']);
                            }
                            else
                            {
                                session(['res'=>$newMovieRes['vipRight']]);
                            }
                        }

                        return redirect('newDisplay');
                    }
                    else
                    {
                        // return Redirect::to('newDisplay');
                        $data = ['res' => ''];
                        return redirect('newDisplay');
                    }
                }
                else
                {
                    $data = ['res' => ''];
                    return redirect('newDisplay');
                }
            }

        }

    }
    //返回展示首页方法
    public function reback()
    {
        //获取iot大会员的access_token
        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array (
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type'=>'client_credentials',
            'scope' =>'',
        );
        $newresult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token' , $postArr);
        $infos=json_decode($newresult,true);
        $iotToken="Bearer ".$infos['access_token'];//得到access_token
        //调用大会员的mapping映射接口，获取到影视会员id
        $chrageResult=$this->doGet($iotToken,config('flnet-iot-member.base_api_url') . 'users/cms-search?user_uuid='.session('useruuid') );
        $chargeRes=json_decode($chrageResult,true);//获得影视会员的信息（包括 id,mobile,nickname);
        //判断是否是夏普影视会员result_code==1而且cms_user['id']存在即为会员
        if($chargeRes['result_code']==1)
        {
            $chargeId = $chargeRes['cms_user']['id'];
            $chargeTel = $chargeRes['cms_user']['mobile'];
            $chargeNickName = $chargeRes['cms_user']['nickname'];//$chargeId就是影视会员ID
            //获取到影视会员id，接下来就开始和kidd对接....................................//
            if($chargeId)
            {
                //赋值$chargeId
                $accountid=$chargeId;
                //$accountid = 'GIGDTDUMTHQKNVVLJPTO';
                //先md5加密
                $md5account_id = md5('accountId=' . $accountid);
                // 使用私钥加密
                openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
                //base64以防乱码
                $signature = base64_encode($encrypted);
                //购买展示url
                $movieRightUrl = config('wechat.official_account.default.display_url');
                $movarray = array(
                    'accountId' => $accountid,
                );
                $movieArr = array(
                    'Data' => base64_encode(json_encode($movarray)),
                    'Signature' => $signature,
                );
                $movieResult = json_encode($movieArr);
                $movRes = $this->curl_movie($movieRightUrl, $movieResult);
                $newMovieRes = json_decode($movRes, true);session(['res'=>$newMovieRes['vipRight']]);
                $data=['res'=>session('res')];
                //return redirect('newDisplay');
                return view('display', $data);
            }
            else
            {
                $data = ['res' => ''];
                return view('display', $data);
            }
        }
        else
        {
            $data = ['res' => ''];
            return view('display', $data);
        }
    }
    //管理页面之夏普电视展示方法
    public function tvShow()
    {
        if (session('status') == 1)
        {
            return view('tvShow');
        }
        else
        {
            return redirect('newLogin');
        }
    }
    //管理页面之夏普空清展示方法
    public function airFresh()
    {
        if (session('status') == 1)
        {
            return view('airFresh');
        }
        else
        {
            return redirect('newLogin');
        }
    }
    //管理页面之手机展示方法
    public function mobileShow()
    {
        if (session('status') == 1) {
            return view('mobileShow');
        } else {
            return redirect('newLogin');
        }

    }
    //重定向到注册页面
    public function newRegister()
    {
        return view('register');
    }
    //显示昵称
    public function editnick()
    {
        return view('editnick');
    }
    //修改昵称
    public function nick()
    {
        $nick = $_POST['nick'];
        //获取iot大会员的access_token
        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array(
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials',
            'scope' => '',
        );
        $newResult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token', $postArr);
        $infos = json_decode($newResult, true);
        $iottoken = "Bearer " . $infos['access_token'];//得到access_token
        $puturl = config('flnet-iot-member.base_api_url') . "users/" . session('useruuid');
        $putarr = array(
            'nickname' => $nick,
        );
        $putresult = $this->curltwo($iottoken, $puturl, $putarr);
        $putres = json_decode($putresult, true);
        if ($putres['result_code'] == 1) {
            session(['nickname' => $nick]);
            return view('manage');//管理页面
        } else {
            return redirect('editnick');
        }

    }
    //忘记密码
    public function forgetPass()
    {
        return view('forget');
    }

    /**
     * 提交忘記密碼form
     * @param Request $requst
     * @return Redirect
     */
    public function forget(Request $requst)
    {
        $input = $requst->all();

        $mobile = $input['tel'];
        $mobileConfirmCode = $input['mobile_confirm_code'];

        session(['forget_password_mobile' => $mobile]);
        session(['forget_password_mobile_confirm_code' => $mobileConfirmCode]);

        /** @var FlnetIotMemberApiService $flnetIotMemberApiService 大會員接口集成服務 */
        $flnetIotMemberApiService = App::make(FlnetIotMemberApiService::class);
        // 調用api/sms/codes/{mobile}/validation/{code}驗證手機驗證碼
        $flnetIotMemberApiService->validateMobileConfirmCode(2, $mobileConfirmCode, $mobile);
        $response = $flnetIotMemberApiService->getResponse();
        $responseArray = json_decode($response->getBody(), true);

        // 若驗證簡訊發生錯誤
        if (!isset($responseArray['result_code']) || $responseArray['result_code'] == 0) {
            return Redirect::back()->withInput($input)->withErrors([$responseArray['message']]);
        }

        // 忘記密碼驗證手機驗證碼成功
        session(['forget_password_success' => 1]);

        // 成功後導向到重設密碼頁
        return redirect('resetpass');
    }
    //重设密码显示方法
    public function resetpass()
    {
        // 若沒有通過手機驗證碼驗證，則導向到忘記密碼頁面
        if (!session('forget_password_success')) {
            return redirect('forgetPass');
        }
        return view('reset');
    }
    //重设密码执行方法
    public function reset()
    {
        $newMob = session('forget_password_mobile');
        $newPass = $_POST['resetpassword'];
        $reseturl = config('flnet-iot-member.base_api_url') . "auth/passwords/reset";
        //获取大会员的access-token
        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array(
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials',
            'scope' => '',
        );
        $newresult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token', $postArr);
        $infos = json_decode($newresult, true);
        $iottoken = "Bearer " . $infos['access_token'];//得到access_token
        $psoa = array(
            'mobile' => $newMob,
            'mobile_confirm_code' => session('forget_password_mobile_confirm_code'),
            'password' => $newPass
        );

        $resres = $this->get_data($iottoken, $reseturl, $psoa);
        $newresres = json_decode($resres, true);
        if ($newresres['result_code'] == 1) {
            session(['xinone' => $newPass]);
            session(['mobile'=>$newMob]);
            session(['pass' => $newPass]);
            return redirect('newLogin');
        } else {
            echo "重置密码失败";
            return redirect('resetpass');
        }

    }

    //普通注册时发送短信验证码方法
    public function sendTelCode()
    {
        logger()->debug('send confirm code');

        //根据手机号发送验证码
        $mobile = $_GET['tel'];
        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array(
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials',
            'scope' => '',
        );
        $newresult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token', $postArr);
        logger()->debug('send confirm code url = ' . config('flnet-iot-member.base_api_url') . 'oauth/token');
        $infos = json_decode($newresult, true);
        $iottoken = "Bearer " . $infos['access_token'];

        $smsurl = config('flnet-iot-member.base_api_url') . "sms/codes/" . $mobile;
        $smsarr = array(
            'type' => '1',
            'mobile_country_code' => '+86',
        );
        $unres = $this->get_data($iottoken, $smsurl, $smsarr);
        $unress = json_decode($unres, true);
        session(['result_code' => $unress['result_code']]);
        if ($unress['result_code'] == 1) {
            return $unress;
        } else {
            return $unress;
        }

    }
    //快捷注册时发送短信验证码方法
    public function sendFastTelCode()
    {
        logger()->debug('send confirm code');

        //根据手机号发送验证码
        $mobile = $_GET['tel'];
        $captcha=$_GET['captcha'];

        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array(
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials',
            'scope' => '',
        );
        $newresult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token', $postArr);
        logger()->debug('send confirm code url = ' . config('flnet-iot-member.base_api_url') . 'oauth/token');
        $infos = json_decode($newresult, true);
        $iottoken = "Bearer " . $infos['access_token'];

        $smsurl = config('flnet-iot-member.base_api_url') . "sms/codes/" . $mobile;
        $smsarr = array(
            'type' => '14',
            'mobile_country_code' => '+86',
            'captcha'=>$captcha
        );
        $unres = $this->get_data($iottoken, $smsurl, $smsarr);
        $unress = json_decode($unres, true);
        session(['result_code' => $unress['result_code']]);
        if ($unress['result_code'] == 1) {
            return $unress;
        } else {
            return $unress;
        }

    }
    //忘记密码时发送短信验证码的方法
    public function sendTelCodeForget()
    {
        logger()->debug('sendTelCodeForget');
        //根据手机号发送验证码
        $mobile = $_GET['tel'];
        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array(
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials',
            'scope' => '',
        );
        $newresult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token', $postArr);
        $infos = json_decode($newresult, true);
        $iottoken = "Bearer " . $infos['access_token'];
        $smsurl = config('flnet-iot-member.base_api_url') . "sms/codes/" . $mobile;
        $smsarr = array(
            'type' => '2',
            'mobile_country_code' => '+86',
        );
        $unres = $this->get_data($iottoken, $smsurl, $smsarr);
        $unress = json_decode($unres, true);
        session(['result_code' => $unress['result_code']]);
        if ($unress['result_code'] == 1) {
            return $unress;
        } else {
            return $unress;
        }
    }
    //用户退出登录后会跳转到本地的display页面
    public function returnUrl()
    {
        session(['status'=>0]);
        return view('newdisplay');
    }
    public function succUrl()
    {
        return view('newdisplay');
    }
    //点击会员服务菜单时的执行方法
    public function zhuce()
    {
        $broker=new Broker(config('wechat.sso.default.sso_server'),config('wechat.sso.default.sso_broker_id'),config('wechat.sso.default.sso_broker_secret'));
        $broker->attach(true);
        //获取用户的信息
        $userinfo=$broker->getUserInfo();
        //未取得用户资料，将导向至大会员的登录页面
        if(empty($userinfo))
        {
            //没有用户信息时
            /*$action='login';
            //产生本地登录的return_url;
            $localLoginUrl='http://'.$_SERVER['HTTP_HOST']."/newDisplay";
            //生成bid
            $sessionId=$broker->getSessionId();
            $encoded=$broker->encode($sessionId,'flnet-sso');
            $params=[
                'redirect_url'=>$localLoginUrl,
                'bid'=>$encoded,
            ];
            $url=config('wechat.sso.default.sso_server').'/'.$action.'?'.http_build_query($params);
            header('Location:'.$url);
            exit();*/
            return redirect('returnUrl');
        }
        //已取得用户资料
        else
        {
            //设置项目所需要的各种session值
            session(['status' => 1]);//改变状态为1
            session(['mobile' => $userinfo->mobile]);
            session(['wxnickname' => $userinfo->name]);
            session(['anotherMobile' => $userinfo->mobile]);
            session(['useruuid' => $userinfo->uuid]);
            session(['nickname' => $userinfo->nickname]);
            session(['newimage'=>$userinfo->avatar]);
            session(['pointUserId' => $userinfo->id]);
            session(['pointAccessToken' => $userinfo->access_token]);
            //公共参数
            $tim = time();
            $pointClientId = config('wechat.official_account.default.point_client_id');
            $pointClientSecret = config('wechat.official_account.default.point_client_secret');
            $pointUserId=$userinfo->id;
            $pointUseruuid=session('useruuid');
            $pointAccessToken=$userinfo->access_token;
            //用户首次登录成功后新增20积分
            if(session('createPointStatus') !== 1)
            {
                session(['createPointStatus'=>1]);
                $randNum52=$this->GetRandStr(80);
                $pointArr52=array(
                    'ticket'=>$randNum52,
                    'definition'=>'首次登入奖励',
                    'client_id'=>config('wechat.official_account.default.point_client_id'),
                    'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                    'user_id'=>$userinfo->id,
                    'user_uuid'=>$userinfo->uuid,
                    'user_name'=>$userinfo->nickname,
                    'access_token'=>$userinfo->access_token,
                    'bonus_point'=>config('wechat.official_account.default.point_register_bounes'),
                );
                $createPointResult52=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr52);
                $createPointRes52=json_decode($createPointResult52,true);

                $points52 = config('wechat.official_account.default.point_bind_device');
                $results52=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum52,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>1,'bonus_point'=>$points52,'orderid'=>'','definition'=>'快捷登录','createtime'=>$tim]);
            }
            //根据用户的uuid获取所有设备资讯
            $uuidurl52 = config('flnet-iot-member.base_api_url') . "users/" . $userinfo->uuid . "/devices";
            $uuidresult52 = $this->doGet('Bearer ' . $userinfo->access_token, $uuidurl52);
            $uuidres52 = json_decode($uuidresult52, true);
            session(['userdev' => $uuidres52['devices']]);
            if(session('userdev') &&  (session('binddevice5') !==1))
            {
                foreach($uuidres52['devices'] as $v) {
                    if ($v['type'] == 5) {
                        session(['binddevice5' => 1]);
                        $randNum39 = $this->GetRandStr(80);
                        $pointArr39 = array(
                            'ticket' => $randNum39,
                            'definition' => '绑定设备',
                            'client_id' => config('wechat.official_account.default.point_client_id'),
                            'client_secret' => config('wechat.official_account.default.point_client_secret'),
                            'user_id' => $userinfo->id,
                            'user_uuid' => $userinfo->uuid,
                            'user_name'=>$userinfo->nickname,
                            'access_token' => $userinfo->access_token,
                            'bonus_point' => config('wechat.official_account.default.point_bind_device'),
                        );
                        $createPointResult39 = $this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr39);
                        $createPointRes39 = json_decode($createPointResult39, true);
                        $points39 = config('wechat.official_account.default.point_bind_device');
                        $results39=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum39,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points39,'orderid'=>'','definition'=>'绑定空气净化器设备','createtime'=>$tim]);
                    }
                }
            }
            //调用大会员的mapping映射接口，获取到影视会员id
            $chrageResult=$this->doGet('Bearer ' . $userinfo->access_token,config('flnet-iot-member.base_api_url') . 'users/cms-search?user_uuid='.session('useruuid') );
            $chargeRes=json_decode($chrageResult,true);//获得影视会员的信息（包括 id,mobile,nickname);
            //判断是否是夏普影视会员result_code==1而且cms_user['id']存在即为会员
            if($chargeRes['result_code']==1)
            {
                $chargeId = $chargeRes['cms_user']['id'];
                $chargeTel = $chargeRes['cms_user']['mobile'];
                $chargeNickName = $chargeRes['cms_user']['nickname'];//$chargeId就是影视会员ID
                //获取到影视会员id，接下来就开始和kidd对接....................................
                if($chargeId)
                {
                    session(['accountid'=>$chargeId]);
                    //赋值$chargeId
                    $accountid=$chargeId;
                    //先md5加密
                    $md5account_id = md5('accountId=' . $accountid);
                    // 使用私钥加密
                    openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
                    //base64以防乱码
                    $signature = base64_encode($encrypted);
                    //购买展示url
                    $movieRightUrl = config('wechat.official_account.default.display_url');
                    $movarray = array(
                        'accountId' => $accountid,
                    );
                    $movieArr = array(
                        'Data' => base64_encode(json_encode($movarray)),
                        'Signature' => $signature,
                    );

                    //recharge充值url
                    $moviePriceUrl = config('wechat.official_account.default.recharge_url');
                    $movieResults = json_encode($movieArr);
                    $movRess = $this->curl_movie($moviePriceUrl, $movieResults);
                    if($movRess!=='{}')
                    {
                        $newMovieRess = json_decode($movRess, true);

                        if(empty($newMovieRess['vipRight']))
                        {
                            session(['rechargeDisplay'=>'']);
                        }
                        else
                        {
                            session(['rechargeDisplay'=>$newMovieRess['vipRight']]);
                            if(session('rechargeDisplay') &&  (session('bindsharp') !==1))
                            {
                                session(['bindsharp'=>1]);
                                $randNum50=$this->GetRandStr(80);
                                $pointArr50=array(
                                    'ticket'=>$randNum50,
                                    'definition'=>'绑定设备',
                                    'client_id'=>config('wechat.official_account.default.point_client_id'),
                                    'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                                    'user_id'=>$userinfo->id,
                                    'user_uuid'=>$userinfo->uuid,
                                    'user_name'=>$userinfo->nickname,
                                    'access_token'=>$userinfo->access_token,
                                    'bonus_point'=>config('wechat.official_account.default.point_bind_device'),
                                );
                                $createPointResult50=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr50);
                                $createPointRes50=json_decode($createPointResult50,true);
                                $points50 = config('wechat.official_account.default.point_bind_device');
                                $results50=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum50,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points50,'orderid'=>'','definition'=>'绑定夏普电视设备','createtime'=>$tim]);

                            }
                            foreach($newMovieRess['vipRight'] as $v)
                            {
                                if($v['providerName']=='IQIYI' && $v['devices'])
                                {
                                    $iqiyimac=$v['devices'][0]['mac'];$iqiyiprovider=$v['devices'][0]['provider'];$iqiyilimitdate=$v['devices'][0]['limitDate'];$iqiyimodel=$v['devices'][0]['model'];$iqiyideviceid=$v['devices'][0]['deviceId'];
                                    session(['iqiyimac'=>$iqiyimac]);session(['iqiyiprovider'=>$iqiyiprovider]);session(['iqiyilimitdate'=>$iqiyilimitdate]);session(['iqiyimodel'=>$iqiyimodel]);session(['iqiyideviceid'=>$iqiyideviceid]);
                                }
                                if($v['providerName']=='YOUKU' && $v['devices'])
                                {
                                    $youkumac=$v['devices'][0]['mac'];$youkuprovider=$v['devices'][0]['provider'];$youkulimitdate=$v['devices'][0]['limitDate'];$youkumodel=$v['devices'][0]['model'];$youkudeviceid=$v['devices'][0]['deviceId'];
                                    session(['youkumac'=>$youkumac]);session(['youkuprovider'=>$youkuprovider]);session(['youkulimitdate'=>$youkulimitdate]);session(['youkumodel'=>$youkumodel]);session(['youkudeviceid'=>$youkudeviceid]);
                                }
                                if($v['providerName']=='BESTV:PPTV' && $v['devices'])
                                {
                                    $pptvmac=$v['devices'][0]['mac'];$pptvprovider=$v['devices'][0]['provider'];$pptvlimitdate=$v['devices'][0]['limitDate'];$pptvmodel=$v['devices'][0]['model'];$pptvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['pptvmac'=>$pptvmac]);session(['pptvprovider'=>$pptvprovider]);session(['pptvlimitdate'=>$pptvlimitdate]);session(['pptvmodel'=>$pptvmodel]);session(['pptvdeviceid'=>$pptvdeviceid]);
                                }
                                if($v['providerName']=='BESTV' && $v['devices'])
                                {
                                    $bestvmac=$v['devices'][0]['mac'];$bestvprovider=$v['devices'][0]['provider'];$bestvlimitdate=$v['devices'][0]['limitDate'];$bestvmodel=$v['devices'][0]['model'];$bestvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['bestvmac'=>$bestvmac]);session(['bestvprovider'=>$bestvprovider]);session(['bestvlimitdate'=>$bestvlimitdate]);session(['bestvmodel'=>$bestvmodel]);session(['bestvdeviceid'=>$bestvdeviceid]);
                                }
                            }
                        }
                    }

                    $movieResult = json_encode($movieArr);
                    $movRes = $this->curl_movie($movieRightUrl, $movieResult);
                    if($movRes!=='{}')
                    {
                        $newMovieRes = json_decode($movRes, true);
                        if(empty($newMovieRes['vipRight']))
                        {
                            session(['res'=>'']);
                        }
                        else
                        {
                            session(['res'=>$newMovieRes['vipRight']]);
                        }
                    }
                }
            }
            return redirect('succUrl');
        }

    }

    //开通自动续费功能方法及展示相关自动续费说明
    public function autoPay()
    {
        if ($_POST['tot']) {
            $tot = $_POST['tot'];
        } else {
            $tot = 19.8;
        }
        session(['tot'=>$tot]);
        return view('autoPay');
    }
    //跳转到自动续费处理页
    public function wxAutoPay()
    {
        $tim = time();
        //将正常的时间格式转化为毫秒级的时间格式
        $newtim = $this->get_microtime_format($tim);//2018-07-17 09:03:39.000
        //将毫秒级时间格式转化为毫秒级的时间戳
        $netime = $this->get_data_format($newtim);//1531818148000
        //将毫秒级的时间戳转化为正常的时间格式
        $newti = date('Y-m-d', $netime / 1000 + 8 * 60 * 60);//2018-07-17 17:03:12
        $subject = '富连网物联网智能家居';
        $currency_value = 1.00;
        $price = session('tot') * $currency_value;
        $price = number_format($price, 2, '.', '');
        $total_fee = $price * 100;session(['total'=>$total_fee]);
        $open_id=session('newopenid');
        #支付前的数据配置
        $reannumb = $this->randomkeys(4) . time() . $this->randomkeys(4);
        $orderid='ZNJJ' . $reannumb;
        //这里写统一下单语句
        $conf = $this->payconfig($orderid, $total_fee, '订单支付', $open_id);
        if (!$conf || $conf['return_code'] == 'FAIL') exit("<script>alert('对不起，微信支付接口调用错误!" . $conf['return_msg'] . "');history.go(-1);</script>");
        $this->orderid = $conf['prepay_id'];
        //生成页面调用参数
        $jsApiObj["appId"] = $conf['appid'];
        $timeStamp = time();
        $jsApiObj["timeStamp"] = "$timeStamp";
        $jsApiObj["nonceStr"] = $this->createNoncestr();
        $jsApiObj["package"] = "prepay_id=" . $conf['prepay_id'];
        $jsApiObj["signType"] = "MD5";
        $jsApiObj["paySign"] = $this->MakeSign($jsApiObj);
        $jsApi=json_encode($jsApiObj);
        $data=['jspay'=>$jsApi];
        return view('jspay',$data);
    }
    //自动续费付款处理页
    public function autoRenew()
    {
        $tim = time();
        //将正常的时间格式转化为毫秒级的时间格式
        $newtim = $this->get_microtime_format($tim);//2018-07-17 09:03:39.000
        //将毫秒级时间格式转化为毫秒级的时间戳
        $netime = $this->get_data_format($newtim);//1531818148000
        //将毫秒级的时间戳转化为正常的时间格式
        $newti = date('Y-m-d H:i:s', $netime / 1000 + 8 * 60 * 60);//2018-07-17 17:03:12
        //判断是否有包月价格
        if ($_POST['tot']) {
            $tot = $_POST['tot'];
        } else {
            $tot = 19.8;
        }
        $subject = '富连网物联网智能家居';
        $currency_value = 1.00;
        $price = $tot * $currency_value;
        $price = number_format($price, 2, '.', '');
        $total_fee = $price * 100;session(['total'=>$total_fee]);
        $open_id=session('newopenid');
        #支付前的数据配置
        $reannumb = $this->randomkeys(4) . time() . $this->randomkeys(4);
        $order_id='ZNJJ' . $reannumb;
        //这里写统一下单语句
        $conf = $this->payconfig($order_id, $total_fee, '订单支付', $open_id);
        if (!$conf || $conf['return_code'] == 'FAIL') exit("<script>alert('对不起，微信支付接口调用错误!" . $conf['return_msg'] . "');history.go(-1);</script>");
        $this->orderid = $conf['prepay_id'];
        //生成页面调用参数
        $jsApiObj["appId"] = $conf['appid'];
        $timeStamp = time();
        $jsApiObj["timeStamp"] = "$timeStamp";
        $jsApiObj["nonceStr"] = $this->createNoncestr();
        $jsApiObj["package"] = "prepay_id=" . $conf['prepay_id'];
        $jsApiObj["signType"] = "MD5";
        $jsApiObj["paySign"] = $this->MakeSign($jsApiObj);
        //return json_encode($jsApiObj);
        $jsApi=json_encode($jsApiObj);
        $data=['jspay'=>$jsApi];
        return view('jspay',$data);
    }
    //退款显示接口
    public function refunds()
    {
        return view('refunds');
    }
    //退款处理接口
    public function refund()
    {
        $inner_interface="http://open.fujinfu.cn:8888/aliwxpay/api/getway";
        /*
       $provider=$_POST['provider'];
       $orderid=$_POST['orderid'];
       $provider=$_POST['provider'];
       $mount=$_POST['refundamount'];
       $remark=$_POST['remark'];
       $paramss=array('orderid'=>$orderid,'refundamount'=>$mount,'remark'=>$remark);
       if($provider=='YOUKU')
       {
           $result=$this->checksign_INs($inner_interface,'refund',json_encode($paramss));
       }
       else
       {
           $result=$this->checksign_IN($inner_interface,'refund',json_encode($paramss));
       }*/
        $paramss=array('orderid'=>'ZNJJ027715407271637584','refundamount'=>'298.00','remark'=>'订单退款');
        $result=$this->checksign_IN($inner_interface,'refund',json_encode($paramss));echo "<pre>";print_r($result);die;

    }
    //非自动续费付款处理页，普通购买处理页
    public function notAutoRenew()
    {

        if ($_POST['packageid']) {
            $packageid = $_POST['packageid'];
        } else {
            $packageid = '';
        }
        session(['orderpackageid'=>$packageid]);
        $tim = time();
        //将正常的时间格式转化为毫秒级的时间格式
        $newtim = $this->get_microtime_format($tim);//2018-07-17 09:03:39.000
        //将毫秒级时间格式转化为毫秒级的时间戳
        $netime = $this->get_data_format($newtim);//1531818148000
        //将毫秒级的时间戳转化为正常的时间格式
        $newti = date('Y-m-d H:i:s', $netime / 1000 + 8 * 60 * 60);//2018-07-17 17:03:12
        session(['ctime'=>$newti]);
        session(['nettime'=>$netime]);
        //判断是否有包月价格
        if ($_POST['tot']) {
            $tot = $_POST['tot'];
        } else {
            $tot = 30;
        }
        if(session('orderprovider')=='IQIYI')
        {
            session(['rightName'=>'爱奇艺']);
        }
        if(session('orderprovider')=='YOUKU')
        {
            session(['rightName'=>'优酷']);
        }
        if(session('orderprovider')=='BESTV:PPTV')
        {
            session(['rightName'=>'百视通影视']);
        }
        if(session('orderprovider')=='BESTV')
        {
            session(['rightName'=>'百视通NBA']);
        }
        session(['total'=>$tot]);
        $subject = '富连网物联网智能家居';
        $currency_value = 1.00;
        $price = $tot * $currency_value;
        $price = number_format($price, 2, '.', '');session(['price'=>$price]);
        $total_fee = $price * 100;
        $open_id=session('newopenid');session(['total_fee'=>$total_fee]);
        #支付前的数据配置
        $reannumb = $this->randomkeys(4) . time() . $this->randomkeys(4);
        $orderid='ZNJJ' . $reannumb;
        session(['order_id'=>$orderid]);

        //先备份一份数据库在本地
        $order_id=session('order_id');
        $order_price=session('price');
        $order_provider=session('orderprovider');
        $order_model=session('ordermodel');
        $order_accountid=session('accountid');
        $order_deviceid=session('orderdeviceid');
        $order_openid=session('newopenid');
        $order_time=session('ctime');
        $order_packageid=session('orderpackageid');
        $results=DB::table('cancel_order')->insert(['orderid'=>$order_id,'ordertotal'=>$order_price,'packagename'=>$order_provider,'model'=>$order_model,'accountid'=>$order_accountid,'deviceid'=>$order_deviceid,'openid'=>$order_openid,'refundstatus'=>0,'createtime'=>$order_time]);
        //开始调用富之富订单接口
        $inner_interface="http://open.fujinfu.cn:8888/aliwxpay/api/getway";
        $paramss=array('orderid'=>session('order_id'),'orderamount'=>session('price'),'ordertime'=>date('Y-m-d H:i:s',time()),'remark'=>'您购买的是型号为'.session('ordermodel').'的'.session('rightName').'VIP权益','notifyurl'=>'https://vipaccount.flnet.com/fzfNotify');
        /*if(session('orderprovider')=='YOUKU')
        {
            $results=$this->checksign_INs($inner_interface,'qrcodepay',json_encode($paramss));
            if($results['resultcode'] && $results['result']['status']==1)
            {
                return redirect($results['result']['qrcode']);
            }
            else
            {
                echo"<script>alert('支付失败！');history.go(-1);</script>";
            }
        }
        else
        {
            $results=$this->checksign_IN($inner_interface,'qrcodepay',json_encode($paramss));
            if($results['resultcode'] && $results['result']['status']==1)
            {
                return redirect($results['result']['qrcode']);
            }
            else
            {
                echo"<script>alert('支付失败！');history.go(-1);</script>";
            }
        }*/
        $results=$this->checksign_IN($inner_interface,'qrcodepay',json_encode($paramss));
        if($results['resultcode'] && $results['result']['status']==1)
        {
            return redirect($results['result']['qrcode']);
        }
        else
        {
            echo"<script>alert('支付失败！');history.go(-1);</script>";
        }
    }
    public function GetRandStr($length)
    {
        $str='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len=strlen($str)-1;
        $randstr='';
        for($i=0;$i<$length;$i++){
            $num=mt_rand(0,$len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }
    //随机数产生接口
    public function random($num='16')
    {
        $a = range(0,9);
        for($i=0;$i<$num;$i++)
        {
            $b[] = array_rand($a);
        }
        return join("",$b);

    }
    /**
     * des-ecb加密
     * @param string  $data 要被加密的数据
     * @param string  $key 加密密钥(64位的字符串)
     */
    public function des_ecb_encrypt($data, $key){
        return openssl_encrypt ($data, 'des-ecb', $key);
    }

    /**
     * des-ecb解密
     * @param string  $data 加密数据
     * @param string  $key 加密密钥
     */
    public function des_ecb_decrypt ($data, $key)
    {
        return openssl_decrypt($data, 'des-ecb', $key);
    }
    //富之富加密接口
    public function aes_encode($message, $encodingaeskey = '', $appid = '') {
        $key = md5($encodingaeskey . '=');
        $text = $this->random(16) . pack("N", strlen($message)) . $message . $appid;
        $iv = substr($key, 0, 8);
        $block_size = 32;
        $text_length = strlen($text);
        $amount_to_pad = $block_size - ($text_length % $block_size);
        if ($amount_to_pad == 0) {
            $amount_to_pad = $block_size;
        }
        $pad_chr = chr($amount_to_pad);
        $tmp = '';
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        $text = $text . $tmp;
        $encrypted = openssl_encrypt($text, 'des-cbc', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
        $encrypt_msg = base64_encode($encrypted);
        return $encrypt_msg;
    }
    //富之富解密接口
    public function aes_decode($message, $encodingaeskey = '', $appid = '')
    {
        $key = md5($encodingaeskey . '=');
        $text=base64_decode($message);
        $iv = substr($key, 0, 8);
        $decrypted = openssl_decrypt($text, 'des-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        $decrypt_msg = base64_encode($decrypted);
        return $decrypt_msg;
    }
    /**
     * des-cbc加密
     * @param string  $data 要被加密的数据
     * @param string  $key 加密使用的key
     * @param string  $iv 初始向量
     */
    function des_cbc_encrypt($data, $key, $iv){
        return openssl_encrypt ($data, 'des-cbc', $key, 0, $iv);
    }

    /**
     * des-cbc解密
     * @param string  $data 加密数据
     * @param string  $key 加密使用的key
     * @param string  $iv 初始向量
     */
    function des_cbc_decrypt($data, $key, $iv){
        return openssl_decrypt ($data, 'des-cbc', $key, 0, $iv);
    }
    //富之富传参接口
    public function checksign_IN($url, $servicecode, $dataJson) {

        $pubKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap (config('wechat.official_account.default.fzf_publickey'), 64, "\n", true ) . "\n-----END PUBLIC KEY-----";
        $priKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap ( config('wechat.official_account.default.my_privatekey'), 64, "\n", true ) . "\n-----END RSA PRIVATE KEY-----";
        $rsaPubId = openssl_pkey_get_public ( $pubKey );//富之富公钥
        $rsaPriId = openssl_pkey_get_private ( $priKey );//商户自己的私钥
        // 1
        $desKey = strtoupper ( substr ( md5 ( rand () ), 0, 8 ) );
        // 2
        // $data = $this->des_ecb_encrypt ( $dataJson,$desKey,'');
        $data = $this->des_cbc_encrypt ( $dataJson,$desKey,$desKey);
        // 3
        openssl_public_encrypt ( $desKey, $encrypted, $rsaPubId );
        $key = base64_encode ( $encrypted );
        // 4
        $sign_arr = array ();
        $sign_arr ['version'] = '1';
        $sign_arr ['source'] = 'ANDROID';
        $sign_arr ['servicecode'] = $servicecode;
        $sign_arr ['openid'] = '18080001333835';//账户信息中的商户编号
        $sign_arr ['random'] = md5 ( rand () );

        $signGene = array (
            'version',
            'random',
            'source',
            'servicecode',
            'openid'
        );
        sort ( $signGene );
        $str = '';
        foreach ( $signGene as $val ) {
            $str .= $val . '=' . $sign_arr [$val];
        }
        //return $str;
        $md5_sign = md5 ( $str );
        openssl_sign ( $md5_sign, $signature, $rsaPriId );
        $sign = base64_encode ( $signature );

        // 5
        $sign_arr ["data"] = $data;
        $sign_arr ["sign"] = $sign;
        $sign_arr ["key"] = $key;
        $json_result = json_encode ( $sign_arr );
        $json_result = str_replace ( "\/", "/", $json_result );
        $curl_data = "fzfContent=".$json_result;
        $curl_data=str_replace("+","%2B",$curl_data);
        // 6
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curl_data );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 ); // 超时时间
        $content = curl_exec ( $ch );
        curl_close ( $ch );
        $re= json_decode ( $content ,true);
        return $re;

    }
    public function checksign_INs($url, $servicecode, $dataJson) {

        $pubKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap (config('wechat.official_account.default.newfzf_publickey'), 64, "\n", true ) . "\n-----END PUBLIC KEY-----";
        $priKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap ( config('wechat.official_account.default.newmy_privatekey'), 64, "\n", true ) . "\n-----END RSA PRIVATE KEY-----";
        $rsaPubId = openssl_pkey_get_public ( $pubKey );//富之富公钥
        $rsaPriId = openssl_pkey_get_private ( $priKey );//商户自己的私钥
        // 1
        $desKey = strtoupper ( substr ( md5 ( rand () ), 0, 8 ) );
        // 2
        // $data = $this->des_ecb_encrypt ( $dataJson,$desKey,'');
        $data = $this->des_cbc_encrypt ( $dataJson,$desKey,$desKey);
        // 3
        openssl_public_encrypt ( $desKey, $encrypted, $rsaPubId );
        $key = base64_encode ( $encrypted );
        // 4
        $sign_arr = array ();
        $sign_arr ['version'] = '1';
        $sign_arr ['source'] = 'ANDROID';
        $sign_arr ['servicecode'] = $servicecode;
        $sign_arr ['openid'] = '17060000228571';//账户信息中的商户编号
        $sign_arr ['random'] = md5 ( rand () );

        $signGene = array (
            'version',
            'random',
            'source',
            'servicecode',
            'openid'
        );
        sort ( $signGene );
        $str = '';
        foreach ( $signGene as $val ) {
            $str .= $val . '=' . $sign_arr [$val];
        }
        //return $str;
        $md5_sign = md5 ( $str );
        openssl_sign ( $md5_sign, $signature, $rsaPriId );
        $sign = base64_encode ( $signature );

        // 5
        $sign_arr ["data"] = $data;
        $sign_arr ["sign"] = $sign;
        $sign_arr ["key"] = $key;
        $json_result = json_encode ( $sign_arr );
        $json_result = str_replace ( "\/", "/", $json_result );
        $curl_data = "fzfContent=".$json_result;
        $curl_data=str_replace("+","%2B",$curl_data);
        // 6
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curl_data );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 ); // 超时时间
        $content = curl_exec ( $ch );
        curl_close ( $ch );
        $re= json_decode ( $content ,true);
        return $re;

    }
    //富之富支付回调传参接口
    public function fzfpaynotify($url, $servicecode, $dataJson) {

        $pubKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap (config('wechat.official_account.default.my_publickey'), 64, "\n", true ) . "\n-----END PUBLIC KEY-----";
        $priKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap ( config('wechat.official_account.default.my_privatekey'), 64, "\n", true ) . "\n-----END RSA PRIVATE KEY-----";
        $rsaPubId = openssl_pkey_get_public ( $pubKey );//商户自己的公钥
        $rsaPriId = openssl_pkey_get_private ( $priKey );//富之富的私钥
        // 1
        $desKey = strtoupper ( substr ( md5 ( rand () ), 0, 8 ) );
        // 2
        // $data = $this->des_ecb_encrypt ( $dataJson,$desKey,'');
        $data = $this->des_cbc_encrypt ( $dataJson,$desKey,$desKey);
        // 3
        openssl_public_encrypt ( $desKey, $encrypted, $rsaPubId );
        $key = base64_encode ( $encrypted );
        // 4
        $sign_arr = array ();
        $sign_arr ['version'] = '1';
        $sign_arr ['source'] = 'ANDROID';
        $sign_arr ['servicecode'] = $servicecode;
        $sign_arr ['openid'] = '18080001333835';//账户信息中的商户编号
        $sign_arr ['random'] = md5 ( rand () );

        $signGene = array (
            'version',
            'random',
            'source',
            'servicecode',
            'openid'
        );
        sort ( $signGene );
        $str = '';
        foreach ( $signGene as $val ) {
            $str .= $val . '=' . $sign_arr [$val];
        }
        //return $str;
        $md5_sign = md5 ( $str );
        openssl_sign ( $md5_sign, $signature, $rsaPriId );
        $sign = base64_encode ( $signature );

        // 5
        $sign_arr ["data"] = $data;
        $sign_arr ["sign"] = $sign;
        $sign_arr ["key"] = $key;
        $json_result = json_encode ( $sign_arr );
        $json_result = str_replace ( "\/", "/", $json_result );
        $curl_data = "fzfContent=".$json_result;
        $curl_data=str_replace("+","%2B",$curl_data);
        // 6
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curl_data );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 ); // 超时时间
        $content = curl_exec ( $ch );
        curl_close ( $ch );
        $re= json_decode ( $content ,true);
        return $re;

    }
    public function skipUrl()
    {
        if($_GET['type']==2)
        {
            return redirect('http://ali-vipman.flnet.com');
        }
        /*else
        {
            return redirect('http://iot.flnet.com');
        }*/
    }
    //富之富支付回调
    public function fzfNotify()
    {
        //支付查询结果
        $inner_interface="http://open.fujinfu.cn:8888/aliwxpay/api/getway";
        $params=array('orderid'=>session('order_id'));
       /* if(session('orderprovider')=='YOUKU')
        {
            $result=$this->checksign_INs($inner_interface,'PayQuery',json_encode($params));
        }
        else
        {
            $result=$this->checksign_IN($inner_interface,'PayQuery',json_encode($params));
        }*/
        $result=$this->checksign_IN($inner_interface,'PayQuery',json_encode($params));
        if($result['resultcode']==1 && $result['result'])
        {
            if(($result['result']['orderstatus']==1)  && ($result['result']['status']==1))
            {
                $order_id=session('order_id');
                $order_price=session('price');
                $order_provider=session('orderprovider');
                $order_model=session('ordermodel');
                $order_accountid=session('accountid');
                $order_deviceid=session('orderdeviceid');
                $order_openid=session('newopenid');
                $order_time=session('ctime');
                $order_packageid=session('orderpackageid');

                //更新显示账号权益信息
                //display展示url
                $md5account_id = md5('accountId=' . $order_accountid);
                // 使用私钥加密
                openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
                //base64以防乱码
                $signature = base64_encode($encrypted);
                $movieDisplayUrl = config('wechat.official_account.default.display_url');
                $movarray = array(
                    'accountId' => $order_accountid,
                );
                $movieArr = array(
                    'Data' => base64_encode(json_encode($movarray)),
                    'Signature' => $signature,
                );
                $movieResult = json_encode($movieArr);
                $movRes = $this->curl_movie($movieDisplayUrl, $movieResult);
                if($movRes!=='{}')
                {
                    $newMovieRess = json_decode($movRes, true);
                    if(empty($newMovieRess['vipRight']))
                    {
                        session(['res' =>'']);
                    }
                    else
                    {
                        session(['res' => $newMovieRess['vipRight']]);
                    }
                }
                $results=DB::table('cancel_order')->insert(['orderid'=>$order_id,'ordertotal'=>$order_price,'packagename'=>$order_provider,'model'=>$order_model,'accountid'=>$order_accountid,'deviceid'=>$order_deviceid,'openid'=>$order_openid,'refundstatus'=>1,'createtime'=>$order_time]);
                //支付成功后获得相应的积分，获得积分如下：
                $platformParam=config('wechat.official_account.default.platform_param');$succParam=config('wechat.official_account.default.point_return_param');

                if($order_provider=='IQIYI')
                {
                    $iqiyiIntegration=$order_price*$platformParam*$succParam;
                    $tim = time();
                    $pointClientId=config('wechat.official_account.default.point_client_id');
                    $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                    $pointUserId=session('pointUserId');
                    $pointUseruuid=session('useruuid');
                    $pointAccessToken=session('pointAccessToken');
                    $randNum6=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum6,
                        'definition'=>'vip影视充值权益',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$pointUserId,
                        'user_uuid'=>$pointUseruuid,
                        'user_name'=>session('nickname'),
                        'access_token'=>$pointAccessToken,
                        'bonus_point'=>round($iqiyiIntegration),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);

                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum6,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>5,'bonus_point'=>$iqiyiIntegration,'orderid'=>$order_id,'definition'=>'购买爱奇艺影视权益','createtime'=>$tim]);
                }
                if($order_provider=='YOUKU')
                {
                    $youkuIntegration=$order_price*$platformParam*$succParam;
                    $tim = time();
                    $pointClientId=config('wechat.official_account.default.point_client_id');
                    $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                    $pointUserId=session('pointUserId');
                    $pointUseruuid=session('useruuid');
                    $pointAccessToken=session('pointAccessToken');
                    $randNum7=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum7,
                        'definition'=>'vip影视充值权益',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$pointUserId,
                        'user_uuid'=>$pointUseruuid,
                        'user_name'=>session('nickname'),
                        'access_token'=>$pointAccessToken,
                        'bonus_point'=>round($youkuIntegration),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);

                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum7,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>5,'bonus_point'=>$youkuIntegration,'orderid'=>$order_id,'definition'=>'购买优酷影视权益','createtime'=>$tim]);
                }
                if($order_provider=='BESTV:PPTV')
                {
                    $pptvIntegration=$order_price*$platformParam*$succParam;
                    $tim = time();
                    $pointClientId=config('wechat.official_account.default.point_client_id');
                    $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                    $pointUserId=session('pointUserId');
                    $pointUseruuid=session('useruuid');
                    $pointAccessToken=session('pointAccessToken');
                    $randNum8=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum8,
                        'definition'=>'vip影视充值权益',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$pointUserId,
                        'user_uuid'=>$pointUseruuid,
                        'user_name'=>session('nickname'),
                        'access_token'=>$pointAccessToken,
                        'bonus_point'=>round($pptvIntegration),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);

                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum8,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>5,'bonus_point'=>$pptvIntegration,'orderid'=>$order_id,'definition'=>'购买百视通影视权益','createtime'=>$tim]);
                }
                if($order_provider=='BESTV')
                {
                    $bestvIntegration=$order_price*$platformParam*$succParam;
                    $tim = time();
                    $pointClientId=config('wechat.official_account.default.point_client_id');
                    $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                    $pointUserId=session('pointUserId');
                    $pointUseruuid=session('useruuid');
                    $pointAccessToken=session('pointAccessToken');
                    $randNum9=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum9,
                        'definition'=>'vip影视充值权益',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$pointUserId,
                        'user_uuid'=>$pointUseruuid,
                        'user_name'=>session('nickname'),
                        'access_token'=>$pointAccessToken,
                        'bonus_point'=>round($bestvIntegration),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);

                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum9,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>5,'bonus_point'=>$bestvIntegration,'orderid'=>$order_id,'definition'=>'购买百视通NBA权益','createtime'=>$tim]);
                }

                //将正常的时间格式转化为毫秒级的时间格式
                $tis=strtotime($result['result']['payendtime']);
                $newtim = $this->get_microtime_format($tis);//2018-07-17 09:03:39.000
                //将毫秒级时间格式转化为毫秒级的时间戳
                $netime = $this->get_data_format($newtim);//1531818148000
                //先md5加密
                $Encode = md5('accountID='.$order_accountid.'deviceID='.$order_deviceid.'orderID=' . $order_id.'packageID='.$order_packageid.'payOrderNO='.$result['result']['fzforderid'].'payTime='.$netime);
                // 使用私钥加密
                openssl_sign($Encode, $encrypted, config('wechat.official_account.default.private_key'));
                //base64以防乱码
                $signature = base64_encode($encrypted);
                //价格展示url
                $moviePriceUrl = config('wechat.official_account.default.order_url');
                $movarray = array(
                    'orderID' => $order_id,
                    'packageID'=>$order_packageid,
                    'accountID'=>$order_accountid,
                    'deviceID'=>$order_deviceid,
                    'payOrderNO'=>$result['result']['fzforderid'],
                    'payTime'=>$netime,
                );
                $movieArr = array(
                    'Data' => base64_encode(json_encode($movarray)),
                    'Signature' => $signature,
                );
                $movieResult = json_encode($movieArr);
                $movRes = $this->curl_movie($moviePriceUrl, $movieResult);
                $res = json_decode($movRes, true);
                return redirect('newDisplay');
            }

        }


    }
    //微信公众号支付回调
    public function actionNotifyurl()
    {
        $url="https://api.mch.weixin.qq.com/pay/orderquery";
        $appid = config('wechat.official_account.default.app_id');
        $mchid = '1486243732';
        $data['appid'] = $appid;
        $data['mch_id'] = $mchid; //商户号
        $data['out_trade_no'] =session('order_id');
        $data['nonce_str'] = $this->createNoncestr();
        $data['sign'] = $this->MakeSign($data);
        $xml = $this->ToXml($data);
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        //设置header
        curl_setopt($curl, CURLOPT_HEADER, FALSE);

        //要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POST, TRUE); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        $tmpInfo = curl_exec($curl); // 执行操作
        curl_close($curl); // 关闭CURL会话
        $arr = $this->FromXml($tmpInfo);
        return redirect('newDisplay');
        //这里修改状态
        //exit('SUCCESS');  //不能去掉
    }
    //调取微信支付弹窗显示页
    public function jspay()
    {
        return view('jspay');
    }
    //支付回调通知页
    public function notify()
    {
        return redirect('newDisplay');
    }
    #微信JS支付参数获取#
    protected function payconfig($no, $fee, $body, $open_id)
    {
        $appid = config('wechat.official_account.default.app_id');
        $mchid = '1486243732';
        $openid = $open_id;
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $data['appid'] = $appid;
        $data['mch_id'] = $mchid; //商户号
        $data['device_info'] = 'WEB';
        $data['body'] = $body;
        $data['out_trade_no'] = $no; //订单号
        $data['total_fee'] = $fee; //金额
        $data['spbill_create_ip'] = $_SERVER["REMOTE_ADDR"];
        $data['notify_url'] = "https://vipaccount.flnet.com/actionNotifyurl";           //通知url
        $data['trade_type'] = 'JSAPI';
        $data['openid'] = $openid;   //获取openid
        $data['nonce_str'] = $this->createNoncestr();
        $data['sign'] = $this->MakeSign($data);
        $xml = $this->ToXml($data);
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POST, TRUE); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        $tmpInfo = curl_exec($curl); // 执行操作
        curl_close($curl); // 关闭CURL会话
        $arr = $this->FromXml($tmpInfo);
        return $arr;
    }
    //点击VIP充值按钮时判断进入哪个页面，是首次连续包月还是已经包月
    public function pay()
    {
        if('未连续包月')
        {
            return redirect('notPayMonth');
        }
        else
        {
            return redirect('payMonth');
        }
    }
    public function iqiyis()
    {

        if(1)
        {
            //拼接变量规则
            $iqiyi='IQIYI';
            //先md5加密
            $iqiyiEncode = md5('Site=' . $iqiyi);
            // 使用私钥加密
            openssl_sign($iqiyiEncode, $encrypted, config('wechat.official_account.default.private_key'));
            //base64以防乱码
            $signature = base64_encode($encrypted);
            //价格展示url
            $moviePriceUrl = config('wechat.official_account.default.price_url');
            $movarray = array(
                'Site' => 'IQIYI',
            );
            $movieArr = array(
                'Data' => base64_encode(json_encode($movarray)),
                'Signature' => $signature,
            );
            $movieResult = json_encode($movieArr);
            $movRes = $this->curl_movie($moviePriceUrl, $movieResult);
            $newMovieRes = json_decode($movRes, true);echo "<pre>";print_r($newMovieRes);die;

        }
        else
        {
            $data = ['res' => '','yuePrice'=>'','yueMonth'=>'','yueName'=>'','jiPrice'=>'','jiMonth'=>'','jiName'=>'','yzPrice'=>'','jzPrice'=>'','hzPrice'=>'','nzPrice'=>'',
                'halfYearPrice'=>'','halfYearMonth'=>'','halfYearName'=>'','yearPrice'=>'','yearMonth'=>'','yearName'=>'','yuePackageId'=>'','jiPackageId'=>'','halfPackageId'=>'','yearPackageId'=>'',];
            return view('iqiyi', $data);
        }
    }

    public function iqiyi()
    {

        if(session('status'))
        {
            //拼接变量规则
            $iqiyi='IQIYI';
            //先md5加密
            $iqiyiEncode = md5('Site=' . $iqiyi);
            // 使用私钥加密
            openssl_sign($iqiyiEncode, $encrypted, config('wechat.official_account.default.private_key'));
            //base64以防乱码
            $signature = base64_encode($encrypted);
            //价格展示url
            $moviePriceUrl = config('wechat.official_account.default.price_url');
            $movarray = array(
                'Site' => 'IQIYI',
            );
            $movieArr = array(
                'Data' => base64_encode(json_encode($movarray)),
                'Signature' => $signature,
            );
            $movieResult = json_encode($movieArr);
            $movRes = $this->curl_movie($moviePriceUrl, $movieResult);
            $newMovieRes = json_decode($movRes, true);
            if($newMovieRes['pacakageList'])
            {
                foreach($newMovieRes['pacakageList'] as $v)
                {
                    if($v['fsk_package_provider']=='IQIYI' && ($v['fsk_package_month']==1))
                    {
                        $yuePrice=$v['fsk_package_price']/100;$yueMonth=$v['fsk_package_month'];$yueName=$v['fsk_package_name'];$yuePackageId=$v['fsk_package_id'];$yzPrice=round(1.5*$yuePrice);
                    }
                    if($v['fsk_package_provider']=='IQIYI' && ($v['fsk_package_month']==3))
                    {
                        $jiPrice=$v['fsk_package_price']/100;$jiMonth=$v['fsk_package_month'];$jiName=$v['fsk_package_name'];$jiPackageId=$v['fsk_package_id'];$jzPrice=round(1.5*$jiPrice);
                    }
                    if($v['fsk_package_provider']=='IQIYI' && ($v['fsk_package_month']==6))
                    {
                        $halfYearPrice=$v['fsk_package_price']/100;$halfYearMonth=$v['fsk_package_month'];$halfYearName=$v['fsk_package_name'];$halfPackageId=$v['fsk_package_id'];$hzPrice=round(1.5*$halfYearPrice);
                    }
                    if($v['fsk_package_provider']=='IQIYI' && ($v['fsk_package_month']==12))
                    {
                        $yearPrice=$v['fsk_package_price']/100;$yearMonth=$v['fsk_package_month'];$yearName=$v['fsk_package_name'];$yearPackageId=$v['fsk_package_id'];$nzPrice=round(1.5*$yearPrice);
                    }
                }
            }
            else
            {
                $newMovieRes['pacakageList']=''; $yuePrice='';$yueMonth='';$yueName='';$yuePackageId=''; $jiPrice='';$jiMonth='';$jiName='';$jiPackageId='';$halfYearPrice='';$halfYearMonth='';$halfYearName=''; $halfPackageId='';$yearPrice='';$yearMonth='';$yearName='';$yearPackageId='';$yzPrice='';$jzPrice='';$hzPrice='';$nzPrice='';
            }
            $ordermac=session('iqiyimac');session(['ordermac'=>$ordermac]);$orderprovider=session(['orderprovider'=>session('iqiyiprovider')]);$orderlimitdate=session(['orderlimitdate'=>session('iqiyilimitdate')]);$ordermodel=session(['ordermodel'=>session('iqiyimodel')]);$orderdeviceid=session(['orderdeviceid'=>session('iqiyideviceid')]);
            $data = ['res' => $newMovieRes['pacakageList'],'yuePrice'=>$yuePrice,'yueMonth'=>$yueMonth,'yueName'=>$yueName,'yzPrice'=>$yzPrice,'jiPrice'=>$jiPrice,'jiMonth'=>$jiMonth,'jiName'=>$jiName,'jzPrice'=>$jzPrice,
                'halfYearPrice'=>$halfYearPrice,'halfYearMonth'=>$halfYearMonth,'halfYearName'=>$halfYearName,'hzPrice'=>$hzPrice,'yearPrice'=>$yearPrice,'yearMonth'=>$yearMonth,'yearName'=>$yearName,'nzPrice'=>$nzPrice,'yuePackageId'=>$yuePackageId,'jiPackageId'=>$jiPackageId,'halfPackageId'=>$halfPackageId,'yearPackageId'=>$yearPackageId,];
            return view('iqiyi', $data);
        }
        else
        {
            $data = ['res' => '','yuePrice'=>'','yueMonth'=>'','yueName'=>'','jiPrice'=>'','jiMonth'=>'','jiName'=>'','yzPrice'=>'','jzPrice'=>'','hzPrice'=>'','nzPrice'=>'',
                'halfYearPrice'=>'','halfYearMonth'=>'','halfYearName'=>'','yearPrice'=>'','yearMonth'=>'','yearName'=>'','yuePackageId'=>'','jiPackageId'=>'','halfPackageId'=>'','yearPackageId'=>'',];
            return view('iqiyi', $data);
        }
    }
    public function youku()
    {
        if(session('status'))
        {
            //拼接变量规则
            $youku='YOUKU';
            //先md5加密
            $youkuEncode = md5('Site=' . $youku);
            // 使用私钥加密
            openssl_sign($youkuEncode, $encrypted, config('wechat.official_account.default.private_key'));
            //base64以防乱码
            $signature = base64_encode($encrypted);
            //价格展示url
            $moviePriceUrl = config('wechat.official_account.default.price_url');
            $movarray = array(
                'Site' => 'YOUKU',
            );
            $movieArr = array(
                'Data' => base64_encode(json_encode($movarray)),
                'Signature' => $signature,
            );
            $movieResult = json_encode($movieArr);
            $movRes = $this->curl_movie($moviePriceUrl, $movieResult);
            $newMovieRes = json_decode($movRes, true);
            if($newMovieRes['pacakageList'])
            {
                foreach($newMovieRes['pacakageList'] as $v)
                {
                    if($v['fsk_package_provider']=='YOUKU' && ($v['fsk_package_month']==1))
                    {
                        $yuePrice=$v['fsk_package_price']/100;$yueMonth=$v['fsk_package_month'];$yueName=$v['fsk_package_name'];$yuePackageId=$v['fsk_package_id'];$yzPrice=round(1.5*$yuePrice);
                    }
                    if($v['fsk_package_provider']=='YOUKU' && ($v['fsk_package_month']==3))
                    {
                        $jiPrice=$v['fsk_package_price']/100;$jiMonth=$v['fsk_package_month'];$jiName=$v['fsk_package_name'];$jiPackageId=$v['fsk_package_id'];$jzPrice=round(1.5*$jiPrice);
                    }
                    if($v['fsk_package_provider']=='YOUKU' && ($v['fsk_package_month']==6))
                    {
                        $halfYearPrice=$v['fsk_package_price']/100;$halfYearMonth=$v['fsk_package_month'];$halfYearName=$v['fsk_package_name'];$halfPackageId=$v['fsk_package_id'];$hzPrice=round(1.5*$halfYearPrice);
                    }
                    if($v['fsk_package_provider']=='YOUKU' && ($v['fsk_package_month']==12))
                    {
                        $yearPrice=$v['fsk_package_price']/100;$yearMonth=$v['fsk_package_month'];$yearName=$v['fsk_package_name'];$yearPackageId=$v['fsk_package_id'];$nzPrice=round(1.5*$yearPrice);
                    }
                }
            }

            else
            {
                $newMovieRes['pacakageList']=''; $yuePrice='';$yueMonth='';$yueName='';$yuePackageId=''; $jiPrice='';$jiMonth='';$jiName='';$jiPackageId='';$halfYearPrice='';$halfYearMonth='';$halfYearName=''; $halfPackageId='';$yearPrice='';$yearMonth='';$yearName='';$yearPackageId='';$yzPrice='';$jzPrice='';$hzPrice='';$nzPrice='';
            }
            $ordermac=session(['ordermac'=>session('youkumac')]);$orderprovider=session(['orderprovider'=>session('youkuprovider')]);$orderlimitdate=session(['orderlimitdate'=>session('youkulimitdate')]);$ordermodel=session(['ordermodel'=>session('youkumodel')]);$orderdeviceid=session(['orderdeviceid'=>session('youkudeviceid')]);
            $data = ['res' => $newMovieRes['pacakageList'],'yuePrice'=>$yuePrice,'yueMonth'=>$yueMonth,'yueName'=>$yueName,'yzPrice'=>$yzPrice,'jiPrice'=>$jiPrice,'jiMonth'=>$jiMonth,'jiName'=>$jiName,'jzPrice'=>$jzPrice,
                'halfYearPrice'=>$halfYearPrice,'halfYearMonth'=>$halfYearMonth,'halfYearName'=>$halfYearName,'hzPrice'=>$hzPrice,'yearPrice'=>$yearPrice,'yearMonth'=>$yearMonth,'yearName'=>$yearName,'nzPrice'=>$nzPrice,'yuePackageId'=>$yuePackageId,'jiPackageId'=>$jiPackageId,'halfPackageId'=>$halfPackageId,'yearPackageId'=>$yearPackageId,];
            return view('youku', $data);
        }
        else
        {
            $data = ['res' => '','yuePrice'=>'','yueMonth'=>'','yueName'=>'','jiPrice'=>'','jiMonth'=>'','jiName'=>'','yzPrice'=>'','jzPrice'=>'','hzPrice'=>'','nzPrice'=>'',
                'halfYearPrice'=>'','halfYearMonth'=>'','halfYearName'=>'','yearPrice'=>'','yearMonth'=>'','yearName'=>'','yuePackageId'=>'','jiPackageId'=>'','halfPackageId'=>'','yearPackageId'=>'',];
            return view('youku', $data);
        }
    }
    public function baishitong()
    {
        if(session('status'))
        {
            //拼接变量规则
            $baishi='BESTV:PPTV';
            //先md5加密
            $baishiEncode = md5('Site=' . $baishi);
            // 使用私钥加密
            openssl_sign($baishiEncode, $encrypted, config('wechat.official_account.default.private_key'));
            //base64以防乱码
            $signature = base64_encode($encrypted);
            //价格展示url
            $moviePriceUrl = config('wechat.official_account.default.price_url');
            $movarray = array(
                'Site' => 'BESTV:PPTV',
            );
            $movieArr = array(
                'Data' => base64_encode(json_encode($movarray)),
                'Signature' => $signature,
            );
            $movieResult = json_encode($movieArr);
            $movRes = $this->curl_movie($moviePriceUrl, $movieResult);
            $newMovieRes = json_decode($movRes, true);
            if($newMovieRes['pacakageList'])
            {
                foreach($newMovieRes['pacakageList'] as $v)
                {
                    if($v['fsk_package_provider']=='BESTV:PPTV' && ($v['fsk_package_month']==1))
                    {
                        $yuePrice=$v['fsk_package_price']/100;$yueMonth=$v['fsk_package_month'];$yueName=$v['fsk_package_name'];$yuePackageId=$v['fsk_package_id'];$yzPrice=round(1.5*$yuePrice);
                    }
                    if($v['fsk_package_provider']=='BESTV:PPTV' && ($v['fsk_package_month']==3))
                    {
                        $jiPrice=$v['fsk_package_price']/100;$jiMonth=$v['fsk_package_month'];$jiName=$v['fsk_package_name'];$jiPackageId=$v['fsk_package_id'];$jzPrice=round(1.5*$jiPrice);
                    }
                    if($v['fsk_package_provider']=='BESTV:PPTV' && ($v['fsk_package_month']==6))
                    {
                        $halfYearPrice=$v['fsk_package_price']/100;$halfYearMonth=$v['fsk_package_month'];$halfYearName=$v['fsk_package_name'];$halfPackageId=$v['fsk_package_id'];$hzPrice=round(1.5*$halfYearPrice);
                    }
                    if($v['fsk_package_provider']=='BESTV:PPTV' && ($v['fsk_package_month']==12))
                    {
                        $yearPrice=$v['fsk_package_price']/100;$yearMonth=$v['fsk_package_month'];$yearName=$v['fsk_package_name'];$yearPackageId=$v['fsk_package_id'];$nzPrice=round(1.5*$yearPrice);
                    }
                }
            }
            else
            {
                $newMovieRes['pacakageList']=''; $yuePrice='';$yueMonth='';$yueName='';$yuePackageId=''; $jiPrice='';$jiMonth='';$jiName='';$jiPackageId='';$halfYearPrice='';$halfYearMonth='';$halfYearName=''; $halfPackageId='';$yearPrice='';$yearMonth='';$yearName='';$yearPackageId='';$yzPrice='';$jzPrice='';$hzPrice='';$nzPrice='';
            }
            $ordermac=session(['ordermac'=>session('tvmac')]);$orderprovider=session(['orderprovider'=>session('tvprovider')]);$orderlimitdate=session(['orderlimitdate'=>session('tvlimitdate')]);$ordermodel=session(['ordermodel'=>session('tvmodel')]);$orderdeviceid=session(['orderdeviceid'=>session('tvdeviceid')]);
            $data = ['res' => $newMovieRes['pacakageList'],'yuePrice'=>$yuePrice,'yueMonth'=>$yueMonth,'yueName'=>$yueName,'yzPrice'=>$yzPrice,'jiPrice'=>$jiPrice,'jiMonth'=>$jiMonth,'jiName'=>$jiName,'jzPrice'=>$jzPrice,
                'halfYearPrice'=>$halfYearPrice,'halfYearMonth'=>$halfYearMonth,'halfYearName'=>$halfYearName,'hzPrice'=>$hzPrice,'yearPrice'=>$yearPrice,'yearMonth'=>$yearMonth,'yearName'=>$yearName,'nzPrice'=>$nzPrice,'yuePackageId'=>$yuePackageId,'jiPackageId'=>$jiPackageId,'halfPackageId'=>$halfPackageId,'yearPackageId'=>$yearPackageId,];
            return view('baishitong', $data);
        }
        else
        {
            $data = ['res' => '','yuePrice'=>'','yueMonth'=>'','yueName'=>'','jiPrice'=>'','jiMonth'=>'','jiName'=>'','yzPrice'=>'','jzPrice'=>'','hzPrice'=>'','nzPrice'=>'',
                'halfYearPrice'=>'','halfYearMonth'=>'','halfYearName'=>'','yearPrice'=>'','yearMonth'=>'','yearName'=>'','yuePackageId'=>'','jiPackageId'=>'','halfPackageId'=>'','yearPackageId'=>'',];
            return view('baishitong', $data);
        }
    }
    public function nba()
    {
        if(session('status'))
        {
            //拼接变量规则
            $baishi='BESTV';
            //先md5加密
            $baishiEncode = md5('Site=' . $baishi);
            // 使用私钥加密
            openssl_sign($baishiEncode, $encrypted, config('wechat.official_account.default.private_key'));
            //base64以防乱码
            $signature = base64_encode($encrypted);
            //价格展示url
            $moviePriceUrl = config('wechat.official_account.default.price_url');
            $movarray = array(
                'Site' => 'BESTV',
            );
            $movieArr = array(
                'Data' => base64_encode(json_encode($movarray)),
                'Signature' => $signature,
            );
            $movieResult = json_encode($movieArr);
            $movRes = $this->curl_movie($moviePriceUrl, $movieResult);
            $newMovieRes = json_decode($movRes, true);
            if($newMovieRes['pacakageList'])
            {
                foreach($newMovieRes['pacakageList'] as $v)
                {
                    if($v['fsk_package_provider']=='BESTV' && ($v['fsk_package_month']==1))
                    {
                        $yuePrice=$v['fsk_package_price']/100;$yueMonth=$v['fsk_package_month'];$yueName=$v['fsk_package_name'];$yuePackageId=$v['fsk_package_id'];$yzPrice=round(1.5*$yuePrice);
                    }
                    if($v['fsk_package_provider']=='BESTV' && ($v['fsk_package_month']==3))
                    {
                        $jiPrice=$v['fsk_package_price']/100;$jiMonth=$v['fsk_package_month'];$jiName=$v['fsk_package_name'];$jiPackageId=$v['fsk_package_id'];$jzPrice=round(1.5*$jiPrice);
                    }
                    if($v['fsk_package_provider']=='BESTV' && ($v['fsk_package_month']==6))
                    {
                        $halfYearPrice=$v['fsk_package_price']/100;$halfYearMonth=$v['fsk_package_month'];$halfYearName=$v['fsk_package_name'];$halfPackageId=$v['fsk_package_id'];$hzPrice=round(1.5*$halfYearPrice);
                    }
                    if($v['fsk_package_provider']=='BESTV' && ($v['fsk_package_month']==12))
                    {
                        $yearPrice=$v['fsk_package_price']/100;$yearMonth=$v['fsk_package_month'];$yearName=$v['fsk_package_name'];$yearPackageId=$v['fsk_package_id'];$nzPrice=round(1.5*$yearPrice);
                    }
                }
            }
            else
            {
                $newMovieRes['pacakageList']=''; $yuePrice='';$yueMonth='';$yueName='';$yuePackageId=''; $jiPrice='';$jiMonth='';$jiName='';$jiPackageId='';$halfYearPrice='';$halfYearMonth='';$halfYearName=''; $halfPackageId='';$yearPrice='';$yearMonth='';$yearName='';$yearPackageId='';$yzPrice='';$jzPrice='';$hzPrice='';$nzPrice='';
            }
            $ordermac=session(['ordermac'=>session('tvmac')]);$orderprovider=session(['orderprovider'=>session('tvprovider')]);$orderlimitdate=session(['orderlimitdate'=>session('tvlimitdate')]);$ordermodel=session(['ordermodel'=>session('tvmodel')]);$orderdeviceid=session(['orderdeviceid'=>session('tvdeviceid')]);
            $data = ['res' => $newMovieRes['pacakageList'],'yuePrice'=>$yuePrice,'yueMonth'=>$yueMonth,'yueName'=>$yueName,'yzPrice'=>$yzPrice,'jiPrice'=>$jiPrice,'jiMonth'=>$jiMonth,'jiName'=>$jiName,'jzPrice'=>$jzPrice,
                'halfYearPrice'=>$halfYearPrice,'halfYearMonth'=>$halfYearMonth,'halfYearName'=>$halfYearName,'hzPrice'=>$hzPrice,'yearPrice'=>$yearPrice,'yearMonth'=>$yearMonth,'yearName'=>$yearName,'nzPrice'=>$nzPrice,'yuePackageId'=>$yuePackageId,'jiPackageId'=>$jiPackageId,'halfPackageId'=>$halfPackageId,'yearPackageId'=>$yearPackageId,];
            return view('nba', $data);
        }
        else
        {
            $data = ['res' => '','yuePrice'=>'','yueMonth'=>'','yueName'=>'','jiPrice'=>'','jiMonth'=>'','jiName'=>'','yzPrice'=>'','jzPrice'=>'','hzPrice'=>'','nzPrice'=>'',
                'halfYearPrice'=>'','halfYearMonth'=>'','halfYearName'=>'','yearPrice'=>'','yearMonth'=>'','yearName'=>'','yuePackageId'=>'','jiPackageId'=>'','halfPackageId'=>'','yearPackageId'=>'',];
            return view('nba', $data);
        }
    }
    public function MulitarraytoSingle($array)
    {
        $temp=array();
        if(is_array($array))
        {
            foreach ($array as $key=>$value )
            {
                if(is_array($value))
                {
                    $this->MulitarraytoSingle($value);
                }
                else
                {
                    $temp[]=$value;
                }
            }
        }
    }
    public function testCalendar()
    {
        $days = cal_days_in_month(CAL_GREGORIAN, 8, 2018);

        $x=1;

        while($x<=$days) {
            echo "'$x'".','. "<br>";
            $calender="'$x'".',';
            $x+=2;
            echo $calender;
        }
        die;
    }
    //进入充值页面之后点击相应的充值按钮时判断逻辑处理方法
    public function recharge()
    {
        $tim = time();
        //将正常的时间格式转化为毫秒级的时间格式
        $newtim = $this->get_microtime_format($tim);//2018-07-17 09:03:39.000
        //将毫秒级时间格式转化为毫秒级的时间戳
        $netime = $this->get_data_format($newtim);//1531818148000

        //将毫秒级的时间戳转化为正常的时间格式
        $newti = date('Y-m-d', $netime / 1000 + 8 * 60 * 60);//2018-07-17 17:03:12
        //获取iot大会员的access_token
        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array (
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type'=>'client_credentials',
            'scope' =>'',
        );
        $newresult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token' , $postArr);
        $infos=json_decode($newresult,true);
        $iottoken="Bearer ".$infos['access_token'];//得到access_token
        //已登录状态就会有session('useruuid');
        if(session('useruuid'))
        {
            //调用大会员的mapping映射接口，获取到影视会员id
            $chrageResult=$this->doGet($iottoken,config('flnet-iot-member.base_api_url') . 'users/cms-search?user_uuid='.session('useruuid') );
            $chargeRes=json_decode($chrageResult,true);//获得影视会员的信息（包括 id,mobile,nickname);
            //判断是否是夏普影视会员result_code==1而且cms_user['id']存在即为会员
            if($chargeRes['result_code']==1 && $chargeRes['cms_user'])
            {
                $chargeId=$chargeRes['cms_user']['id'];$chargeTel=$chargeRes['cms_user']['mobile'];$chargeNickName=$chargeRes['cms_user']['nickname'];//$chargeId就是影视会员ID
                //获取到影视会员id，接下来就开始和kidd对接....................................//
                if($chargeId)
                {
                    //赋值$chargeId
                    $accountid=$chargeId;
                    //  $accountid='GIGDTDUMTHQKNVVLJPTO';
                    // $accountid='YDSEBKMEZBVGLQDQNYVI';
                    session(['accountid'=>$accountid]);
                    //先md5加密
                    $md5account_id = md5('accountId=' . $accountid);
                    // 使用私钥加密
                    openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
                    //base64以防乱码
                    $signature = base64_encode($encrypted);
                    //recharge充值url
                    $moviePriceUrl = config('wechat.official_account.default.recharge_url');
                    //display展示url
                    $movieDisplayUrl = config('wechat.official_account.default.display_url');
                    $movarray = array(
                        'accountId' => $accountid,
                    );
                    $movieArr = array(
                        'Data' => base64_encode(json_encode($movarray)),
                        'Signature' => $signature,
                    );
                    $movieResult = json_encode($movieArr);
                    $movRes = $this->curl_movie($moviePriceUrl, $movieResult);
                    if($movRes!=='{}')
                    {
                        $newMovieRes = json_decode($movRes, true);
                        if(empty($newMovieRes['vipRight']))
                        {
                            session(['rechargeDisplay'=>'']);
                        }
                        else
                        {
                            session(['rechargeDisplay'=>$newMovieRes['vipRight']]);

                            foreach($newMovieRes['vipRight'] as $v)
                            {
                                if($v['providerName']=='IQIYI' && $v['devices'])
                                {
                                    $iqiyimac=$v['devices'][0]['mac'];$iqiyiprovider=$v['devices'][0]['provider'];$iqiyilimitdate=$v['devices'][0]['limitDate'];$iqiyimodel=$v['devices'][0]['model'];$iqiyideviceid=$v['devices'][0]['deviceId'];
                                    session(['iqiyimac'=>$iqiyimac]);session(['iqiyiprovider'=>$iqiyiprovider]);session(['iqiyilimitdate'=>$iqiyilimitdate]);session(['iqiyimodel'=>$iqiyimodel]);session(['iqiyideviceid'=>$iqiyideviceid]);

                                }
                                if($v['providerName']=='YOUKU' && $v['devices'])
                                {
                                    $youkumac=$v['devices'][0]['mac'];$youkuprovider=$v['devices'][0]['provider'];$youkulimitdate=$v['devices'][0]['limitDate'];$youkumodel=$v['devices'][0]['model'];$youkudeviceid=$v['devices'][0]['deviceId'];
                                    session(['youkumac'=>$youkumac]);session(['youkuprovider'=>$youkuprovider]);session(['youkulimitdate'=>$youkulimitdate]);session(['youkumodel'=>$youkumodel]);session(['youkudeviceid'=>$youkudeviceid]);
                                }
                                if($v['providerName']=='BESTV:PPTV' && $v['devices'])
                                {
                                    $pptvmac=$v['devices'][0]['mac'];$pptvprovider=$v['devices'][0]['provider'];$pptvlimitdate=$v['devices'][0]['limitDate'];$pptvmodel=$v['devices'][0]['model'];$pptvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['pptvmac'=>$pptvmac]);session(['pptvprovider'=>$pptvprovider]);session(['pptvlimitdate'=>$pptvlimitdate]);session(['pptvmodel'=>$pptvmodel]);session(['pptvdeviceid'=>$pptvdeviceid]);
                                }
                                if($v['providerName']=='BESTV' && $v['devices'])
                                {
                                    $bestvmac=$v['devices'][0]['mac'];$bestvprovider=$v['devices'][0]['provider'];$bestvlimitdate=$v['devices'][0]['limitDate'];$bestvmodel=$v['devices'][0]['model'];$bestvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['bestvmac'=>$bestvmac]);session(['bestvprovider'=>$bestvprovider]);session(['bestvlimitdate'=>$bestvlimitdate]);session(['bestvmodel'=>$bestvmodel]);session(['bestvdeviceid'=>$bestvdeviceid]);
                                }
                                if(($v['providerName']=='BESTV:PPTV' || $v['providerName']=='BESTV') && $v['devices'])
                                {
                                    $tvmac=$v['devices'][0]['mac'];$tvprovider=$v['devices'][0]['provider'];$tvlimitdate=$v['devices'][0]['limitDate'];$tvmodel=$v['devices'][0]['model'];$tvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['tvmac'=>$tvmac]);session(['tvprovider'=>$tvprovider]);session(['tvlimitdate'=>$tvlimitdate]);session(['tvmodel'=>$tvmodel]);session(['orderdeviceid'=>$tvdeviceid]);
                                }
                            }
                            foreach($newMovieRes['vipRight'] as $vs)
                            {
                                if($vs['providerName'])
                                {
                                    if($vs['providerName']=='IQIYI')
                                    {
                                        foreach($vs['devices'] as $vss)
                                        {
                                            $imacadd[]=$vss['mac'];$imod[]=$vss['model'];$idate[]=$vss['limitDate'];
                                        }
                                    }
                                    else
                                    {
                                        $imacadd[]='';$imod[]='';$idate[]='';
                                    }
                                }

                                if($vs['providerName'])
                                {
                                    if($vs['providerName']=='YOUKU')
                                    {
                                        foreach($vs['devices'] as $vss)
                                        {
                                            $ymacadd[]=$vss['mac']; $ymod[]=$vss['model'];$ydate[]=$vss['limitDate'];

                                        }
                                    }
                                    else
                                    {
                                        $ymacadd[]='';$ymod[]='';
                                    }
                                }
                                if($vs['providerName'])
                                {
                                    if($vs['providerName']=='BESTV:PPTV')
                                    {
                                        foreach($vs['devices'] as $vss)
                                        {
                                            $pmacadd[]=$vss['mac']; $pmod[]=$vss['model'];$pdate[]=$vss['limitDate'];

                                        }

                                    }
                                    else
                                    {
                                        $pmacadd='';$pmod='';
                                    }
                                }

                                if($vs['providerName'])
                                {
                                    if($vs['providerName']=='BESTV')
                                    {
                                        foreach($vs['devices'] as $vss)
                                        {
                                            $bmacadd[]=$vss['mac']; $bmod[]=$vss['model'];$bdate[]=$vss['limitDate'];

                                        }
                                    }
                                    else
                                    {
                                        $bmacadd='';$bmod='';
                                    }
                                }
                            }
                        }
                    }

                    $disRes = $this->curl_movie($movieDisplayUrl, $movieResult);
                    if($disRes !== '{}')
                    {
                        $newDisRes = json_decode($disRes, true);
                        if(empty($newDisRes['vipRight']))
                        {
                            session(['res'=>'']);
                        }
                        else
                        {
                            session(['res'=>$newDisRes['vipRight']]);
                            foreach($newDisRes['vipRight'] as $v)
                            {
                                if($v['fsk_package_provide']=='IQIYI' && $v['fsk_device_id'] && (!(session('iqiyimac'))))
                                {
                                    $iqiyidate=$v['fsk_right_limitdate'];session(['iqiyilimitdate'=>$iqiyidate]);session(['iqiyiprovider'=>'IQIYI']);
                                    $iqiyimac=$v['fsk_device_mac'];session(['iqiyimac'=>$iqiyimac]);$iqiyimodel=$v['fsk_device_model'];session(['iqiyimodel'=>$iqiyimodel]);$iqiyideviceid=$v['fsk_device_id'];session(['iqiyideviceid'=>$iqiyideviceid]);

                                }
                                if($v['fsk_package_provide']=='YOUKU' && $v['fsk_device_id']  && (!(session('youkumac'))))
                                {

                                    $youkudate=$v['fsk_right_limitdate'];session(['youkulimitdate'=>$youkudate]);session(['youkuprovider'=>'YOUKU']);
                                    $youkumac=$v['fsk_device_mac'];session(['youkumac'=>$youkumac]);$youkumodel=$v['fsk_device_model'];session(['youkumodel'=>$youkumodel]);$youkudeviceid=$v['fsk_device_id'];session(['youkudeviceid'=>$youkudeviceid]);
                                }
                                if($v['fsk_package_provide']=='BESTV:PPTV'  && $v['fsk_device_id']  && (!(session('pptvmac'))))
                                {

                                    $pptvdate=$v['fsk_right_limitdate'];session(['pptvlimitdate'=>$pptvdate]);session(['pptvprovider'=>'BESTV:PPTV']);
                                    $pptvmac=$v['fsk_device_mac'];session(['pptvmac'=>$pptvmac]);$pptvmodel=$v['fsk_device_model'];session(['pptvmodel'=>$pptvmodel]);$pptvdeviceid=$v['fsk_device_id'];session(['pptvdeviceid'=>$pptvdeviceid]);
                                }
                                if($v['fsk_package_provide']=='BESTV' && $v['fsk_device_id']  && (!(session('bestvmac'))))
                                {

                                    $bestvdate=$v['fsk_right_limitdate'];session(['bestvlimitdate'=>$bestvdate]);session(['bestvprovider'=>'BESTV']);
                                    $bestvmac=$v['fsk_device_mac'];session(['bestvmac'=>$bestvmac]);$bestvmodel=$v['fsk_device_model'];session(['bestvmodel'=>$bestvmodel]);$bestvdeviceid=$v['fsk_device_id'];session(['bestvdeviceid'=>$bestvdeviceid]);

                                }
                                if(($v['fsk_package_provide']=='BESTV:PPTV' || $v['fsk_package_provide']=='BESTV')  && $v['fsk_device_id']  && (!(session('tvmac'))))
                                {

                                    $tvdate=$v['fsk_right_limitdate'];session(['tvlimitdate'=>$tvdate]);session(['tvprovider'=>'BESTV:PPTV || BESTV']);
                                    $tvmac=$v['fsk_device_mac'];session(['tvmac'=>$tvmac]);$tvmodel=$v['fsk_device_model'];session(['tvmodel'=>$tvmodel]);$tvdeviceid=$v['fsk_device_id'];session(['tvdeviceid'=>$tvdeviceid]);
                                }
                            }

                        }
                    }

                }
                if(empty($newMovieRes['vipRight']) && empty($newDisRes['vipRight']))
                {
                    $data=['res'=>'','time'=>'','newRes'=>'','imacadd'=>'','imod'=>'','ymacadd'=>'','ymod'=>'','pmacadd'=>'','pmod'=>'','bmacadd'=>'','bmod'=>''];
                }
                else
                {
                    $data=['res'=>$newMovieRes['vipRight'],'newRes'=>$newDisRes['vipRight'],'time'=>$netime,'imacadd'=>$imacadd,'imod'=>$imod,'ymacadd'=>$ymacadd,'ymod'=>$ymod,'pmacadd'=>$pmacadd,'pmod'=>$pmod,'bmacadd'=>$bmacadd,'bmod'=>$bmod];
                }

                return view('recharge',$data);
            }
            //否则不是会员提示无可购买套餐
            else
            {
                return redirect('unlogin');
            }
        }
        //否则代表还未登录
        else
        {
            return redirect('newLogin');
        }
    }

    //数组遍历函数2
    public function formatArray($array)
    {

        sort($array);

        $tem = "";

        $temarray = array();

        $j = 0;

        for($i=0;$i<count($array);$i++)

        {

            if($array[$i]!=$tem)

            {

                $temarray[$j] = $array[$i];

                $j++;

            }

            $tem = $array[$i];

        }

        return $temarray;

    }

    //数组遍历函数
    public function deep_in_array($value, $array)
    {
        foreach($array as $item) {
            if(!is_array($item)) {
                if ($item == $value) {
                    return true;
                } else {
                    continue;
                }
            }

            if(in_array($value, $item)) {
                return true;
            } else if(deep_in_array($value, $item)) {
                return true;
            }
        }
        return false;
    }
    //新增菜单项
    public function responseMsg()
    {
        $appid = "wx7ad94baa36c64cd9";
        $appsecret = "0fa4f998b7f87101cd1a641eb33552fb";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsoninfo = json_decode($output, true);
        $access_token = $jsoninfo["access_token"];
        $as=array('type'=>'view','name'=>'测试','url'=>'http://iot.flnet.com/InteMall/QrCode');
        $ass=json_encode($as,JSON_UNESCAPED_UNICODE);
        $ss="{". '"button": [' .$ass.']}';
        $menuurl="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $ch = curl_init ();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_URL, $menuurl);
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $ss);
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        $newmes=json_decode($result,true);
        echo $result ;die;
    }

    //设备未登录页面
    public function unlogin()
    {
        return view('unlogin');
    }
    //此账号无购买权益页面
    public function nothingPay()
    {
        return view('nothingPay');
    }
    //未连续包月（新用户）
    public function notPayMonth()
    {
        return view('notPayMonth');
    }
    //已连续包月（老用户）
    public function payMonth()
    {
        return view('payMonth');
    }
    //错误定向页面（404，500等）
    public function wrong()
    {
        return view('wrong');
    }
    //注册登录成功之后显示页
    public function newDisplay()
    {
        $broker=new Broker(config('wechat.sso.default.sso_server'),config('wechat.sso.default.sso_broker_id'),config('wechat.sso.default.sso_broker_secret'));
        $broker->attach(true);
        //获取用户的信息
        $userinfo=$broker->getUserInfo();
          if($userinfo)
        {
            //设置项目所需要的各种session值
            session(['status' => 1]);//改变状态为1
            session(['mobile' => $userinfo->mobile]);
            session(['wxnickname' => $userinfo->name]);
            session(['anotherMobile' => $userinfo->mobile]);
            session(['useruuid' => $userinfo->uuid]);
            session(['nickname' => $userinfo->nickname]);
            session(['newimage'=>$userinfo->avatar]);
            session(['pointUserId' => $userinfo->id]);
            session(['pointAccessToken' => $userinfo->access_token]);
            //公共参数
            $tim = time();
            $pointClientId = config('wechat.official_account.default.point_client_id');
            $pointClientSecret = config('wechat.official_account.default.point_client_secret');
            $pointUserId=$userinfo->id;
            $pointUseruuid=session('useruuid');
            $pointAccessToken=$userinfo->access_token;
            //用户首次登录成功后新增20积分
            if(session('createPointStatus') !== 1)
            {
                session(['createPointStatus'=>1]);
                $randNum52=$this->GetRandStr(80);
                $pointArr52=array(
                    'ticket'=>$randNum52,
                    'definition'=>'首次登入奖励',
                    'client_id'=>config('wechat.official_account.default.point_client_id'),
                    'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                    'user_id'=>$userinfo->id,
                    'user_uuid'=>$userinfo->uuid,
                    'user_name'=>$userinfo->nickname,
                    'access_token'=>$userinfo->access_token,
                    'bonus_point'=>config('wechat.official_account.default.point_register_bounes'),
                );
                $createPointResult52=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr52);
                $createPointRes52=json_decode($createPointResult52,true);

                $points52 = config('wechat.official_account.default.point_bind_device');
                $results52=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum52,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>1,'bonus_point'=>$points52,'orderid'=>'','definition'=>'快捷登录','createtime'=>$tim]);
            }
            //根据用户的uuid获取所有设备资讯
            $uuidurl52 = config('flnet-iot-member.base_api_url') . "users/" . $userinfo->uuid . "/devices";
            $uuidresult52 = $this->doGet('Bearer ' . $userinfo->access_token, $uuidurl52);
            $uuidres52 = json_decode($uuidresult52, true);
            session(['userdev' => $uuidres52['devices']]);
            if(session('userdev') &&  (session('binddevice5') !==1))
            {
                foreach($uuidres52['devices'] as $v) {
                    if ($v['type'] == 5) {
                        session(['binddevice5' => 1]);
                        $randNum39 = $this->GetRandStr(80);
                        $pointArr39 = array(
                            'ticket' => $randNum39,
                            'definition' => '绑定设备',
                            'client_id' => config('wechat.official_account.default.point_client_id'),
                            'client_secret' => config('wechat.official_account.default.point_client_secret'),
                            'user_id' => $userinfo->id,
                            'user_uuid' => $userinfo->uuid,
                            'user_name'=>$userinfo->nickname,
                            'access_token' => $userinfo->access_token,
                            'bonus_point' => config('wechat.official_account.default.point_bind_device'),
                        );
                        $createPointResult39 = $this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr39);
                        $createPointRes39 = json_decode($createPointResult39, true);
                        $points39 = config('wechat.official_account.default.point_bind_device');
                        $results39=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum39,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points39,'orderid'=>'','definition'=>'绑定空气净化器设备','createtime'=>$tim]);
                    }
                }
            }
            //调用大会员的mapping映射接口，获取到影视会员id
            $chrageResult=$this->doGet('Bearer ' . $userinfo->access_token,config('flnet-iot-member.base_api_url') . 'users/cms-search?user_uuid='.session('useruuid') );
            $chargeRes=json_decode($chrageResult,true);//获得影视会员的信息（包括 id,mobile,nickname);
            //判断是否是夏普影视会员result_code==1而且cms_user['id']存在即为会员
            if($chargeRes['result_code']==1)
            {
                $chargeId = $chargeRes['cms_user']['id'];
                $chargeTel = $chargeRes['cms_user']['mobile'];
                $chargeNickName = $chargeRes['cms_user']['nickname'];//$chargeId就是影视会员ID
                //获取到影视会员id，接下来就开始和kidd对接....................................
                if($chargeId)
                {
                    session(['accountid'=>$chargeId]);
                    //赋值$chargeId
                    $accountid=$chargeId;
                    //先md5加密
                    $md5account_id = md5('accountId=' . $accountid);
                    // 使用私钥加密
                    openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
                    //base64以防乱码
                    $signature = base64_encode($encrypted);
                    //购买展示url
                    $movieRightUrl = config('wechat.official_account.default.display_url');
                    $movarray = array(
                        'accountId' => $accountid,
                    );
                    $movieArr = array(
                        'Data' => base64_encode(json_encode($movarray)),
                        'Signature' => $signature,
                    );

                    //recharge充值url
                    $moviePriceUrl = config('wechat.official_account.default.recharge_url');
                    $movieResults = json_encode($movieArr);
                    $movRess = $this->curl_movie($moviePriceUrl, $movieResults);
                    if($movRess!=='{}')
                    {
                        $newMovieRess = json_decode($movRess, true);

                        if(empty($newMovieRess['vipRight']))
                        {
                            session(['rechargeDisplay'=>'']);
                        }
                        else
                        {
                            session(['rechargeDisplay'=>$newMovieRess['vipRight']]);
                            if(session('rechargeDisplay') &&  (session('bindsharp') !==1))
                            {
                                session(['bindsharp'=>1]);
                                $randNum50=$this->GetRandStr(80);
                                $pointArr50=array(
                                    'ticket'=>$randNum50,
                                    'definition'=>'绑定设备',
                                    'client_id'=>config('wechat.official_account.default.point_client_id'),
                                    'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                                    'user_id'=>$userinfo->id,
                                    'user_uuid'=>$userinfo->uuid,
                                    'user_name'=>$userinfo->nickname,
                                    'access_token'=>$userinfo->access_token,
                                    'bonus_point'=>config('wechat.official_account.default.point_bind_device'),
                                );
                                $createPointResult50=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr50);
                                $createPointRes50=json_decode($createPointResult50,true);
                                $points50 = config('wechat.official_account.default.point_bind_device');
                                $results50=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum50,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points50,'orderid'=>'','definition'=>'绑定夏普电视设备','createtime'=>$tim]);

                            }
                            foreach($newMovieRess['vipRight'] as $v)
                            {
                                if($v['providerName']=='IQIYI' && $v['devices'])
                                {
                                    $iqiyimac=$v['devices'][0]['mac'];$iqiyiprovider=$v['devices'][0]['provider'];$iqiyilimitdate=$v['devices'][0]['limitDate'];$iqiyimodel=$v['devices'][0]['model'];$iqiyideviceid=$v['devices'][0]['deviceId'];
                                    session(['iqiyimac'=>$iqiyimac]);session(['iqiyiprovider'=>$iqiyiprovider]);session(['iqiyilimitdate'=>$iqiyilimitdate]);session(['iqiyimodel'=>$iqiyimodel]);session(['iqiyideviceid'=>$iqiyideviceid]);
                                }
                                if($v['providerName']=='YOUKU' && $v['devices'])
                                {
                                    $youkumac=$v['devices'][0]['mac'];$youkuprovider=$v['devices'][0]['provider'];$youkulimitdate=$v['devices'][0]['limitDate'];$youkumodel=$v['devices'][0]['model'];$youkudeviceid=$v['devices'][0]['deviceId'];
                                    session(['youkumac'=>$youkumac]);session(['youkuprovider'=>$youkuprovider]);session(['youkulimitdate'=>$youkulimitdate]);session(['youkumodel'=>$youkumodel]);session(['youkudeviceid'=>$youkudeviceid]);
                                }
                                if($v['providerName']=='BESTV:PPTV' && $v['devices'])
                                {
                                    $pptvmac=$v['devices'][0]['mac'];$pptvprovider=$v['devices'][0]['provider'];$pptvlimitdate=$v['devices'][0]['limitDate'];$pptvmodel=$v['devices'][0]['model'];$pptvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['pptvmac'=>$pptvmac]);session(['pptvprovider'=>$pptvprovider]);session(['pptvlimitdate'=>$pptvlimitdate]);session(['pptvmodel'=>$pptvmodel]);session(['pptvdeviceid'=>$pptvdeviceid]);
                                }
                                if($v['providerName']=='BESTV' && $v['devices'])
                                {
                                    $bestvmac=$v['devices'][0]['mac'];$bestvprovider=$v['devices'][0]['provider'];$bestvlimitdate=$v['devices'][0]['limitDate'];$bestvmodel=$v['devices'][0]['model'];$bestvdeviceid=$v['devices'][0]['deviceId'];
                                    session(['bestvmac'=>$bestvmac]);session(['bestvprovider'=>$bestvprovider]);session(['bestvlimitdate'=>$bestvlimitdate]);session(['bestvmodel'=>$bestvmodel]);session(['bestvdeviceid'=>$bestvdeviceid]);
                                }
                            }
                        }
                    }

                    $movieResult = json_encode($movieArr);
                    $movRes = $this->curl_movie($movieRightUrl, $movieResult);
                    if($movRes!=='{}')
                    {
                        $newMovieRes = json_decode($movRes, true);
                        if(empty($newMovieRes['vipRight']))
                        {
                            session(['res'=>'']);
                        }
                        else
                        {
                            session(['res'=>$newMovieRes['vipRight']]);
                        }
                    }
                }
            }
            //return view('display',['res'=>$newMovieRes['vipRight'],'newimage'=>$userinfo->avatar,'nickname'=>$userinfo->nickname,'mobile'=>$userinfo->mobile]);
            //return redirect('succUrl');
            return view('display');
        }
          else
          {
                return redirect('newLogin');
          }
    }
    //修改完昵称之后重定向到manage页面的方法
    public function display()
    {
        logger()->debug('display page');
        //获取iot大会员的access_token
        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array(
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials',
            'scope' => '',
        );
        $newresult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token', $postArr);
        $infos = json_decode($newresult, true);
        $iottoken = "Bearer " . $infos['access_token'];//得到access_token
        //根据unionid查询大会员信息
        if (session('useruuid')) {
            $uuid = session('useruuid');
            //根据用户的uuid获取所有设备资讯
            $uuidurl = config('flnet-iot-member.base_api_url') . "users/" . $uuid . "/devices";
            $uuidresult = $this->doGet($iottoken, $uuidurl);
            $uuidres = json_decode($uuidresult, true);
            session(['userdev' => $uuidres['devices']]);
            if (!empty($uuidres['devices'])) {
                session(['uuidres' => 1]);
                return view('manage');
            } else {
                session(['uuidress' => 2]);
                return view('manage');
            }
        } else {
            return redirect('newLogin');
        }
    }
    //展示页中点击管理按钮时跳转的方法
    public function displayManage()
    {
        if (session('status') == 1) {
            return view('manage');
        } else {
            return redirect('newLogin');
        }
    }
    //账号显示详情页
    public function accountDetail()
    {
        if (session('status') == 1) {
            return view('accountDetail');
        } else {
            return redirect('newLogin');
        }

            /*if (session('status') == 1)
            {
                $broker=new Broker(config('wechat.sso.default.sso_server'),config('wechat.sso.default.sso_broker_id'),config('wechat.sso.default.sso_broker_secret'));
                $broker->attach(true);
                //$action='profile';
                $action='#information';
                //产生本地登录的return_url;
                $localLoginUrl='http://'.$_SERVER['HTTP_HOST']."/logout";
                //生成bid
                $sessionId=$broker->getSessionId();
                $encoded=$broker->encode($sessionId,'flnet-sso');
                $params=[
                    'redirect_url'=>$localLoginUrl,
                    'bid'=>$encoded,
                ];
                $url=config('wechat.sso.default.sso_url').'/'.$action.'?'.http_build_query($params);
                header('Location:'.$url);
                exit();
                //return redirect(config('wechat.sso.default.sso_url').'#information');
            }
            else
            {
                return redirect('newLogin');
            }*/

    }
    //注销登录
    public function logout()
    {
        $broker=new Broker(config('wechat.sso.default.sso_server'),config('wechat.sso.default.sso_broker_id'),config('wechat.sso.default.sso_broker_secret'));
        $broker->attach(true);
        $action='logout';
        $broker->clearToken();
        //产生本地退出登录的回调return_url;
        $localLoginOutUrl='http://'.$_SERVER['HTTP_HOST']."/returnUrl";
        //生成bid
        $sessionId=$broker->getSessionId();
        $encoded=$broker->encode($sessionId,'flnet-sso');
        $params=[
            'redirect_url'=>$localLoginOutUrl,
            'bid'=>$encoded,
        ];
        $url=config('wechat.sso.default.sso_server').'/'.$action.'?'.http_build_query($params);
        header('Location:'.$url);
        exit();
    }
    //密码修改展示页
    public function modifyPass()
    {
        if (session('status') == 1) {
            $broker=new Broker(config('wechat.sso.default.sso_server'),config('wechat.sso.default.sso_broker_id'),config('wechat.sso.default.sso_broker_secret'));
            $broker->attach(true);
            $action='profile';
            //$action='profile#edit-password-mobile-confirm-popup';
            //产生本地登录后的return_url;
            $localLoginUrl='http://'.$_SERVER['HTTP_HOST']."/logout";
            //生成bid
            $sessionId=$broker->getSessionId();
            $encoded=$broker->encode($sessionId,'flnet-sso');
            $params=[
                'redirect_url'=>$localLoginUrl,
                'bid'=>$encoded,
            ];
            $url=config('wechat.sso.default.sso_url').'/'.$action.'?'.http_build_query($params);
            header('Location:'.$url);
            exit();
           // return redirect(config('wechat.sso.default.sso_url').'#account');
        } else {
            return redirect('newLogin');
        }
    }
    //修改密码逻辑处理方法
    public function handleModifyPass()
    {
        $newMobile=session('mobile');
        $newpass = $_POST['newpassword'];
        $oldpass = $_POST['oldpassword'];
        $password = $_POST['xgpassword'];
        //获取iot大会员的access_token
        $client_uuid=config('wechat.official_account.default.dfclient_uuid');
        $client_secret=config('wechat.official_account.default.dfclient_sercet');
        $postArr = array(
            'client_uuid' => $client_uuid,
            'client_secret' => $client_secret,
            'grant_type' => 'client_credentials',
            'scope' => '',
        );
        $newresult = $this->curlPost(config('flnet-iot-member.base_api_url') . 'oauth/token', $postArr);
        $infos = json_decode($newresult, true);
        $iottoken = "Bearer " . $infos['access_token'];//得到access_token


        session(['xinone' => $newpass]);
        //更改密码接口
        $cpassurl = config('flnet-iot-member.base_api_url') . "auth/passwords/change";
        $cpassarr = array(
            'user_uuid' =>session('useruuid'),
            'old_password' => $oldpass,
            'new_password' => $newpass,
        );
        $cpassres = $this->get_data($iottoken, $cpassurl, $cpassarr);
        $cpassresult = json_decode($cpassres, true);
        if (($cpassresult['result_code'] == 1) && $newpass == $password && session('pass') == $oldpass) {

            session(['status' => 1]);
            session(['pass' => $newpass]);
            return redirect('display');
        } else {
            echo "修改失败";
            return redirect('modifyPass');
        }
    }

    public function https_post($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public function GetOpenid()
    {
        //通过code获得openid
        $code = $_GET['code'];
        $openid = session('newopenid');
        $newactoken = $this->GetAccessTokenFromMp($code);
        $newinfosurl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $newactoken . "&openid=" . $openid . "&lang=zh_CN";
        $opresults = $this->https_request($newinfosurl);
        $userinfos = json_decode($opresults, true);
        if ($userinfos['unionid'] && (session('status') == 1)) {
            return redirect('newDisplay');
        } else {
            return redirect('newLogin');
        }
    }

    public function getOpenIds()
    {
        if (!isset($_GET['code'])) {
            //触发微信返回code码
            $redirectUrl = urlencode(config('wechat.official_account.default.oauth_redirect'));
            $url = $this->__CreateOauthUrlForCodes($redirectUrl);
            header("Location:$url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $openid = $this->GetOpenidFromMp($code);
            return $openid;
        }
    }
    private function __CreateOauthUrlForCodes($redirectUrl)
    {
        $newappid = config('wechat.official_account.default.app_id');
        $urlObj["appid"] = $newappid;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_userinfo";
        $urlObj["state"] = "STATE" . "#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?" . $bizString;
    }

    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        $news = $this->https_request($url);
        logger()->debug('$news = ' . $news);
        $data = json_decode($news, true);
        if (isset($data['openid'])) {
            $openid = $data['openid'];
            session(['oid' => $openid]);
            return $openid;
        } else {
            return redirect('wrong');
        }
    }

    public function GetAccessTokenFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出access_token
        $data = json_decode($res, true);
        $this->data = $data;
        $access_token = $data['access_token'];
        return $access_token;
    }

    private function __CreateOauthUrlForOpenid($code)
    {
        $appid = config('wechat.official_account.default.app_id');
        $appsecret = config('wechat.official_account.default.secret');
        $urlObj["appid"] = $appid;
        $urlObj["secret"] = $appsecret;
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        logger()->debug('$bizString = ' . $bizString);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?" . $bizString;
    }

    public function curltwo($authorization, $url, $postFields)
    {

        $header = array(
            'Authorization:' . $authorization,
            'Accept:application/json',
        );
        $postFields = http_build_query($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //定义请求地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//定义是否直接输出返回流
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); //定义请求类型，必须为大写
        //curl_setopt($ch, CURLOPT_HEADER,1); //定义是否显示状态头 1：显示 ； 0：不显示
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//定义header
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields); //定义提交的数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        $res = curl_exec($ch);
        curl_close($ch);//关闭
        return $res;                                                // 返回数据
    }

    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            if ($k != "sign") {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }


    /**
     *时间戳 转   日期格式 ： 精确到毫秒，x代表毫秒
     */
    public function get_microtime_format($time)
    {
        if (strstr($time, '.')) {
            sprintf("%01.3f", $time); //小数点。不足三位补0
            list($usec, $sec) = explode(".", $time);
            $sec = str_pad($sec, 3, "0", STR_PAD_RIGHT); //不足3位。右边补0
        } else {
            $usec = $time;
            $sec = "000";
        }
        $date = date("Y-m-d H:i:s.x", $usec);
        return str_replace('x', $sec, $date);
        //return $date;
    }

    /** 时间日期转时间戳格式，精确到毫秒，
     *
     */
    public function get_data_format($time)
    {
        list($usec, $sec) = explode(".", $time);
        $date = strtotime($usec);
        $return_data = str_pad($date . $sec, 13, "0", STR_PAD_RIGHT); //不足13位。右边补0
        return $return_data;
    }
    public function doGet($authorization, $url)
    {
        $headers = array(
            'Authorization:' . $authorization,
            'Accept:application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function https_request($url)//自定义函数,访问url返回结果
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR' . curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }
    public function curl_movie($url, $postFields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json; charset=utf-8",
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function curlPost($url, $postFields)
    {
        $postFields = http_build_query($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function get_data($authorization, $url, $postFields)
    {
        $headers = array(
            'Authorization:' . $authorization,
            'Accept:application/json',
        );
        $postFields = http_build_query($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function getMillisecond()
    {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }

    /**
     *  作用：产生随机字符串，不长于32位
     */

    public function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    /**
     *  作用：产生随机字符串，不长于32位
     */
    public function randomkeys($length)
    {
        $pattern = '1234567890123456789012345678905678901234';
        $key = null;

        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{mt_rand(0, 30)};    //生成php随机数
        }

        return $key;
    }
    public function randomkeyss($length)
    {
        $pattern = '1234567890123456789012345678905678901234';
        $key = null;

        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{mt_rand(0, 80)};    //生成php随机数
        }

        return $key;
    }
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public function FromXml($xml)
    {
        //将XML转为array
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public function ToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    protected function MakeSign($arr)
    {
        $keys = 'vW8491xwx559KI9XK8s8Xvbi5999iS66';
        //签名步骤一：按字典序排序参数
        ksort($arr);
        $string = $this->ToUrlParamss($arr);

        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $keys;

        //签名步骤三：MD5加密
        $string = md5($string);

        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);

        return $result;
    }

    /**
     * 格式化参数格式化成url参数
     */
    protected function ToUrlParamss($arr)
    {
        $buff = "";

        foreach ($arr as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    public static function Inits($xml)
    {
        $obj = new self();
        $obj->FromXml($xml);
        if ($obj->values['return_code'] != 'SUCCESS') {
            return $obj->GetValues();
        }
        $obj->CheckSign();
        return $obj->GetValues();
    }
    public function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public function SetAppid($value)
    {
        $this->values['appid'] = $value;
    }
    public function mysqli_query($link, $query, $resultmode = MYSQLI_STORE_RESULT){}
    public function mysqli_connect($host = '', $user = '', $password = '', $database = '', $port = '', $socket = ''){}
    public function mysqli_error($link){}
    public function mysqli_close($link){}
    public function mysql_fetch_row($result){}
    public function mysqli_fetch_assoc($result){}
    public function http_build_query(array $formdata, $numeric_prefix = null, $arg_separator = null, $enc_type = PHP_QUERY_RFC1738){}
}
