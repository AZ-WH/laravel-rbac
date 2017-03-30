<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Database\Eloquent\Model;

class AdminAuthController extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->_response['_active']['_model']       = 'auth';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '角色管理';
    }

    public function role(){
        $this->_response['_active']['_action']      = 'list';
        return view('admin.roles.list' , $this->_response);
    }

}