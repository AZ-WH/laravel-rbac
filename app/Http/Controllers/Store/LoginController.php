<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Store\StoreController;

use Session , Cookie , Config , Log , Validator;

class LoginController extends StoreController
{

    public function __construct(){

    }

    public function login(){
        return response()->json(array(['code' => 111]));
    }
}
