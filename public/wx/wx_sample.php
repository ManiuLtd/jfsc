<?php
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
$wechatObj->token();
$wechatObj->delMenu();
$wechatObj->menu();
class wechatCallbackapiTest
{
	protected 	$appid="wx648efe06b5d56db6";
	protected	$secret="4a231637756bd650ed133710fa2eb746";
	public function valid()
    {
        $echoStr = $_GET['echostr'];
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }	
	private function checkSignature()
	{
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	public function token(){
		$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->secret;
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$str=curl_exec($ch);
		if($str!= false)
		{
			$jsonstr=json_decode($str);
			return $jsonstr->access_token;
		}else{
			echo curl_error($ch);
		}
		curl_close($ch);
	}
	public function delMenu(){
		$url="https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$this->token();
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_exec($ch);
		curl_close($ch);	
	}
	public function menu(){
		$post='{
			 "button":[{    
							"type":"view",
							"name":"首页",
							"url":"http://iot.flnet.com"
						},
						{    
							"type":"view",
							"name":"积分商城",
							"url":"http://iot.flnet.com/InteMall/index"
						},
						{    
							"type":"view",
							"name":"我的",
							"url":"http://iot.flnet.com/displayManage"
						}]
		 }';
		$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->token();
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_exec($ch);
		curl_close($ch);
	}
}
?>