<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Menu;
use App\Libs\Message;
use Validator;
use Illuminate\Database\Eloquent\Model;

class MenuController extends AdminController
{
    public function __construct(){
        parent::__construct();
        $this->_response['_title']		= '小一农货平台管理系统';
        $this->_response['_menuactive']	= 'index';
    }
    
    public function getAdminMenuList() {
        $menuModel = new Menu();
        $this->_response['list'] = $menuModel->getMenu2();
        
        return view('admin.menu.list',$this->_response);
        
    }
    
    public function getMenuListByFather(){
        $father = Menu::where('pid' , 0)->get();
        
        return response()->json(Message::setResponseInfo('SUCCESS' , $father));
    }

    public function postAddMenu(Request $request){
        $validation = Validator::make($request->all(), [
            'name'                 => 'required',
        ] , ['name.required' => "菜单名称是必须填写的"]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(Message::setResponseInfo('DEFINED' , '' , '0001' , $error[0]));
        }
        if(Menu::create($request->all())){
            return response()->json(Message::setResponseInfo('SUCCESS'));
        }else{
            return response()->json(Message::setResponseInfo('FAILED'));
        }
    }

    public function getDelMenu(Request $request){
        $url = '/admin/menu';
        $validation = Validator::make($request->all(), [
            'id'                 => 'required',
        ]);

        if($validation->fails()){
            return redirect($url);
        }

        $id = $request->get('id');

        Menu::where('id' , $id)->delete();

        return redirect($url);
    }

    public function getMenuInfo(Request $request){
        $validation = Validator::make($request->all(), [
            'id'                 => 'required',
        ] , ['id.required' => "未找到对应的数据"]);

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(Message::setResponseInfo('DEFINED' , '' , '0001' , $error[0]));
        }

        $id = $request->get('id');

        $menu = Menu::where('id' , $id)->first();

        return response()->json(Message::setResponseInfo('SUCCESS' , $menu));
    }

    public function postUpdateMenu(Request $request){
        $validation = Validator::make($request->all(), [
            'id'                    => 'required',
            'name'                  => 'required',
        ] , [
                'name.required' => "菜单名称是必须填写的",
                'id.required' => "未找到对应的数据"
            ]
        );

        if($validation->fails()){
            $error = $validation->errors()->all();
            return response()->json(Message::setResponseInfo('DEFINED' , '' , '0001' , $error[0]));
        }

        if(Menu::where('id' , $request->get('id'))->update($request->all())){
            return response()->json(Message::setResponseInfo('SUCCESS'));
        }else{
            return response()->json(Message::setResponseInfo('FAILED'));
        }
    }

}
