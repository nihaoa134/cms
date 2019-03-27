<?php
namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function Tlike(){

                return view('task.task');
    }
    public function Tlike1(){
        $data = DB::table('user')->get()->toArray();
        echo json_encode(['data'=>$data]);
        //print_r($data);

    }
}