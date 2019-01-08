<?php
/***积分商城栏目商品列表***/
/***开发：田鑫***/
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class InteListController Extends Controller{
    public function index(Request $request){
        $url=config('wechat.official_account.default.list_url');
        $class_id=$request->class_id;
        $data=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'type'=>2,
            'class_id'=>$class_id
        ];
        $res=$this->curl_post($url,$data);
        return view('InteList.index',['product'=>$res['products']]);
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
    public function bindString($len=80){
        $str="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxwz0123456789!@#$%^&*+-*/";
        $num=strlen($str)-1;
        $getStr='';
        for($i=0;$i<$len;$i++){
            $getStr.=$str[rand(0,$num)];
        }
        return $getStr;
    }
}
?>

