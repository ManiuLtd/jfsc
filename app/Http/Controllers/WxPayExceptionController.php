<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/19
 * Time: 14:37
 */

namespace App\Http\Controllers;


class WxPayException extends Exception {
    public function errorMessage()
    {
        return $this->getMessage();
    }
}