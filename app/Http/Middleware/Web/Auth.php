<?php

namespace App\Http\Middleware\Web;

use Closure;

use Config , Session , Cookie;

class Auth {

    public function handle($request , Closure $next , $gurad = null){

        $sessionKey = cookie::get(Config::get('session.user_cookie'));

        global $uid;
        $userData = Session::get($sessionKey);

        if(isset($userData['id']) && $userData['id'] > 0){
            $uid = $userData['id'];
            return $next($request);
        }else{
            return redirect('/nologin');
        }

    }
}