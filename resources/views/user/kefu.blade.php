
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script  src="../js/jquery-1.7.2.min.js"></script>
        <meta charset="UTF-8">
        <title>HTML5模拟微信聊天界面</title>
        <style>
            /**重置标签默认样式*/
            * {
                margin: 0;
                padding: 0;
                list-style: none;
                font-family: '微软雅黑'
            }
            #container {
                height: 780px;
                background: #eee;
                position: relative;
                box-shadow: 20px 20px 55px #777;
            }
            .header {
                background: #000;
                height: 40px;
                color: #fff;
                line-height: 34px;
                font-size: 20px;
                padding: 0 10px;
            }
            .footer {
                width: 1680px;
                height: 50px;
                background: #666;
                position: absolute;
                bottom: 0;
                padding: 10px;
            }
            .footer input {
                width: 1500px;
                height: 45px;
                outline: none;
                font-size: 20px;
                text-indent: 10px;
                position: absolute;
                border-radius: 6px;
            }
            .footer span {
                display: inline-block;
                width: 150px;
                height: 48px;
                background: #ccc;
                font-weight: 900;
                line-height: 45px;
                cursor: pointer;
                text-align: center;
                position: absolute;
                right: 10px;
                border-radius: 6px;
            }
            .footer span:hover {
                color: #fff;
                background: #999;
            }
            #user_face_icon {
                display: inline-block;
                background: red;
                width: 60px;
                height: 60px;
                border-radius: 30px;
                position: absolute;
                bottom: 6px;
                left: 14px;
                cursor: pointer;
                overflow: hidden;
            }
            img {
                width: 60px;
                height: 60px;
            }
        .content {
            font-size: 20px;
            width: 435px;
            height: 662px;
            overflow: auto;
            padding: 5px;
        }
        .content li {
            margin-top: 10px;
            padding-left: 10px;
            width: 412px;
            display: block;
            clear: both;
            overflow: hidden;
        }
        .content li img {
            float: left;
        }
        .content li span{
            background: #7cfc00;
            padding: 10px;
            border-radius: 10px;
            float: left;
            margin: 6px 10px 0 10px;
            max-width: 310px;
            border: 1px solid #ccc;
            box-shadow: 0 0 3px #ccc;
        }
        .content li img.imgleft {
            float: left;
        }
        .content li img.imgright {
            float: right;
        }
        .content li span.spanleft {
            float: left;
            background: #fff;
        }
        .content li span.spanright {
            float: right;
            background: #7cfc00;
        }
    </style>

</head>
<body>
<div id="container">
    <div class="header">
        <span style="float: left;">{{$name}}</span>
        <span style="float: right;" id="openid">{{$openid}}</span>
    </div>
    <ul class="content" id="leng">
    </ul>
    <div class="footer">
        <input id="text" type="text" placeholder="说点什么吧...">
        <span id="btn" name="btn">发送</span>
    </div>
</div>
</body>
</html>

<script>

    $('#btn').click(function(){
        var _data = $('#text').val();
        var _id = $('#openid').html();
        $.ajax({
            url: '/kefu1',
            type: 'post',
            data: {data:_data,id:_id},
            dataType: 'json',
            success: function () {
            }
        });
    })
    setInterval(function () {
        var start=$("#leng").find('li').length;
        $.ajax({
            url:  '/kefu2',
            type: 'post',
            data: {start:start},
            dataType: 'json',
            success: function (msg) {
                    var data=msg.res;
                var str="";
                $.each(msg,function(i,v){
                    str+=
                        "<li>自己<span>"+v.date+"</span></li>"

                });
                $('#leng').append(str);
            }

         })
    },3000)
    setInterval(function () {
        var start=$("#leng").find('li').length;
        $.ajax({
            url:  '/kefu3',
            type: 'post',
            data: {start:start},
            dataType: 'json',
            success: function (msg) {
                var data=msg.res;
                var str="";
                $.each(msg,function(i,v){
                    str+=
                        "<li>对方<span>"+v.date+"</span></li>"

                });
                $('#leng').append(str);
            }

        })
    },3000)
</script>
