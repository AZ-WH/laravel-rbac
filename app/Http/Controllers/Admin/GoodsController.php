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

use App\Models\Goods;

use Validator;

class GoodsController extends AdminController {

    private $_length = 20;

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model']       = 'goods';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '小一农货-商品管理';
    }


    public function getList(Request $request){
        $page = 1;
        $search = [];
        $param = '';

        if($request->has('page')){
            $page = $request->get('page');
        }
        $offset = ($page - 1) * $this->_length;

        if($request->has('type') && $request->get('type') == 0){
            $search['status'] = 0;
            $param .= 'type=' . $search['status'];
            $this->_response['_active']['_action']    = 'list-off';
        }else{
            $search['status'] = 1;
            $param .= 'type=' . $search['status'];
            $this->_response['_active']['_action']    = 'list-on';
        }

        $goodsModel = new Goods();
        $this->_response['goods'] = $goodsModel->getGoodsList($search , $offset , $this->_length);
        $this->_response['goods']['pageData']['page'] = $page;
        $this->_response['goods']['pageData']['pageHtml'] = self::getPageHtml($page , $this->_response['goods']['pageData']['lastPage'] , '/admin/goods?' . $param);

        return view('admin.goods.list' , $this->_response);
    }

    public function add(Request $request){
        $this->_response['_active']['_action']    = 'add';
        return view('admin.goods.add' , $this->_response);
    }

    public function doAdd(Request $request){
        $validation = Validator::make($request->all() , [
            'name'              => 'required',
            'c_id'              => 'required',
            'producing_area'    => 'required',
            'unit'              => 'required',
            'out_price'         => 'required',
            'imgs'              => 'required'
        ] , [
            'name.required'             => '必须填写商品名称',
            'producing_area.required'   => '必须填写产地',
            'unit.required'             => '必须填写商品规格',
            'out_price.required'        => '必须填写售价',
            'imgs.required'             => '必须上传图片',
            'c_id.required'             => '必须选择分类'
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $saveData = $request->all();
        if($request->has('show_title')){
            $saveData['show_title'] = $request->get('show_title');
        }else{
            $saveData['show_title'] = $saveData['name'];
        }

        //将价格换成整数
        $saveData['out_price'] = $saveData['out_price'] * 100;
        if($request->has('now_price')){
            $saveData['now_price'] = $request->get('now_price') * 100;
        }else{
            $saveData['now_price'] = $saveData['out_price'];
        }

        if($request->has('in_price')){
            $saveData['in_price'] = $request->get('in_price') * 100;
        }

        $goodsModel = new Goods();

        if($goodsModel->saveGoods($saveData)){
            return response()->json(['code' => 0 , 'msg' => '添加成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '添加失败,请稍后重试']);
        }

    }

    public function getGoods($gid){
        $goodsModel = new Goods();
        $goods = $goodsModel->getGoodsList(['ids' => [$gid]] , 0 , 1 , true);

        if(count($goods['list']) == 1){
            $this->_response['info']  = $goods['list'][0];
        }else{
            $this->_response['info']  = [];
        }

        return view('admin.goods.edit' , $this->_response);
    }

    public function update(Request $request){
        $validation = Validator::make($request->all() , [
            'id'                => 'required',
            'name'              => 'required',
            'c_id'              => 'required',
            'producing_area'    => 'required',
            'unit'              => 'required',
            'out_price'         => 'required',
            'imgs'              => 'required'
        ] , [
            'id.required'               => '没有要修改的商品',
            'name.required'             => '必须填写商品名称',
            'producing_area.required'   => '必须填写产地',
            'unit.required'             => '必须填写商品规格',
            'out_price.required'        => '必须填写售价',
            'imgs.required'             => '必须上传图片',
            'c_id.required'             => '必须选择分类'
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $saveData = $request->all();

        $gId = $saveData['id'];
        unset($saveData['id']);

        if($request->has('show_title')){
            $saveData['show_title'] = $request->get('show_title');
        }else{
            $saveData['show_title'] = $saveData['name'];
        }

        //将价格换成整数
        $saveData['out_price'] = $saveData['out_price'] * 100;
        if($request->has('now_price')){
            $saveData['now_price'] = $request->get('now_price') * 100;
        }else{
            $saveData['now_price'] = $saveData['out_price'];
        }

        if($request->has('in_price')){
            $saveData['in_price'] = $request->get('in_price') * 100;
        }

        $saveData['updated_at'] = date('Y-m-d H:i:s' , $_SERVER['REQUEST_TIME']);

        $goodsModel = new Goods();

        if($goodsModel->updateGoods($gId , $saveData)){
            return response()->json(['code' => 0 , 'msg' => '添加成功']);
        }else{
            return response()->json(['code' => -1 , 'msg' => '添加失败,请稍后重试']);
        }

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