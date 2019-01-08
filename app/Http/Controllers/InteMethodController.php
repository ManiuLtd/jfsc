<?php
/***积分商城积分方法***/
/***开发：田鑫***/
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class InteMethodController Extends Controller{
    public function index(){
        date_default_timezone_set('PRC');
        $res=DB::table('inte_method')->get();
        //会员积分数量
        $Inteurl=config('wechat.official_account.default.get-remaining');
        $Intedata=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
        ];
        $arr=$this->curl_post($Inteurl,$Intedata);
        $beginTime=strtotime(date("Y-m-d 00:00:00",time()));
        $endTime=strtotime(date("Y-m-d 23:59:59",time()));
        $today_point=DB::table('cancel_point')->where([['createtime','>=',$beginTime],['createtime','<',$endTime],['user_id','=',session('pointUserId')],['user_uuid','=',session('useruuid')]])->sum('bonus_point');

        return view('InteMethod.index',['res'=>$res,'arr'=>$arr,'today_point'=>$today_point]);
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

