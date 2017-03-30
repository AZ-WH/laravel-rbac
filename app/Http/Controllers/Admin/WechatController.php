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

use App\Models\WechatPubAccount;

class WechatController extends AdminController {

    private $_pageLength = 20;

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model'] = 'wechat';
    }


    public function getList(){
        $this->_response['_active']['_action'] = 'list';

        $this->_response['data'] = WechatPubAccount::paginate($this->_pageLength);

        return view('admin.wechat.list' , $this->_response);
    }

    public function add(){
        $this->_response['_active']['_action'] = 'add';
        return view('admin.wechat.add' , $this->_response);
    }

    public function doAdd(Request $request){
        $validation = Validator::make($request->all() , [
            'name'              => 'required',
            'original_id'       => 'required',
            'wechat_account'    => 'required'
        ] , [
            'name.required'             => '必须填写公众号名称',
            'original_id.required'      => '必须填写公众号原始ID',
            'wechat_account.required'   => '必须填写微信号'
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $saveData = $request->all();
        $saveData['token']      = md5($saveData['name'] . time());
        $saveData['aes_key']    = md5($saveData['name'] . $saveData['wechat_account'] . time());
        $saveData['tag']        = substr(md5(uniqid()) , 0 , 16 );

        if(WechatPubAccount::create($saveData)){
            return response()->json(['code' => 0 , 'msg' => '添加成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '添加失败,请稍后重试']);
        }

    }

    public function setting(){
        return view('admin.wechat.setting' , $this->_response);
    }

}