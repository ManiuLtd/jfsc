<?php 
namespace App\Http\Controllers;

use DB;
use Jasny\SSO\NotAttachedException;
use Session;
use Request;

class Broker extends Controller {

	/*
	| --------------------------------------
	| Please note that you should re-login to see the session work
	| --------------------------------------
	|
	*/
	protected $url;
    public $broker;
    protected $secret;
    public $token;
    protected $isSsoSiteAlive;
    protected $userinfo;
    protected $uuid;
    protected $cookie_lifetime;

    public function __construct($url,$broker,$secret,$cookie_lifetime=7200)
    {
        if(!$url) throw new \InvalidArgumentException("SSO server URL not specified");
        if(!$broker) throw new \InvalidArgumentException("SSO broker id not specified");
        if(!$secret) throw new \InvalidArgumentException("SSO broker secret not specified");
        $this->url =$url;
        $this->broker=$broker;
        $this->secret=$secret;
        $this->cookie_lifetime=$cookie_lifetime;
        if(isset($_COOKIE[$this->getCookieName()])) $this->token=$_COOKIE[$this->getCookieName()];
    }

    protected function getCookieName()
    {
        return 'sso_token_'.preg_replace('/[_\W]+/','_',strtolower($this->broker));
    }

    public function getSessionId()
    {
        if(!isset($this->token)) return null;
        $checknum = hash('sha256','session'.$this->token.$this->secret);
        return "SSO-{$this->broker}-{$this->token}-$checknum";
    }

    public function generateToken()
    {
        if(isset($this->token)) return ;
        $this->token=base_convert(md5(uniqid(rand(),true)),16,36);
        setcookie($this->getCookieName(),$this->token,time()+$this->cookie_lifetime,'/');
    }

    public function clearToken()
    {
        setcookie($this->getCookieName(),null,1,'/');
        $this->userinfo=$this->getUserInfoFromSession();
        if($this->userinfo)
        {
            $this->clearUserInfoFromSession();
        }
        $this->token = null;
    }

    public function isAttached()
    {
        return isset($this->token);
    }

    public function getAttachUrl($params =array())
    {
        $this->generateToken();
        $data=array(
            'command'=>'attach',
            'broker'=>$this->broker,
            'token'=>$this->token,
            'checksum'=>hash('sha256','attach',$this->token.$this->secret)
        );
        $data=array_merge($data,$_GET);
        return $this->url."?".http_build_query($data+$params);
    }

    public function attach($returnUrl = null)
    {
        if($this->isAttached()) return;
        if($returnUrl === true)
        {
            $protocol=!empty($_SERVER['HTTPS'])?'https://':'http://';
            $returnUrl=$protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        if(!$this->checkSsoSiteAlive($this->url.'/login'))
        {
            return;
        }
        $params=array('return_url'=>$returnUrl);
        $url=$this->getAttachUrl($params);
        header("Location:$url",true,307);
        echo "You're redirected to <a href='$url'>$url</a>";
        exit();
    }

    protected function getRequestUrl($command,$params=array())
    {
        $params['command']=$command;
        return $this->url.'?'.http_build_query($params);
    }

    protected function request($method,$command,$data=null)
    {
        if(!$this->isAttached())
        {
            throw new NotAttachedException('No token');
        }
        $url=$this->getRequestUrl($command,!$data || $method==='POST'?array():$data);
        $ch=curl_init($url);
        $SSL=substr($url,0,8)=="https://" ? true : false;
        if($SSL)
        {
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$method);
        curl_setopt($ch,CURLOPT_VERBOSE,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Accept:application/json','Authorization:Bearer '.$this->getSessionID()));
        if($method==='POST' && !empty($data))
        {
            $post=is_string($data)?$data:http_build_query($data);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
        }
        $response=curl_exec($ch);
        if(curl_errno($ch) != 0)
        {
            $message = 'Server request failed:'.curl_error($ch);
            throw new Exception($message);
        }
        $httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        list($contentType)=explode(';',curl_getinfo($ch,CURLINFO_CONTENT_TYPE));
        if($contentType != 'application/json')
        {
            $message='Expected application/json response,got '. $contentType;
            throw new Exception($message);
        }
        $data=json_decode($response,true);
        if($httpCode == 403)
        {
            $this->clearToken();
            throw new NotAttachedException($data['error']?:$response,$httpCode);
        }
        if($httpCode>=400) throw new Exception($data['error']?:$response,$httpCode);
        return $data;
    }

    public function getUserInfo($sso_user_id = null)
    {
        // 服務器暫存
        $this->userinfo = $this->getUserInfoFromSession();

        if (!isset($this->userinfo) || !$this->userinfo) {
            // 透過API從sso server獲取用戶資料
            $this->userinfo = $this->request('GET', 'userInfo', is_null($sso_user_id)?null:array('sso_user_id' => $sso_user_id));

            // 用uuid作為key值
            if (isset($this->userinfo['uuid']) && $this->userinfo['uuid']) {
                // 將結果暫存在session中，n小时後過期
                $this->uuid = $this->userinfo['uuid'];
                $this->saveUuidToSession($this->uuid);
                $this->saveUserInfoToSession($this->userinfo);
            }
        }

        return $this->userinfo;

    }

    public function encode($string,$key)
    {
        return str_replace(array('+','/'),array('-','_'),base64_encode($string));
    }

    //$broker=new Jasny\SSO\Broker($serverUrl,$brokerId,$brokerSecret);
}