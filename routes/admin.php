<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' ] , function(){

    Route::group(['middleware' => 'AdminAuth'] , function (){

        Route::get('index' , 'IndexController@index');


        //权限节点start
        Route::get('/permission' , 'AdminPermissionController@getList');
        Route::get('/permission/info/{id}' , 'AdminPermissionController@getInfo');
        Route::post('/permission/update' , 'AdminPermissionController@update');
        Route::get('/permission/delete/{id}' , 'AdminPermissionController@delete');
        Route::get('/permission/add' , 'AdminPermissionController@add');
        Route::post('/permission/add' , 'AdminPermissionController@doAdd');
        //权限节点end

        //角色start
        Route::get('/roles' , 'AdminRoleController@getRoleList');
        Route::get('/roles/permission/{id}' , 'AdminRoleController@getRolePermission');
        Route::post('/roles/update' , 'AdminRoleController@updateRole');
        Route::get('/role/add' , 'AdminRoleController@addRole');
        Route::post('/role/add' , 'AdminRoleController@doAddRole');

        Route::get('/roles/del/{id}' , 'AdminRoleController@delRole');
        //角色end

        //账号start
        Route::get('/adminuser' , 'AdminUserController@getList');
        Route::get('/adminuser/info/{id}' , 'AdminUserController@getInfo');
        Route::get('/adminuser/add' , 'AdminUserController@add');
        Route::post('/adminuser/add' , 'AdminUserController@doAdd');
        Route::post('/adminuser/update' , 'AdminUserController@update');
        Route::post('/adminuser/update/permission' , 'AdminUserController@updatePermission');

        Route::get('/adminuser/permission/{id}' , 'AdminUserController@getPermission');
        //账号end

        Route::get('/current/user' , 'AdminUserController@currentLoginUser');
    });


    Route::get('error' , 'ErrorController@error');
    Route::get('login' , 'AdminUserController@login');
    Route::post('login' , 'AdminUserController@doLogin');
});