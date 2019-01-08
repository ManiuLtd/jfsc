<?php
/***积分商城首页***/
/***开发：田鑫***/
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Broker;
class InteMallController Extends Controller
{
    public function index()
    {

        ini_set('date.timezone','Asia/Shanghai');
        //累计签到次数
        $count = DB::table('cancel_point')->where([['integral_id', '=', 2], ['user_id', '=', session('pointUserId')], ['user_uuid', '=', session('useruuid')]])->count();

        //判断是否签到
        $beginTime = strtotime(date('Y-m-d 00:00:00', time()));
        $endTime = strtotime(date('Y-m-d 23:59:59', time()));
        $status = DB::table('cancel_point')->where([['createtime', '>=', $beginTime], ['createtime', '<', $endTime], ['integral_id', '=', 2], ['user_id', '=', session('pointUserId')], ['user_uuid', '=', session('useruuid')]])->count();
        //$a=Broker::encode('bes');echo "<pre>";print_r($a);
        //会员积分数量
        $Inteurl =config('wechat.official_account.default.get-remaining');
        $Intedata = [
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id' => session('pointUserId'),
            'user_uuid' => session('useruuid'),
            'access_token' => session('pointAccessToken'),
        ];
        $res = $this->curl_post($Inteurl, $Intedata);


        //积分商城banner
        $banner1=DB::table('cancel_banner1')->orderBy('banner_dates','desc')->first();
        $banner2=DB::table('cancel_banner2')->orderBy('banner_dates','desc')->first();
        $banner3=DB::table('cancel_banner3')->orderBy('banner_dates','desc')->first();

        //商品类目和商品列表
        $url=config('wechat.official_account.default.list_url');
        $data = [
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'type' => 3,
        ];
        $arr = $this->curl_post($url, $data);

        if ($arr['success'] == 1) {
            return view('InteMall.index', ['arr' => $arr, 'status' => $status, 'res' => $res, 'count' => $count,'banner1'=>$banner1,'banner2'=>$banner2,'banner3'=>$banner3]);
        } else {
            return view('InteMall.index', ['status' => $status, 'res' => $res, 'count' => $count,'banner1'=>$banner1,'banner2'=>$banner2,'banner3'=>$banner3]);
        }
    }
    public function getImage()
    {
        //获取当前的url
        $realpath = str_replace('sysimg/','',Request::path());

        $path = storage_path() . $realpath;



        if(!file_exists($path)){
            //报404错误
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit;
        }
        //输出图片
        header('Content-type: image/jpg');
        echo file_get_contents($path);
        exit;
    }
    public function getStatus()
    {
        ini_set('date.timezone','Asia/Shanghai');
        $beginTime = strtotime(date('Y-m-d 00:00:00', time()));
        $EndTime = strtotime(date('Y-m-d 23:59:59', time()));
        $status = DB::table('cancel_point')->where([['createtime', '>=', $beginTime], ['createtime', '<', $EndTime], ['integral_id', '=', 2], ['user_id', '=', session('pointUserId')], ['user_uuid', '=', session('useruuid')]])->count();
        if ($status == 0) {
            $data = [
                'client_id'=>config('wechat.official_account.default.client_id'),
                'client_secret'=>config('wechat.official_account.default.client_secret'),
                'ticket' => $this->bindString(),
                'user_id' => session('pointUserId'),
                'user_uuid' => session('useruuid'),
                'access_token' => session('pointAccessToken'),
                'createtime' => time(),
                'integral_id' => 2,
                'bonus_point' => 10,
                'definition'=>'每天签到成功'
            ];
            $res = DB::table('cancel_point')->insert($data);

            $url=config('wechat.official_account.default.create');
            $reqData = [
                'client_id'=>config('wechat.official_account.default.client_id'),
                'client_secret'=>config('wechat.official_account.default.client_secret'),
                'ticket' => $this->bindString(),
                'user_id' => session('pointUserId'),
                'user_uuid' => session('useruuid'),
                'user_name'=>session('nickname'),
                'access_token' => session('pointAccessToken'),
                'bonus_point' => 10,
                'definition' => '每天签到成功'
            ];
            //print_r($reqData);
            $reqRes = $this->curl_post($url, $reqData);
            if ($reqRes['success'] == 1 && $res) {
                $arr = ['code' => 1, 'data' => $status, 'msg' => '签到成功'];
            } else {
                $arr = ['code' => 0, 'data' => $status, 'msg' => '签到失败'];
            }
        } else {
            $arr = ['code' => 2, 'data' => $status, 'msg' => '你已签到'];
        }
        $arr = json_encode($arr);
        return $arr;
    }

    public function curl_post($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        $arr = json_decode($res, true);
        curl_close($ch);
        return $arr;
    }

    public function bindString($len = 80)
    {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxwz0123456789!@#$%^&*+-*/";
        $num = strlen($str) - 1;
        $getStr = '';
        for ($i = 0; $i <= $len; $i++) {
            $getStr .= $str[rand(0, $num)];
        }
        return $getStr;
    }
}
?>

