<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Goods;

use DB;

class Cart extends Model
{
    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [

    ];


    public function getCart($uid){
        $goodsModel = new Goods();
        $carts = DB::table($this->table . ' as c')
            ->select(
                'c.u_id' ,
                'c.buy_num',
                'g.id as g_id',
                'g.show_title',
                'g.unit',
                'g.now_price'
            )
            ->where('u_id' , $uid)
            ->join($goodsModel->getTable() . ' as g' , 'g.id' , '=' , 'c.g_id')
            ->get();

        $gids = [];
        foreach ($carts as $gl) {
            $gids[] = $gl->g_id;
        }

        $goodsImgs = GoodsImg::whereIn('g_id', $gids)->whereNull('deleted_at')->orderBy('sort' , 'asc')->get();

        foreach ($carts as $gl) {

            $gl->now_price  = priceIntToFloat($gl->now_price);
            $gl->img = '';
            foreach ($goodsImgs as $gi) {
                if ($gi->g_id == $gl->g_id) {
                    $gl->img = $gi->img_url;
                }
            }
        }

        return $carts;
    }
}
