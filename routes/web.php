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

Route::get('/', function () {
    return view('welcome');
});

Route::any("/teas","Ce\TeasController@token");
Route::any("/teas1","Ce\TeasController@token1");
Route::any("/teas2","Ce\TeasController@token2");
Route::any("/www","Ce\TeasController@www");

//登录
Route::get("/login","User\LoginController@login");
Route::post("/logindo","User\LoginController@logindo");

//注册
Route::get("/register","User\RegisterController@register");
Route::post("/registerdo","User\RegisterController@registerdo");

//个人中心
Route::get("/userCenter","User\LoginController@userCenter");

//哈希
Route::get("/hash","Ce\TeasController@hash");
Route::get("/hash2","Ce\TeasController@hash2");