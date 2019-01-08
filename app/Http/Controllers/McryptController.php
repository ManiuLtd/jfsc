<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/19
 * Time: 14:31
 */

namespace App\Http\Controllers;

class McryptController
{
    protected $td = '';
    protected $iv = '';
    protected $key = '';
    private static $instance = NULL;

    private function __construct($cipher,$mode,$key) {
        $this->cipher = $cipher;
        $this->mode = $mode;
        $this->key = $key;
    }

    public static function getInstance($cipher='des',$mode='ecb',
                                       $key='H5gOs1ZshKZ6WikN') {
        if (self::$instance == NULL) {
            self::$instance = new self($cipher,$mode,$key);
        }
        return self::$instance;
    }
    public function mcrypt_module_open ($algorithm, $algorithm_directory, $mode, $mode_directory) {}
    public function encrypt($str) {
        $td = $this->mcrypt_module_open('des','','ecb','');//打开算法模块
        $this->td = $td;print_r($td);die;
        $iv_size = mcrypt_enc_get_iv_size($td);// 获取向量大小
        $iv = mcrypt_create_iv($iv_size,MCRYPT_RAND);//初始化向量
        $this->iv = $iv;
        $num = mcrypt_generic_init($td,$this->key,$iv);//初始化加密空间
        //var_dump($num);
        $encypt = mcrypt_generic($td,$str);//执行加密
        mcrypt_generic_deinit($td); // 结束加密，执行清理工作
        return base64_encode($encypt);//base64编码成字符串适合数据传输

    }

    public function decyrpt($str) {
        $str = base64_decode($str);
        $td = $this->td;
        mcrypt_generic_init($td,$this->key,$this->iv);
        $decrypt = mdecrypt_generic($td,$str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);//关闭算法模块
        return $decrypt;
    }

}