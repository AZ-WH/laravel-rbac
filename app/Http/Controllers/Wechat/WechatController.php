<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Session , Cookie , Config , Log , Validator;


use EasyWeChat\Foundation\Application;


class WechatController extends Controller
{

    private $wechat;
    public function __construct(){
//        parent::__construct();
        $this->wechat = new Application(Config::get('wechat'));

    }

    /**
     *
     * 微信验证token
     */
    public function index(){

            // 从项目实例中得到服务端应用实例。
            $server = $this->wechat->server;

            $server->setMessageHandler(function ($message) {
                Log::info($message);
                switch ($message->MsgType) {
                    case 'event':
                        switch ($message->Event) {
                            case 'subscribe':
                                return "欢迎关注'玖号潮品'公众号,我们将为您寻找最潮最好吃的食品";
                                break;
                            case 'SCAN':
                                return "您已关注'玖号潮品'公众号,快进入商城挑选另您心动的商品吧!";
                                break;
                            case 'CLICK':
                                switch ($message->EventKey){
                                    //点击关于我们
                                    case 'XY_GYWM':
                                        return "我们是谁不重要,在商城里面有您心动的商品才重要";
                                        break;
                                }
                                break;
                            default:
                                break;
                        }
                        break;
                }
            });
            $response = $server->serve();
            return $response->send();
    }

}