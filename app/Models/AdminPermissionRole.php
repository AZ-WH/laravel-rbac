<?php
namespace App\Models;

use DB;
use Log;
use Illuminate\Database\Eloquent\Model;

class AdminPermissionRole extends Model{

    protected $table = 'admin_permission_role';

    public function addRolePermission($data){
        Log::info($data);
        return DB::table($this->table)->insert($data);
    }

    public function delRolePermission($RoleId){
        return DB::table($this->table)->where('role_id' , $RoleId)->delete();
    }

}
