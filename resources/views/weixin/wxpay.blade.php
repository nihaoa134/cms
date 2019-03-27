<!doctype html>
<html lang="en">
<script src="./js/qrcodejs-master/qrcode.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div id="qrcode"></div>
</body>
</html>
<script>
    // 简单方式
    new QRCode(document.getElementById('qrcode'), 'your content');

    // 设置参数方式
    var qrcode = new QRCode('qrcode', {
        text: 'your content',
        width: 256,
        height: 256,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });

    // 使用 API
    qrcode.clear();
    qrcode.makeCode('new content');
</script>