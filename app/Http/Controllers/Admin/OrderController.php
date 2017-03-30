<?php
/**
 * Created by PhpStorm.
 * User: woody
 * Date: 17-2-16
 * Time: 下午10:46
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

class OrderController extends AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model'] = 'order';
    }


    public function getList(){

        return view('admin.order.list' , $this->_response);
    }

}