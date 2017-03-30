<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Validator;

use App\Models\AdminUrl;
use App\Models\AdminPermission;

class AdminPermissionController extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->_response['_active']['_model']       = 'auth';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '小一农货-权限节点';
    }

    public function getList(){
        $this->_response['_active']['_action']      = 'list';

        $adminPermissionModel = new AdminPermission();
        $this->_response['permission']  = $adminPermissionModel->getPermissionsList();

        return view('admin.permission.list' , $this->_response);
    }

    public function add(){
        $this->_response['_active']['_action']      = 'add';

        $this->_response['url']         = AdminUrl::orderBy('url' , 'asc')->get();
        $this->_response['permission']  = AdminPermission::where('pid' , 0)->get();

        return view('admin.permission.add' , $this->_response);
    }

    public function doAdd(Request $request){

        $validation = Validator::make($request->all() , [
            'name'              => 'required',
            'rule'              => 'required'
        ] , [
            'name.required'             => '必须填写节点名称',
            'rule.required'             => '必须选择链接',
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $pid    = $request->get('pid' , 0);
        $name   = $request->get('name');
        $rule   = $request->get('rule');

        if(empty($rule)){
            return response()->json(['code' => -1 , 'msg' => '参数错误']);
        }

        $adminPermissionModel = new AdminPermission();

        if($adminPermissionModel->saveData($pid , $name , $rule)){
            return response()->json(['code' => 0 , 'msg' => '操作成功']);
        }else{
            return response()->json(['code' => -2 , 'msg' => '操作失败']);
        }
    }

    public function getInfo($id){
        $this->_response['url']         = AdminUrl::orderBy('url' , 'asc')->get();
        $this->_response['permission']  = AdminPermission::where('pid' , 0)->get();
        $info        = AdminPermission::where('id' , $id)->first();
        if(isset($info->id)){
            $info->url = explode(',' , $info->rule);
        }

        $this->_response['info'] = $info;

        return view('admin.permission.edit' , $this->_response);
    }


    public function update(Request $request){
        $validation = Validator::make($request->all() , [
            'id'                => 'required',
            'name'              => 'required',
            'rule'              => 'required'
        ] , [
            'id.required'               => '没有找到数据',
            'name.required'             => '必须填写节点名称',
            'rule.required'             => '必须选择链接',
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $id    = $request->get('id');
        $pid    = $request->get('pid' , 0);
        $name   = $request->get('name');
        $rule   = $request->get('rule');

        if(empty($rule)){
            return response()->json(['code' => -1 , 'msg' => '参数错误']);
        }

        if(AdminPermission::where('id' , $id)->update([
            'name'  => $name,
            'rule'  => implode(',' , $rule),
            'pid'   => $pid
        ]) !== false){
            return response()->json(['code' => 0 , 'msg' => '操作成功']);
        }else{
            return response()->json(['code' => -2 , 'msg' => '操作失败']);
        }
    }

    public function delete($id){

        $permission = AdminPermission::where('id' , $id)->first();

        $canDelete = false;

        if($permission->pid != 0) {
            $canDelete = true;
        }else{
            if(AdminPermission::where('pid' , $id)->count() == 0){
                $canDelete = true;
            }

        }

        if($canDelete) {
            if (AdminPermission::where('id', $id)->delete() !== false) {
                return response()->json(['code' => 0, 'msg' => '操作成功']);
            } else {
                return response()->json(['code' => -2, 'msg' => '操作失败']);
            }
        }else{
            return response()->json(['code' => -3, 'msg' => '请先删除子节点']);
        }

    }

}