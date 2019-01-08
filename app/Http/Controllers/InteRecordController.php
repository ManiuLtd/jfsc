<?php
/***积分商城兑换记录***/
/***开发：田鑫***/
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class InteRecordController Extends Controller{
    public function index(){
        date_default_timezone_set('PRC');
        //取得兑换历史记录
        $url=config('wechat.official_account.default.exchange-history-list');
        $data=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
        ];
        $json_arr=$this->curl_post($url,$data);
        if($json_arr['list']){
            $count=count($json_arr['list']);
            $exchange_integral=0;
            foreach($json_arr['list'] as $val){
                $exchange_integral+=$val['bonus_point'];
            }
        }

        //查询个人剩余积分
        $Inteurl=config('wechat.official_account.default.get-remaining');
        $Intedata=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
        ];
        $res=$this->curl_post($Inteurl,$Intedata);
        return view('InteRecord.index',['HistoryRecords'=>$json_arr['list'],'remaining_point'=>$res['remaining_point'],'count'=>$count,'exchange_integral'=>$exchange_integral]);
    }
    public function curl_post($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res=curl_exec($ch);
        $arr=json_decode($res,true);
        curl_close($ch);
        return $arr;
    }
}
?>

