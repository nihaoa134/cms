<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>会员编辑-有点</title>
    <link rel="stylesheet" type="text/css" href="../css/css.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
</head>
<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="../img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
                        href="#">公共管理</a>&nbsp;-</span>&nbsp;会员编辑
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>会员编辑</span>
            </div>
            <div class="baBody">
                <div id="menu">
                <div class="bbD" id="aaaa">
                    菜 单 名 ：<input type="text" class="input3" id="name"/>

                    菜单类型：<select class="input3" id="type">
                        <option value="view">VIEW</option>
                        <option value="click">CLICK</option>
                    </select>

                    菜单内容：<input class="input3" type="text" id="val"/>
                    <button class="top_btn" style="width: 100px;height: 40px;background-color:lawngreen;color:#fff;border: none;">克隆</button>
                </div>
            </div>
            <div class="bbD">
                <p class="bbDP">
                    <button class="btn_ok btn_yes" href="#" id="btn">提交</button>
                    <a class="btn_ok btn_no" href="#">取消</a>
                </p>
            </div>
            </div>
        </div>

        <!-- 上传广告页面样式end -->
    </div>
</div>
</body>
</html>

<script>
    $(function() {


        //克隆一级菜单
        $(document).on('click', '.top_btn', function () {
            var _this = $(this);
            var _div = _this.parents('#menu');
            //console.log(_div.length);
                _div.after(_div.clone());
        });
    })
        //处理数组
    $('#btn').click(function() {
        var name=[];
        var type=[];
        var key=[];
        $('.bbD').each(function(){
            name.push($(this).find('#name').val());
            type.push($(this).find('#type').val()) ;
            key.push($(this).find('#val').val());
        })

        //console.log(info);

        $.ajax({
            url: '/domenu',
            type: 'post',
            data: {name:name,type:type,key:key},
            dataType: 'json',
            success: function (a) {
                if(a.code == 0) {
                    alert('发布成功')
                }
            }
        });
    })
</script>


