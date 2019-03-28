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
}