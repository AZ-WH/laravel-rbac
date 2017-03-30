<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Manufactor extends Model
{
    protected $table = 'manufactor';
    
    public function getManufactorsList($search, $offset=0, $length=20 ){
        $sql = DB::table($this->table . ' as m');
        
        $sql->whereNull('m.deleted_at');
        
        if (isset($search['ids'])) {
            $sql->whereIn('m.id', $search['ids']);
        }
        
        $manufactorsList['pageDate']['count']    = $sql->count();
        $manufactorsList['pageDate']['lastPage'] = ceil($manufactorsList['pageDate']['count'] / $length);
        
        $manufactorsList['list'] = $sql->skip($offset)->take($length)->get();
        
        return $manufactorsList;
    }
        
}