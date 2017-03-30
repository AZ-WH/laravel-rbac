<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Session , Cookie , Config , Log , Validator;

use App\Models\User;

use EasyWeChat\Foundation\Application;

class LoginController extends Controller
{

    private $wechat;
    public function __construct(){
        $this->wechat = new Application(Config::get('wechat'));
    }

    /**
     * 跳转微信登录
     */
    public function login(){
        $wechatApp      = $this->wechat;
        $oauth          = $wechatApp->oauth;
        return $oauth->redirect();
    }

    /**
     * 微信登录回调
     */
    public function callbackLogin(){
        if(!isset($_GET['code'])){
            return response()->json(['code' => -1 , 'msg' => '没有code']);
        }


        $appid = Config::get('wechat.app_id');
        $secret = Config::get('wechat.secret');

        // 获取 OAuth 授权结果用户信息

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$_GET['code']."&grant_type=authorization_code";

        $data   = $this->curlGet($url);
        $data	= json_decode($data);

        if(isset($data->errcode)){
            return response()->json(['code' => -2 , 'msg' => '获取token失败']);
        }

        $token		= $data->access_token;
        $openid		= $data->openid;

        $getUserInfoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid;

        $weixinUserInfo = $this->curlGet($getUserInfoUrl);

        $weixinUserInfo = json_decode($weixinUserInfo);

        $userData = [];
        $userInfo = User::where('wx_openid' , $weixinUserInfo->openid)->first();
        if($userInfo){
            $userData = [
                'nick_name'     => $weixinUserInfo->nickname,
                'headimgurl'    => $weixinUserInfo->headimgurl,
                'updated_at'    => date('Y-m-d H:i:s' , $_SERVER['REQUEST_TIME']),
                'wx_openid'     => $weixinUserInfo->openid,
                'mobile'        => $userInfo->mobile,
                'email'         => $userInfo->email
            ];

            if(User::where('id' , $userInfo->id)->update($userData) === false){
                return response()->json(['code' => -1 , 'msg' => '登录失败']);
            }
            $userData['id']  = $userInfo->id;
        }else{
            $userData = [
                'wx_openid'     => $weixinUserInfo->openid,
                'nick_name'     => $weixinUserInfo->nickname,
                'headimgurl'    => $weixinUserInfo->headimgurl,
                'created_at'    => date('Y-m-d H:i:s' , $_SERVER['REQUEST_TIME']),
                'mobile'        => '',
                'email'         => ''
            ];

            $userModel = new User();
            $userId  = $userModel->saveUser($userData);

            if(!$userId){
                return response()->json(['code' => -1 , 'msg' => '登录失败']);
            }

            $userData['id']  = $userId;
        }

        if(isset($userData->password)){
            unset($userData->password);
        }
        if(isset($userData->salt)){
            unset($userData->salt);
        }

        $sessionKey = $userData['wx_openid'];

        Session::put($sessionKey, $userData);

        $cookie = Cookie::make(Config::get('session.user_cookie'), $sessionKey, Config::get('session.user_cookie_lifetime'));

        return redirect('/')->withCookie($cookie);
    }

}
