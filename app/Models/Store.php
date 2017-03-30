<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Store extends Model
{
    protected $table = 'stores';
    
    public function getStoresList($search, $offset=0, $length=20 ){
        $sql = DB::table($this->table . ' as s');
        
        $sql->whereNull('s.deleted_at');
        
        if (isset($search['ids'])) {
            $sql->whereIn('s.id', $search['ids']);
        }
        
        $storesList['pageDate']['count']    = $sql->count();
        $storesList['pageDate']['lastPage'] = ceil($storesList['pageDate']['count'] / $length);
        
        $storesList['list'] = $sql->skip($offset)->take($length)->get();
        
        return $storesList;
    }
      
    public function saveStore($saveData){
//         if(!isset($saveData['imgs'])){
//             return false;
//         }
    
//         $imgs = $saveData['imgs'];
//         unset($saveData['imgs']);
    
//         $goodsImgModel = new GoodsImg();
    
        DB::beginTransaction();
        try{
            $sID = DB::table($this->table)->insertGetId($saveData);
    
//             $saveImgData = [];
//             $i = 0;
//             foreach ($imgs as $img){
//                 $saveImgData[$i] = [];
//                 $saveImgData[$i]['img_url']     = $img['imgUrl'];
//                 $saveImgData[$i]['g_id']        = $gID;
//                 $saveImgData[$i]['sort']        = $img['sort'];
//             }
//             DB::table($goodsImgModel->getTable())->insert($saveImgData);
    
            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollBack();
            return false;
        }
    
    }
    
    
    public function updateStore($sId, $updateData){
//         if(!isset($updateData['imgs'])){
//             return false;
//         }
        
//         $imgs = $updateData['imgs'];
//         unset($updateData['imgs']);
        
//         $goodsImgModel = new GoodsImg();
        
        DB::beginTransaction();
        try{
            if(DB::table($this->table)->where('id' , $sId)->update($updateData) === false){
                DB::rollBack();
                return false;
            }
        
//             $updateImgData = [];
//             $i = 0;
//             foreach ($imgs as $img){
//                 $updateImgData['img_url']     = $img['imgUrl'];
//                 $updateImgData['sort']        = $img['sort'];
//                 $imgId                        = isset($img['imgId']) ? $img['imgId'] : 0;
        
//                 if($imgId) {
//                     if (DB::table($goodsImgModel->getTable())->where('g_id', $gId)->where('id', $imgId)->update($updateImgData) === false) {
//                         DB::rollBack();
//                         return false;
//                     }
//                 }else{
//                     $updateImgData['g_id'] = $gId;
//                     if (DB::table($goodsImgModel->getTable())->insertGetId($updateImgData) === false) {
//                         DB::rollBack();
//                         return false;
//                     }
//                 }
//             }
        
            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollBack();
            return false;
        }
        
    }
}
