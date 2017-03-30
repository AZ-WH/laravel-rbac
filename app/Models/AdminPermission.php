<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

use App\Models\AdminUrl;

class AdminPermission extends Model
{
    protected $table = 'admin_permissions';
    
    public function getPermissionsList() {
        $parent = DB::table($this->table)->where('pid' , 0)->orderBy('created_at' , 'asc')->get();
        $child	= DB::table($this->table)->where('pid' , '<>' ,  0)->get();

        $ruleId = [];

        foreach ($parent as $p){
            $p->rule = explode(',' ,$p->rule);
            $ruleId = array_merge( $p->rule , $ruleId);
        }
        foreach ($child as $c){
            $c->rule = explode(',' ,$c->rule);
            $ruleId = array_merge( $c->rule , $ruleId);
        }

        $adminUrlModel = new AdminUrl();

        $url = DB::table($adminUrlModel->getTable())->whereIn('id' , $ruleId)->get();

        foreach ($parent as $p){
            $p->url = [];
            foreach ($p->rule as $pu){
                foreach ($url as $u){
                    if($u->id == $pu){
                        $p->url[] = $u;
                    }
                }
            }
        }
        foreach ($child as $c){
            $c->url = [];
            foreach ($c->rule as $cu){
                foreach ($url as $u){
                    if($cu == $u->id){
                        $c->url[] = $u;
                    }
                }
            }
        }

        foreach($parent as $p){
            $p->child = array();
            foreach($child as $c){
                if($c->pid == $p->id){
                    $p->child[] = $c;
                }
            }
        }

        return $parent;
    }


    public function saveData($pid=0 , $name , $rule){

        return DB::table($this->table)->insertGetId([
            'pid'   => $pid,
            'name'  => $name,
            'rule'  => implode(',' , $rule)
        ]);

    }
}