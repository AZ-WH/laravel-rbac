<?php

Route::group(['namespace' => 'Wechat' , 'prefix' => 'wechat' ] , function(){
    Route::any('/' , 'WechatController@index');
    Route::get('menu/text' , 'MenuController@addText');
    Route::get('menu/set' , 'MenuController@setMenu');
    Route::get('login' , 'LoginController@login');
    Route::get('call-back/login' , 'LoginController@callbackLogin');
});

Route::group(['namespace' => 'Web' , 'middleware' => 'WebAuth'] , function(){
    Route::any('/', 'IndexController@index');
    Route::get('/goods/list', 'IndexController@goodsList');
    Route::get('/goods/info', 'IndexController@goodsInfo');

    Route::get('/order', 'OrderController@index');
    Route::post('/order/init', 'OrderController@init');
    Route::get('/order/cart', 'OrderController@cart');
    Route::get('/order/cart-clear', 'OrderController@clearCart');
    Route::post('/order/update-cart', 'OrderController@updateCart');
    Route::get('/order/comfirm/{orderId}', 'OrderController@comfirm');


    Route::get('/user', 'UserController@index');
    Route::get('/area', 'UserController@getAreas');
    Route::get('/user/address', 'UserController@address');
    Route::get('/user/address-add', 'UserController@addAddress');
    Route::post('/user/address-add', 'UserController@doAddAddress');
    Route::get('/user/address-update/{aid}', 'UserController@editAddress');
    Route::post('/user/address-update', 'UserController@doEditAddress');
});

Route::get('/nologin', 'Web\UserController@noLogin');
Route::get('/login/account', 'Web\UserController@login');