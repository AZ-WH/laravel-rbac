<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class User extends Model
{
    protected $table = 'users';

    public function saveUser($data){
        return DB::table($this->table)->insertGetId($data);
    }
}
