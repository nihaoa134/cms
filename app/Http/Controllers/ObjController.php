<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\models\Register;
class   ObjController extends Controller{
    public function a(Request $request){
        
//连接远程
$memcache_obj=new \memcache();
$memcache_bool=$memcache_obj->connect('127.0.0.1',11211);
$time=time()+86400;
// //接受搜索的值
// $age=empty($_GET['age'])?'':$_GET['age'];
// $page=empty($_GET['page'])?1:$_GET['page'];
// $key="page_$page"."_$age";
// // print_r($key);
// $arr=$memcache_obj->get($key);
// // print_r($arr);
//     if($arr){
//     echo '缓存';
//     $data=$memcache_obj->get($key);
// }else{
//     echo '数据库';
//     $data=DB::table('teacher')->where('age','like',"%$age%")->paginate(3);
//    $info=$memcache_obj->set($key,$data,MEMCACHE_COMPRESSED,$time);

// }
//   return view('a',['data'=>$data,'age'=>$age]);
  return view('a');

    }
    public function b(Request $request){
                //连接远程
        $memcache_obj=new \memcache();
        $memcache_bool=$memcache_obj->connect('127.0.0.1',11211);
        $time=time()+86400;
        // $memcache_obj->flush();
        //手机号
        $tel=$request->input('tel');
        //密码
        $pwd1=$request->input('pwd');
        $pwd=md5($pwd1);
        $key="tel_$tel";
        // print_r($key);
        $arr=$memcache_obj->get($key);
        // print_r($arr);
        if($arr){
            // echo 1;
            if($tel==$arr[0]->tel&&$pwd==$arr[0]->pwd){
                return ['code'=>1]; 
                }else{
                    return ['code'=>0];
                }
        }else{
            // echo 2;
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
        $memcache_obj=new \memcache();
        $memcache_bool=$memcache_obj->connect('127.0.0.1',11211);
        $time=time()+86400;

        $tel=$request->input('tel');
        //密码
        $pwd1=$request->input('pwd');
        $npwd=md5($pwd1);
        $npw=$request->input('npwd');
        $pwd=md5($npw);
        $key="tel_$tel";
        $data=DB::table('register')->where('tel',$tel)->where('pwd',$npwd)->first();
        if($data){
           DB::table('register')->where('tel',$tel)->update(['pwd'=>$pwd]);
           $data=DB::table('register')->where("tel",$tel)->get();
           $memcache_obj->set($key,$data,MEMCACHE_COMPRESSED,$time); 
            return ['code'=>1];
        }else{
            return ['code'=>0];
        }
    }
    public function del(){
             $memcache_obj=new \memcache();
            $memcache_bool=$memcache_obj->connect('127.0.0.1',11211);
            $memcache_obj->flush();
            return json_encode(['code'=>1,'msg'=>'success']);
           
    }
}