<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Array_;

class Menu extends Model{

    protected $table = 'memuu_admin_permissions';

    protected $fillable = [
        'id' ,
        'name' ,
        'pid' ,
        'rule',
//         'belong',
//         'icon',
//         'sort'
    ];

    public $timestamps = false;

    public function getMenu($belong){
        $menuWithPid    = DB::table($this->table)->where('belong' , $belong)->where('pid' , 0)->orderBy('sort' , 'desc')->get();
        $menuWithChild  = DB::table($this->table)->where('belong' , $belong)->where('pid' , '<>' , 0)->orderBy('sort' ,'desc')->get();

        foreach ($menuWithPid as $mp){
            $mp->child = array();
            foreach ($menuWithChild as $mc){
                if($mp->id == $mc->pid){
                    $mp->child[] = $mc;
                }
            }
        }
        return $menuWithPid;
    }
    
   public function getMenu2() {
        $menuWithPid    = DB::table($this->table)->where('pid' , 0)->orderBy('sort' , 'desc')->get();
        $menuWithChild  = DB::table($this->table)->where('pid' , '<>' , 0)->orderBy('sort' ,'desc')->get();

        foreach ($menuWithPid as $mp){
            $mp->child = array();
            foreach ($menuWithChild as $mc){
                if($mp->id == $mc->pid){
                    $mp->child[] = $mc;
                }
            }
        }
        return $menuWithPid;
   } 
  
}
