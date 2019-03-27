<?php
namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    public function wtest(){
        $str = md5(time());
        $orderid = date('YmdHis',rand(1000000,300000000));
        $orderid = $orderid.rand(10000,30000);
        $key = '7c4a8d09ca3762af61e59520943AB26Q';
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $ip = $_SERVER['REMOTE_ADDR'];
        $info = array(
            'appid' => 'wxd5af665b240b75d4',
            'mch_id' => '1500086022',
            'nonce_str' => $str,
            'sign_type' => 'MD5',
            'body' => '席宏刚一条腿',
            'out_trade_no' => $orderid,                       //本地订单号
            'total_fee' => '1',                               //用户要支付的总金额
            'spbill_create_ip' => $ip,
            'notify_url' => 'http://pp.lixiaonitongxue.top/index',
            'trade_type' => 'NATIVE',
        );
        ksort($info);
        $strpay = urldecode(http_build_query($info));
        $strpay.="&key=$key";
        $endstr = md5($strpay);
        $info['sign'] = $endstr;

        $obj =new \url;
        $arr2 = $obj->arr2Xml($info);
//        echo $arr2;
        $bol=$obj->sendPost($url,$arr2);
        $data = simplexml_load_string($bol);
        $code = $data->code_url;
        //echo $code;die;
//        print_r($code);die;
        return view('weixin.wxpay',['code'=>$code]);
    }

}