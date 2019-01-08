<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/19
 * Time: 14:31
 */

namespace App\Http\Controllers;

class DesController
{
    private $key;
    public function __construct($key) {
        $this->key = $key;
    }
    public function mcrypt_enc_get_iv_size ($td) {}
    public function mcrypt_create_iv ($size, $source = MCRYPT_DEV_URANDOM) {}
    public function mcrypt_module_open ($algorithm, $algorithm_directory, $mode, $mode_directory) {}
    public function mcrypt_get_block_size ($cipher , $mode ){}
    public function mcrypt_generic_init ($td, $key, $iv) {}
    public function mcrypt_generic ($td, $data) {}
    public function mcrypt_generic_deinit ($td) {}
    public function mcrypt_module_close ($td) {}
    public function encrypt($input) {
        $size = $this->mcrypt_get_block_size('des', 'ecb');    //本函数用来取得编码方式的区块大小
        $input = $this->pkcs5_pad($input);
        $key = $this->key;
        $td = $this->mcrypt_module_open('des', '', 'ecb', '');
        $iv = $this->mcrypt_create_iv ($this->mcrypt_enc_get_iv_size($td), 2);
        $this->mcrypt_generic_init($td, $key, $iv);
        $data =$this-> mcrypt_generic($td, $input);
        $this->mcrypt_generic_deinit($td);
        $this->mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }
    public function mcrypt_enc_get_key_size ($td) {}
     public function decrypt($encrypted) {
        $encrypted = base64_decode($encrypted);
        $key =$this->key;
        $td = mcrypt_module_open('des','','ecb',''); //使用MCRYPT_DES算法,cbc模式
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), 2);
        $ks = $this->mcrypt_enc_get_key_size($td);
        @mcrypt_generic_init($td, $key, $iv);       //初始处理
        $decrypted = mdecrypt_generic($td, $encrypted);       //解密
        mcrypt_generic_deinit($td);       //结束
        mcrypt_module_close($td);
        $y=$this->pkcs5_unpad($decrypted);
        return $y;
    }
    public function pkcs5_pad ($text) {
        $pad =(strlen($text) );
        return $text . str_repeat(chr($pad), $pad);
    }
    public function pkcs5_unpad($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
            return false;
        return substr($text, 0, -1 * $pad);
    }
}