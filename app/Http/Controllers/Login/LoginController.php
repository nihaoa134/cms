<?php

namespace App\Http\Controllers\ogin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function reg(Request $request)
    {
        $data = [
            'name'  => $request->input('name'),
            'pwd'  => $pwd,
            'email'  => $request->input('email'),
            'reg_time'  => time(),
        ];

        $uid = DB::table();
        if($uid){
            setcookie('uid',$uid,time()+86400,'/','www.shop.com',false,true);
            echo('注册成功');
            header("Refresh:3;url=/login");

        }else{
            echo '注册失败';
        }
    }
}
