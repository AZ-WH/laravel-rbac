<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Web\WebController;

use Session , Cookie , Config , Log , Validator;

use App\Models\AmapCityCode;
use App\Models\UserAddress;
use App\Models\User;

class UserController extends WebController
{

    public function __construct(){
        parent::__construct();
        $this->_response['_title']  = '用户中心';
        $this->_response['_css'] = [
            'address.css'
        ];
    }

    public function noLogin(){
        return view('web.nologin' , $this->_response);
    }

    public function login(Request $request){
        $account = $request->get('account');
        $password = $request->get('password');

        $userData = User::where('mobile' , $account)->where('password' , $password)->first();

        if(isset($userData->password)){
            unset($userData->password);
        }
        if(isset($userData->salt)){
            unset($userData->salt);
        }

        $sessionKey = '2s3r232ss3234sadas423';

        Session::put($sessionKey, $userData->toArray());

        $cookie = Cookie::make(Config::get('session.user_cookie'), $sessionKey, Config::get('session.user_cookie_lifetime'));

        return redirect('/')->withCookie($cookie);
    }


    public function index(){
        $this->_response['_css'] = [
            'user.css'
        ];

        global $uid;
        $user = User::where('id' , $uid)->whereNull('deleted_at')->first();

        if(isset($user->password)){
            unset($user->password);
        }
        if(isset($user->salt)){
            unset($user->salt);
        }

        $this->_response['user'] = $user;

        return view('web.user' , $this->_response);
    }

    public function address(){
        $this->_response['_title']  = '收货地址';

        global $uid;
        $this->_response['address'] = UserAddress::where('u_id' , $uid)->whereNull('deleted_at')->get();

        return view('web.address' , $this->_response);
    }


    public function addAddress(){
        $this->_response['_title']  = '添加收货地址';
        return view('web.address-add' , $this->_response);
    }

    public function doAddAddress(Request $request){
        $validation = Validator::make($request->all() , [
            'name'                          => 'required',
            'province'                      => 'required',
            'city'                          => 'required',
            'address'                       => 'required',
            'house_number'                  => 'required',
            'mobile'                        => 'required',

        ] , [
            'province.required'                 => '请选择省份',
            'city.required'                     => '请选择城市',
            'address.required'                  => '请填写详细地址',
            'house_number.required'             => '请填写门牌号',
            'mobile.required'                   => '请填写收货人电话',
            'name.required'                     => '请填写收货人名称'
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        global $uid;

        $saveData = $request->all();
        $saveData['u_id']   = $uid;

        if(UserAddress::create($saveData)){
            return response()->json(['code' => 0 , 'msg' => '添加成功']);
        }else{
            return response()->json(['code' => -2 , 'msg' => '添加失败']);
        }
    }

    public function getAreas(Request $request){
        $validation = Validator::make($request->all() , [
            'pid'                   => 'required',
            'level'                 => 'required',

        ] , [
            'pid.required'               => '参数错误',
            'level.required'             => '参数错误',
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        $level = $request->get('level');
        $pid = $request->get('pid');

        $data = array();
        $amapCodeModel = new AmapCityCode();
        if($level == 'province'){
            $data = $amapCodeModel->getAreasProvince();
        }elseif($level == 'city'){
            $data = $amapCodeModel->getAreasCity($pid);
        }elseif ($level == 'district'){
            $data = $amapCodeModel->getAreasDistrict($pid);
        }
        return response()->json(['code' => 0 , 'msg' => '' , 'data' => $data]);
    }

    public function editAddress($aid){
        $this->_response['_title']  = '编辑收货地址';

        $this->_response['address'] = UserAddress::where('id' , $aid)->first();

        return view('web.address-update' , $this->_response);
    }

    public function doEditAddress(Request $request){
        $validation = Validator::make($request->all() , [
            'name'                          => 'required',
            'province'                      => 'required',
            'city'                          => 'required',
            'address'                       => 'required',
            'house_number'                  => 'required',
            'mobile'                        => 'required',
            'id'                            => 'required'

        ] , [
            'province.required'                 => '请选择省份',
            'city.required'                     => '请选择城市',
            'address.required'                  => '请填写详细地址',
            'house_number.required'             => '请填写门牌号',
            'mobile.required'                   => '请填写收货人电话',
            'name.required'                     => '请填写收货人名称',
            'id.required'                       => '没有该信息'
        ]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(['code' => -1 , 'msg' => $error[0]]);
        }

        global $uid;
        $aid = $request->get('id');

        $saveData = $request->all();
        unset($saveData['id']);
        $saveData['updated_at'] = date("Y-m-d H:i:s" , $_SERVER['REQUEST_TIME']);

        if(UserAddress::where('id' , $aid)->where('u_id' , $uid)->update($saveData) !== false){
            return response()->json(['code' => 0 , 'msg' => '修改成功']);
        }else{
            return response()->json(['code' => -2 , 'msg' => '修改失败']);
        }
    }
}
