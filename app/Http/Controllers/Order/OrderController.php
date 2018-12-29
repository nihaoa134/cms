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
}
