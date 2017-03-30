<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Web\WebController;

use Session , Cookie , Config , Log , Validator;

use App\Models\Goods;
use App\Models\Cart;

class IndexController extends WebController
{

    private $_length;

    public function __construct(){
        parent::__construct();
        $this->_length = 7;
        $this->_response['_title']  = '潮水果';
        $this->_response['_css'] = [
            'index.css'
        ];
    }

    public function index(){
        return view('web.index' , $this->_response);
    }

    public function goodsList(Request $request){

        $page = 1;

        if($request->has('page')){
            $page = $request->get('page');
        }

        $offset = ($page - 1) * $this->_length;

        $search = [];
        $search['status'] = 1;

        $goodsModel = new Goods();

        $goodsList = $goodsModel->getGoodsList($search , $offset , $this->_length , true);
        $goodsList['pageData']['page'] = $page;

        global $uid;
        $cartList = Cart::where('u_id' , $uid)->get();

        $responseData = [
            'list'      => $goodsList['list'],
            'pageData'  => $goodsList['pageData'],
            'cartList'  => $cartList
        ];

        return response()->json([ 'code' => 0 , 'mag' => '操作成功' , 'data' => $responseData ] );
    }

    public function goodsInfo(){
        $this->_response['_title']  = '潮水果';
        return view('web.info' , $this->_response);
    }
}
