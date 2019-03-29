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
    //客户聊天页面
    public function kefu(Request $request){
        $name = $request->input('name');
        $openid = $request->input('id');
        return view("user.kefu",['name' => $name,'openid' => $openid]);
    }
    //客服聊天
    public function  kefu1(Request $request){
        $arr=$_POST;
        $data = $arr['data'];
        $openid = $arr['id'];
//        echo $openid;die;
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$accessToken";
        $arr = array(
            "touser" => "$openid",
            "msgtype" => "text",
            "text" =>array(
                "content" => "$data",
            )
        );
        $arrjson = json_encode($arr, true);
        $bol = $obj->sendPost($url, $arrjson);
        //return $bol;die;
        $redis = new \redis;
        $redis->connect("127.0.0.1",6379);//exit;
        $id = $redis->incr('id');
        $hest = "id_{$id}";
        $like = "kefu1";
        $redis->hset($hest,"id","$id");
        $redis->hset($hest,"openid","$openid");
        $redis->hset($hest,"date","$data");
        $redis->rPush($like,$hest);
    }
    //取聊天记录
    public function kefu2(Request $request){
        $start=$request->input('start');
        $redis = new \redis;
        $redis->connect("127.0.0.1",6379);//exit;
        $like="kefu1";
        $data = $redis->lrange($like,$start,-1);
        $res =array();
        foreach($data as $k => $v){
            $arr = $redis -> hGetAll($v);
            array_push($res,$arr);
        }
        return $res;
//        print_r($res);
    }
    public function  kefu3(){
        $str=file_get_contents("php://input");
        file_put_contents("/wx_event.log",$str,FILE_APPEND);
        $obj=simplexml_load_string($str);
/*        $redis = new \redis;
        $redis->connect("127.0.0.1",6379);//exit;
        $id = $redis->incr('id');
        $hest = "id_{$id}";
        $like = "kefu2";
        $redis->hset($hest,"id","$id");
        $redis->hset($hest,"openid","$openid");
        $redis->hset($hest,"date","$data");
        $redis->rPush($like,$hest);*/
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