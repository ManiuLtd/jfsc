<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FlnetIotMemberApiService;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Jasny\SSO\Broker;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
   //login构造方法
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
   //普通登录时使用的方法
    public function index(Request $request)
    {
        $tim = time();
        //将正常的时间格式转化为毫秒级的时间格式
        $newtim = $this->get_microtime_format($tim);//2018-07-17 09:03:39.000
        //将毫秒级时间格式转化为毫秒级的时间戳
        $netime = $this->get_data_format($newtim);//1531818148000
        session(['time'=>$netime]);
        $input = $request->all();
        logger()->debug('login post form');

        $newmobile = $input['username'];
        $newpass = $input['dlpassword'];

        /** @var FlnetIotMemberApiService $flnetIotMemberApiService 大會員接口集成服務 */
        $flnetIotMemberApiService = App::make(FlnetIotMemberApiService::class);
        // 調用api/auth/eixinweb/login接口進行第三方登入
        $flnetIotMemberApiService->login($newmobile, $newpass);
        $loginResponse = $flnetIotMemberApiService->getResponse();
        $loginResponseArray = json_decode($loginResponse->getBody(), true);
        $iotToken = isset($loginResponseArray['access_token']) ? $loginResponseArray['access_token'] : NULL;

        // 若result_code為0或token為NULL，都代表登入失敗，返回原頁面並提示錯誤提示
        if (!isset($loginResponseArray['result_code']) || $loginResponseArray['result_code'] == 0 || !$iotToken) {
            // 回傳失敗結果
            logger()->debug('login failed : ' . $loginResponseArray['message']);
            return Redirect::back()->withInput($input)->withErrors([$loginResponseArray['message']]);
        }

        logger()->debug('start bind user data');

        //根据用户的uuid获取所有设备资讯
        $uuidurl = config('flnet-iot-member.base_api_url') . "users/" . $loginResponseArray['user']['uuid'] . "/devices";
        $uuidresult = $this->doGet('Bearer ' . $iotToken, $uuidurl);
        $uuidres = json_decode($uuidresult, true);
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
                    $pointUserId = $loginResponseArray['user']['user_client']['user_id'];
                    $pointAccessToken = $loginResponseArray['access_token'];
                    $randNum19 = $this->GetRandStr(80);
                    $pointArr = array(
                        'ticket' => $randNum19,
                        'definition' => '绑定设备',
                        'client_id' => config('wechat.official_account.default.point_client_id'),
                        'client_secret' => config('wechat.official_account.default.point_client_secret'),
                        'user_id' => $loginResponseArray['user']['user_client']['user_id'],
                        'user_uuid' => $loginResponseArray['user']['uuid'],
                        'user_name'=>$loginResponseArray['user']['nickname'],
                        'access_token' => $loginResponseArray['access_token'],
                        'bonus_point' => config('wechat.official_account.default.point_bind_device'),
                    );
                    $createPointResult = $this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes = json_decode($createPointResult, true);
                    $points = config('wechat.official_account.default.point_bind_device');
                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum19,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定空气净化器设备','createtime'=>$tim]);
                }
            }
        }
        session(['useruuid' => $loginResponseArray['user']['uuid']]);
        session(['status' => 1]);
        session(['mobile' => $loginResponseArray['user']['mobile']]);
        session(['pass' => $newpass]);
        session(['anotherMobile' => $newmobile]);
        session(['nickname' => $loginResponseArray['user']['nickname']]);
        session(['newimage'=>$loginResponseArray['user']['avatar']]);
        session(['pointUserId' => $loginResponseArray['user']['user_client']['user_id']]);
        session(['pointAccessToken' => $loginResponseArray['access_token']]);

        //调用大会员的mapping映射接口，获取到影视会员id
        $chrageResult=$this->doGet('Bearer ' . $iotToken,config('flnet-iot-member.base_api_url') . 'users/cms-search?user_uuid='.session('useruuid') );
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
                            $tim = time();
                            $pointClientId=config('wechat.official_account.default.point_client_id');
                            $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                            $pointUserId=$loginResponseArray['user']['user_client']['user_id'];
                            session(['bindsharp'=>1]);
                            $pointUseruuid=session('useruuid');
                            $pointAccessToken=$loginResponseArray['access_token'];
                            $randNum20=$this->GetRandStr(80);
                            $pointArr=array(
                                'ticket'=>$randNum20,
                                'definition'=>'绑定设备',
                                'client_id'=>config('wechat.official_account.default.point_client_id'),
                                'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                                'user_id'=>$loginResponseArray['user']['user_client']['user_id'],
                                'user_uuid'=>$loginResponseArray['user']['uuid'],
                                'user_name'=>$loginResponseArray['user']['nickname'],
                                'access_token'=>$loginResponseArray['access_token'],
                                'bonus_point'=>config('wechat.official_account.default.point_bind_device'),
                            );
                            $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                            $createPointRes=json_decode($createPointResult,true);
                            $points = config('wechat.official_account.default.point_bind_device');
                            $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum20,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定夏普电视设备','createtime'=>$tim]);

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
    //快捷登录时使用的方法
    public function fastLogin(Request $request)
    {
        $tim = time();
        //将正常的时间格式转化为毫秒级的时间格式
        $newtim = $this->get_microtime_format($tim);//2018-07-17 09:03:39.000
        //将毫秒级时间格式转化为毫秒级的时间戳
        $netime = $this->get_data_format($newtim);//1531818148000
        session(['time'=>$netime]);
        $input = $request->all();
        logger()->debug('fast login post form');

        $newUsername = $input['usernames'];
        $newMobileCode = $input['mobile_confirm_code'];
        $confirm_code=$input['confirm_code'];
        /** @var FlnetIotMemberApiService $flnetIotMemberApiService 大會員接口集成服務 */

        $flnetIotMemberApiService = App::make(FlnetIotMemberApiService::class);
        // 調用api/auth/fast-login快捷登录接口進行登入
        $loginApiInput = array(
            'mobile' =>$newUsername,
            'mobile_country_code'=>'+86',
            'mobile_confirm_code' => $newMobileCode,
        );
        $flnetIotMemberApiService->loginFastRegister($loginApiInput['mobile'], $loginApiInput['mobile_confirm_code'], $loginApiInput);
        $loginResponse = $flnetIotMemberApiService->getResponse();
        $loginResponseArray = json_decode($loginResponse->getBody(), true);
        $iotToken = isset($loginResponseArray['access_token']) ? $loginResponseArray['access_token'] : NULL;

        if($confirm_code !== session('milkcaptchas'))
        {
            return Redirect::back()->withInput($input)->withErrors(['图形验证码验证失败！']);
        }
        else
        {
            // 若result_code為0或token為NULL，都代表第三方登入失敗，返回原頁面並提示錯誤提示
            if (!isset($loginResponseArray['result_code']) || $loginResponseArray['result_code'] == 0 || !$iotToken)
            {
                logger()->debug('fast login failed : ' . $loginResponseArray['message']);
                session(['newuserlogin' => 1]);
                return Redirect::back()->withInput($input)->withErrors([$loginResponseArray['message']]);
            }
            else
            {
                logger()->debug('$iotToken = ' . $iotToken);
                logger()->debug('user uuid = ' . $loginResponseArray['user']['uuid']);
                logger()->debug('fast login success');
                //根据用户的uuid获取所有设备资讯
                $uuidurl = config('flnet-iot-member.base_api_url') . "users/" . $loginResponseArray['user']['uuid'] . "/devices";
                $uuidresult = $this->doGet('Bearer ' . $iotToken, $uuidurl);
                $uuidres = json_decode($uuidresult, true);
                if (isset($uuidres['devices'])) {
                    session(['userdev' => $uuidres['devices']]);
                    if(session('userdev') &&  (session('binddevice5') !==1))
                    {
                        foreach($uuidres['devices'] as $v)
                        {
                            if($v['type']==5)
                            {
                                $tim = time();
                                $pointClientId=config('wechat.official_account.default.point_client_id');
                                $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                                session(['binddevice5'=>1]);
                                $pointUseruuid=session('useruuid');
                                $pointUserId=$loginResponseArray['user']['user_client']['user_id'];
                                $pointAccessToken=$loginResponseArray['access_token'];
                                $randNum21=$this->GetRandStr(80);
                                $pointArr=array(
                                    'ticket'=>$randNum21,
                                    'definition'=>'绑定设备',
                                    'client_id'=>config('wechat.official_account.default.point_client_id'),
                                    'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                                    'user_id'=>$loginResponseArray['user']['user_client']['user_id'],
                                    'user_uuid'=>$loginResponseArray['user']['uuid'],
                                    'user_name'=>$loginResponseArray['user']['nickname'],
                                    'access_token'=>$loginResponseArray['access_token'],
                                    'bonus_point'=>config('wechat.official_account.default.point_bind_device'),
                                );
                                $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                                $createPointRes=json_decode($createPointResult,true);
                                $points = config('wechat.official_account.default.point_bind_device');
                                $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum21,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定空气净化器设备','createtime'=>$tim]);

                            }
                        }


                    }
                    logger()->debug('device count = ' . count($uuidres['devices']));
                }
                session(['status' => 1]);//改变状态为1
                session(['mobile' => $loginResponseArray['user']['mobile']]);
                session(['pass' => $newMobileCode]);//默认密码第一次只有30分钟有效期
                session(['anotherMobile' => $loginResponseArray['user']['mobile']]);
                session(['useruuid' => $loginResponseArray['user']['uuid']]);
                session(['nickname' => $loginResponseArray['user']['nickname']]);
                session(['newimage'=>$loginResponseArray['user']['avatar']]);
                session(['pointUserId' => $loginResponseArray['user']['user_client']['user_id']]);
                session(['pointAccessToken' => $loginResponseArray['access_token']]);
                //用户首次登录成功后新增20积分
                if(session('createPointStatus') !== 1)
                {
                    $tim = time();
                    $pointClientId=config('wechat.official_account.default.point_client_id');
                    $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                    $pointUserId=$loginResponseArray['user']['user_client']['user_id'];
                    $pointUseruuid=session('useruuid');
                    $pointAccessToken=$loginResponseArray['access_token'];
                    session(['createPointStatus'=>1]);
                    $randNum22=$this->GetRandStr(80);
                    $pointArr=array(
                        'ticket'=>$randNum22,
                        'definition'=>'首次登入奖励',
                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                        'user_id'=>$loginResponseArray['user']['user_client']['user_id'],
                        'user_uuid'=>$loginResponseArray['user']['uuid'],
                        'user_name'=>$loginResponseArray['user']['nickname'],
                        'access_token'=>$loginResponseArray['access_token'],
                        'bonus_point'=>config('wechat.official_account.default.point_register_bounes'),
                    );
                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                    $createPointRes=json_decode($createPointResult,true);

                    $points = config('wechat.official_account.default.point_bind_device');
                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum22,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>1,'bonus_point'=>$points,'orderid'=>'','definition'=>'快捷登录','createtime'=>$tim]);
                }
                // 註冊成功後，導向到管理頁面
                //调用大会员的mapping映射接口，获取到影视会员id
                $chrageResult=$this->doGet('Bearer ' . $iotToken,config('flnet-iot-member.base_api_url') . 'users/cms-search?user_uuid='.session('useruuid') );
                $chargeRes=json_decode($chrageResult,true);//获得影视会员的信息（包括 id,mobile,nickname);
                //判断是否是夏普影视会员result_code==1而且cms_user['id']存在即为会员
                if($chargeRes['result_code']==1 && $chargeRes['cms_user'])
                {
                    $chargeId=$chargeRes['cms_user']['id'];$chargeTel=$chargeRes['cms_user']['mobile'];$chargeNickName=$chargeRes['cms_user']['nickname'];//$chargeId就是影视会员ID
                    //获取到影视会员id，接下来就开始和kidd对接....................................//
                    if($chargeId)
                    {
                        session(['accountid'=>$chargeId]);
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
                                if(session('rechargeDisplay') &&  (session('bindsharp')!==1))
                                {
                                    session(['bindsharp'=>1]);
                                    $pointUseruuid=session('useruuid');
                                    $pointClientId=config('wechat.official_account.default.point_client_id');
                                    $pointClientSecret=config('wechat.official_account.default.point_client_secret');
                                    $pointUserId=$loginResponseArray['user']['user_client']['user_id'];
                                    $pointAccessToken=$loginResponseArray['access_token'];
                                    $randNum23=$this->GetRandStr(80);
                                    $pointArr=array(
                                        'ticket'=>$randNum23,
                                        'definition'=>'绑定设备',
                                        'client_id'=>config('wechat.official_account.default.point_client_id'),
                                        'client_secret'=>config('wechat.official_account.default.point_client_secret'),
                                        'user_id'=>$loginResponseArray['user']['user_client']['user_id'],
                                        'user_uuid'=>$loginResponseArray['user']['uuid'],
                                        'user_name'=>$loginResponseArray['user']['nickname'],
                                        'access_token'=>$loginResponseArray['access_token'],
                                        'bonus_point'=>config('wechat.official_account.default.point_bind_device'),
                                    );
                                    $createPointResult=$this->curlPost(config('wechat.official_account.default.create_point_url'), $pointArr);
                                    $createPointRes=json_decode($createPointResult,true);
                                    $points = config('wechat.official_account.default.point_bind_device');
                                    $results=DB::table('cancel_point')->insert(['client_id'=>$pointClientId,'client_secret'=>$pointClientSecret,'ticket'=>$randNum23,'user_id'=>$pointUserId,'user_uuid'=>$pointUseruuid,'access_token'=>$pointAccessToken,'integral_id'=>4,'bonus_point'=>$points,'orderid'=>'','definition'=>'绑定夏普电视设备','createtime'=>$tim]);

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

    //服务协议
    public function serviceterms()
    {
        return view('service-terms');
    }
    //隐私权政策
    public function privacy()
    {
        return view('privacy');
    }
    //关于富连网
    public function aboutflnet()
    {
        return view('about-flnet');
    }
    //富连网链接地址
    public function linkflnet()
    {
        return view('linkflnet');
    }
    //重定向到登录页面
    public function newLogin()
    {
        $broker=new Broker(config('wechat.sso.default.sso_server'),config('wechat.sso.default.sso_broker_id'),config('wechat.sso.default.sso_broker_secret'));
        $broker->attach(true);
        //获取用户的信息
        $userinfo=$broker->getUserInfo();
        //未取得用户资料，将导向至大会员的登录页面
        if(empty($userinfo))
        {
            $action='login';
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
            exit();

        }
        //return view('login');
    }
    //微博登录处理函数
    public function weibo()
    {
        $baseUrl = urlencode('https://vipaccount.flnet.com/weibo');
        $url = $this->__CreateOauthUrlForWeiboCode($baseUrl);
        header("Location:$url");
        exit();
    }
    //微信登录处理函数
    public function weixin()
    {
        //触发微信返回code码
        $baseUrl = urlencode('https://vipaccount.flnet.com/weixin');
        $url = $this->__CreateOauthUrlForWeixinCode($baseUrl);
        header("Location:$url");
        exit();
    }
    //qq登录处理函数
    public function qq()
    {
        $baseUrl = urlencode('https://vipaccount.flnet.com/qq');
        $url = $this->__CreateOauthUrlForQqCode($baseUrl);
        header("Location:$url");
        exit();
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

    private function __CreateOauthUrlForWeiboCode($redirectUrl)
    {
        $client_id = '4042140543';
        $urlObj["client_id"] = $client_id;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["scope"] = "";
        $urlObj["response_type"] = "code";
        $urlObj["state"] = "sSAkYspaF2bgDsAK48Iy7CPR8Qsf20ng76OWlsA8";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weibo.com/oauth2/authorize?" . $bizString;
    }

    private function __CreateOauthUrlForWeixinCode($redirectUrl)
    {
        $newappid = 'wxaa7b4c753b91691c';
        $urlObj["appid"] = $newappid;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_login";
        $urlObj["state"] = "vrwZ2VuaUG7OopGvDz0UQpL205CVewnjTOT23hlf" . "#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/qrconnect?" . $bizString;
    }

    private function __CreateOauthUrlForQqCode($redirectUrl)
    {
        $login = 'Login';
        $urlObj["which"] = $login;
        $urlObj['display'] = 'pc';
        $urlObj['client_id'] = '101463804';
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["scope"] = "get_user_info";
        $urlObj["response_type"] = "code";
        $urlObj["state"] = "c7uxLXwIASUKzKkG8IpMqBiPrZehi68VIWg7ccyL";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://graph.qq.com/oauth2.0/show?" . $bizString;
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

    public function GetOpenid()
    {
        //通过code获得openid
        if (!isset($_GET['code'])) {
            //触发微信返回code码
            $baseUrl = urlencode('http://pay.fujinfu.cn/oauth2_payservice_test.php?istype=2');
            $url = $this->__CreateOauthUrlForCode($baseUrl);
            header("Location:$url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $openid = $this->GetOpenidFromMp($code);
            return $openid;
        }
    }

    private function __CreateOauthUrlForCode($redirectUrl)
    {
        $newappid = config('wechat.official_account.default.app_id');
        $urlObj["appid"] = $newappid;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE" . "#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?" . $bizString;
    }

    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        $news = $this->https_request($url);
        $data = json_decode($news, true);
        $openid = $data['openid'];
        return $openid;
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
        return "https://api.weixin.qq.com/sns/oauth2/access_token?" . $bizString;
    }
}

