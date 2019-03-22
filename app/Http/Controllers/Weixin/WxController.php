<?php
namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class WxController extends Controller
{
    public function index(){
        return view('index');
    }

    /*获取accesstoken值*/
    public function accessToken(){
        $obj = new \url();
        $appid = "wx0ed775ffa80afa46";
        $appsecret = "6a5574a26d9bc3db5a3df198f16d855d";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        /*echo  $url;
        exit;*/
        $access = $obj -> sendGet($url);
        $arr = json_decode($access,true);
        $accesstoken = $arr['access_token'];
        $key = "accesstoken";
        //cache::flush();
        $time = $arr['expires_in']/60;
        cache([$key=>$accesstoken],$time);
       $accessToken = cache($key);
        echo $accessToken;
    }

    /*获取accesstoken*/
    public function shuaxin()
    {
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=$accessToken";
        $arr = array("appid" => "wx0ed775ffa80afa46");
        $arrjson = json_encode($arr, JSON_UNESCAPED_UNICODE);
        $val = $obj->sendPost($url, $arrjson);
        echo $val;
    }


    /*创建菜单*/
    public function menu(){
        /*
        $key = "accesstoken";
        $accessToken = cache($key);
//        echo $accessToken;exit;
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$accessToken";
        //echo $url;
        //exit;
        $arr = array(
            'button' => array(
                    array(
                            "name" => "发送位置",
                            "type" => "location_select",
                            "key" =>"rselfmenu_2_0",
                    ),

                    array(
                        "name" => "搜索",
                        "sub_button"=>array(
                            array(
                                "name" => "搜狗",
                                 "type" => "view",
                                 "url" =>"http://www.soso.com/",
                            ),
                            array(
                                "name" => "百度",
                                "type" => "view",
                                "url" =>"http://www.baidu.com/",
                            ),

                        )

                    ),


            )
        );
        $strJson = json_encode($arr,JSON_UNESCAPED_UNICODE);
        $objurl = new \url();
        $bol =$objurl->sendPost($url,$strJson);
        var_dump($bol);*/
        return view("menu.menu");
    }




    /**
     * 发布自定义菜单
     */
    public function domenu(Request $request)
    {
        $data = $request->input();
//        print_r($data);die;
        $count=count($data['name']);
        $arr=array();
        for($i=0;$i<$count;$i++){
            if(($data['type'][$i]=="click")){
                $arr[$i]['type']=$data['type'][$i];
                $arr[$i]['name']=$data['name'][$i];
                $arr[$i]['key']=$data['key'][$i];
            }else{
                $arr[$i]['type']=$data['type'][$i];
                $arr[$i]['name']=$data['name'][$i];
                $arr[$i]['url']=$data['key'][$i];
            }

        }
        //print_r($arr);exit;
        $info = [
            'button'    =>  $arr
        ];
        //print_r($info);exit;
        $jsoninfo=json_encode($info,true);
        //print_r($jsoninfo);exit;
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$accessToken";
        $r = $obj->sendPost($url,$jsoninfo); 
        print_r($r);exit;
        $respone = json_decode($r->getBody(),true);
        print_r($respone);
    }

    public function  tanchi(){
        return view("menu.123");
    }
	public function wxlogin(){
        $url = urlencode("node.lixiaonitongxue.top/wxlogincode");
        $wxurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx0ed775ffa80afa46&redirect_uri=$url&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        echo "<a href=".$wxurl.">微信登陆</a>";
	}
    public function  wxlogincode(Request $request){
        print_r($_GET);
    }
}