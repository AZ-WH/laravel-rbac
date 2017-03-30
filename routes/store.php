<?php

Route::group(['namespace' => 'Store' , 'prefix' => 'store' ] , function(){

    Route::get('login' , 'LoginController@login');
;
});
