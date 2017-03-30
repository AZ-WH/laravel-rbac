<?php
/**
 * Created by PhpStorm.
 * User: woody
 * Date: 17-2-16
 * Time: 下午10:46
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Admin\AdminController;

class ErrorController extends AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model']       = 'eror';
        $this->_response['_active']['_action']      = '';
        $this->_response['_title']                  = '小一农货-错误';
    }


    public function error(){
        $this->_response['error'] = '没有权限访问';
        return view('admin.common.error' , $this->_response);
    }

}