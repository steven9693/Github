<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="./Home/View/js/jquery-1.11.1.min.js"></script>
    <link href="./Home/View/css/global.css" rel="stylesheet">
    <link href="./Home/View/layui/css/layui.css" rel="stylesheet">
    <script src="./Home/View/layui/layui.all.js"></script>
    <script src="./Home/View/js/urls.js"></script>

</head>
<style>
    .content{width:600px;margin:40px auto 0}
</style>

<body>
<div class="content">
    <div class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" required  lay-verify="required" placeholder="如：武侠" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">保存</button>
            </div>
        </div>

    </div>
</div>



<script>
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(formDemo)', function(data){
            //layer.msg(JSON.stringify(data.field));
            var href=window.parent.window.location.href;

             $.post(ADDCATOGARY,data.field,function(ret){
                 console.log(ret)
                 if(ret.status==1){
                     window.parent.location.href=href;
                 }
             },'json');

            return false;

        });
    });
</script>

</body>

</html>