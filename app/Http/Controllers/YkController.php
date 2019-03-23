<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\models\Register;
class   YkController extends Controller{
    public function yuekao(Request $request){
        return view('a');
    }
    public function denglu(Request $request){
        //登录
        //连接远程
        $memcache_obj=new \memcache();
        $memcache_bool=$memcache_obj->connect('127.0.0.1',11211);
        $time=time()+600;
        //电话
        $tel=$request->input('tel');
        //密码
        $pwd1=$request->input('pwd');
        $pwd=md5($pwd1);
        $key="tel_$tel";
        $arr=$memcache_obj->get($key);
        if($arr){
            echo 1;
            // print_r($arr);
            if($tel==$arr[0]->tel&&$pwd==$arr[0]->pwd){
                return ['code'=>1]; 
                }else{
                    return ['code'=>0];
                }
        }else{
            echo 2;
                $data=DB::table('register')->where("tel",$tel)->get();
                // print_r($data);
                if(count($data)==0){
                    return ['code'=>0];
                }else{
                    if($tel==$data[0]->tel&&$pwd==$data[0]->pwd){
                $info=$memcache_obj->set($key,$data,MEMCACHE_COMPRESSED,$time); 
                return ['code'=>1]; 
                }else{
                     return ['code'=>0];
                }
                }
                
        }
    }
    public function reupd(){
            return view('c');
    }
    public function nreupd(Request $request){
        //修改
        //连接远程
        $memcache_obj=new \memcache();
        $memcache_bool=$memcache_obj->connect('127.0.0.1',11211);
        $time=time()+600;
        $tel=$request->input('tel');
        //密码
        $pwd1=$request->input('pwd');
        $pwd=md5($pwd1);
        $pwd2=$request->input('npwd');
        $npwd=md5($pwd2);
        $key="tel_$tel";
        $data=DB::table('register')->where('tel',$tel)->where('pwd',$pwd)->first();
        if($data){
            DB::table('register')->where('tel',$tel)->where('pwd',$pwd)->update(['pwd'=>$npwd]);
            $data=DB::table('register')->where("tel",$tel)->get();
            // print_r($data);
            $info=$memcache_obj->set($key,$data,MEMCACHE_COMPRESSED,$time); 
            return ['code'=>1];
        }else{
            return ['code'=>0];
        }
    }
    public function delhc(){
        //清除缓存
        //连接远程
        $memcache_obj=new \memcache();
        $memcache_bool=$memcache_obj->connect('127.0.0.1',11211);
        $memcache_obj->flush();
        return ['code'=>1];
    }
}