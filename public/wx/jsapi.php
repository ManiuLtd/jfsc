<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(0);
require_once "WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
//①、获取用户openid
$tools = new JsApiPay();
//$openId = $tools->GetOpenid();
echo "<pre>";print_r($tools );
?>