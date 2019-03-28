<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>话题管理-有点</title>
    <link rel="stylesheet" type="text/css" href="../css/css.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script  src="../js/jquery-1.7.2.min.js"></script>
    <!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="../img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
                        href="#">公共管理</a>&nbsp;-</span>&nbsp;意见管理
        </div>
    </div>

    <div class="page">
        <!-- topic页面样式 -->
        <div class="topic">
            <div class="conform">
                <form>

                </form>
            </div>
            <!-- topic表格 显示 -->
            <div class="conShow">
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="200px" class="tdColor tdC">id</td>
                        <td width="250px" class="tdColor">支付方式</td>
                        <td width="250px" class="tdColor">支付结果</td>
                    </tr>
                    @foreach($info as $v)
                        <tr>
                            <td width="200px" class="tdColor tdC">{{$v->order_id}}</td>
                            @if($v->order_paytype==2)
                            <td width="250px" class="tdColor">微信支付</td>
                            @else
                            <td width="250px" class="tdColor">支付宝支付</td>
                            @endif
                            @if($v->order_status==2)
                                <td width="250px" class="tdColor">支付成功</td>
                            @else
                                <td width="250px" class="tdColor">未支付</td>
                            @endif

                        </tr>
                    @endforeach
                </table>
                <table border="1" cellspacing="0" cellpadding="0" id="leng">

                </table>
                <div class="paging">此处是分页</div>
            </div>
            <!-- topic 表格 显示 end-->
        </div>
        <!-- topic页面样式end -->
    </div>

</div>
</body>

</html>