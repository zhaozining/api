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

//测Http明文加密
Route::get("/enc","Ce\EncController@enc");//对称
Route::any("/prienc","Ce\EncController@prienc");//非对称
Route::any("/signature","Ce\EncController@signature");//签名
Route::any("/privsign","Ce\EncController@privsign");//非对称签名


//登录
Route::get("/login","User\LoginController@login");
Route::post("/logindo","User\LoginController@logindo");

//注册
Route::get("/register","User\RegisterController@register");
Route::post("/registerdo","User\RegisterController@registerdo");

//个人中心
Route::get("/userCenter","User\LoginController@userCenter")->middleware("viewcount","token","usercount");

//商品
Route::get("/goodsList","Goods\GoodsController@goodsList")->middleware("viewcount","token","usercount");
//哈希
Route::get("/hash","Ce\TeasController@hash")->middleware("viewcount");
Route::get("/hash2","Ce\TeasController@hash2");

//。。。H5。。。
Route::post("/h5/logindo","H5User\UserController@logindo");//登录
Route::post("/h5/register","H5User\UserController@register");//注册
Route::post("/h5/conter","H5User\UserController@conter");//个人中心
//列表
Route::any("/h5/lists","Goods\GoodsController@lists");
//详情
Route::get("/h5/details","Goods\GoodsController@details");
//购物车
Route::get("/h5/cart","Goods\GoodsController@cart");



