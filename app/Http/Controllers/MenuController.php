<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 9:11
 */

namespace App\Http\Controllers;

use EasyWeChat;
use EasyWeChat\OfficialAccount\Application;

class MenuController extends Controller
{
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function menu()
    {
        $app = $this->app;
        $menu = $app->menu;
        $menus = $menu->all();//查询菜单
        //$menus=$menu->current();//查询自定义菜单
        return $menus;
    }

    //新增菜单
    public function addmenu()
    {
        $app = $this->app;
        $menu = $app->menu;

        $buttons = [
            [
                "type" => "view",
                "name" => "会员服务(測試)",
                "url" => "http://iot.flnet.com:8088/zhuce"
            ],
            [
                "type" => "view",
                "name" => "会员服务(正式)",
                "url" => "https://vipaccount.flnet.com/zhuce"
            ],
        ];
        $menus = $menu->create($buttons);//新增菜单

        return $menus;
    }

    public function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event) {
            case "subscribe":
                $content[] = array("Title" => "欢迎关注富连网物联网智能家居公众号", "Description" => "", "PicUrl" => "", "Url" => "");
                break;
            case "CLICK":
                switch ($object->EventKey) {
                    case "zans":
                        $content[] = array("Title" => "OpenID", "Description" => "你的OpenID为：" . $object->FromUserName, "PicUrl" => "", "Url" => "");
                        break;
                }
                break;
        }

        echo $object->FromUserName;
    }

    //查询菜单
    public function findmenu()
    {
        $app = $this->app;
        $menu = $app->menu;
        $menus = $menu->list();
        return $menus;
    }

    //修改菜单
    public function editmenu()
    {
        $app = $this->app;
        $menu = $app->menu;
        if ($menu->list()) {
            $menus = $menu->create($menu->list());
        }
        return $menus;
    }

    //删除菜单
    public function delmenu()
    {
        $app = $this->app;
        $menu = $app->menu;
        $menus = $menu->delete();//删除操作
        return $menus;
    }


}
