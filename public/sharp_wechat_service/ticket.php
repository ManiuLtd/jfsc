<?php
$appid="wx36fd584bb2fa5b06";
$secret="0a98f189f32dcabfe2084b572225997e";
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$str=curl_exec($ch);
if($str!=false)
{
	$jsonstr=json_decode($str);
	$access_token=$jsonstr->access_token;
}else{
	echo curl_error($ch);
}
curl_close($ch);
$url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
$post='{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "LCD-45SF460A"}}}';
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$str=curl_exec($ch);
curl_close($ch);
$jsonstr=json_decode($str);
$ticket=urlencode($jsonstr->ticket);
echo $url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_exec($ch);
curl_close($ch);
?>