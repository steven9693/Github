<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台管理系统</title>
    <script src="./Home/View/js/jquery-1.11.1.min.js"></script>
    <link href="./Home/View/css/global.css" rel="stylesheet">
    <link href="./Home/View/layui/css/layui.css" rel="stylesheet">
    <script src="./Home/View/layui/layui.all.js"></script>
    <script src="./Home/View/js/urls.js?v=3"></script>
    <script src="./Home/View/js/doT.js"></script>
</head>
<body>


<div class="layui-form" style="width:400px;margin:200px auto 0"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->

    <div class="layui-form-item">
        <label class="layui-form-label">账号</label>
        <div class="layui-input-block">
            <input type="text" name="phone" placeholder="手机号码" autocomplete="off" class="layui-input" lay-verify="required|phone">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="password" name="pwd" placeholder="输入密码" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">登录</button>
        </div>
    </div>

</div>


<script>
    layui.use('form', function(){
        var form = layui.form;
        //各种基于事件的操作，下面会有进一步介绍
        form.on('submit(formDemo)', function (data) {
            console.log(data)
            $.post(GOTOLOGIN,data.field,function(ret){
                if(ret.status==1){
                    window.location.href="./index.php?m=Home&c=Login&a=login"
                }

                if(ret.status==2){
                    layer.msg('密码不正确！', {icon: 5});
                }

                if(ret.status==3){
                    layer.msg('用户不存在！', {icon: 5});
                }
            },'json')
        })
    });


</script>

</body>

</html>