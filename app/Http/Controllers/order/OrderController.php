<?php

namespace App\Http\Controllers\order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Test;
class OrderController extends Controller
{
    public function index(Request $request){
    return view('order.order');
//       $id=$request->input('id');
//        $name=$request->input('name');
// //
//      echo $id;
//         echo $name;
//         $url=url('msg');
//         echo $url;
        //return redirect('msg');
//       return view('order.order');
//        if($id <2){
//          return redirect('https://www.baidu.com');
//        }else{
//            return redirect('http://www.4399.com/');
//        }
    }
    public function msg(Request $request){
        // $name=$request->input('name');
        // print_r($name);
        // $sql="insert into lianxi (name,age) values ('anyupeng','18')";
        // $bol=DB::insert($sql);
        $sql="select * from lianxi";
        $bol =DB::select($sql);
        print_r($bol) ;
    }
    public function some(Request $request){
      $data=$request->input();
      //print_r($data);
    //   $name=$data['name'];
    //   $fenlei=$data['fenlei'];
    //   $miaoshu=$data['miaoshu'];
    //   $rexiao=$data['rexiao'];
    //   $shangjia=$data['shangjia'];
    //   $sql="insert into lianxi (name,fenlei,miaoshu,rexiao,shangjia) values ('$name','$fenlei','$miaoshu','$rexiao','$shangjia')";
      //print_r($sql);die; 
      $bol=Test::insert($data);
      return ['code'=>1,'msg'=>'添加成功'];
    }
    public function show(){
     // echo 111;
    //  $sql="select * from lianxi";
    //     $bol =DB::select($sql);
    //     //print_r($bol) ;
    $bol=Test::paginate(1);
     return view('order.show')->with(['bol'=>$bol]);
    }
    public function dele(Request $request){
      $id=$request->input('id');
      //$sql="delete from lianxi where id=$id";
      $bol=Test::destroy($id);;
      return ['code'=>1,'msg'=>'删除成功'];
    }
    public function updat(Request $request){
      $id=$request->input('id');
      
      $na=$request->input('na');
      $sql="update lianxi set rexiao=$na where id=$id";
      $bol=DB::update($sql);
    }
    public function updatedata(Request $request){
        //dump($id);
        $id=$request->input('id');
         $data= Test::where('id', $id)->get();
         $info = array();
         foreach($data as $key => $value){
             $info['id']=$value->id;
             $info['name']=$value->name;
             $info['fenlei']=$value->fenlei;
             $info['miaoshu']=$value->miaoshu;
             $info['rexiao']=$value->rexiao;
             $info['shangjia']=$value->shangjia;
         }
        //  var_dump($info);
        //  exit;
        return view('order.updatedata',['data'=>$info]);
    }
    public function update2(Request $request){
        $arrInfo = $request->input();
        $id=$request->input('id');

       $res= Test::where('id',$id)->update($arrInfo);
    //    print_r($res);
     return ['code'=>1,'msg'=>'修改成功'];
    }
    public function seach(Request $request){
        $rexiao=$request->input('rexiao');
        $shangjia=$request->input('shangjia');
        if($rexiao=='' && $shangjia==''){
            return 2;
        }
        if($rexiao!='' && $shangjia!=''){
            $info=Test::where('rexiao',$rexiao)->where('shangjia',$shangjia)->paginate(3);
            //print_r($info);die;
            return view('order.show',['bol'=>$info]);
        }
        if($rexiao!=''){
            $info=Test::where('rexiao',$rexiao)->paginate(3);
            return view('order.show',['bol'=>$info]);
        }
        if($shangjia!=''){
            $info=Test::where('shangjia',$shangjia)->paginate(3);
            return view('order.show',['bol'=>$info]);
        }
        
    }
    public function ajaxupd(Request $request){
        $id=$request->input('id');
        $mobile=$request->input('mobile');
        //print_r($mobile);
        $data=Test::where('id',$id)->update(['name'=>$mobile]);
        //print_r($data);
        if($data){
            return 1;
        }
    }
}
