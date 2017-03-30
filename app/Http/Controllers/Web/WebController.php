<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class WebController extends Controller {

    protected $_response;

    public function __construct()
    {
        $this->_response                            = array();
        $this->_response['_title']                  = '小一农货';

    }

}