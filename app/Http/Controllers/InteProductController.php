<?php
/***积分商城产品详情和兑换***/
/***开发：田鑫***/
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class InteProductController Extends Controller{
    public function index(Request $request){
        $url=config('wechat.official_account.default.detail');
        $data=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'product_id'=>$request->product_id,
        ];
        $product=$this->curl_post($url,$data);
        return view('InteProduct.index',['products'=>$product['products'],'series_num'=>$request->sernum]);
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
    public function getInte(){
        //会员积分数量
        $url=config('wechat.official_account.default.get-remaining');
        $data=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
        ];
        $res=$this->curl_post($url,$data);
        return $res['remaining_point'];
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
    public function exchange(Request $request)
    {
        //开始用积分兑换商品
        $url=config('wechat.official_account.default.exchange-goods');
        $data=[
            'ticket'=>$this->bindString(),
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
            'product_id'=>$request->product_id,
            'number'=>$request->number
        ];
        $res=$this->curl_post($url,$data);
        return $res;
    }
    public function newexchange(Request $request)
    {
        $useruuid=session('useruuid');
        $pointuserid=session('pointUserId');
        //开始用积分兑换商品
        $url=config('wechat.official_account.default.exchange-goods');
        $data=[
            'ticket'=>$this->bindString(),
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
            'product_id'=>$request->product_id,
            'number'=>$request->number,
            's_province'=>$request->s_province,
            's_city'=>$request->s_city,
            's_county'=>$request->s_county,
            's_addr'=>$request->s_addr,
            's_code'=>$request->s_code,
            's_name'=>$request->s_name,
            's_mobile'=>$request->s_mobile,
        ];
        $res=$this->curl_post($url,$data);
        if($res)
        {
            if($request->s_province && $request->s_city && $request->s_county && $request->s_addr && $request->product_id && $request->s_name && $request->s_mobile)
            {
                //拼接数据库对象数组
                $resarr=[
                    's_province'=>$request->s_province,
                    's_city'=>$request->s_city,
                    's_county'=>$request->s_county,
                    's_addr'=>$request->s_addr,
                    's_code'=>$request->s_code,
                    's_name'=>$request->s_name,
                    's_mobile'=>$request->s_mobile,
                    'product_id'=>$request->product_id,
                    'user_id'=>session('pointUserId'),
                    'user_uuid'=>session('useruuid'),
                    'openid'=>session('newopenid'),
                ];
                if(DB::table('cancel_address')->where('user_uuid',$useruuid)->where('user_id',$pointuserid)->get())
                {
                    //如果存在则更新该用户地址信息
                    $result=DB::table('cancel_address')->update($resarr);
                    session(['s_province'=>$request->s_province]);session(['s_city'=>$request->s_city]);session(['s_county'=>$request->s_county]);session(['s_addr'=>$request->s_addr]);session(['s_code'=>$request->s_code]);
                    session(['s_name'=>$request->s_name]);session(['s_mobile'=>$request->s_mobile]);
                }
                else
                {
                    //首次写入该用户地址信息
                    $result=DB::table('cancel_address')->insert($resarr);
                    session(['s_province'=>$request->s_province]);session(['s_city'=>$request->s_city]);session(['s_county'=>$request->s_county]);session(['s_addr'=>$request->s_addr]);session(['s_code'=>$request->s_code]);
                    session(['s_name'=>$request->s_name]);session(['s_mobile'=>$request->s_mobile]);
                }
            }
        }
        return $res;
    }
    public function addr(Request $request)
    {
        return view('InteAddress.index',['number'=>$request->number,'bonus_point'=>$request->bonus_point,'remaining_number'=>$request->remaining_number,'product_id'=>$request->product_id]);
    }
}
?>

