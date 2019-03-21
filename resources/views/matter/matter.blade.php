<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>头部-有点</title>
    <link rel="stylesheet" type="text/css" href="../css/css.css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script  src="../js/jquery.js"></script>
    <script  src="../js/ajaxfileupload.js"></script>
</head>
<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="../img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
                        href="#">公共管理</a>&nbsp;-</span>&nbsp;意见管理
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <form class="form-horizontal" method="POST" action="/upload/" enctype="multipart/form-data">
            <div class="banneradd bor">
                <div class="baTop">
                    <span>上传图片</span>
                </div>
                <div class="baBody">
                    <div class="bbD">
                        上传图片：
                        <div class="bbDd">
                            <div class="bbDImg">+</div>
                            <input type="file" class="file" name="file" id="file"/> <a class="bbDDel" href="#">删除</a>
                        </div>
                    </div>
                    <div class="bbD">
                        <p class="bbDP">
                            <button class="btn_ok btn_yes" href="#">提交</button>
                            <a class="btn_ok btn_no" href="#">取消</a>
                        </p>
                    </div>
                </div>
            </div>
        </form>
        <!-- 上传广告页面样式end -->
    </div>
</div>
</body>
</html>

<script>
    $("#file").change(function () {
        $.ajaxFileUpload({
            type : "post",
            url : "/upload",
            secureuri : false,
            fileElementId : "file",
            dataType : "json",
            success:function (data) {
                var filePath = data.path;

            }
        })
    })
</script>
