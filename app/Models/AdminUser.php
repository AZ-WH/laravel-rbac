<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB , Log;

use App\Models\AdminUserRole;
use App\Models\AdminUserPermission;
use App\Models\AdminRole;
use App\Models\AdminPermission;
use App\Models\AdminUrl;

class AdminUser extends Model
{
    protected $table = 'admin_users';

    public function saveData($data , $roleId = []){

        $adminUserRoleModel = new AdminUserRole();
        $adminRoleModel     = new AdminRole();

        DB::beginTransaction();
        try{
            $userId = DB::table($this->table)->insertGetId($data);
            if(!$userId){
                DB::rollBack();
                return false;
            }

            $userRole = [];
            $userRoleLength = 0;
            foreach ($roleId as $r){
                $userRole[$userRoleLength] = [];
                $userRole[$userRoleLength]['uid'] = $userId;
                $userRole[$userRoleLength]['rid'] = $r;
                $userRoleLength++;
            }

            $role = AdminRole::whereIn('id' , $roleId)->get();
            $permissionId = [];
            foreach ($role as $r){
                $tmp_permission = explode(',' , $r->permission);
                $permissionId = array_merge($permissionId , $tmp_permission);
            }

            if(!$this->updateUserPermission($userId , $permissionId)){
                DB::rollBack();
                return false;
            }

            if(!DB::table($adminUserRoleModel->getTable())->insert($userRole)){
                DB::rollBack();
                return false;
            }

            DB::commit();
            return true;
        }catch (\Exception $e){
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }

    public function updateUserPermission($uid , $permission){

        $permission = array_unique($permission);

        $adminUserPermissionModel = new AdminUserPermission();

        DB::table($adminUserPermissionModel->getTable())->where('uid' , $uid)->delete();

        $userPermission = [];
        $userPermissionLength = 0;
        foreach ($permission as $p){
            $userPermission[$userPermissionLength]['uid'] = $uid;
            $userPermission[$userPermissionLength]['pid'] = $p;
            $userPermissionLength++;
        }

        return DB::table($adminUserPermissionModel->getTable())->insert($userPermission);

    }

    public function getUserList(){
        $adminUserRoleModel = new AdminUserRole();
        $adminRoleModel     = new AdminRole();

        $user = DB::table($this->table)->whereNull('deleted_at')->get();

        $userIds = [];
        foreach( $user as $u) {
            $userIds[] = $u->id;
        }

        $role = DB::table($adminUserRoleModel->getTable() . ' as ur')
            ->whereIn('uid' , $userIds)
            ->leftJoin($adminRoleModel->getTable() . ' as r' , 'ur.rid' , '=' , 'r.id')
            ->get();

        foreach ($user as $u){
            $u->role = [];
            foreach ($role as $r){
                if($u->id == $r->uid){
                    $u->role[] = $r;
                }
            }
        }

        return $user;
    }

    public function getUserInfo($uid){
        $adminUserRoleModel = new AdminUserRole();
        $adminRoleModel     = new AdminRole();

        $user = DB::table($this->table)->where('id' , $uid)->whereNull('deleted_at')->first();

        $role = DB::table($adminUserRoleModel->getTable() . ' as ur')
            ->where('uid' , $uid)
            ->leftJoin($adminRoleModel->getTable() . ' as r' , 'ur.rid' , '=' , 'r.id')
            ->get();

        $user->role = $role;

        return $user;
    }

    public function updateUser($userId , $data , $roleId = []){

        $adminUserRoleModel = new AdminUserRole();

        DB::beginTransaction();
        try{
            if(DB::table($this->table)->where('id' , $userId)->update($data) === false){
                DB::rollBack();
                return false;
            }

            $userRole = [];
            $userRoleLength = 0;
            foreach ($roleId as $r){
                $userRole[$userRoleLength] = [];
                $userRole[$userRoleLength]['uid'] = $userId;
                $userRole[$userRoleLength]['rid'] = $r;
                $userRoleLength++;
            }

            $role = AdminRole::whereIn('id' , $roleId)->get();
            $permissionId = [];
            foreach ($role as $r){
                $tmp_permission = explode(',' , $r->permission);
                $permissionId = array_merge($permissionId , $tmp_permission);
            }

            $this->updateUserPermission($userId , $permissionId);

            DB::table($adminUserRoleModel->getTable())->where('uid' , $userId)->delete();

            if(!DB::table($adminUserRoleModel->getTable())->insert($userRole)){
                DB::rollBack();
                return false;
            }

            DB::commit();
            return true;
        }catch (\Exception $e){
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }


    public function getUserPermissionUrl($userId){
        $userPermission = AdminUserPermission::where('uid' , $userId)->get()->toArray();

        $permissionId = [];
        foreach ($userPermission as $up){
            $permissionId[] = $up['pid'];
        }

        $rule = AdminPermission::whereIn('id' , $permissionId)->get()->toArray();

        $ruleId = [];
        foreach ($rule as $r){
            $ruleId = array_merge($ruleId , explode(',' , $r['rule']));
        }

        $ruleId = array_unique($ruleId);

        $url = AdminUrl::whereIn('id' , $ruleId)->get()->toArray();

        return $url;
    }
}