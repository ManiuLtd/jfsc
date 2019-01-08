<?php
define("TOKEN", "weixin");//自己定义的token 就是个通信的私�?
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
   
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
        $as=array('type'=>'view','name'=>'����','url'=>'http://iot.flnet.com/InteMall/QrCode');
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
   private function checkSignature()
    {
        if(!defined("TOKEN"))
        {
            throw new Exception("TOKEN is not defined!");
        }
        $signature = $_GET["signature"];//从用户端获取签名赋予变量signature
        $timestamp = $_GET["timestamp"];//从用户端获取时间戳赋予变量timestamp
        $nonce = $_GET["nonce"];    //从用户端获取随机数赋予变量nonce

        $token = TOKEN;//将常量token赋予变量token
        $tmpArr = array($token, $timestamp, $nonce);//简历数组变量tmpArr
        sort($tmpArr, SORT_STRING);//新建排序
        $tmpStr = implode( $tmpArr );//字典排序
        $tmpStr = sha1( $tmpStr );//shal加密
        //tmpStr与signature值相同，返回真，否则返回�?
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
 public function curlPosts($url,$postFields)
    {
        $ch = curl_init ();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }



    public function https_request($url)//自定义函�?访问url返回结果
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)){
            return 'ERROR'.curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }
    public function valid()//验证接口的方�?
    {
        $echoStr = $_GET["echostr"];//从微信用户端获取一个随机字符赋予变量echostr
        //valid signature , option访问�?1行的checkSignature签名验证方法，如果签名一致，输出变量echostr，完整验证配置接口的操作
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }


}
?>