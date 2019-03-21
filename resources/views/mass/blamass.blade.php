<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="textml; charset=utf-8" />
    <title>广告-有点</title>
    <link rel="stylesheet" type="text/css" href="../css/css.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="../img/coin02.png" /><span><a href="index">首页</a>&nbsp;-&nbsp;<a
                        href="labellist">标签管理</a>&nbsp;-</span>&nbsp;意见管理
        </div>
    </div>
    <div class="page">
        <!-- banner页面样式 -->
        <div class="banner">
            <!-- banner 表格 显示 -->
            <div class="banShow">
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="66px" class="tdColor tdC">序号</td>
                        <td width="315px" class="tdColor">名称</td>
                        <td width="308px" class="tdColor">详情</td>
                    </tr>
                    <tr>
                        @foreach($data as $v)
                            <td class="abc">{{$v['id']}}</td>
                            <td>{{$v['name']}}</td>
                            {{--<td><a href="biaoqianlistdo?template_id={{$v['template_id']}}"><input type="button" class="addA" value="查看" style="margin:5px 10px 5px 10px;"></a></td>--}}
                        @endforeach
                    </tr>
                </table>
                <div class="paging">此处是分页</div>
            </div>
            <!-- banner 表格 显示 end-->
        </div>
        <!-- banner页面样式end -->
    </div>

</div>


<!-- 删除弹出框 -->
{{--<div class="banDel">--}}
{{--<div class="delete">--}}
{{--<div class="close">--}}
{{--<a><img src="img/shanchu.png" /></a>--}}
{{--</div>--}}
{{--<p class="delP1">你确定要删除此条记录吗？</p>--}}
{{--<p class="delP2">--}}
{{--<a href="#" class="ok yes" onclick="del()" id="dele">确定</a><a class="ok no">取消</a>--}}
{{--</p>--}}
{{--</div>--}}
{{--</div>--}}
<!-- 删除弹出框  end-->
</body>
<script src="js/j.js"></script>
<script src="layui/layui.js"></script>
<script>
    layui.use('layer', function() {
        var layer = layui.layer;
        //删除
        $('.delban').click(function () {
//        var _this = $('this');
//        var _id = _this.parents('tr').attr('delete');
//        console.log(_id)
            var obj = $(this).parents("tr");
            var ss = obj.find(".abc").text();
            $.post(
                'labeldelete',
                {ss: ss},
                function (res) {
                    if (res.msg == 1) {
                        layer.msg(res.font);
                        obj.remove();
                    }
                },'json'
            )

        })
        //标签详情
        $('.zxczxc').click(function(){
            var obj = $(this).parents("tr");
            var ss = obj.find(".abc").text();
            $.post(
                '/labMass/',
                {ss: ss},
                function (res) {
                    if (res.msg == 1) {
                        layer.msg(res.font);
                    }
                },'json'
            )
        })
    })





    // 广告弹出框
    $(".delban").click(function(){
        $(".banDel").show();
    });
    $(".close").click(function(){
        $(".banDel").hide();
    });
    $(".no").click(function(){
        $(".banDel").hide();
    });
    // 广告弹出框 end

    function del(){
        var input=document.getElementsByName("check[]");
        for(var i=input.length-1; i>=0;i--){
            if(input[i].checked==true){
                //获取td节点
                var td=input[i].parentNode;
                //获取tr节点
                var tr=td.parentNode;
                //获取table
                var table=tr.parentNode;
                //移除子节点
                table.removeChild(tr);
            }
        }
    }
</script>
</html>
