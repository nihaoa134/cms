<?php
namespace App\Http\Controllers\Label;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class labelController extends Controller
{

    public function label()
    {
        return view('label.labeladd');

    }

    public function labeladd(Request $request)
    {
        $obj = new \url();        //新建缓存
        $key = "accesstoken";
        $accessToken = cache($key);
        if (!empty($accessToken)) {
            $accessToken = cache($key);
        } else {
            $this->accesstoken();
        }
        $name = $request->input('name');
        $data = DB::table('name')->insert(['name' => $name, 'time' => time()]);
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token=' . $accessToken;
        $arr = array("tag" => array("name" => "$name"));
        $arrjson = json_encode($arr, JSON_UNESCAPED_UNICODE);
        $val = $obj->sendPost($url, $arrjson);
        //print_r($val);
        //exit();
        return view('label.labeladd');
    }


    public function labellist()
    {
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        if (!empty($accessToken)) {
            $accessToken = cache($key);
        } else {
            $this->accesstoken();
        }
        $url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=$accessToken";
        $val = $obj->sendGet($url);
        $data = json_decode($val, true);

//        print_r($data);
//        exit();
        return view('label.labellist', ['data' => $data]);
    }

    public function labeldel(Request $request)
    {
        $obj = new \url();
        $key = "accesstoken";
        $accessToken = cache($key);
        if (!empty($accessToken)) {
            $accessToken = cache($key);
        } else {
            $this->accesstoken();
        }
        $id = $request->input('id');
        $url = "https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=$accessToken";
        $arr = array("tag" => array("id" => "$id"));
        $arrjson = json_encode($arr, true);
        $val = $obj->sendPost($url, $arrjson);
        print_r($val);
        return redirect('labellist');
    }


}
