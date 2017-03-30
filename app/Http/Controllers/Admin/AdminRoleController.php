<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

use App\Models\AdminRole;
use App\Models\AdminPermission;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Validator;

class AdminRoleController extends AdminController{
    
    public function __construct(){
        parent::__construct();
        $this->_response['_active']['_model']       = 'auth';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '小一农货-角色管理';
    }
    
    /**
     * 获取角色列表
     */
    public function getRoleList(){
        $this->_response['_active']['_action']      = 'list';
        $roleModel		= new AdminRole;
        $rolesList      = $roleModel->getRoleList();

        $adminPermissionModel      = new AdminPermission;
        $permissionList = $adminPermissionModel->getPermissionsList();
        
        $this->_response['permissions'] = $permissionList;
        $this->_response['roles'] = $rolesList;

        return view('admin.roles.list' , $this->_response);
    }
    

    //获取角色权限
    public function getRolePermission($id){
        $role = AdminRole::where('id' , $id)->first();

        $permission = [];

        if(isset($role->permission)){
            $permission = explode(',' , $role->permission);
        }

        return response()->json(['code' => 0 , 'data' => $permission]);

    }

    //添加角色权限
    public function updateRole(Request $request){
        $validation = Validator::make($request->all() , [
            'id'              => 'required'

        ] , [
            'id.required'             => '找不到信息'

        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $id = $request->get('id');

        $updateData = [];

        if($request->has('name')){
            $updateData['name'] = $request->get('name');
        }

        if($request->has('permission')){
            $updateData['permission'] = implode(',' , $request->get('permission'));
        }

        $updateData['updated_at'] = date('Y-m-d H:i:s' , time());

        if(AdminRole::where('id' , $id)->update($updateData)){
            return response()->json(['code' => 0 , 'msg' => '操作成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '操作失败']);
        }

    }

    public function addRole(){
        $this->_response['_active']['_action']      = 'add';

        return view('admin.roles.add' , $this->_response);
    }

    public function doAddRole(Request $request){
        $validation = Validator::make($request->all() , [
            'name'              => 'required'
        ] , [
            'name.required'             => '必须填写名称'
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $name = $request->get('name');

        $roleModel		= new AdminRole;

        if($roleModel->saveData(['name' => $name])){
            return response()->json(['code' => 0 , 'msg' => '操作成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '操作失败']);
        }
    }
    

    
}