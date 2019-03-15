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
Route::get('user', 'User@text');


Route::get('weixin','Weixin\WxController@index');
Route::get('weixin/token','Weixin\WxController@accessToken'); //存入accessToken

Route::get('weixin/menu','Weixin\WxController@menu'); //创建菜单

Route::get('label','Label\labelController@label'); //添加标签页面
Route::post('labeladd','Label\labelController@labeladd'); //添加标签
Route::any('labeldel','Label\labelController@labeldel'); //删除标签
Route::any('labellist','Label\labelController@labellist'); //展示标签
Route::any('shuaxin','Weixin\WxController@shuaxin'); //刷新accesstoken

Route::any('user','User\UserController@usershow'); //用户展示
Route::get('blake','User\UserController@blakeshow'); //拉黑用户blackshow