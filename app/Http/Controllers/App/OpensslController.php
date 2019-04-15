<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OpensslController extends Controller
{

    public function private1(Request $request)
    {
        $content=$request->input('key');
        $openssl = DB::table('openssl')->where('id','1')->first();
        $private_key =  $openssl->private;

        $encryptData="";//秘钥字符串
        openssl_private_encrypt($content,$encryptData,$private_key);
        $mima = base64_encode($encryptData);

        $this->public1($mima);
        echo '<br/>';
        echo $mima;
    }
    public function  public1($mima){
        $openssl = DB::table('openssl')->where('id','1')->first();
        $pblic_key = $openssl->public;
        $data = base64_decode($mima);
        $go ='';
        openssl_public_decrypt($data,$go,$pblic_key);
        echo $go;
    }
}
