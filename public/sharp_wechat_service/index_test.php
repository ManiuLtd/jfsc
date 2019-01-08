<?php
define("TOKEN", "flnet_iot_member_wechat_account");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
    protected $appid = "wx36fd584bb2fa5b06";
    protected $secret = "0a98f189f32dcabfe2084b572225997e";

    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature()) {
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
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function responseMsg()
    {
//        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");

        if ($postStr) {
            $postObj = $xml = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $ToUserName = $postObj->ToUserName;
            $FromUserName = $postObj->FromUserName;
            $MsgType = $postObj->MsgType;
            $Event = $postObj->Event;
            $time = time();
            error_log("postObj is " . json_encode($postObj) . " \n", 3, './wechat_debug.log');

            if (strtolower($MsgType) == 'event' && strtolower($Event) == 'subscribe') {
                // 訂閱事件
                if (!empty($postObj->EventKey)) {
                    $EventKey = $postObj->EventKey;
                    $arr = explode('_', $EventKey);
                    $EventKey = $arr[1];
                    $url = "http://openapi.ctx.ptsharp.gitv.tv/api3.0/helpespec?site=0&model=" . $EventKey;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    $jsonStr = curl_exec($ch);
                    $jsonObj = json_decode($jsonStr);
                    $code = $jsonObj->code;
                    if($code==40190001){
                        $model = $jsonObj->data->model;
                        $downloadurl = $jsonObj->data->downloadurl;
                        $xml = "<xml> 
                            <ToUserName>%s</ToUserName> 
                            <FromUserName>%s</FromUserName> 
                            <CreateTime>%s</CreateTime> 
                            <MsgType>text</MsgType>                 
                            <Content>亲爱的夏普用户，您爱机的型号是：" . $EventKey . "，请点击&lt;a href=&quot;$downloadurl &quot; &gt;下载说明书&lt;/a&gt; </Content>                   
                            </xml>";
                    }else{
                        $xml = "<xml> 
                        <ToUserName>%s</ToUserName> 
                        <FromUserName>%s</FromUserName> 
                        <CreateTime>%s</CreateTime> 
                        <MsgType>text</MsgType>                 
                        <Content>很抱歉，机型".$EventKey."电子说明书正在加急制作中，请耐心等待，如需帮助，请致电400-898-1818！</Content>                  
                        </xml>";
                    }
                    $info = printf($xml, $FromUserName, $ToUserName, $time);
                    echo $info;
                } else {
                    $welcome = "<xml> 
						<ToUserName>%s</ToUserName> 
						<FromUserName>%s</FromUserName> 
						<CreateTime>%s</CreateTime> 
						<MsgType>text</MsgType> 				
						<Content>您好！&#x000A;欢迎关注“夏普服务支持”微信公众号&#x000A;---------------------------&#x000A;安装预约，&lt;a href=&apos; https://app.sharp.cn/Wechat/W0002/init &apos;&gt;请点击此处&lt;/a&gt;更多服务，请点击“服务中心”&#x000A;---------------------------</Content>					
						</xml>";
                    $$welcome = printf($welcome, $FromUserName, $ToUserName, $time);
                    echo $welcome;
                }
            } else if (strtolower($MsgType) == 'event' && strtolower($Event) == 'scan') {
                // 掃描事件
                if (!empty($postObj->EventKey)) {
                    $EventKey = $postObj->EventKey;
                    $url = "http://openapi.ctx.ptsharp.gitv.tv/api3.0/helpespec?site=0&model=" . $EventKey;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    $jsonStr = curl_exec($ch);
                    $jsonObj = json_decode($jsonStr);
                    $code = $jsonObj->code;
                    if($code==40190001){
                        $model = $jsonObj->data->model;
                        $downloadurl = $jsonObj->data->downloadurl;
                        $xml = "<xml> 
                        <ToUserName>%s</ToUserName> 
                        <FromUserName>%s</FromUserName> 
                        <CreateTime>%s</CreateTime> 
                        <MsgType>text</MsgType>                 
                        <Content>亲爱的夏普用户，您爱机的型号是：" . $EventKey . "，请点击&lt;a href=&quot;$downloadurl &quot; &gt;下载说明书&lt;/a&gt; </Content>                   
                        </xml>";
                }else{
                    $xml = "<xml> 
                        <ToUserName>%s</ToUserName> 
                        <FromUserName>%s</FromUserName> 
                        <CreateTime>%s</CreateTime> 
                        <MsgType>text</MsgType>                 
                        <Content>很抱歉，机型".$EventKey."电子说明书正在加急制作中，请耐心等待，如需帮助，请致电400-898-1818！</Content>                  
                        </xml>";
                     }
                    $info = printf($xml, $FromUserName, $ToUserName, $time);
                    echo $info;
                } else {
                    $welcome = "<xml> 
						<ToUserName>%s</ToUserName> 
						<FromUserName>%s</FromUserName> 
						<CreateTime>%s</CreateTime> 
						<MsgType>text</MsgType> 				
						<Content>您好！&#x000A;欢迎关注“夏普服务支持”微信公众号&#x000A;---------------------------&#x000A;安装预约，&lt;a href=&apos; https://app.sharp.cn/Wechat/W0002/init &apos;&gt;请点击此处&lt;/a&gt;更多服务，请点击“服务中心”&#x000A;---------------------------</Content>					
						</xml>";
                    $$welcome = printf($welcome, $FromUserName, $ToUserName, $time);
                    echo $welcome;
                }
            } else if (strtolower($MsgType) == 'event' && strtolower($Event) == 'click') {
                // 點擊推送事件
                $keyword = trim($postObj->Content);

                $msgTpl = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>';
                if ($postObj->EventKey == 'V10_FIX_RESERV') {
                    $result = sprintf($msgTpl, $postObj->FromUserName, $postObj->ToUserName, time(), "请致电热线：400-898-1818\n\n工作时间：24小时（节假日无休）");
                    echo $result;
                }

            } else if (strtolower($MsgType) == 'text') {
                // 一般文字訊息
                $keyword = trim($postObj->Content);
                $textTpl = "<xml> 
								<ToUserName>%s</ToUserName> 
								<FromUserName>%s</FromUserName> 
								<CreateTime>%s</CreateTime> 
								<MsgType>text</MsgType> 
								<Content>%s</Content> 
							</xml>";
                $contentStr = '夏普服务支持';
                error_log("keyword is " . $keyword . " \n", 3, './wechat_debug.log');

                if (!empty($keyword)) {
                    if (stripos($keyword, "挂架") !== false) {
                        $contentStr = "请点击菜单 我要->咨询保修政策->影音产品 或者 配件信息 了解挂架服务信息";
                    } else if (stripos($keyword, "维修") !== false) {
                        $contentStr = "未开通 维修 服务预约如果需要 维修 服务预约请致电 400-898-1818\n谢谢";
                    } else if (stripos($keyword, "安装") !== false) {
                        $contentStr = "请点击菜单 我要->申请售后服务->服务预约 进入安装/维修流程";
                    } else if (stripos($keyword, "lucksung") !== false) {
                        $contentStr = "https://app.sharp.cn/Wechat/W0002/init";
                    }
                }

                $result = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $contentStr);
                echo $result;
            }
        }
    }
}

?>
