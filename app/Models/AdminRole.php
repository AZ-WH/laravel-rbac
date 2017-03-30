<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class AdminRole extends Model
{
    protected $table = 'admin_roles';
    
    public function getRoleList() {
        return DB::table($this->table)->get();
    }

    public function saveData($data){
        return DB::table($this->table)->insertGetId($data);
    }
}