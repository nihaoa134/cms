<?php

namespace App\Http\Controllers\Code;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QrcodeController extends Controller
{
    public function qrshow(){
        return view('Qrcode.Qrcode');
    }
    public function qredis(Request $request){
        $token = $request->token;
        $uid = $request->uid;

        $redis = new \Redis();
        $redis->connect("127.0.0.1",6379);
        $redis->set($token,$uid);
    }
}
