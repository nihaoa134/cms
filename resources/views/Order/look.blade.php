
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理员管理-有点</title>
    <link rel="stylesheet" type="text/css" href="../css/css.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="../img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;-</span>&nbsp;管理员管理
        </div>
    </div>

    <div class="page">
        <!-- user页面样式 -->
        <div class="connoisseur">
            <!-- user 表格 显示 -->
            <div class="conShow">
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="66px" class="tdColor tdC">id</td>
                        <td width="315px" class="tdColor">名字</td>
                        <td width="315px" class="tdColor">用户id</td>
                        <td width="308px" class="tdColor">openid</td>
                        <td width="308px" class="tdColor">时间</td>
                    </tr>
                    @foreach($info as $v)
                        <tr width="100%">
                            <td>{{$v->id}}</td>
                            <td>{{$v->goods_id}}</td>
                            <td> {{$v->user_id}}</td>
                            <td>{{$v->openid}}</td>
                            <td>{{$v->time}}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="paging">此处是分页</div>
            </div>
            <!-- user 表格 显示 end-->
        </div>
        <!-- user页面样式end -->
    </div>

</div>
</body>
</html>