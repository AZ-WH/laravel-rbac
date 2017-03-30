<?php
/**
 * Created by PhpStorm.
 * User: woody
 * Date: 17-2-16
 * Time: 下午10:46
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

use App\Models\AdminUser;
use App\Models\AdminRole;
use App\Models\AdminPermission;

use App\Models\AdminUserPermission;
use Illuminate\Http\Request;
use Validator , Config , Session , Cookie;

class AdminUserController extends AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model']       = 'auth';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '账号管理';
    }


    public function login(){
        return view('admin.admin_user.login');
    }

    public function doLogin(Request $request){
        $account    = $request->get('account');
        $password   = $request->get('password');

        $adminUserModel = new AdminUser();

        $user = AdminUser::whereNull('deleted_at')->where('account' , $account)->first();
        if($user){
            $passwordSalt = encrypt_sha_md5($password , $user->salt);

            if($passwordSalt == $user->password){

                $sessionKey = md5('Admin_' . $user->salt . time());

                $user = $user->toArray();
                unset($user['password']);
                unset($user['salt']);

                $url = $adminUserModel->getUserPermissionUrl($user['id']);

                $permission = [];
                foreach ($url as $u){
                    $permission[] = $u['url'] . '|' . $u['method'];
                }

                $sessionData = [
                    'userInfo'      => $user,
                    'permission'    => $permission
                ];

                Session::put($sessionKey, $sessionData);

                $cookie = Cookie::make(Config::get('session.admin_cookie'), $sessionKey, Config::get('session.admin_cookie_lifetime'));

                return response()->json(['code' => 0 , 'msg' => '登录成功'])->withCookie($cookie);
            }else{
                return response()->json(['code' => -1 , 'msg' => '登录失败']);
            }
        }else{
            return response()->json(['code' => -2 , 'msg' => '登录失败']);
        }
    }

    public function getList(){
        $this->_response['_active']['_action']      = 'list';

        $adminUserModel = new AdminUser();
        $adminPermissionModel       = new AdminPermission;
        $permissionList             = $adminPermissionModel->getPermissionsList();

        $this->_response['permissions'] = $permissionList;
        $this->_response['user'] = $adminUserModel->getUserList();

        return view('admin.admin_user.list' , $this->_response);
    }

    public function add(){
        $this->_response['_active']['_action']      = 'add';

        $this->_response['role']    = AdminRole::whereNull('deleted_at')->get();

        return view('admin.admin_user.add' , $this->_response);
    }

    public function doAdd(Request $request){
        $validation = Validator::make($request->all() , [
            'name'                  => 'required',
            'password'              => 'required|min:6',
            'role'                  => 'required'
        ] , [
            'name.required'             => '必须填写账号',
            'password.required'         => '必须填写密码',
            'role.required'             => '必须选择一个角色'
        ]);
        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $saveData = [];

        $saveData['name']       = $request->get('name');
        $saveData['account']    = $saveData['name'];
        $saveData['password']   = $request->get('password');

        $role       = $request->get('role');

        if(empty($role)){
            return response()->json(['code' => -1 , 'msg' => '必须选择一个角色']);
        }

        $saveData['salt']       = getSalt(8);
        $saveData['password']   = encrypt_sha_md5($saveData['password'] , $saveData['salt']);

        $adminUserModel = new AdminUser();

        if($adminUserModel->saveData($saveData , $role)){
            return response()->json(['code' => 0 , 'msg' => '添加成功']);
        }else{
            return response()->json(['code' => -2 , 'msg' => '添加失败,请稍后重试']);
        }
    }


    public function getInfo($id){
        $adminUserModel = new AdminUser();

        $this->_response['user']    = $adminUserModel->getUserInfo($id);
        $this->_response['role']    = AdminRole::whereNull('deleted_at')->get();

        return view('admin.admin_user.edit' , $this->_response);
    }


    public function update(Request $request){

        if($request->has('id')){
            $id = $request->get('id');
        }else{
            return response()->json(['code' => -1 , 'msg' => '参数错误']);
        }

        $saveData = [];
        if($request->has('name')) {
            $saveData['name']       = $request->get('name');
            $saveData['account']    = $saveData['name'];
        }
        if($request->has('password')) {
            $saveData['password']   = $request->get('password');
            $saveData['salt']       = getSalt(8);
            $saveData['password']   = encrypt_sha_md5($saveData['password'] , $saveData['salt']);
        }

        $role = [];

        if($request->has('role') || !empty($role)){
            $role       = $request->get('role');
        }

        $saveData['updated_at'] = date('Y-m-d H:i:s' , time());

        $adminUserModel = new AdminUser();

        if($adminUserModel->updateUser($id , $saveData , $role)){
            return response()->json(['code' => 0 , 'msg' => '修改成功']);
        }else{
            return response()->json(['code' => -2 , 'msg' => '修改失败,请稍后重试']);
        }
    }

    public function updatePermission(Request $request){

        if($request->has('id')){
            $id = $request->get('id');
        }else{
            return response()->json(['code' => -1 , 'msg' => '参数错误']);
        }

        $permission = [];

        if($request->has('permission') ) {
            $permission = $request->get('permission');
        }

        $adminUserModel = new AdminUser();

        if($adminUserModel->updateUserPermission($id , $permission )){
            return response()->json(['code' => 0 , 'msg' => '修改成功']);
        }else{
            return response()->json(['code' => -2 , 'msg' => '修改失败,请稍后重试']);
        }


    }


    public function getPermission($id){

        $userPermission = AdminUserPermission::where('uid' , $id)->get();

        $permission = [];
        foreach ($userPermission as $up){
            $permission[] = $up->pid;
        }

        return response()->json(['code' => 0 , 'data' => $permission]);
    }

    public function currentLoginUser(){
        global $uuuid;

        $user = AdminUser::select('name' , 'account' , 'id')->whereNull('deleted_at')->where('id' , $uuuid)->first()->toArray();

        return response()->json(['code' => 0 , 'data' => $user]);
    }

}