<?php
namespace App\Http\Controllers\Order;

use App\Model\OrderModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function text($id){
        $order=OrderModel::where(['id'=>$id])->first()->toarray();
        print_r($order);
    }
    public function add(){
        $data=[
          'username'=>str_random(5)
        ];
        $add=OrderModel::insert($data);
        dump($add);
    }
    public function show(){
        $add=OrderModel::get()->toArray();
        dump($add);
    }
    public function upd($id){
        $data=[
            'username'=>str_random(5)
        ];
        $where=[
            'id'=>$id
        ];
        $upd=OrderModel::Where(['id'=>$id])->update($data);
        dump($upd);
    }
    public function  del($id){
        $del=OrderModel::where(['id'=>$id])->delete();
        dump($del);
    }
    public function web(){
        $data=OrderModel::get();
        $info=[
            'info'=>$data
        ];
        return view('Order.order',$info);
    }
}
