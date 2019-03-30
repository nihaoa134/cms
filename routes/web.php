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
Route::any('valid1','Weixin\WxController@valid1');
Route::get('weixin/token','Weixin\WxController@accessToken'); //存入accessToken
Route::get('weixin/shuaxin','Weixin\WxController@shuaxin'); //存入accessToken

Route::get('menu','Weixin\WxController@menu'); //创建菜单
Route::any('domenu','Weixin\WxController@domenu'); //创建菜单
Route::any('jieshou','Weixin\WxController@jieshou'); //接收事件


Route::get('label','Label\labelController@label'); //添加标签页面
Route::post('labeladd','Label\labelController@labeladd'); //添加标签
Route::any('labeldel','Label\labelController@labeldel'); //删除标签
Route::any('labellist','Label\labelController@labellist'); //展示标签
Route::any('shuaxin','Weixin\WxController@shuaxin'); //刷新accesstoken

Route::any('user','User\UserController@usershow'); //用户展示
Route::get('blake','User\UserController@blakeshow'); //拉黑用户blackshow

Route::any('addmatter','Matter\MatterController@addMatter'); //添加素材页面
Route::any('matter','Matter\MatterController@Matter'); //添加临时素材
Route::any('getmatter','Matter\MatterController@getMatter'); //获取临时素材
Route::any('upload','Matter\MatterController@upload'); //上传素材到redis

Route::any('show','Matter\MatterController@showupload'); //素材展示

Route::any('','Mass\MassController@idMass'); //id群发
Route::any('labMass','Mass\MassController@labMass'); //标签群发
Route::any('temp','Mass\MassController@temp'); //群发模板
Route::any('users','Mass\MassController@user'); //获取用户列表
Route::any('usermsg','Mass\MassController@usermsg'); //获取用户列表
Route::any('labeldo','Mass\MassController@labeldo'); //获取用户列表


Route::any('lookmass','Mass\MassController@LookMass'); //群发状态

Route::any('123','Weixin\WxController@tanchi'); //tanchi

Route::any('wxlogin','Weixin\WxController@wxlogin'); //微信登陆获取code
Route::any('wxlogincode','Weixin\WxController@wxlogincode'); //处理code
Route::any('123','Weixin\WxController@tanchi'); //tanchi


Route::any('task','Task\TaskController@Tlike');//任务展示
Route::any('task1','Task\TaskController@Tlike1');//任务展示


Route::any('showlogin','Weixin\WxController@showlogin'); //登录展示
Route::any('codeshow','Weixin\WxController@codeshow'); //登录展示
Route::any('QRcode','Weixin\WxController@QRcode'); //二维码

Route::any('wtest','Weixin\PayController@wtest'); //二维码支付
Route::any('wxstatus','Weixin\PayController@wxstatus'); //微信验签

Route::any('orderlist','order\OrderlistController@orderlist'); //支付展示

Route::any('kefu','User\UserController@kefu'); //客服聊天界面
Route::any('kefu1','User\UserController@kefu1'); //客服聊天
Route::any('kefu2','User\UserController@kefu2'); //取客服记录
