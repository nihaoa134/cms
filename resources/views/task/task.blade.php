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
                    <input type="button" name="start" value="开始">
                    <input type="button" name="end" value="结束">

                    <tr>
                        <td width="200px" class="tdColor tdC">id</td>
                        <td width="250px" class="tdColor">用户名</td>
                        <td width="250px" class="tdColor">年龄</td>

                    </tr>
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
<script>
    $("input[name = 'start']").click(function(){
        setInterval(function () {
            $.ajax({
                url:  '/task1',
                type: 'post',
                data: '',
                dataType: 'json',
                success: function (msg) {
                    $('#leng').empty();
                    var data=msg.data;
                    var str="";
                    $.each(data,function(i,v){
                        str+="<tr>"+
                            "<td width=\"200px\">"+v['id']+"</td>" +
                            "<td width=\"250px\">"+v['name']+"</td>" +
                            "<td width=\"250px\">"+v['age']+"</td>"+
                        "</tr>"
                    });
                    $('#leng').append(str);
                }
            });
        },1000)
        num=bol;
    })
    $("input[name='end']").click(function(){
        clearInterval(num);
    })

</script>