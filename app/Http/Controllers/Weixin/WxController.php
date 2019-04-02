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
    /**
     *首次接入
     */
    public function valid1()
    {
        //echo $_GET['echostr'];
        $data = file_get_contents("php://input");
//        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        $objxml = simplexml_load_string($data);
        file_put_contents('logs/wx_event.log',$data,FILE_APPEND);
        $openid = $objxml->FromUserName;
        $time = $objxml->CreateTime;
        $info = DB::table('wxuser')->where(['openid'=>$openid])->first();
        if(empty($info)){
            DB::table('wxuser')->insert(['name'=>$openid,'time'=>$time]);
            $xml = '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName><FromUserName><![CDATA['.$openid.']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[欢迎关注'.$openid.'公众号]]></Content></xml>';
            echo $xml;
        }


/*       $content=$objxml->Content;
        $redis = new \redis;
        $redis->connect("127.0.0.1",6379);//exit;
        $id = $redis->incr('id');
        $hest = "id_{$id}";
        $like = "ziji";
        $redis->hset($hest,"id","$id");
        $redis->hset($hest,"openid","$openid");
        $redis->hset($hest,"date","$content");
        $redis->rPush($like,$hest);*/

    }
    //取聊天记录
    public function kefu3(Request $request){
        $start=$request->input('start');
        $redis = new \redis;
        $redis->connect("127.0.0.1",6379);//exit;
        $like="ziji";
        $data = $redis->lrange($like,$start,-1);
        $res =array();
        foreach($data as $k => $v){
            $arr = $redis -> hGetAll($v);
            array_push($res,$arr);
        }
        return $res;
    }
/*    //接收事件
    public function jieshou(){
        $data = file_get_contents("php://input");

        //解析XML
        $xml = simplexml_load_string($data);        //将 xml字符串 转换成对象
        $openid = $xml->FromUserName;               //用户openid
        $event = $xml->Event;                       //事件类型

        // 处理用户发送消息
        if(isset($xml->MsgType)){
            if($xml->MsgType=='text'){            //用户发送文本消息
                $msg = $xml->Content;
                $xml_response = '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName><FromUserName><![CDATA['.$xml->ToUserName.']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['. $msg. date('Y-m-d H:i:s') .']]></Content></xml>';
                echo $xml_response;
            }elseif($xml->MsgType=='image'){       //用户发送图片信息
                //视业务需求是否需要下载保存图片
                if(1){  //下载图片素材
                    $this->dlWxImg($xml->MediaId);
                    $xml_response = '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName><FromUserName><![CDATA['.$xml->ToUserName.']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.'图片保存成功' . ' >>> ' . date('Y-m-d H:i:s') .']]></Content></xml>';
                    echo $xml_response;
                }
            }elseif($xml->MsgType=='voice'){        //处理语音信息
                $this->dlVoice($xml->MediaId);
                $xml_response = '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName><FromUserName><![CDATA['.$xml->ToUserName.']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.'语音保存成功' . ' >>> ' . date('Y-m-d H:i:s') .']]></Content></xml>';
                echo $xml_response;
            }elseif($xml->MsgType=='video'){        //处理视频信息
                $this->dlVideo($xml->MediaId);
                $xml_response = '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName><FromUserName><![CDATA['.$xml->ToUserName.']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.'视频保存成功' . ' >>> ' . date('Y-m-d H:i:s') .']]></Content></xml>';
                echo $xml_response;
            }

            exit();
        }
    }*/
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

    /*刷新accesstoken*/
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
        $urlstart = urlencode("http://node.lixiaonitongxue.top/wxlogincode");
        $appid = "wx0ed775ffa80afa46";
        $scope = "snsapi_userinfo";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$urlstart&response_type=code&scope=$scope&state=STATE#wechat_redirect";
        echo "<a href=".$url.">微信登陆</a>";
	}
    public function  wxlogincode(Request $request){
        //print_r($_GET);
        $appid = "wx0ed775ffa80afa46";
        $appsecret= "6a5574a26d9bc3db5a3df198f16d855d";
        $code = $request->input('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $token_json = file_get_contents($url);
        $token_arr = json_decode($token_json,true);
        //print_r($token_arr);
        $openid = $token_arr['openid'];
        $redis = new \redis;
        $redis->connect("127.0.0.1",6379);//exit;
        $like="openid";
        $redis->rpush($like,$openid);
        $data = $redis->lrange($like,0,-1);
        //print_r($data);
     }
     //登陆展示
	 public function showlogin(){
		 $redis = new \redis;
        $redis->connect("127.0.0.1",6379);//exit;
        $like="wxlogin";
        $data = $redis->lrange($like,0,-1);
         $res =array();
         foreach($data as $k => $v){
             $arr = $redis -> hGetAll($v);
             array_push($res,$arr);
         }
         return view('weixin.showlogin', ['res' => $res]);
	 }
	 //生成二维码
    public function QRcode(){
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$accessToken";
        $arr = array(
          "expire_seconds" => 604800,
            "action_name" => "QR_SCENE",
            "action_info" => array(
                "scene" =>array(
                    "scene_id" => 3,
                )
            )
        );
        $jsoninfo = json_encode($arr,true);
        $obj = new \url();
        $r = $obj->sendPost($url,$jsoninfo);
        $data = json_decode($r,true);
        $ticket = $data['ticket'];
        //print_r($ticket);
        $url2 = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
        $res = $obj->sendGet($url2);
        file_put_contents("./3.jpg",$res);
        //print_r($res);

    }
    //登陆扫码
    public function codeshow()
    {
        $redis = new \redis;
        $redis->connect("127.0.0.1", 6379);//exit;
        $like = "listkey";
        $data = $redis->lrange($like, 0, -1);
        $res = array();
        foreach ($data as $k => $v) {
            $arr = $redis->hGetAll($v);
            array_push($res, $arr);
        }
        return view('weixin.codeshow', ['res' => $res]);
    }
    //扫码关注
    public function scanQR(){
        return view('weixin.attention');
    }


}