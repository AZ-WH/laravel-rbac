<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Web\WebController;

use Session , Cookie , Config , Log , Validator;

use App\Models\Goods;
use App\Models\Cart;
use App\Models\Order;

use App\Models\UserAddress;

class OrderController extends WebController
{

    private $_length;
    public function __construct(){
        parent::__construct();
        $this->_length = 20;
        $this->_response['_title']  = '订单';
        $this->_response['_css'] = [
            'cart.css'
        ];
    }


    public function index(Request $request){
        $this->_response['_css'] = [
            'order.css'
        ];

        $page = 1;
        if($request->has('page')){
            $page = $request->get('page');
        }

        $status = Config::get('order.status');

        $offset = ($page -1) * $this->_length;

        $orderModel = new Order();
        $this->_response['order']   = $orderModel->getOrderInfo([] , $offset , $this->_length);

        foreach ($this->_response['order'] as $o){
            $o->status_msg = $status[$o->status];
        }

        return view('web.order' , $this->_response);
    }

    public function init(Request $request){
        $validation = Validator::make($request->all() , [
            'goods'                      => 'required',
            'address_id'                => 'required',

        ] , [
            'data.required'               => '没有商品',
            'address_id.required'         => '没有收货地址',
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $goods = json_decode($request->get('goods'));

        global $uid;

        $orderModel = new Order();
        $orderInitData = $orderModel->init($uid , $request->get('address_id') , $goods);

        return response()->json($orderInitData);

    }

    public function cart(){
        $this->_response['_title']  = '购物车';

        global $uid;

        $cartModel = new Cart();

        $this->_response['carts']   = $cartModel->getCart($uid);
        $this->_response['address'] = UserAddress::where('u_id' , $uid)->whereNull('deleted_at')->first();

        return view('web.cart' , $this->_response);
    }

    public function updateCart(Request $request){
        $validation = Validator::make($request->all() , [
            'gid'                  => 'required',
            'buy_num'              => 'required',

        ] , [
            'gid.required'               => '没有商品',
            'buy_num.required'           => '没有购买数量',
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $updateData = [
            'u_id'      => 1,
            'g_id'      => $request->get('gid'),
            'buy_num'   => $request->get('buy_num')
        ];

        $goodsData = Goods::where('id' , $updateData['g_id'])->first();
        if(!$goodsData){
            return response()->json(['code' => -2 , 'msg' => '商品不存在' ]);
        }

        $updateData['now_price']    = $goodsData->now_price;

        //如果购买数量小于等于0,,则删除记录
        if($updateData['buy_num'] <= 0){
            Cart::where('u_id' , $updateData['u_id'])
                ->where('g_id' , $updateData['g_id'])
                ->delete();
            return response()->json(['code' => 0 , 'msg' => '更新购物车成功' ]);
        }else {
            $issetCart = Cart::where('u_id', $updateData['u_id'])
                ->where('g_id', $updateData['g_id'])
                ->first();

            //如果存在这条记录,则更新,否则添加
            if ($issetCart) {
                $updateData['updated_at'] = date('Y-m-d H:i:s', time());

                if (
                    Cart::where('u_id', $updateData['u_id'])
                        ->where('g_id', $updateData['g_id'])
                        ->update($updateData) === false
                ) {
                    return response()->json(['code' => -3, 'msg' => '更新购物车失败']);
                }

            } else {
                if (!Cart::create($updateData)) {
                    return response()->json(['code' => -4, 'msg' => '更新购物车失败']);
                }
            }
            return response()->json(['code' => 0 , 'msg' => '更新购物车成功' ]);
        }

    }

    public function clearCart(){
        global $uid;
        if(Cart::where('u_id' , $uid)->delete()){
            return response()->json(['code' => 0]);
        }else{
            return response()->json(['code' => 0]);
        }
    }

    public function comfirm($orderId){
        $this->_response['_title']  = '确认订单';
        $this->_response['_css'][] = 'comfirm.css';

        $orderModel = new Order();
        $this->_response['order']   = $orderModel->getOrderInfo(['ids' => [$orderId]] , 0 , 1);

        if(count($this->_response['order']) == 1){
            $this->_response['order'] = $this->_response['order'][0];
        }

        return view('web.comfirm' , $this->_response);
    }
}
