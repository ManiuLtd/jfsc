<?php

namespace App\Http\Controllers;
use EasyWeChat;
use EasyWeChat\OfficialAccount\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use EasyWeChat\OfficialAccount\Menu\Client;
class WechatController extends Controller
{
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    /**
     * 接入微信并处理微信文本消息
     *
     * @return string
     */
    public function serve()
    {
        $time = time();
        session(['time' => $time]);
        $request=new Request();
        $postStr=$request->getContent();//将用户端发送的数据保存到变量postStr中，由于微信端发送的都是xml，使用postStr无法解析，故使用$request->getContent()获取,laravelHOnga不支持$GLOBALS["HTTP_RAW_POST_DATA"]
        if (!empty($postStr)){
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//将postStr变量进行解析并赋予变量postObj。simplexml_load_string（）函数是php中一个解析XML的函数，SimpleXMLElement为新对象的类，LIBXML_NOCDATA表示将CDATA设置为文本节点，CDATA标签中的文本XML不进行解析
            $fromUsername = $postObj->FromUserName;//将微信用户端的用户名赋予变量FromUserName
            $toUsername = $postObj->ToUserName;//将你的微信公众账号ID赋予变量ToUserName
            $keyword = trim($postObj->Content);//将用户微信发来的文本内容去掉空格后赋予变量keyword
            $ev = $postObj->Event;
            //构建XML格式的文本赋予变量textTpl，注意XML格式为微信内容固定格式，详见文档
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
            $newtextTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Event><![CDATA[%s]]></Event>
                            <EventKey><![CDATA[%s]]></EventKey>
                            </xml>";

            $newsTpl="<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType>< ![CDATA[news] ]></MsgType>
<ArticleCount>2</ArticleCount>
<Articles>
<item>
<Title>< ![CDATA[title1] ]></Title>
<Description>< ![CDATA[description1] ]></Description>
<PicUrl>< ![CDATA[picurl1] ]></PicUrl>
<Url>< ![CDATA[url1] ]></Url>
</item>
<item>
<Title>< ![CDATA[title2] ]></Title>
<Description>< ![CDATA[description2] ]></Description>
<PicUrl>< ![CDATA[picurl2] ]></PicUrl>
<Url>< ![CDATA[url2] ]></Url>
</item>
</Articles>
</xml>";

            if(!empty( $keyword ))
                //如果用户端微信发来的文本内容不为空，执行46--51否则52--53
            {
                if($msgType="text"){

                    if($keyword==1)
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户，您好！非常感谢您的反馈，如果您已经扫码支付成功，请不要重复扫码支付。建议您尝试登出账号重新登陆或者切换连接热点，查看是否可以观看该影片，如果仍无法观看，请您致电夏普全国售后热线400-898-1818，感谢您对夏普电视的支持！非常抱歉给您带来不便！";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }
                    if($keyword==2)
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户，您好！新购买的夏普电视会有免费的会员赠送，您可以按照会员领取指引领取或者拨打夏普全国售后服务电话咨询领取。在赠送会员未到期之前，请不要购买新会员或者续费，不然赠送会员将会因为权益冲突而不能累计。如果您会员到期后缴费充值新会员未能按时到您的账户，您可以退出账户后重新登录查看，如仍未能到账，请您拨打我们的全国售后服务电话400-898-1818进行咨询。我们的售后人员会和您一起解决您的问题。";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }
                    if($keyword==3)
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户，暂未达到在平台播放要求，应版权方要求，该影片未达到VIP影视欣赏的条件内，需要支付对版权方的影片购买权益。您可以选择在线支付或者使用观影券进行观看，也可以静等该影片上线VIP权益后再观看。非常抱歉给您带来不便！";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }
                    if($keyword==4)
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户，您的问题小夏无法回答，为了更好地为您解决问题，请致电售后服务热线400-898-1818，非常抱歉给您带来不便！";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }
                    if(empty($keyword))
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户：
您好！感谢您在富连网物联网智能家居的公众号上留言。
◆单片点播无法观看，回复1
◆VIP充值无法到账，回复2
◆为什么要购买单片，回复3
◆其他问题，请回复4";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }
                   /* if(substr_count($keyword,"您好") || substr_count($keyword,"你好") || substr_count($keyword,"有人") || substr_count($keyword,"在吗"))
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户您好！请问有什么可以为您服务的？";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }
                    if(substr_count($keyword,"只能试看6分钟") || substr_count($keyword,"还要购买") || substr_count($keyword,"还要付款"))
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户，暂未达到在平台播放要求，应版权方要求，该影片未达到VIP影视欣赏的条件内，需要支付对版权方的影片购买权益。您可以选择在线支付或者使用观影券进行观看，也可以静等该影片上线VIP权益后再观看。非常抱歉给您带来不便！";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }
                    if(substr_count($keyword,"扫码") || substr_count($keyword,"支付") || substr_count($keyword,"购买") || substr_count($keyword,"付款") || substr_count($keyword,"缴了费") || substr_count($keyword,"交了费") || substr_count($keyword,"看不了") || substr_count($keyword,"没办法看") || substr_count($keyword,"不能看") || substr_count($keyword,"不能用") || substr_count($keyword,"微信") || substr_count($keyword,"支付宝"))
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户，您好！非常感谢您的反馈，如果您已经扫码支付成功，请不要重复扫码支付。建议您尝试登出账号重新登陆或者切换连接热点，查看是否可以观看该影片，如果仍无法观看，请您致电夏普全国售后热线400-898-1818，感谢您对夏普电视的支持！非常抱歉给您带来不便！";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }
                    if(substr_count($keyword,"会员") || substr_count($keyword,"领取") || substr_count($keyword,"充值") || substr_count($keyword,"缴费") || substr_count($keyword,"交费") || substr_count($keyword,"VIP") || substr_count($keyword,"没到账") || substr_count($keyword,"没成功") || substr_count($keyword,"没有开通") || substr_count($keyword,"没开通"))
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户，您好！新购买的夏普电视会有免费的会员赠送，您可以按照会员领取指引领取或者拨打夏普全国售后服务电话咨询领取。在赠送会员未到期之前，请不要购买新会员或者续费，不然赠送会员将会因为权益冲突而不能累计。如果您会员到期后缴费充值新会员未能按时到您的账户，您可以推出账户后重新登录查看，如仍未能到账，请您拨打我们的全国售后服务电话400-898-1818进行咨询。我们的售后人员会很您一起解决您的问题。";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }*/
                    else
                    {
                        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                        $contentStr ="尊敬的用户：
您好！感谢您在富连网物联网智能家居的公众号上留言。
◆单片点播无法观看，回复1
◆VIP充值无法到账，回复2
◆为什么要购买单片，回复3
◆其他问题，请回复4";;//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;exit;//输出回复信息，即发送微信
                    }

                }

            }
            /*
            $newurls="https://vipaccount.flnet.com/zhuce";
            //$newurls="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxd5edfce8a4540de9&redirect_uri=http%3A%2F%2Fpay.fujinfu.cn%2Foauth2_payservice_test.php%3Fistype%3D2&response_type=code&scope=snsapi_base&state=STATE&connect_redirect=1#wechat_redirect";
            $appid="wxd5edfce8a4540de9";
            $appsecret="de2eea7cf9edc9d37c06d2a5784ca89c";
            $accessurl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $accessinfo=$this->https_request($accessurl);
            $lt=json_decode($accessinfo,true);
            $accesstoken=$lt['access_token'];
            $as=array('type'=>'view','name'=>"会员服务",'url'=>$newurls);
            $ass=json_encode($as,JSON_UNESCAPED_UNICODE);
            $ss="{". '"button": [' .$ass.']}';
            $menuurl="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$accesstoken;
            $meres=$this->curlPosts($menuurl,$ss);
            $newmes=json_decode($meres,true);*/
            if($ev=="subscribe"){

                $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
                //$contentStr ='歡迎關注富連網會員服務公眾號！';
                $contentStr ='尊敬的富连网用户,我们在此恭候您多时了！';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                echo $resultStr;
                exit;//输出回复信息，即发送微信
            }
            else
            {
                echo "Input something...";//不发送到微信端，只是测试使用
            }
        }
        else {
            echo "";
            exit;
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



    public function https_request($url)//自定义函数,访问url返回结果
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
    public function valid()//验证接口的方法
    {
        $echoStr = $_GET["echostr"];//从微信用户端获取一个随机字符赋予变量echostr
        //valid signature , option访问地61行的checkSignature签名验证方法，如果签名一致，输出变量echostr，完整验证配置接口的操作
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }


    public function mysqli_query ($link, $query, $resultmode = MYSQLI_STORE_RESULT) {}
    public function mysqli_connect ($host = '', $user = '', $password = '', $database = '', $port = '', $socket = '') {}
    public function mysqli_error ($link) {}
    public function mysqli_close ($link) {}
    public function session_start () {}


    //签名验证程序    ，checkSignature被18行调用。官方加密、校验流程：将token，timestamp，nonce这三个参数进行字典序排序，然后将这三个参数字符串拼接成一个字符串惊喜shal加密，开发者获得加密后的字符串可以与signature对比，表示该请求来源于微信。
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
        //tmpStr与signature值相同，返回真，否则返回假
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
