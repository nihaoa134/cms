<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class send{
		public function show($tel,$num){
			 
        $content = "您的验证码是：【{$num}】。请不要把验证码泄露给其他人。如非本人操作，可不用理会！";//
        $ch = curl_init();//初始化
       $arr= config('app.send');
      //print_r($arr);
       $str="{$arr['url']}?account={$arr['username']}&password={$arr['pwd']}&mobile={$tel}&content={$content}";
       curl_setopt($ch,CURLOPT_URL, $str);
       curl_setopt($ch, CURLOPT_HEADER, false);
      	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $info = curl_exec($ch);
        //   var_dump($info);
        
        return $info;
        
        }
          
    }
?>