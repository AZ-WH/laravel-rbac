<?php
/**
 * Created by PhpStorm.
 * User: woody
 * Date: 17-2-16
 * Time: 下午10:46
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

class IndexController extends AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->_response['_active']['_model'] = 'index';
    }


    public function index(){

        return view('admin.index.index' , $this->_response);
    }

}