<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    //用户列表
    public function usershow()
    {
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        //dump($accessToken);exit;
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$accessToken&next_openid=";
        $bol = $obj->sendGet($url);
        $arr = json_decode($bol, true);
        $arrOpenId = $arr['data']['openid'];
        // print_r($arrOpenId);
        foreach ($arrOpenId as $k => $v) {
            $url2 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$v&lang=";
            $bol2[$k] = $obj->sendGet($url2);
            $arr2[$k] = json_decode($bol2[$k], true);
        }
        // print_r($arr2);exit;
        return view("user.user", ['data' => $arr2]);
    }

    //黑名单列表
    public function blakeshow(Request $request)
    {
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        $aid = $request->input('id');
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=$accessToken";
        $arr = array(
            "openid_list" => array("$aid")
        );
        $arrjson = json_encode($arr, true);
        $bol = $obj->sendPost($url, $arrjson);
        var_dump($bol);
        exit;
        $url2 = "https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=$accessToken";
        $arr2 = array(
            "begin_openid" => array("$aid")
        );
        $arrjson2 = json_encode($arr2, true);
        // print_r($arrjson2);
        $bol2 = $obj->sendPost($url2, $arrjson2);
        // var_dump($bol2);
        $arrinfo = json_decode($bol2, true);
        // print_r($arrinfo);
        $arrOpenId = $arrinfo['data']['openid'];
        foreach ($arrOpenId as $k => $v) {
            $url3 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$v&lang=";
            $bol3[$k] = $obj->sendGet($url3);
        }
    }

}