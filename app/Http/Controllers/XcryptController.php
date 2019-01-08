<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/19
 * Time: 14:31
 */

namespace App\Http\Controllers;

class XcryptController
{
    private $mcrypt;
    private $key;
    private $mode;
    private $iv;
    private $blocksize;

    /**
     * 构造函数
     *
     * @param string 密钥
     * @param string 模式
     * @param string 向量（"off":不使用 / "auto":自动 / 其他:指定值，长度同密钥）
     */
    public function __construct($key, $mode = 'cbc', $iv = "off"){
        switch (strlen($key)){
            case 8:
                $this->mcrypt = 'des';
                break;
            case 16:
                $this->mcrypt = 'rijndael-128';
                break;
            case 32:
                $this->mcrypt = 'rijndael-256';
                break;
            default:
                die("Key size must be 8/16/32");
        }

        $this->key = $key;

        switch (strtolower($mode)){
            case 'ofb':
                $this->mode = 'ofb';
                if ($iv == 'off') die('OFB must give a IV'); //OFB必须有向量
                break;
            case 'cfb':
                $this->mode = 'cfb';
                if ($iv == 'off') die('CFB must give a IV'); //CFB必须有向量
                break;
            case 'ecb':
                $this->mode = 'ecb';
                $iv = 'off'; //ECB不需要向量
                break;
            case 'cbc':
            default:
                $this->mode = 'cbc';
        }

        switch (strtolower($iv)){
            case "off":
                $this->iv = null;
                break;
            case "auto":
                $source = PHP_OS=='WINNT' ? MCRYPT_RAND : MCRYPT_DEV_RANDOM;
                $this->iv = mcrypt_create_iv(mcrypt_get_block_size($this->mcrypt, $this->mode), $source);
                break;
            default:
                $this->iv = $iv;
        }

    }

    /**
     * 获取向量值
     * @param string 向量值编码（base64/hex/bin）
     * @return string 向量值
     */
    public function getIV($code = 'base64'){
        switch ($code){
            case 'base64':
                $ret = base64_encode($this->iv);
                break;
            case 'hex':
                $ret = bin2hex($this->iv);
                break;
            case 'bin':
            default:
                $ret = $this->iv;
        }
        return $ret;
    }
    public function mcrypt_encrypt ($cipher, $key, $data, $mode, $iv = null) {}
    /**
     * 加密
     * @param string 明文
     * @param string 密文编码（base64/hex/bin）
     * @return string 密文
     */
    public function encrypt($str, $code = 'base64'){
        if ($this->mcrypt == 'des') $str = $this->_pkcs5Pad($str);

        if (!is_null($this->iv)) {
            $result = $this->mcrypt_encrypt($this->mcrypt, $this->key, $str, $this->mode, $this->iv);
        } else {
            $result = $this->mcrypt_encrypt($this->mcrypt, $this->key, $str, $this->mode);
        }

        switch ($code){
            case 'base64':
                $ret = base64_encode($result);
                break;
            case 'hex':
                $ret = bin2hex($result);
                break;
            case 'bin':
            default:
                $ret = $result;
        }

        return $ret;

    }
    public function openssl_encrypt($data, $method, $password, $raw_output = false, $iv = "") { }
    public function openssl_decrypt($data, $method, $password, $raw_input = false, $iv = "") { }
    public function random($num='16'){
        $a = range(0,9);
        for($i=0;$i<$num;$i++){
            $b[] = array_rand($a);
        }
        return join("",$b);

    }
    public function aes_encode($message, $encodingaeskey = '', $appid = '') {
        $key = base64_decode($encodingaeskey . '=');
        $text = $this->random(16) . pack("N", strlen($message)) . $message . $appid;
        $iv = substr($key, 0, 16);

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

        $encrypted = openssl_encrypt($text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
        $encrypt_msg = base64_encode($encrypted);
        return $encrypt_msg;
    }
    public function aes_decode($message, $encodingaeskey = '', $appid = '')
    {
        $key = base64_decode($encodingaeskey . '=');

        $ciphertext_dec = base64_decode($message);
        $iv = substr($key, 0, 16);

        /* mcrypt对称解密代码在PHP7.1已经被抛弃了，所以使用下面的openssl来代替
        $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($module, $key, $iv);
        $decrypted = mdecrypt_generic($module, $ciphertext_dec);
        mcrypt_generic_deinit($module);
        mcrypt_module_close($module);
        */
        $decrypted = openssl_decrypt($ciphertext_dec, 'AES-256-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

        $pad = ord(substr($decrypted, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
    }
    /**
     * 解密
     * @param string 密文
     * @param string 密文编码（base64/hex/bin）
     * @return string 明文
     */
    public function decrypt($str, $code = "base64"){
        $ret = false;

        switch ($code){
            case 'base64':
                $str = base64_decode($str);
                break;
            case 'hex':
                $str = hex2bin($str);
                break;
            case 'bin':
            default:
        }

        if ($str !== false){
            if (isset($this->iv)) {
                $ret = mcrypt_decrypt($this->mcrypt, $this->key, $str, $this->mode, $this->iv);
            } else {
                @$ret = mcrypt_decrypt($this->mcrypt, $this->key, $str, $this->mode);
            }
            if ($this->mcrypt == 'des') $ret = $this->_pkcs5Unpad($ret);
        }

        return $ret;
    }
    public function mcrypt_get_block_size ($cipher , $mode ){}
    private function _pkcs5Pad($text){
        $this->blocksize = 32;/*mcrypt_get_block_size($this->mcrypt, $this->mode);*/
        $pad = $this->blocksize - (strlen($text) % $this->blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    private function _pkcs5Unpad($text){
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        $ret = substr($text, 0, -1 * $pad);
        return $ret;
    }

}