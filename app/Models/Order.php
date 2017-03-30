<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB , Log;

use App\Models\OrderInfo;
use App\Models\UserAddress;
use App\Models\OrderAddress;
use App\Models\Goods;
use App\Models\GoodsImg;

class Order extends Model
{
    protected $table = 'orders';

    public function init($uid ,$addressId , $goods){

        $saveOrderAddress = [];

        //获取地址信息
        $address = UserAddress::where('u_id' , $uid)->where('id' , $addressId)->whereNull('deleted_at')->first();
        if(!$address){
            return array('code' => -1 , 'msg' => '收货地址不存在');
        }

        //需要保存的收货地址信息
        $saveOrderAddress['mobile']         = $address['mobile'];
        $saveOrderAddress['name']           = $address['name'];
        $saveOrderAddress['province']       = $address['province'];
        $saveOrderAddress['city']           = $address['city'];
        $saveOrderAddress['district']       = $address['district'];
        $saveOrderAddress['address']        = $address['address'];
        $saveOrderAddress['house_number']   = $address['house_number'];
        $saveOrderAddress['sex']            = $address['sex'];

        $goodsId = [];

        foreach ($goods as $g){
            $goodsId[]  = $g->goods_id;
        }

        //获取商品信息
        $goodsModel = new Goods();

        //排除下架的商品 和库存为0的商品
        $search = [
            'status'    => 1,
            'ids'       => $goodsId,
            'stock_num' => [
                'condition' => '<>',
                'value'     => 0
            ]
        ];
        $goodsInfo =  $goodsModel->getGoodsList($search , 0 , count($goodsId) , false);
        //校验商品数量
        if(count($goodsId) != count($goodsInfo['list'])) {
            return array('code' => -2 , 'msg' => '商品信息错误');
        }

        $saveOrderGoodsInfo = [];
        $goodsPrice = 0;
        foreach ($goodsInfo['list'] as $g){
            foreach ($goods as $gNum){
                if($gNum->goods_id == $g->id){
                    $g->buy_num = $gNum->buy_num;
                    $goodsPrice += $gNum->buy_num + $g->now_price;
                }
            }
            $saveOrderGoodsInfo[] = [
                'g_id'              => $g->id,
                'show_title'        => $g->show_title,
                'buy_num'           => $g->buy_num,
                'now_price'         => $g->now_price * 100,
                'unit'              => $g->unit,
                'producing_area'    => $g->producing_area,
                'name'              => $g->name,
                'c_id'              => $g->c_id
            ];
        }

        //计算需要支付的价格
        $payTotal = $goodsPrice;

        $saveOrder = [
            'order_num'         => 'kw_' . time(),
            'g_total_price'     => $goodsPrice,
            'pay_total'         => $payTotal,
            'status'            => 1
        ];

        DB::beginTransaction();
        try{
            //保存Order数据
            $orderId = DB::table($this->table)->insertGetId($saveOrder);

            //保存订单收货地址信息
            $saveOrderAddress['o_id'] = $orderId;
            $orderAddressModel = new OrderAddress();
            DB::table($orderAddressModel->getTable())->insert($saveOrderAddress);

            //保存订单商品信息
            foreach ($saveOrderGoodsInfo as &$sog){
                $sog['o_id'] = $orderId;
            }

            $orderInfoModel = new OrderInfo();
            DB::table($orderInfoModel->getTable())->insert($saveOrderGoodsInfo);

            DB::commit();

            return array('code' => 0 , 'msg' => '成功' , 'data' => $orderId);
        }catch( \Exception $e ){
            Log::error($e);
            DB::rollBack();
            return array('code' => -2 , 'msg' => '失败');
        }
    }





    public function getOrderInfo($search , $offset=0 , $length = 10){

        $orderAddressModel  = new OrderAddress();
        $orderInfoModel     = new OrderInfo();
        $goodsImgModel      = new GoodsImg();

        $sql =DB::table($this->table . ' as o')
            ->select(
                'o.id',
                'o.order_num',
                'o.g_total_price',
                'o.pay_total',
                'o.service_charge',
                'o.created_at',
                'o.status',
                'oa.province',
                'oa.city',
                'oa.district',
                'oa.address',
                'oa.house_number',
                'oa.name',
                'oa.mobile'
            );
        if(isset($search['ids'])){
            $sql->whereIn('o.id' , $search['ids']);
        }

        $orderInfo = $sql->join($orderAddressModel->getTable() . ' as oa' , 'o.id' , '=' , 'oa.o_id')
            ->skip($offset)->take($length)
            ->get();

        $orderIds = [];
        foreach ($orderInfo as $o){
            $orderIds[] = $o->id;
        }
        $orderGoodsInfo = DB::table($orderInfoModel->getTable())->whereIn('o_id' , $orderIds)->get();

        $goodsIds = [];
        foreach ($orderGoodsInfo as $oi){
            $goodsIds[] = $oi->g_id;
        }

        $goodsImg = DB::table($goodsImgModel->getTable())->whereIn('g_id' , $goodsIds)->get();

        foreach ($orderGoodsInfo as $og) {
            $og->imgs = [];
            $og->img = '';
            foreach ($goodsImg as &$gi) {
                if($gi->g_id == $og->g_id){
                    $img = [];
                    $img['imgUrl'] = $gi->img_url;
                    $img['imgId'] = $gi->id;
                    $og->imgs[] = $img;
                }
            }

            if(count($og->imgs) > 0){
                $og->img = $og->imgs[0];
            }
        }

        foreach ($orderInfo as $o){
            $o->goods = [];
            foreach ($orderGoodsInfo as $og){
                if($o->id == $og->o_id){
                    $o->goods[] = $og;
                }
            }
        }

        return $orderInfo;
    }
}
