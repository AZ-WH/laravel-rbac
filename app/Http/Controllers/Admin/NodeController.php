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

use App\Models\Node;

use Validator;

class NodeController extends AdminController {

    private $_length = 20;

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model']       = 'node';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '小一农货-节点管理';
    }


    public function getList(Request $request){
        $page = 1;
        $search = [];
        $param = '';

        if($request->has('page')){
            $page = $request->get('page');
        }
        $offset = ($page - 1) * $this->_length;

//         if($request->has('type') && $request->get('type') == 0){
//             $search['status'] = 0;
//             $param .= 'type=' . $search['status'];
//             $this->_response['_active']['_action']    = 'list-off';
//         }else{
//             $search['status'] = 1;
//             $param .= 'type=' . $search['status'];
//             $this->_response['_active']['_action']    = 'list-on';
//         }

        $nodeModel = new Node();
        $this->_response['node'] = $nodeModel->getGoodsList($search , $offset , $this->_length);
        $this->_response['node']['pageData']['page'] = $page;
        $this->_response['node']['pageData']['pageHtml'] = self::getPageHtml($page , $this->_response['node']['pageData']['lastPage'] , '/admin/node?' . $param);

        return view('admin.node.list' , $this->_response);
    }

    public function add(Request $request){
        $this->_response['_active']['_action']    = 'add';
        return view('admin.node.add' , $this->_response);
    }

    public function doAdd(Request $request){
        $validation = Validator::make($request->all() , [
            'name'              => 'required',
            'url'               => 'required',
            'method'            => 'required',
        ] , [
            'name.required'     => '必须填写节点名称',
            'url.required'      => '必须填写节点url',
            'method.required'   => '必须填写节点method',
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $saveData = $request->all();

        $nodeModel = new Node();

        if($nodeModel->addNode($saveData)){
            return response()->json(['code' => 0 , 'msg' => '添加成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '添加失败,请稍后重试']);
        }

    }

    public function getNode($nid){
        $nodeModel = new Node();
        $nodes = $nodeModel->getGoodsList(['ids' => [$nid]] , 0 , 1 , true);

        if(count($nodes['list']) == 1){
            $this->_response['info']  = $nodes['list'][0];
        }else{
            $this->_response['info']  = [];
        }

        return view('admin.node.edit' , $this->_response);
    }

    public function update(Request $request){
        $validation = Validator::make($request->all() , [
            'name'              => 'required',
            'url'               => 'required',
            'method'            => 'required',
            'id'                => 'required',
        ] , [
            'name.required'     => '必须填写节点名称',
            'url.required'      => '必须填写节点url',
            'method.required'   => '必须填写节点method',
            'id.required'       => '必须填写节点id',
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $saveData = $request->all();

        $nId = $saveData['id'];
        unset($saveData['id']);


    }

    public function delete($gId){
        if(Goods::where('id' , $gId)->update([
            'deleted_at' => date('Y-m-d H:i:s' , $_SERVER['REQUEST_TIME'])
        ])){
            return response()->json(['code' => 0 , 'msg' => '删除成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '删除失败,请稍后重试']);
        }
    }

}