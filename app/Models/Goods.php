<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

use DB;
use App\Models\GoodsImg;

class Goods extends Model
{
    protected $table = 'goods';

    public function saveGoods($saveData){
        if(!isset($saveData['imgs'])){
            return false;
        }

        $imgs = $saveData['imgs'];
        unset($saveData['imgs']);

        $goodsImgModel = new GoodsImg();

        DB::beginTransaction();
        try{
            $gID = DB::table($this->table)->insertGetId($saveData);

            $saveImgData = [];
            $i = 0;
            foreach ($imgs as $img){
                $saveImgData[$i] = [];
                $saveImgData[$i]['img_url']     = $img['imgUrl'];
                $saveImgData[$i]['g_id']        = $gID;
                $saveImgData[$i]['sort']        = $img['sort'];
            }
            DB::table($goodsImgModel->getTable())->insert($saveImgData);

            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollBack();
            return false;
        }

    }

    public function getGoodsList($search , $offset=0 , $length = 20 , $isShowImg = false){
        $goodsImgModel = new GoodsImg();
        $goodsList = array();
        $goodsList['pageData'] = array();

        $sql = DB::table($this->table . ' as g');

        $sql->whereNull('g.deleted_at');

        if(isset($search['status'])){
            $sql->where('g.status' , $search['status']);
        }

        if(isset($search['ids'])){
            $sql->whereIn('g.id'  , $search['ids']);
        }

        $goodsList['pageData']['count']     = $sql->count();
        $goodsList['pageData']['lastPage']  = ceil($goodsList['pageData']['count'] / $length);

        $goodsList['list'] = $sql->skip($offset)->take($length)->get();

        foreach ($goodsList['list'] as $gl) {
            $gl->now_price  = priceIntToFloat($gl->now_price);
            $gl->out_price  = priceIntToFloat($gl->out_price);
            $gl->in_price   = priceIntToFloat($gl->in_price);
            $gl->buy_num    = 0;
        }

        if($isShowImg) {
            $gids = [];
            foreach ($goodsList['list'] as $gl) {
                $gids[] = $gl->id;
            }

            $goodsImgs = GoodsImg::whereIn('g_id', $gids)->whereNull('deleted_at')->orderBy('sort' , 'asc')->get();

            foreach ($goodsList['list'] as $gl) {

                $gl->img = '';
                $gl->imgs = [];
                foreach ($goodsImgs as $gi) {
                    if ($gi->g_id == $gl->id) {
                        $img = [];
                        $img['imgUrl'] = $gi->img_url;
                        $img['imgId'] = $gi->id;
                        $gl->imgs[] = $img;
                    }
                }

                if(count($gl->imgs) > 0){
                    $gl->img = $gl->imgs[0];
                }
            }
        }

        return $goodsList;
    }


    public function updateGoods($gId , $updateData){
        if(!isset($updateData['imgs'])){
            return false;
        }

        $imgs = $updateData['imgs'];
        unset($updateData['imgs']);

        $goodsImgModel = new GoodsImg();

        DB::beginTransaction();
        try{
            if(DB::table($this->table)->where('id' , $gId)->update($updateData) === false){
                DB::rollBack();
                return false;
            }

            $updateImgData = [];
            $i = 0;
            foreach ($imgs as $img){
                $updateImgData['img_url']     = $img['imgUrl'];
                $updateImgData['sort']        = $img['sort'];
                $imgId                        = isset($img['imgId']) ? $img['imgId'] : 0;

                if($imgId) {
                    if (DB::table($goodsImgModel->getTable())->where('g_id', $gId)->where('id', $imgId)->update($updateImgData) === false) {
                        DB::rollBack();
                        return false;
                    }
                }else{
                    $updateImgData['g_id'] = $gId;
                    if (DB::table($goodsImgModel->getTable())->insertGetId($updateImgData) === false) {
                        DB::rollBack();
                        return false;
                    }
                }
            }

            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollBack();
            return false;
        }

    }
}
