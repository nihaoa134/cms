
<?php
$redis=new Redis();
$redis->connect('127.0.0.1',6379);
$key="token_app";
$token=$redis->sPop($key);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="../js/qrcodejs-master/qrcode.js"></script>
    <script  src="../js/jquery.min.js"></script>
</head>
<body>
<div id="qrcode"></div>

</body>
</html>
<script>

    // 设置参数方式
    var qrcode = new QRCode('qrcode', {
        text: "<?php echo $token;?>",
        width: 256,
        height: 256,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });

</script>
<script>
    token = "<?php echo $token;?>"
    setInterval(function () {
        $.ajax({
            url:  'node.lixiaonitongxue.top/gredis',
            type: 'post',
            data: token,
            dataType: 'json',
            success: function (data) {
                if (data==1){
                    alert('登陆成功')
                }
            }
        });
    },2000)
</script>