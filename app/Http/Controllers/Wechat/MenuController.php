<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Session , Cookie , Config , Log , Validator;


use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;


class MenuController extends Controller
{

    private $wechat;
    public function __construct(){
//        parent::__construct();

        $this->wechat = new Application(Config::get('wechat'));

    }

    /**
     * 设置菜单
     */
    public function setMenu(){

        $wechatApp = $this->wechat;

        $menu = $wechatApp->menu;

        $buttons = [
            [
                "type" => "view",
                "name" => "商城",
                "url"  => Config::get('app.url').'/wechat/login'
            ],

            [
                "type"  => "click",
                "name"  => "关于我们",
                "key"   => "XY_GYWM"
            ],



        ];

        $menu->add($buttons);
    }

    /**
     * 删除菜单
     */
    public function delAllMenu(){
        $wechatApp = $this->wechat;
        $menu = $wechatApp->menu;
        $menu->destroy();

    }

    /**
     * 获取全部菜单
     */
    public function getAllMenu(){

        $wechatApp = $this->wechat;
        $menu = $wechatApp->menu;
        return $menu->all();

    }

}