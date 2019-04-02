<?php
namespace App\Http\Controllers\order;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderlistController extends Controller
{
    public function orderlist(){
        $info = DB::table('shop_order')->get();
//        echo $info;die;
        return view('Order.list',['info'=>$info]);
    }
    public function lookshow(){
        $info = DB::table('lookshow')->get();
//        echo $info;die;
        return view('Order.look',['info'=>$info]);
    }
}