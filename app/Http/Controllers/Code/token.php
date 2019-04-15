<?php
    $num = rand(1,1000000).time();
    $data = md5($num);
    $start = rand(0,10);
    $end = rand(11,32);
    $token = substr($data,$start,$end);

    $redis = new Redis();
    $redis->connect("127.0.0.1",6379);

    $key = "token_app";
    $userToken = $redis->scard($key);
    echo $userToken;
?>