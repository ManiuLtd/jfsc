<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
class QrcodeController Extends Controller{
    //创建临时二维码
    public function createTempTicket()
    {
        $appid = config('wechat.official_account.default.app_id');
        $appsecret = config('wechat.official_account.default.secret');
        $accessurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        $accessinfo = $this->https_request($accessurl);
        $results = json_decode($accessinfo, true);
        $accesstoken = $results['access_token'];
        $ticketUrl="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$accesstoken;
        $postArr=array('expire_seconds'=>2592000,'action_name'=>'QR_SCENE','action_info'=>array('scene'=>array('scene_id'=>888)));
        $postarr=json_encode($postArr);
        $result=$this->curl_post($ticketUrl,$postarr);
        $res=json_decode($result,true);
        $ticket=urlencode($res['ticket']);
        $ticketurl="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
        header("Location:$ticketurl");
        exit();
    }
    //创建永久二维码
    public function createForeverTicket()
    {
        $appid = config('wechat.official_account.default.app_id');
        $appsecret = config('wechat.official_account.default.secret');
        $accessurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        $accessinfo = $this->https_request($accessurl);
        $results = json_decode($accessinfo, true);
        $accesstoken = $results['access_token'];
        $ticketUrl="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$accesstoken;
        $postArr=array('action_name'=>'QR_LIMIT_SCENE','action_info'=>array('scene'=>array('scene_id'=>888)));
        $postarr=json_encode($postArr);
        $result=$this->curl_post($ticketUrl,$postarr);
        $res=json_decode($result,true);
        $ticket=urlencode($res['ticket']);
        $ticketurl="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
        header("Location:$ticketurl");
        exit();
    }
    public function curl_post($url, $postFields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json; charset=utf-8",
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function https_request($url)//自定义函数,访问url返回结果
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl))
        {
            return 'ERROR' . curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }
    public function https_requestPic($url)//自定义函数,访问url返回结果
    {
        $headers=array(
            'Content-Type:image/jpg',
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl))
        {
            return 'ERROR' . curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }
}
?>

