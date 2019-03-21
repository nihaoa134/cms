<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>话题添加-有点</title>
    <link rel="stylesheet" type="text/css" href="../css/css.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
</head>
<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="../img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
                        href="#">ID群发</a>&nbsp;-</span>&nbsp;
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTop">
                <span>OPENID发送</span>
            </div>
            <div class="baBody">
                <div class="bbD">
                    <div>用户：<div>
                            <div class="info" style="width:50%;margin-left:31px;margin-top:-16px">
                                @foreach($data as $key => $value)
                                    <label>
                                        <input type="checkbox"  value="{{$value['openid']}}" name="user"/>{{$value['nickname']}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="bbD">
                            内容：
                            <div class="btext">
                                <textarea class="text2"></textarea>
                            </div>
                        </div>
                        <div class="bbD">
                            <p class="bbDP">
                                <button class="btn_ok btn_yes" href="#" name="btn">提交</button>
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
    $(document).ready(function(){
        $("button[name='btn']").click(function(){
            var openid=[];
            var data={};
            $("input[name='user']").each(function(){
                if($(this).is(":checked")){
                    var val = $(this).val();
                    openid.push(val);
                }
            });
            data.openid =openid;
            var text = $(".text2").val();
            data.content = text;
            console.log(data);
            var url = "/idmass/";
            $.ajax({
                type : "post",
                dataType : "json",
                url : url,
                data:data,
                success:function(msg){

                }
            });

        });
    });
</script>
