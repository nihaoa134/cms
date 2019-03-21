<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="textml; charset=utf-8" />
    <title>标签管理-有点</title>
    <link rel="stylesheet" type="text/css" href="../css/css.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script src="../js/jquery-1.7.2.min.js"></script>
    <!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>


<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="../img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a href="#">管理</a>&nbsp;-</span>&nbsp;管理
        </div>
    </div>
    <div class="add">
        <a class="addA" href="/upload/">上传&nbsp;&nbsp;+</a>
    </div>
    <div class="page">
        <!-- balance页面样式 -->
        <div class="connoisseur">
            <div class="conShow">
                <table border="1" cellpadding="0" cellpadding="0">
                    <tr>
                        <td width="66px" class="tdColor tdC">id</td>
                        <td width="250px" class="tdColor">图片</td>
                        <td width="300px" class="tdColor">过期时间</td>
                        <td width="380px" class="tdColor">media_id</td>
                        <td width="300px" class="tdColor">创建时间</td>
                    </tr>
                    @foreach($data as $v)
                        <tr clas="banDel">
                            <td>{{$v['id']}}</td>
                            <td><img src=".{{$v['filepath']}}" style="width: 100px;height: 100px"></td>
                            <td>{{$v['time']}}</td>
                            <td>{{$v['media_id']}}</td>
                            <td>{{$v['presenttime']}}</td>
                        </tr>
                    @endforeach
                </table>
                <div style="align-content: center;margin-left: 500px;margin-top: 10px">
                    <a href="/show/?page={{$arr['first']}}">首页</a>
                    <a href="/show/?page={{$arr['prevpage']}}">上一页</a>
                    <a href="/show/?page={{$arr['nextpage']}}">下一页</a>
                    <a href="/show/?page={{$arr['total']}}">尾页</a>
                </div>
            </div>
            <!-- balance 表格 显示 end-->
        </div>
        <!-- balance页面样式end -->
    </div>
</div>
</body>
<html>