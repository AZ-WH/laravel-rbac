<?php
/**
 * Created by PhpStorm.
 * User: woody
 * Date: 17-2-16
 * Time: 下午10:46
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

use Validator;

use App\Models\Manufactor;
use Illuminate\Database\Eloquent\Model;

class ManufactorController extends AdminController {

    private $_length = 20;

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model']       = 'manufactor';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '小一农货-供应商管理';
    }

    public function getList(Request $request){
        $this->_response['_active']['_action']      = 'list';
        $page = 1;
        $search = [];
        $param = '';
        $this->_response['_active']['_action']      = 'list';
        
        if($request->has('page')) {
            $page = $request->get('page');
        }
        $offset = ($page - 1) * $this->_length;
        
        $manufactorModel = new Manufactor();
        $this->_response['stores'] = $manufactorModel->getManufactorsList($search, $offset, $this->_length);
        $this->_response['goods']['pageData']['page'] = $page;
        $this->_response['goods']['pageData']['pageHtml'] = self::getPageHtml($page , $this->_response['manufactor']['pageData']['lastPage'] , '/admin/manufactor?' . $param);
        
        return view('admin.manufactor.list' , $this->_response);
    }

    public function add(Request $request){
        $this->_response['_active']['_action']    = 'add';
        return view('admin.manufactor.add' , $this->_response);
    }
    
    public function doAdd(Request $request){
        $validation = validator::make($request->all(),[
            'name'                  => 'required',
            'address'               => 'required',
            'mobile'                => 'required',
            'contact'               => 'required'
        ] , [
            'name.required'             => '必须填写供应商名称',
            'address.required'          => '必须填写供应商地址',
            'mobile.required'           => '必须填写联系方式',
            'contact.required'          => '必须填写联系人'
        ]);
        if($validation->fails()) {
            $error = $validation->errors()->all();
            return response()->json(['code' => -1, 'msg' => $error[0]]);
        }
        
        $saveData = $request->all();
        
        $manufactorModel = new Manufactor();
        $mId = Manufactor::insertGetId($saveData);
        if($mId){
            return response()->json(['code' => 0 , 'msg' => '添加成功', 'data'=>$mId]);
        }else{
            return response()->json(['code' => -1 , 'msg' => '添加失败,请稍后重试']);
        }
    }
    
    public function getManufactor($mid){
        $this->_response['_active']['_action']    = 'edit';
        $manufactorModel = new Manufactor();
        $manufactors = $manufactorModel->getManufactorsList(['ids'=>[$mid], 0, 1]);
        
        if(count($manufactors['list']) == 1){
            $this->_response['info']  = $manufactors['list'][0];
        }else{
            $this->_response['info']  = [];
        }
        
        return view('admin.manufactor.edit' , $this->_response);
    }
    
    public function update(Request $request){
        $validation = validator::make($request->all(),[
            'id'                    => 'required',
            'name'                  => 'required',
            'address'               => 'required',
            'mobile'                => 'required',
            'contact'               => 'required'
        ] , [
            'id.required'               => '没有要修改的供应商',
            'name.required'             => '必须填写供应商名称',
            'address.required'          => '必须填写供应商地址',
            'mobile.required'           => '必须填写联系方式',
            'contact.required'          => '必须填写联系人'
        ]);
        
        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }
        
        $saveData = $request->all();
        
        $mId = $saveData['id'];
        unset($saveData['id']);
        
        $saveData['updated_at'] = date('Y-m-d H:i:s' , $_SERVER['REQUEST_TIME']);
        
        if(Manufactor::where('id', $mId)->update($saveData)){
            return response()->json(['code' => 0 , 'msg' => '修改成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '修改失败,请稍后重试']);
        }
    }
    
    public function delete($mId){
        if(Manufactor::where('id' , $mId)->update([
            'deleted_at' => date('Y-m-d H:i:s' , $_SERVER['REQUEST_TIME'])
        ])){
            return response()->json(['code' => 0 , 'msg' => '删除成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '删除失败,请稍后重试']);
        }
    }
}