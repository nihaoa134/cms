<?php
    $redis = new Redis();
    $redis->connect("127.0.0.1",6379);

    $key = "token_app";
    $usertoken = $redis->scard($key);
    for ($i=0;$i<100-$usertoken;$i++){
        $num = rand(1,1000000).time();
        $data = md5($num);
        $start = rand(0,10);
        $end = rand(11,32);
        $token = substr($data,$start,$end);
        $redis->sAdd($key,$token);
    }