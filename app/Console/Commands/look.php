<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class look extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $redis = new \redis;
        $redis->connect("127.0.0.1", 6379);//exit;
        $like = "liulan";
        $data = $redis->lrange($like, 0, -1);
        $res = array();
        foreach ($data as $k => $v) {
            $arr = $redis->hGetAll($v);
            array_push($res, $arr);
        }
        $gid = $arr['goods_id'];
        $uid = $arr['uid'];
        $openid = $arr['openid'];
        $time = $arr['time'];
//        print_r($arr);die;
        DB::table('lookshow')->insert(['goods_id'=>$gid,'user_id'=>$uid,'openid'=>$openid,'time'=>$time,]);
    }
}
