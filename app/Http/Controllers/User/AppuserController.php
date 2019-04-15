<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AppuserController extends Controller
{
    //登陆
    public function login(Request $request)
    {
        $ses = $request->session()->get('user_name');
        if ($request->session()->get('user_name')) {
            return 3;
        }
        $name = $request->input('name');
        $pd = $request->input('pwd');
        $pwd = md5(md5($pd));
        $res = DB::table('app_user')->where(['user_name' => $name, 'user_pwd' => $pwd])->first();
        if ($res) {
            $request->session()->put('user_name', $name);
            return 1;
        } else {
            return 2;
        }
    }
        //下拉展示
        public function show(Request $request){
        $data = DB::table('user')->Paginate(1)->toArray();
         $info = json_encode($data,1);
        return $info;
        }

}