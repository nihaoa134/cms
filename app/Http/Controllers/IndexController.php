<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\models\Register;
use App\models\Car;
class IndexController extends Controller
{
    public function index(Request $request){
        //var_dump($request->session()->get('tel'));
        $data=DB::table('goods')->where('is_tell',1)->get(['goods_name','description','goods_img']);
        $date=DB::table('goods')->where('is_like',1)->paginate(10);
        //var_dump($data);
        return view('index',['data'=>$data,'date'=>$date]);
    }
    public function register(){
        return view('register');
    }
    public function userpage(){
        // $id='';
        // session(['id'=>$id,'name'=>'lisi']);
        return view('userpage');
    }
    public function set(){
        return view('set');
    }
    public function login(){
        return view('login');
    }
    public function zhuce(Request $request){
       $data=$request->input();
       $tel=$data['tel'];
       $code=$data['code'];
       $pwd=$data['pwd'];
       $conpwd=$data['conpwd'];
            //   验证验证码
            //    if(empty($tel)){
            //     $arr=array(
            //         'code'=>0,
            //         'msg'=>"验证码不能为空"
            //     );
            //     return $arr;die;
            //    }
       $time=time();
       $sql="select * from code where tel=$tel and code=$code and timeout>$time and status=1";
       $codeinfo=DB::select($sql);
       if(empty($codeinfo)){
        $arr=array(
            'code'=>0,
            'msg'=>"验证码错误"
        );
         return $arr;die;
        }
        if(empty($tel)){
        $arr=array(
            'code'=>0,
            'msg'=>"用户不能为空"
        );
        return $arr;die;
        }
       
        if($pwd!=$conpwd){
           $arr=array(
               'code'=>0,
               'msg'=>"密码不一致"
            );
       return $arr;die;
       } 
       $res=Register::where('tel',$tel)->first();
       if($res){
        $arr=array(
            'code'=>0,
            'msg'=>"用户已存在"
        );
      return $arr; die;
       }
       $pwd=md5($pwd);
       $arrInfo=array(
           'tel'=>$tel,
           'pwd'=>$pwd
       );
       $date=Register::insert($arrInfo);
       if($date){
           //修改数据库状态
           $sql=DB::table('code')->where('id',$codeinfo[0]->id)->update(['status'=>0]);
           echo $sql;die;
        $arr=array(
            'code'=>1,
            'msg'=>"注册成功"
        );
      return $arr;die;
         }else{
        $arr=array(
            'code'=>0,
            'msg'=>"失败"
        );
      return $arr;die;
       }
    }
    public function denglu(Request $request){
        $data=$request->input();
        $tel=$data['tel'];
        $pwd=$data['pwd'];
        $pwd=md5($pwd);
        $data=[
            'tel'=>$tel,
            'pwd'=>$pwd
        ];
        $info=DB::table('register')->where($data)->first();
        // print_r($info->id);die;
        if($info){
            session(['id'=>$info->id,'tel'=>$info->tel]);
            $arr=array(
                'code'=>1,
                'msg'=>"登录成功"
            );
        return $arr;
        }
        if(empty($tel)){
            $arr=array(
                'code'=>0,
                'msg'=>"手机号不能为空"
            );
        return $arr;
        }
        if(!isset($data['pwd'])){
            //return 213;
            $arr=array(
                'code'=>0,
                'msg'=>"密码不能为空"
            );
        return $arr;
        }
        if($tel!=$info['tel'] &&$pwd!=$info['pwd']){
            $arr=array(
                'code'=>0,
                'msg'=>"账号或密码错误"
            );
        return $arr;
        }
    }
    public function t1(Request $request){
        $tel=$request->input('tel');
        // $code=$request->input('code');
        // $data=[
        //     'tel'=>$tel,
        //     'code'=>$code,
        //     'timeout'=>time()<'timeout'
        // ];
        // $sql=DB::table('code')->where($data)->first();
        
        // print_r($tel);
        // print_r($code);
        $obj =new \send();
        $num = rand(1000,9999);
        $bol=$obj->show($tel,$num);
        if($bol==100){
            $data=[
            'code'=>$num,
            'tel'=>$tel,
            'timeout'=>time()+120,
            'status'=>1
        ];
        $sql=DB::table('code')->insert($data);
        if($sql){
            $arr=array(
                'code'=>1,
                'msg'=>"发送成功"
            );
        return $arr;  
        }
        }else{
            $arr=array(
                'code'=>0,
                'msg'=>"发送失败"
            );
        return $arr; 
        }
    }
    public function t2(){
        return view('jiazai');
    }
    public function allshops(){
        $catedata=DB::table('category')->where('parent_id',0)->get(['cate_id','cate_name']);
        $goodsdata=DB::table('goods')->orderBy('click_count','desc')->get();
        return view('allshops',['data'=>$catedata,'goodsdata'=>$goodsdata]);
    }
    public function newshow(){
        return view('newshow');
    }
    public function shopcart(Request $request){
        //当前登录的用户id
        $uid=session('id');
        $user=$request->session()->get('id');
        if(empty($user)){
            return redirect('login');
        }else{
            $car=Car::all()->toArray();
            $goods_id=array_column($car,'goods_id');
            $data=DB::table('goods')->join('car','goods.goods_id','=','car.goods_id')->where('is_show',1)->where('uid',session('id'))->where('status',1)->get();
            //print_r($data);
            //人气推荐
            $date=DB::table('goods')->where('is_like',1)->paginate(4);
        }
        
        //print_r($date);
        return view('goods.shopcart',['data'=>$data,'date'=>$date]);
    }
    public function addli(Request $request){
        $arr=array();
        $page=$request->input('page');
        $pagenum=4;//每页显示条数
        $offset=($page-1)*$pagenum;//下一页
        $info=DB::table('goods')->where('is_like',1)->offset($offset)->limit($pagenum)->get();//每页的数据
        //print_r($info);die;
        $totaldata=DB::table('goods')->where('is_like',1)->count();
        $pagetotal=ceil($totaldata/$pagenum);//总页数
       //print_r($pagetotal);
        $pageview=view('goods.goods',['info'=>$info]);
        $content=response($pageview)->getContent();
        $arr['info']=$content;
        $arr['page']=$pagetotal;
        return $arr;
    }
    public function selegood(Request $request){
        $arr=array();
        $cate_id=$request->input('id');
        $arrids=DB::table('category')->get();
        //var_dump($arrids);die;
        $arrid=$this->get($arrids,$cate_id);
        $arrid=is_array($arrid)?$arrid :[];
        array_unshift($arrid,$cate_id);
        //$arr_id=implode(',',$arrid);
        // print_r($arr_id);
        if($cate_id==0){
            $data=DB::table('goods')->orderBy('click_count','desc')->get(); 
            $objview=view('goods.goodshow',['info'=>$data]);
            $content=response($objview)->getContent();
            $arr['info']=$content;
            return $arr;   
        }
        $data=DB::table('goods')->whereIn('cat_id',$arrid)->orderBy('click_count','desc')->get();
       // print_r($data);die;
        $objview=view('goods.goodshow',['info'=>$data]);
        $content=response($objview)->getContent();
        $arr['info']=$content;
        return $arr;
    }
    public function get($arrids,$p_id){
        static $data;
        if($arrids){
            foreach($arrids as $k => $v){
                if($v->parent_id ==$p_id){
                    $data[$k] = $v->cate_id;
                    $this ->get($arrids,$v->cate_id);
                }  
            }
        }
        return $data;
    }
    public function xiangqing(Request $request){
        $id=$request->input('goods_id');
        $data=DB::table('goods')->where('goods_id',$id)->get();
        // print_r($data);die
        $car=Car::all()->where('status',1)->toArray();
        $car=array_column($car,'goods_num');
        $num=array_sum($car);
        // print_r($num);
        return view('goods.shopcontent',['data'=>$data,'num'=>$num]);
    }
    public function zhoume(){
        $arr=array(
            array('id'=>1,'name'=>'xuexue','age'=>'20'),
            array('id'=>2,'name'=>'aze','age'=>'50'),
            array('id'=>3,'name'=>'zhaozhao','age'=>'10'),
            array('id'=>4,'name'=>'tian','age'=>'9'),
            array('id'=>5,'name'=>'peng','age'=>'4'),
        );
       $arr1=array();
       foreach($arr as $k=>$v){
           $arr1[$v['age']]=$v;
       }
      // print_r($arr1);
       $arr2=array();
       foreach($arr as $k=>$v){
           $arr2[]=$v['age'];
       }
       sort($arr2);
        // print_r($arr2);
        $arr3=array();
        foreach($arr2 as $v){
            $arr3[]=$arr1[$v];
        }
        print_r($arr3);
    }
    public function car(Request $request){
        $arr=array();
        $goods_id=$request->input('id');
        $user=$request->session()->get('id');
        $uid=session('id');
        $goods_num=1;
        // print_r($uid);exit;
        if($goods_id){
            if(empty($user)){
                $arr=[
                    'code'=>0
                ];
                return $arr;
            }else{
                $goods=DB::table('goods')->where('goods_id',$goods_id)->where('is_on_sale',1)->first();
                if(empty($goods)){
                    $arr=[
                        'code'=>2,
                        'msg'=>"亲该商品还没上架，请重新选择商品"
                    ];
                    return $arr; 
                   }
                //判断库存
                $goods_nums=DB::table('goods')->where('goods_id',$goods_id)->where('goods_number','>=',$goods_num)->first();
            //    print_r($goods_nums) ;exit;
               if(empty($goods_nums)){
                $arr=[
                    'code'=>2,
                    'msg'=>"库存不足"
                ];
                return $arr; 
               }
               
               //查询数据库是否有这条信息
               $car=DB::table('car')->where('goods_id',$goods_id)->where('status',1)->first();
               if($car){
                   $data=[
                    'goods_num'=>$car->goods_num+1,
                   ];
                   DB::table('car')->where('goods_id',$goods_id)->update($data);
                $arr=[
                    'code'=>1,
                    'msg'=>"加入购物车成功"
                ];
                return $arr; 
               }
               
               $date=[
                   'goods_id'=>$goods_id,
                   'uid'=>$uid,
                   'goods_num'=>$goods_num,
                   'creattime'=>time()
               ];
               $info=DB::table('car')->insert($date);
               if($info){
                $arr=[
                    'code'=>1,
                    'msg'=>"加入购物车成功"
                ];
                return $arr; 
               }
            } 
        }
    }
    public function jiashan(Request $request){
        $goods_id=$request->input('id');
        Car::where('goods_id',$goods_id)->update(['is_show'=>0]);
        return redirect('shopcart');
    }
    public function payment(Request $request){
        $price=$request->input('price');
        $price=trim($price,'￥');
        // print_r($price);die;
        $goods_id=$request->input('gid');
        if(empty($goods_id)){
            $arr=array(
                'code'=>0,
                'msg'=>'购物车为空不可下单'
            );
            return $arr; 
        }else{
        // print_r($goods_id);die;
        // $goods_id=explode(',',$goods_id);
        // print_r($goods_id);exit;
        $user=$request->session()->get('id');
        if(empty($user)){
            return redirect('login');
        }else{
            // //通过id查询数据
            // $info=DB::table('goods')->whereIn('goods_id',$goods_id)->get();
            // print_r($info);
            //判断库存
            $data=[];
            $info=DB::table('goods')->join('car','goods.goods_id','=','car.goods_id')->whereIn('goods.goods_id',$goods_id)->get(['goods_name','goods_number','goods_num','goods.goods_id','goods_img','shop_price']);
            // print_r($info);die;
            foreach($info as $k=>$v){
                if($v->goods_num>$v->goods_number){
                    $data[]=$v->goods_name;
                }
            }
            if($data){
                $name=implode(',',$data);
                $arr=array(
                    'code'=>0,
                    'msg'=>$name.'库存不足'
                );
                return $arr;
            }
            $order_no=date("YmdHis".time()).rand(1000,9999);
            $uid=session('id');
            $datainfo=[
                'order_no'=>$order_no,
                'user_id'=>$uid,
                'order_amout'=>$price,
                'ctime'=>time()
            ];
            $res=DB::table('order')->insert($datainfo);
            $orderdata=DB::table('order')->where('order_no',$order_no)->get(['order_id']);
            foreach($info as $v){
                $arrr=[
                    'order_id'=>$orderdata[0]->order_id,
                    'order_no'=>$order_no,
                    'user_id'=>$uid,
                    'goods_id'=>$v->goods_id,
                    'buy_number'=>$v->goods_num,
                    'goods_name'=>$v->goods_name,
                    'goods_price'=>$v->shop_price,
                    'goods_img'=>$v->goods_img,
                    'status'=>1,
                    'utime'=>time()

                ];
                DB::table('order_detail')->insert($arrr);
            }
            $res1=Car::whereIn('goods_id',$goods_id)->where('uid',$uid)->update(['status'=>2]);
            if($res){
                $arr=array(
                    'code'=>1,
                );
                return $arr;
            }
        }
        }
        
         
    }
    public function pay(){
        $uid=session('id');
        $data=DB::table('order_detail')->where('user_id',$uid)->get();
        // print_r($data);
        return view('goods.payment',['data'=>$data]);
    }
    public function pishan(Request $request){
        $goods_id=$request->input('id'); 
        Car::whereIn('goods_id',$goods_id)->update(['is_show'=>0]);
        return ['code'=>1,'msg'=>'删除成功'];
    }
    public function jia(Request $request){
        $num=$request->input('num');
        $id=$request->input('id');
        $info=DB::table('goods')->where('goods_id',$id)->first(['goods_number']);
        
        if($num>=$info->goods_number){
            return ['code'=>0,'msg'=>'库存不足'];
        }else{
            $data=[
                'goods_num'=>$num+1
            ];
            Car::where('goods_id',$id)->update($data);
            return ['code'=>1,'msg'=>'1'];
        }
    }
    public function jian(Request $request){
        $num=$request->input('num');
        $id=$request->input('id');
        $info=DB::table('goods')->where('goods_id',$id)->first(['goods_number']);
        
        if($num<1){
            return ['code'=>0,'msg'=>'库存不足'];
        }else{
            $data=[
                'goods_num'=>$num-1
            ];
            Car::where('goods_id',$id)->update($data);
            return ['code'=>1,'msg'=>'1'];
        }
    }
    public function kuang(Request $request){
        $num=$request->input('num');
        $id=$request->input('id');
        $info=DB::table('goods')->where('goods_id',$id)->first(['goods_number']);
        if($num>=$info->goods_number){
            Car::where('goods_id',$id)->update(['goods_num'=>$info->goods_number]);
            return ['code'=>0,'msg'=>'111'];
        }else{
            Car::where('goods_id',$id)->update(['goods_num'=>$num]);
        }
        if($num<0){
            Car::where('goods_id',$id)->update(['goods_num'=>1]);
            return ['code'=>0,'msg'=>'111'];
        }
    }
    public function address(Request $request){
        $data=DB::table('order_address')->where('user_id',session('id'))->get();
      //  print_r($data);
        return view('goods.address',['data'=>$data]);
    }
    public function success(Request $request){
        $price=$request->input('price');
        $uid=session('id');
        if(empty($uid)){
            return redirect('login');
        }else{
            //判断用户有没有默认收货地址
            $data=DB::table('order_address')->where('user_id',$uid)->where('post_code',1)->get()->toArray();
            //  print_r($data);
            if(empty($data)){
                return ['code'=>0,'msg'=>'亲，您还没有收货地址，马上去添加吧'];
            }else{
                return ['code'=>1];
            }

        }
    }
    public function moren(Request $request){
        $id=$request->input('id');
        DB::table('order_address')->where('user_id',session('id'))->update(['post_code'=>0]);
        DB::table('order_address')->where('id',$id)->update(['post_code'=>1]);
        return ['code'=>1];
    }
    public function writeaddr(Request $request){
        return view('goods.writeaddr');
    }
    public function dizhi(Request $request){
        $data=$request->input();
        //print_r($data);
        $uid=session('id');
        if(empty($data['post_code'])){
            $data=[
                'user_id'=>$uid,
                'order_receive_name'=>$data["order_receive_name"],
                'receive_tel'=>$data['receive_tel'],
                'receive_address'=>$data["receive_address"],
                'receive_xiangxi'=>$data["receive_xiangxi"]
            ];
            // print_r($data);die;
            DB::table('order_address')->insert($data);
            return ['code'=>0,'msg'=>'success'];
        }else{
            DB::table('order_address')->where('user_id',session('id'))->update(['post_code'=>0]);
            $data=[
            'user_id'=>$uid,
            'order_receive_name'=>$data['order_receive_name'],
            'receive_tel'=>$data['receive_tel'],
            'receive_address'=>$data['receive_address'],
            'receive_xiangxi'=>$data['receive_xiangxi'],
            'post_code'=>1
        ];
        DB::table('order_address')->insert($data);
            return ['code'=>0,'msg'=>'success'];
        }
        
    }
    public function paysuccess(){
        return view('goods.paysuccess');
    }
    public function dzdel(Request $request){
        $id=$request->input('id');
        // print_r($id);die;
        DB::table('order_address')->where('id',$id)->delete();
        return ['ceod'=>0];
    }
    public function writeaddrs(Request $request){
        $id=$request->input('id');
        $data=DB::table('order_address')->where('id',$id)->get();
        // print_r($data);
        return view('goods.writeaddrs',['data'=>$data]);
    }
    public function dizhixiu(Request $request){
            $data=$request->input();
            $id=$data["id"];
            $uid=session('id');
            // print_r($data);
            if(empty($data['post_code'])){
                $data=[
                    'user_id'=>$uid,
                    'order_receive_name'=>$data["order_receive_name"],
                    'receive_tel'=>$data['receive_tel'],
                    'receive_address'=>$data["receive_address"],
                    'receive_xiangxi'=>$data["receive_xiangxi"]
                ];
                // print_r($data);die;
                DB::table('order_address')->where('id',$id)->update($data);
                return ['code'=>0,'msg'=>'success'];
            }else{
                DB::table('order_address')->where('user_id',session('id'))->update(['post_code'=>0]);
                $data=[
                'user_id'=>$uid,
                'order_receive_name'=>$data['order_receive_name'],
                'receive_tel'=>$data['receive_tel'],
                'receive_address'=>$data['receive_address'],
                'receive_xiangxi'=>$data['receive_xiangxi'],
                'post_code'=>1
            ];
            DB::table('order_address')->where('id',$id)->update($data);
                return ['code'=>0,'msg'=>'success'];
            }
    }
    public function buyrecord(Request $request){
        $uid=session('id');
        $data=DB::table('order_detail')->where('user_id',$uid)->get();
        
        return view('goods.buyrecord',['data'=>$data]);
    }
}
