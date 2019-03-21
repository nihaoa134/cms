<?php
namespace App\Http\Controllers\Mass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MassController extends Controller
{
    public function idMass(Request $request){
        $key = "accesstoken";
        $accessToken = cache($key);
        $openid = $request->input('openid');

        $content = $request->input('content');
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$accessToken";
        $data = array(
            'touser'=>array(
                $openid,
            ),
            'text'=>array(
                'content' => $content,
            ),
            'msgtype' => 'text'
        );
        $arr = json_encode($data, true);
//        print_r($arr);exit;

        //exit;
        $obj = new \url();
        $val = $obj->sendPost($url, $arr);
        print_r($val);
    }

    /**标签群发展示*/
    public function labeldo(){
        $objurl = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$accessToken";
        $info = $objurl->sendGet($url);
        $arrInfo = json_decode($info,true);
        $data = $arrInfo['data'];
        $openid = $data['openid'];
        foreach($openid as $k=>$v){
            $userUrl="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$v&lang=zh_CN";
            $userAccessInfo=$objurl->sendGet($userUrl);
            $userInfo=json_decode($userAccessInfo,true);
            $datainfos[]=$userInfo;
        }

        $url2="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=$accessToken";
        $info2=$objurl->sendGet($url2);
        $arr2=json_decode($info2,true);

        $arr = [];
        foreach ($arr2 as $key => $value) {
            $arr = $value;
        }
        return view('mass.blamass',['data'=>$arr]);
    }
    public function labMass(){
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=$accessToken";
        $data = array(
            'filter'=>array(
                'is_to_all-bKRc' => true,
            ),
            'text'=>array(
                'content' => '22222',
            ),
            'msgtype' => 'text'
        );
        $arr = json_encode($data, true);
//        print_r($arr);exit;

        //exit;
        $obj = new \url();
        $val = $obj->sendPost($url, $arr);
        print_r($val);
    }


    public function LookMass(){
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token=$accessToken";
        $data = array(
            'msg_id' => '3147483659',
        );
        $arr = json_encode($data, true);
        $obj = new \url();
        $val = $obj->sendPost($url, $arr);
        print_r($val);
    }
    public function  temp(){
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$accessToken";
        $arr = array(
            "touser" => "oFyS41A5S3cOUMK_uySYrXf3Tma4",
           "template_id" => "wsaupxxhD4GUvGXEaLL_HZafWtelphNKjr0fpwpnGc8",
           "url" => "http://weixin.qq.com",
            "miniprogram" => array(
                "pagepath" => "index?foo=bar"
            ),
            "data" => array(
                "info" => array(
                    "value" => "1",
                    "color" => "#173177",
                ),
                "name" => array(
                    "value" => "2",
                    "color" => "#173177",
                ),
                "age" => array(
                    "value" => "3",
                    "color" => "#173177",
                ),
            )
        );
        $data = json_encode($arr, true);
        //print_r($data);exit;
        $obj = new \url();
        $val = $obj->sendPost($url, $data);
        //print_r($val);
    }
    //获取用户信息
    public function user()
    {
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        //dump($accessToken);exit;
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$accessToken&next_openid=";
        $bol = $obj->sendGet($url);
        $arr = json_decode($bol, true);
        $arrOpenId = $arr['data']['openid'];
//         print_r($arrOpenId);exit;
        $data = $this->usermsg($arrOpenId);
        //dump($data);exit;
        return view("mass.idmass")->with(['data'=>$data]);

    }
    public function usermsg($arrOpenId){
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=$accessToken";
        $userinfo = array();
        $data = array();
        foreach($arrOpenId as $v){
            $arrTmp = array();
            $arrTmp['openid'] = $v;
            $arrTmp['lang'] = "Zh_CN";
            array_push($data,$arrTmp);
        }
        $userinfo['user_list'] = $data;
        $json = json_encode($userinfo,true);
        $val = $obj ->sendPost($url,$json);
        $data1 = json_decode($val,true);
        //print_r($val);
        return $data1['user_info_list'];
    }

    /**获取模板列表*/
    public function tpl(){
        $access = $this->accessTokendo();
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=$access";
        $objurl = new \curl();
        $info = $objurl->sendGet($url);
        $arr=json_decode($info,true);
        //print_r($arr);exit;
        $data = $arr['template_list'];
        return view('tpllist',['data'=>$data]);
    }
    /**模板一次展示*/
    public function mobanlistasd(){
        $objurl = new \curl();
        $accessTonken = $this->accessTokendo();
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=$accessTonken";

        $bol = $objurl->sendGet($url);
        $strjson = json_decode($bol,true);
        $data = $strjson['template_list'];
        //print_r($data);exit;
        return view('tpllist',['data'=>$data]);
    }
    /**模板二次展示*/
    public function biaoqianlistdo(Request $request){
        $template_id = $request->input('template_id');
        $objurl = new \curl();
        $access = $this->accessTokendo();
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access";
        $info = $objurl->sendGet($url);
        $arrInfo = json_decode($info,true);
        $data = $arrInfo['data'];
        $openid = $data['openid'];
        foreach($openid as $k=>$v){
            $userUrl="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access&openid=$v&lang=zh_CN";
            $userAccessInfo=$objurl->sendGet($userUrl);
            $userInfo=json_decode($userAccessInfo,true);
            $datainfos[]=$userInfo;
        }
        $arrss['template_id']=$template_id;
//        print_r($arr);exit;
        $url2="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=$access";
        $info2=$objurl->sendGet($url2);
        $arr2=json_decode($info2,true);

        $arr = [];
        foreach ($arr2 as $key => $value) {
            $arr = $value;
        }

        return view('tpllist1',['data'=>$datainfos],['arrss'=>$arrss]);
    }
    /**发送模板消息*/
    public function mobando(Request $request){
        $_select = $request->input('_select');
        $biaoti = $request->input('biaoti');
        $mingzi = $request->input('mingzi');
        $neirong = $request->input('neirong');
        $asdasd = $request->input('asdasd');
        $accessTonken = $this->accessTokendo();
        $objurl = new \curl();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$accessTonken";
        $arr = array(
            'touser'=>$_select,
            'template_id'=>$asdasd,
            'data'=>array(
                'info'=>array(
                    'value'=>$biaoti,
                ),
                'name'=>array(
                    'value'=>$mingzi,
                ),
                'age'=>array(
                    'value'=>$neirong,
                ),
            ),
        );
        $strjson = json_encode($arr,JSON_UNESCAPED_UNICODE);
        $bol = $objurl->sendPost($url,$strjson);
        $strjsonss = json_decode($bol,JSON_UNESCAPED_UNICODE);
        $datado = array(
            'content'=>$biaoti,
            'type'=>"模板",
            'status'=>$strjsonss['errmsg'],
            'createtime'=>time()
        );
        $this->cachedo($datado);
//        var_dump($bol);
        return $bol;
    }
}