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

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;

class StoreController extends AdminController {

    private $_length = 20;

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model']       = 'store';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '小一农货-门店管理';
    }

    public function getList(Request $request){
        $page = 1;
        $search = [];
        $param = '';
        $this->_response['_active']['_action']      = 'list';
        
        if($request->has('page')) {
            $page = $request->get('page');
        }
        $offset = ($page - 1) * $this->_length;
        
        $storeModel = new Store();
        $this->_response['stores'] = $storeModel->getStoresList($search, $offset, $this->_length);
        $this->_response['goods']['pageData']['page'] = $page;
        $this->_response['goods']['pageData']['pageHtml'] = self::getPageHtml($page , $this->_response['store']['pageData']['lastPage'] , '/admin/store?' . $param);

        return view('admin.store.list' , $this->_response);
    }

    public function add(Request $request){
        $this->_response['_active']['_action']    = 'add';
        return view('admin.store.add' , $this->_response);
    }
    
    public function doAdd(Request $request){
        $validation = Validator::make($request->all(), [
            'name'                  => 'required',
            'address'               => 'required',
            'mobile'                => 'required',
            'contact'               => 'required',
            'i_d_card'              => 'required',
            'business_license'      => 'required'
        ] , [
            'name.required'             => '必须填写店铺名称',
            'address.required'          => '必须填写店铺地址',
            'mobile.required'           => '必须填写联系方式',
            'contact.required'          => '必须填写联系人',
            'i_d_card.required'         => '必须填写身份证',
            'business_license.required' => '必须上传营业执照'
        ]);
        if($validation->fails()) {
            $error = $validation->errors()->all();
            return response()->json(['code' => -1, 'msg' => $error[0]]);
        }
        
        $saveData = $request->all();
        
        $storeModel = new Store();
        if($storeModel->saveStore($saveData)) {
            return response()->json(['code' => 0 , 'msg' => '添加成功']);
        }else {
            return response()->json(['code' => -1 , 'msg' => '添加失败,请稍后重试']);
        }
        
    }
    
    public function getStore($sid) {
        $storeModel = new Store();
        $stores = $storeModel->getStoresList(['ids'=> [$sid], 0, 1]);
        
        if(count($stores['list']) == 1) {
            $this->_response['info'] = $stores['list'][0];
        }else {
            $this->_response['info'] = [];
        }
        
        return view('admin.store.edit', $this->_response);
    }
    
    public function update(Request $request){
        $validation = Validator::make($request->all(), [
            'id'                    => 'required',
            'name'                  => 'required',
            'address'               => 'required',
            'mobile'                => 'required',
            'contact'               => 'required',
            'i_d_card'              => 'required',
            'business_license'      => 'required'
        ] , [
            'id.required'               => '没有要修改的店铺',
            'name.required'             => '必须填写店铺名称',
            'address.required'          => '必须填写店铺地址',
            'mobile.required'           => '必须填写联系方式',
            'contact.required'          => '必须填写联系人',
            'i_d_card.required'         => '必须填写身份证',
            'business_license.required' => '必须上传营业执照'
        ]);
        
        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }
        
        $saveData = $request->all();
        
        $sId = $saveData['id'];
        unset($saveData['id']);
        
        $saveData['updated_at'] = date('Y-m-d H:i:s' , $_SERVER['REQUEST_TIME']);
        
        $storeModel = new Store();
        if($storeModel->updateStore($sId , $saveData)){
            return response()->json(['code' => 0 , 'msg' => '添加成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '添加失败,请稍后重试']);
        }
    }
    
    public function delete($sId){
        if(Store::where('id', $sId)->update(['deleted_at' => date('Y-m-d H:i:s' , $_SERVER['REQUEST_TIME'])]) ){
            return response()->json(['code' => 0 , 'msg' => '删除成功']);  
        }else{
            return response()->json(['code' => -1 , 'msg' => '删除失败,请稍后重试']);
        }
    }
    
    
}