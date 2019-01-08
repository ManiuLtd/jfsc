<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/10
 * Time: 8:08
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\XcryptController;
use App\Http\Controllers\DesController;
use App\Http\Controllers\McryptController;
class RsaController {

    public function openssl_pkey_export($key, &$out, $passphrase = null, array $configargs = null) { }
    public function openssl_pkey_get_details($key) { }
    public function openssl_public_encrypt($data, &$crypted, $key, $padding = OPENSSL_PKCS1_PADDING) { }
    public function openssl_public_decrypt($data, &$decrypted, $key, $padding = OPENSSL_PKCS1_PADDING) { }
    public function openssl_private_encrypt($data, &$crypted, $key, $padding = OPENSSL_PKCS1_PADDING) { }
    public function openssl_private_decrypt($data, &$decrypted, $key, $padding = OPENSSL_PKCS1_PADDING) { }
    public function base64_encode ($data) {}
    public function base64_decode ($data, $strict = null) {}
    public function openssl_pkey_new(array $configargs = null) { }


    /**
     * 构造函数
     *
     * @param string 公钥文件（验签和加密时传入）
     * @param string 私钥文件（签名和解密时传入）
     */

    public $privateKey = '-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJfw61T8oFGX2Axs
rx/UxCDo7NEfw+xs27jHyac5mH27/tPoUytXJFaRkqmrq0YoqBufl7ohQKmC0rtn
bwAFAhc9UWOEo0rfcVgzvWbTXeGUg1lIiuoO9yZ++dtgnrhvDhTuJZsB05eHcchS
dkk16Azjy4+T84sM0Q2zQhJD78aPAgMBAAECgYAhHk1dZ/dV8aARDTua15ish7je
2GqvRQcbnsiwn5hCh9DCxdgjEUqFaBOs0hNyJniGFOJQmuDqUe63FJOYUH8k1aRw
AWaqgVMbZga50ABCUu95xW13iqEHxaJX7GFA2nUK6nZ3o7rqmKmv1u5zonbaLt1d
ghOGsMSQyhHnuhTtwQJBAMlv2t+nsbbLqC41+zHKFvVno9JvEcaQ1D8iIyV5qGfp
b4Vqjw7NYvxKyhsgzOnSL+3NqNXvmxZpMjEI5aCljKECQQDBGOXRbrlKhlAkdU4n
+5VgAymXKyZcyI5zockiqWLmOW18okc1zjJUM6dzM9HoJla4daRfjcDTRrGdvMVp
6dUvAkBI24Q20NieXRr/W9b3MzkKmenO+w1a3JdoHljH/TDEJNKJVvlXSUI8LnDb
TwnOqI9dW71tY7ScboAQ7D7h0/8BAkEAr2j8rEnXDHoCp3vgabXDNhrpVyedi7+s
mCIp4tDYxKb6bLPF2Hzdf1wFC0PRtP/O23YSwbK1rbeUdeQbuWDvhQJAEjjHAqml
LWODxHDk/UPv0bYzR17fyIlLI8JrfCzurOHvPGEHA8RtUzTA5KDzBQgSbfNWg+Zj
P3Iv4/Lj/rwQAw==
-----END PRIVATE KEY-----';

    public $publicKey = '-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA3m5CfM3JnRwvO1FviUgG
wqSythI3WrApQpteDzrmghut5J9XH8qSMXvfelROSvv/BiOl/fM4ftE+HKofgFae
OxSVms4qcfzwErhxs8Kd5JwgVdQc88JmzocKLHsFTr7VA9/IzCtVKIVnplQiN0/m
sStbhElO1RWnIIc97N1a8/5NoRCUv/Y/giDfY4TLn9IABokJcP+5UaYNl8qPB3Ap
hRIfvlX7PcgS952xVjNOlZe6Q8Ds9If/voLVSYzxW+0TWhn+2fUr9xDSMtJmgnQe
E0xLb0r2W+34UDHHarGea2COedZKsx/whBSmc+fGErnLjJDXJ4NfOcnQC3Jn+kve
3C1Y8msp8HDtWJW/uoprWnzc9g+A9tNBbTmRZ3kD+l/E+E3AQL0gghdJceh+uhXn
UKcaoU9e4iv14afo1YdeYjRJVAJsnabWXxLYAcKG8xZJv4S2sR3iJmyRTCLI6yKh
hI4FOfTKblAeiy02gu5Idk9f8dL9nMdjs9TYUstUr1mRjNm6tJVkAAICUxb9ZZYW
T8jzMdHxBfjKDGZwqNpsSH8pTOTV+/nvr3rVENyJlTo4Dg2/uEACpwAxJuzQW3gX
om2Z63U8ksj32jkV+6u3MIB0zr1t8Qq5FzM4n7ll762abA/DAnS4w+xY6EgLUJig
zzlB0e52Pw9ryDa8QSZoQZUCAwEAAQ==
-----END PUBLIC KEY-----';
    public function __construct()
    {

    }
    public function create_key()
    {
       /* public $public_key = '';
        public $private_key = '';
        public $configs = array('private_key_bits' => '512', 'private_key_type' => OPENSSL_KEYTYPE_RSA,);
        $res =openssl_pkey_new($configs);//print_r($res);die;
        if($res == false) return false;
        openssl_pkey_export($res, $private_key);
        $public_key = $this->openssl_pkey_get_details($res);
        return array('public_key'=>$public_key["key"],'private_key'=>$private_key);*/
        $config = array(
            //"digest_alg" => "sha512",
            "private_key_bits" => 1024,           //字节数  512 1024 2048  4096 等
            "private_key_type" => OPENSSL_KEYTYPE_RSA,   //加密类型
        );
        $pubKey = '';
        $privKey = '';
//1.创建公钥和私钥  返回资源
        $res = $this->openssl_pkey_new($config);

//从得到的资源中获取私钥  并把私钥赋给$privKey
        $this->openssl_pkey_export($res, $privKey);

//从得到的资源中获取私钥  并把私钥赋给$pubKey
        $pubKey = $this->openssl_pkey_get_details($res);

        $pubKey = $pubKey["key"];
        var_dump(array('privKey'=>$privKey,'pubKey'=>$pubKey));
        die;

    }
    public function publicEncrypt($data, $publicKey)
    {
        openssl_public_encrypt($data, $encrypted, $publicKey);
        return $encrypted;
    }

    public function publicDecrypt($data, $publicKey)
    {
        openssl_public_decrypt($data, $decrypted, $publicKey);
        return $decrypted;
    }

    public function privateEncrypt($data, $privateKey)
    {
        openssl_private_encrypt($data, $encrypted, $privateKey);
        return $encrypted;
    }

    public function privateDecrypt($data, $privateKey)
    {
        openssl_private_decrypt($data, $decrypted, $privateKey);
        return $decrypted;
    }
    public function encrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING)
    {
        $ret = false;
        if (!$this->_checkPadding($padding, 'en')) $this->_error('padding error');
        if (openssl_private_encrypt($data, $result, $this->$privateKey, $padding)) {
            $ret = $this->_encode($result, $code);
        }
        return $ret;
    }
    private function _error($msg)
    {
        die('RSA Error:' . $msg); //TODO
    }

    /**
     * 检测填充类型
     * 加密只支持PKCS1_PADDING
     * 解密支持PKCS1_PADDING和NO_PADDING
     *
     * @param int 填充模式
     * @param string 加密en/解密de
     * @return bool
     */
    private function _checkPadding($padding, $type)
    {
        if ($type == 'en') {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING:
                    $ret = true;
                    break;
                default:
                    $ret = false;
            }
        } else {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING:
                case OPENSSL_NO_PADDING:
                    $ret = true;
                    break;
                default:
                    $ret = false;
            }
        }
        return $ret;
    }

    private function _encode($data, $code)
    {
        switch (strtolower($code)) {
            case 'base64':
                $data = base64_encode('' . $data);
                break;
            case 'hex':
                $data = bin2hex($data);
                break;
            case 'bin':
            default:
        }
        return $data;
    }
    public function random($num='16'){
        $a = range(0,9);
        for($i=0;$i<$num;$i++){
            $b[] = array_rand($a);
        }
        return join("",$b);

    }
    public function openssl_encrypt($data, $method, $password, $raw_output = false, $iv = "") { }
    public function openssl_decrypt($data, $method, $password, $raw_input = false, $iv = "") { }
    public function aes_encode($message, $encodingaeskey = '', $appid = '') {
        $key = md5($encodingaeskey . '=');
        $text = $this->random(16) . pack("N", strlen($message)) . $message . $appid;
        $iv = substr($key, 0, 8);

        $block_size = 32;
        $text_length = strlen($text);
        $amount_to_pad = $block_size - ($text_length % $block_size);
        if ($amount_to_pad == 0) {
            $amount_to_pad = $block_size;
        }
        $pad_chr = chr($amount_to_pad);
        $tmp = '';
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        $text = $text . $tmp;
        /* mcrypt对称加密代码在PHP7.1已经被抛弃了，所以使用下面的openssl来代替
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($module, $key, $iv);
        $encrypted = mcrypt_generic($module, $text);
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);
        */

        $encrypted = openssl_encrypt($text, 'des-cbc', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);//echo "<pre>";print_r($encrypted);die;

        $encrypt_msg = base64_encode($encrypted);
        return $encrypt_msg;
    }
    /**
     * des-cbc加密
     * @param string  $data 要被加密的数据
     * @param string  $key 加密使用的key
     * @param string  $iv 初始向量
     */
    function des_cbc_encrypt($data, $key, $iv){
        return openssl_encrypt ($data, 'des-cbc', $key, 0, $iv);
    }

    /**
     * des-cbc解密
     * @param string  $data 加密数据
     * @param string  $key 加密使用的key
     * @param string  $iv 初始向量
     */
    function des_cbc_decrypt($data, $key, $iv){
        return openssl_decrypt ($data, 'des-cbc', $key, 0, $iv);
    }
    /**
     * des-ecb加密
     * @param string  $data 要被加密的数据
     * @param string  $key 加密密钥(64位的字符串)
     */
    public function des_ecb_encrypt($data, $key){
        return openssl_encrypt ($data, 'des-ecb', $key);
    }

    /**
     * des-ecb解密
     * @param string  $data 加密数据
     * @param string  $key 加密密钥
     */
    public function des_ecb_decrypt ($data, $key)
    {
        return openssl_decrypt($data, 'des-ecb', $key);
    }

        public function aes_decode($message, $encodingaeskey = '', $appid = '')
    {
        $key = md5($encodingaeskey . '=');
        $text=base64_decode($message);
        $iv = substr($key, 0, 8);



        /* mcrypt对称解密代码在PHP7.1已经被抛弃了，所以使用下面的openssl来代替
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($module, $key, $iv);
        $decrypted = mdecrypt_generic($module, $ciphertext_dec);
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);
        */
        $decrypted = openssl_decrypt($text, 'des-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

       /* $pad = ord(substr($decrypted, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }*/
        $decrypt_msg = base64_encode($decrypted);
        return $decrypt_msg;
    }
     public function mcrypt_encrypt ($cipher, $key, $data, $mode, $iv = null) {}
     public function desencrypt($str, $key){
        $block = 32;
        $pad = $block - (strlen($str) % $block);
        $str .= str_repeat(chr($pad), $pad);
        return base64_encode($this->mcrypt_encrypt('des', $key, $str, 'ecb') );
    }
//解密
    public function desdecrypt($sStr, $sKey) {
        $decrypted= mcrypt_decrypt(
            'des',
            $sKey,
            base64_decode($sStr),
            'ecb'
        );

        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
    public function mcrypt_module_open ($algorithm, $algorithm_directory, $mode, $mode_directory) {}
    public function mcrypt_enc_get_key_size ($td) {}
    public function mcrypt_enc_get_iv_size ($td) {}
    public function mcrypt_create_iv ($size, $source = MCRYPT_DEV_URANDOM) {}
    public function mcrypt_generic_init ($td, $key, $iv) {}
    public function mcrypt_generic ($td, $data) {}
    public function mdecrypt_generic ($td, $data) {}
    public function mcrypt_generic_deinit ($td) {}
    public function mcrypt_module_close ($td) {}
    public function jiami($key, $str)
    {
        /* Open module, and create IV */
        $td = $this->mcrypt_module_open('des', '', 'ecb', '');//print_r($td);die;
        //$td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
        //$td = mcrypt_module_open('des', '', 'cbc', '');
        $key = substr($key, 0, $this->mcrypt_enc_get_key_size($td));
        $iv_size = $this->mcrypt_enc_get_iv_size($td);
        $iv = $this->mcrypt_create_iv($iv_size, 2);
        /* Initialize encryption handle */
        if ($this->mcrypt_generic_init($td,$key, $iv) === -1)
        {
            return FALSE;
        }
        /* Encrypt data */
        $c_t = $this->mcrypt_generic($td, $str);
        /* Clean up */
        $this->mcrypt_generic_deinit($td);
        $this->mcrypt_module_close($td);
        return $c_t;
    }
    public function jiemi($key, $str)
    {
        /* Open module, and create IV */
        $td = $this->mcrypt_module_open('des', '', 'ecb', '');
        //$td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
        //$td = mcrypt_module_open('des', '', 'cbc', '');
        $key = substr($key, 0, $this->mcrypt_enc_get_key_size($td));
        $iv_size = $this->mcrypt_enc_get_iv_size($td);
        $iv = $this->mcrypt_create_iv($iv_size, 2);
        /* Initialize encryption handle */
        if ($this->mcrypt_generic_init($td, $key, $iv) === -1)
        {
            return FALSE;
        }
        /* Reinitialize buffers for decryption */
        $p_t =$this->mdecrypt_generic($td, $str);
        /* Clean up */
        $this->mcrypt_generic_deinit($td);
        $this->mcrypt_module_close($td);
        return trim($p_t);
    }

    public function checksign_IN($url, $servicecode, $dataJson) {

        $pubKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap (config('wechat.official_account.default.fzf_publickey'), 64, "\n", true ) . "\n-----END PUBLIC KEY-----";
        $priKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap ( config('wechat.official_account.default.my_privatekey'), 64, "\n", true ) . "\n-----END RSA PRIVATE KEY-----";
        $rsaPubId = openssl_pkey_get_public ( $pubKey );//富之富公钥
        $rsaPriId = openssl_pkey_get_private ( $priKey );//商户自己的私钥
        // 1
        $desKey = strtoupper ( substr ( md5 ( rand () ), 0, 8 ) );
       /* // 2
        include_once('Xcrypt/Xcrypt.php');*/
        $xcrypt = new XcryptController( $desKey);
        //$data = $this->desencrypt ( $dataJson,$this->random(8));echo "<pre>";print_r($data);
        $data = $this->des_cbc_encrypt ( $dataJson,$desKey,$desKey);//echo "<pre>";print_r($data);die;
        //$x=$this->aes_decode($data,$desKey,'');//print_r($x);die;
        // 3
        openssl_public_encrypt ( $desKey, $encrypted, $rsaPubId );
        $key = base64_encode ( $encrypted );
        // 4
        $sign_arr = array ();
        $sign_arr ['version'] = '1';
        $sign_arr ['source'] = 'ANDROID';
        $sign_arr ['servicecode'] = $servicecode;
        $sign_arr ['openid'] = '18080001333835';//账户信息中的商户编号
        $sign_arr ['random'] = md5 ( rand () );

        $signGene = array (
            'version',
            'random',
            'source',
            'servicecode',
            'openid'
        );
        sort ( $signGene );
        $str = '';
        foreach ( $signGene as $val ) {
            $str .= $val . '=' . $sign_arr [$val];
        }
        //return $str;
        $md5_sign = md5 ( $str );
        openssl_sign ( $md5_sign, $signature, $rsaPriId );
        $sign = base64_encode ( $signature );

        // 5
        $sign_arr ["data"] = $data;
        $sign_arr ["sign"] = $sign;
        $sign_arr ["key"] = $key;
        $json_result = json_encode ( $sign_arr );
        $json_result = str_replace ( "\/", "/", $json_result );
        $curl_data = "fzfContent=".$json_result;
        $curl_data=str_replace("+","%2B",$curl_data);
        //return $curl_data;
        // 6
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curl_data );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 ); // 超时时间
        $content = curl_exec ( $ch );
        curl_close ( $ch );
        $re= json_decode ( $content ,true);
        return $re;

    }

    public function mcrypt_ecb ($cipher, $key, $data, $mode) {}
    public function index(Request $request)
    {
        //echo date('Y-m-d H:i:s',time());die;
      /*  $m = McryptController::getInstance();
        echo $s = $m->encrypt('hello'); // 输出 4cnqrVkCjcr5unW0ySUdWg==
        echo $m->decyrpt($s);  // 输出 hello
        die;*/
       /* $key = "this is a secret key";
        $input = "Let us meet at 9 o'clock at the secret place.";
        // 打开mcrypt，或者mcrypt类型的资源对象，该对象使用ecb模式，使用3des作为加密算法。
        $td = mcrypt_module_open('des', '', 'ecb', '');print_r($td);die;
        // 创建iv(初始化向量)
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        // 根据密钥和iv初始化$td,完成内存分配等初始化工作
        mcrypt_generic_init($td, $key, $iv);
        // 进行加密
        $encrypted_data = mcrypt_generic($td, $input);
        // 反初始化$td,释放资源
        mcrypt_generic_deinit($td);
        // 关闭资源对象，退出
        mcrypt_module_close($td);*/
        /*$key='very important data';
        $str = 'hello world!';
        echo 'key:' . $key . '<br>';
        echo 'str:' . $str . '<br>';
        $jiami = $this->jiami($key, $str);
        echo '加密:' . $jiami . '<br>';
        file_put_contents('jiamiqian.txt', $str);
        file_put_contents('jiamihou.txt', $jiami);
        $jiemi = $this->jiemi($key, $jiami);
        echo '解密:' . $jiemi . '<br>';*/

       /* $inner_interface="http://open.fujinfu.cn:8888/aliwxpay/api/getway";
        $paramss=array('orderid'=>'znjj660815357027799620','refundamount'=>'0.01','remark'=>'第一笔退款');

        $this->checksign_IN($inner_interface,'refund',json_encode($paramss));*/
        //$key=$this->create_key();echo "<pre>";print_r($key);die;
        //$rsa = new Rsa();
        //echo "公钥：\n", $this->publicKey, "\n";
        //echo "私钥：\n", $this->privateKey, "\n";
        //header("Content-Type: text/html; charset=utf-8");
        /*echo "公钥加密（base64处理过）：\n", $str, "\n";*/
       /* $str = base64_decode($str);
        //$pubstr = $this->publicDecrypt($str, $this->publicKey);
        //echo "公钥解密：\n", $pubstr, "\n";
        $privstr = $this->privateDecrypt($str, $this->privateKey);
        echo "私钥解密：\n", $privstr, "\n";echo "<br/>";

// 使用私钥加密
        $str = $this->privateEncrypt('hello', $this->privateKey);
// 这里使用base64是为了不出现乱码，默认加密出来的值有乱码
        $str = base64_encode($str);
        echo "私钥加密（base64处理过）：\n", $str, "\n";
        $str = base64_decode($str);
        $pubstr = $this->publicDecrypt($str, $this->publicKey);
        echo "公钥解密：\n", $pubstr, "\n";*/
        //$privstr = $this->privateDecrypt($str, $this->privateKey);
        //echo "私钥解密：\n", $privstr, "\n";
        //变量accountid
        $accountid='BESTV';
        //先md5加密
        $md5account_id=md5('Site='.$accountid);
        // 使用私钥加密
        openssl_sign($md5account_id, $encrypted, config('wechat.official_account.default.private_key'));
        $stri = base64_encode($encrypted);
        $movieUrl=config('wechat.official_account.default.display_url');
        $moviesUrl=config('wechat.official_account.default.recharge_url');
        $priceUrl=config('wechat.official_account.default.price_url');
        $movarray=array(
          'Site'=>$accountid,
        );
        $movieArr=array(
            'Data'=>base64_encode(json_encode($movarray)),
            'Signature'=>$stri,
        );
        $movieResult=json_encode($movieArr);
        $movRes = $this->curl_movie($priceUrl, $movieResult);
        $rechargeRes=$this->curl_movie($moviesUrl,$movieResult);
        $rechargeResult=json_decode($rechargeRes,true);
        $newMovieRes=json_decode($movRes,true);//echo "<pre>";print_r($newMovieRes);die;
        $iqiyiArr = [];$youkuArr=[];$pptvArr=[];$bestvArr=[];
        foreach($newMovieRes['vipRight'] as $k=>$v)
        {
            foreach($rechargeResult['vipRight'] as $vs)
            {
                foreach($vs['devices'] as $vss)
                {
                    if($v['fsk_device_mac'] !== $vss['mac'])
                    {
                        if($v['fsk_package_provide']=='IQIYI' && $v['fsk_device_mac'] && $v['fsk_device_model'] )
                        {
                            if(!in_array($v['fsk_device_mac'],$iqiyiArr) && !in_array($v['fsk_device_model'],$iqiyiArr))
                            {
                                $iqiyiArr[]=array(
                                    'fsk_device_mac'=>$v['fsk_device_mac'],
                                    'fsk_device_model'=>$v['fsk_device_model'],
                                    'fsk_package_provide'=>$v['fsk_package_provide'],
                                    'fsk_right_limitdate'=>$v['fsk_right_limitdate'],
                                );
                            }
                        }
                        if($v['fsk_package_provide']=='YOUKU' && $v['fsk_device_mac'] && $v['fsk_device_model'])
                        {
                            if(!in_array($v['fsk_device_mac'],$youkuArr) && !in_array($v['fsk_device_model'],$youkuArr))
                            {
                                $youkuArr[]=array(
                                    'fsk_device_mac'=>$v['fsk_device_mac'],
                                    'fsk_device_model'=>$v['fsk_device_model'],
                                    'fsk_package_provide'=>$v['fsk_package_provide'],
                                    'fsk_right_limitdate'=>$v['fsk_right_limitdate'],
                                );
                            }
                        }
                        if($v['fsk_package_provide']=='BESTV:PPTV' && $v['fsk_device_mac'] && $v['fsk_device_model'])
                        {
                            if(!in_array($v['fsk_device_mac'],$pptvArr) && !in_array($v['fsk_device_model'],$pptvArr))
                            {
                                $pptvArr[]=array(
                                    'fsk_device_mac'=>$v['fsk_device_mac'],
                                    'fsk_device_model'=>$v['fsk_device_model'],
                                    'fsk_package_provide'=>$v['fsk_package_provide'],
                                    'fsk_right_limitdate'=>$v['fsk_right_limitdate'],
                                );
                            }
                        }
                        if($v['fsk_package_provide']=='BESTV' && $v['fsk_device_mac'] && $v['fsk_device_model'])
                        {
                            if(!in_array($v['fsk_device_mac'],$bestvArr) && !in_array($v['fsk_device_model'],$bestvArr))
                            {
                                $bestvArr[]=array(
                                    'fsk_device_mac'=>$v['fsk_device_mac'],
                                    'fsk_device_model'=>$v['fsk_device_model'],
                                    'fsk_package_provide'=>$v['fsk_package_provide'],
                                    'fsk_right_limitdate'=>$v['fsk_right_limitdate'],
                                );
                            }
                        }
                    }
                }

            }

        }
        foreach($bestvArr as $ksv)
        {
            $imac[]=$ksv['fsk_device_mac'];
            $imodel[]=$ksv['fsk_device_model'];
            $iprovider[]=$ksv['fsk_package_provide'];
            $ilimitdate[]=$ksv['fsk_right_limitdate'];
        }
        $imacadd=array_unique($imac);
        $imod=array_unique($imodel);
        $idate=array_unique($ilimitdate);
        $ipro=array_unique($iprovider);
       // echo "<pre>";print_r($imacadd);echo "<br>";
       // echo "<pre>";print_r($imod);echo "<br>";
        foreach($newMovieRes['vipRight'] as $ns)
        {
            if($ns['fsk_package_provide']=="BESTV")
            {
              //  echo "<pre>";print_r($ns);
            }

        }
        $url=$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        $arr = parse_url($url);
       // echo "<pre>";var_dump($arr['path']);
/*
        $result = array_reduce($iqiyiArr, function ($result, $value) {
            return array_merge($result, array_values($value));
        }, array());
        echo "<pre>";print_r(array_unique($result));*/
            $movRess=$this->curl_movie($moviesUrl,$movieResult);
        $newMovieRess=json_decode($movRess,true);
        if($newMovieRess)
        {
            foreach($newMovieRess['vipRight'] as $v)
            {
                if($v['providerName']=='IQIYI' && $v['devices'])
                {
                    $iqiyimac=$v['devices'][0]['mac'];$iqiyiprovider=$v['devices'][0]['provider'];$iqiyilimitdate=$v['devices'][0]['limitDate'];$iqiyimodel=$v['devices'][0]['model'];$iqiyideviceid=$v['devices'][0]['deviceId'];
                    session(['iqiyimac'=>$iqiyimac]);session(['iqiyiprovider'=>$iqiyiprovider]);session(['iqiyilimitdate'=>$iqiyilimitdate]);session(['iqiyimodel'=>$iqiyimodel]);session(['iqiyideviceid'=>$iqiyideviceid]);
                }
                if($v['providerName']=='YOUKU' && $v['devices'])
                {
                    $youkumac=$v['devices'][0]['mac'];$youkuprovider=$v['devices'][0]['provider'];$youkulimitdate=$v['devices'][0]['limitDate'];$youkumodel=$v['devices'][0]['model'];$youkudeviceid=$v['devices'][0]['deviceId'];
                    session(['youkumac'=>$youkumac]);session(['youkuprovider'=>$youkuprovider]);session(['youkulimitdate'=>$youkulimitdate]);session(['youkumodel'=>$youkumodel]);session(['youkudeviceid'=>$youkudeviceid]);
                }
                if($v['providerName']=='BESTV:PPTV' && $v['devices'])
                {
                    $pptvmac=$v['devices'][0]['mac'];$pptvprovider=$v['devices'][0]['provider'];$pptvlimitdate=$v['devices'][0]['limitDate'];$pptvmodel=$v['devices'][0]['model'];$pptvdeviceid=$v['devices'][0]['deviceId'];
                    session(['pptvmac'=>$pptvmac]);session(['pptvprovider'=>$pptvprovider]);session(['pptvlimitdate'=>$pptvlimitdate]);session(['pptvmodel'=>$pptvmodel]);session(['pptvdeviceid'=>$pptvdeviceid]);
                }
                if($v['providerName']=='BESTV' && $v['devices'])
                {
                    $bestvmac=$v['devices'][0]['mac'];$bestvprovider=$v['devices'][0]['provider'];$bestvlimitdate=$v['devices'][0]['limitDate'];$bestvmodel=$v['devices'][0]['model'];$bestvdeviceid=$v['devices'][0]['deviceId'];
                    session(['bestvmac'=>$bestvmac]);session(['bestvprovider'=>$bestvprovider]);session(['bestvlimitdate'=>$bestvlimitdate]);session(['bestvmodel'=>$bestvmodel]);session(['bestvdeviceid'=>$bestvdeviceid]);
                }
            }
        }
        else
        {
            if($newMovieRes)
            {
                foreach($newMovieRes['vipRight'] as $v)
                {
                    if($v['fsk_package_provide']=='IQIYI' && $v['fsk_device_id'] && $v['fsk_device_mac'] && $v['fsk_device_model'])
                    {
                        $iqiyidate[]=$v['fsk_right_limitdate'];
                        $iqiyimac=$v['fsk_device_mac'];$iqiyiprovider=$v['fsk_package_provide'];$iqiyilimitdate=$v['fsk_right_limitdate'];$iqiyimodel=$v['fsk_device_model'];$iqiyideviceid=$v['fsk_device_id'];
                        session(['iqiyimac'=>$iqiyimac]);session(['iqiyiprovider'=>$iqiyiprovider]);session(['iqiyilimitdate'=>$iqiyilimitdate]);session(['iqiyimodel'=>$iqiyimodel]);session(['iqiyideviceid'=>$iqiyideviceid]);

                    }
                    if($v['fsk_package_provide']=='YOUKU' && $v['fsk_device_id'] && $v['fsk_device_mac'] && $v['fsk_device_model'])
                    {
                        $youkudate[]=$v['fsk_right_limitdate'];
                        $youkumac=$v['fsk_device_mac'];$youkuprovider=$v['fsk_package_provide'];$youkulimitdate=$v['fsk_right_limitdate'];$youkumodel=$v['fsk_device_model'];$youkudeviceid=$v['fsk_device_id'];
                        session(['youkumac'=>$youkumac]);session(['youkuprovider'=>$youkuprovider]);session(['youkulimitdate'=>$youkulimitdate]);session(['youkumodel'=>$youkumodel]);session(['youkudeviceid'=>$youkudeviceid]);
                    }
                    if($v['fsk_package_provide']=='BESTV:PPTV'  && $v['fsk_device_id'] && $v['fsk_device_mac'] && $v['fsk_device_model'])
                    {
                        $pptvdate[]=$v['fsk_right_limitdate'];
                        $pptvmac=$v['fsk_device_mac'];$pptvprovider=$v['fsk_package_provide'];$pptvlimitdate=$v['fsk_right_limitdate'];$pptvmodel=$v['fsk_device_model'];$pptvdeviceid=$v['fsk_device_id'];
                        session(['pptvmac'=>$pptvmac]);session(['pptvprovider'=>$pptvprovider]);session(['pptvlimitdate'=>$pptvlimitdate]);session(['pptvmodel'=>$pptvmodel]);session(['pptvdeviceid'=>$pptvdeviceid]);
                    }
                    if($v['fsk_package_provide']=='BESTV' && $v['fsk_device_id'] && $v['fsk_device_mac'] && $v['fsk_device_model'])
                    {
                        $bestvdate[]=$v['fsk_right_limitdate'];
                        $bestvmac=$v['fsk_device_mac'];$bestvprovider=$v['fsk_package_provide'];$bestvlimitdate=$v['fsk_right_limitdate'];$bestvmodel=$v['fsk_device_model'];$bestvdeviceid=$v['fsk_device_id'];
                        session(['bestvmac'=>$bestvmac]);session(['bestvprovider'=>$bestvprovider]);session(['bestvlimitdate'=>$bestvlimitdate]);session(['bestvmodel'=>$bestvmodel]);session(['bestvdeviceid'=>$bestvdeviceid]);
                    }

                }

            }

        }

       // echo "<pre>";print_r($newMovieRes);
        //echo "<pre>";print_r($newMovieRes['vipRight']);die;
    }
        public function array_unique_fb($array2D){
            foreach ($array2D as $k=>$v){
                $v=join(',',$v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
                $temp[$k]=$v;
            }
            $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
            foreach ($temp as $k => $v){
                $array=explode(',',$v); //再将拆开的数组重新组装
                //下面的索引根据自己的情况进行修改即可
                $temp2[$k]['id'] =$array[0];
                $temp2[$k]['title'] =$array[1];
                $temp2[$k]['keywords'] =$array[2];
                $temp2[$k]['content'] =$array[3];
            }
            return $temp2;
        }
        public function objtoarr($obj)
        {

            $ret = array();
            foreach($obj as $key =>$value){

                if(gettype($value) == 'array' || gettype($value) == 'object' || gettype($value) == 'integer'){
                    $ret[$key] = $this->objtoarr($value);
                }else{
                    $ret[$key] = $value;
                }
            }
            return $ret;
        }
        public function curl_movie($url, $postFields)
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

}