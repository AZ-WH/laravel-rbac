<?php

namespace App\Http\Middleware\Admin;

use Closure , Session , Cookie , Config;

use Illuminate\Http\Response;

use App\Models\AdminUser;

class Auth {

    public function handle($request , Closure $next , $gurad = null){

        $sessionKey = Cookie::get(Config::get('session.admin_cookie'));

        $sessionData = Session::get($sessionKey);

        if(!isset($sessionData['userInfo']) || empty($sessionData['userInfo'])){
            if($request->ajax()){
                return response()->json(['code' => -1000 , 'msg' => '未登录']);
            }else{
                return redirect('/admin/login');
            }
        }

        $user = $sessionData['userInfo'];
        $permission = $sessionData['permission'];

        $currentUri         = $request->route()->uri;
        $currentMethod      = $request->route()->methods();

        $currentURL = $currentUri;
        foreach ($currentMethod as $cm){
            $currentURL .= '|' . $cm;
        }

//        if(!in_array($currentURL , $permission)){
//            if($request->ajax()){
//                return response()->json(['code' => -1001 , 'msg' => '没有权限访问']);
//            }else{
//                return redirect('/admin/error');
//            }
//        }

        global $uuuid;
        $uuuid = $user['id'];

        $adminUserModel = new AdminUser();

        $adminUserModel->getUserPermissionUrl($uuuid);

        return $next($request);
    }
}