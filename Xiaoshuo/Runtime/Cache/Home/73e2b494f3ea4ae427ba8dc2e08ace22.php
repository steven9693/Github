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




<body>

<form class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">书名</label>
        <div class="layui-input-block">
            <input type="text" name="bookname" required  lay-verify="required" placeholder="书名" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">ULR</label>
        <div class="layui-input-block">
            <input type="text" name="url" required  lay-verify="required" placeholder="原始URL" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">选择框</label>

        <div class="layui-input-block">
            <select id="edit_exam_school" name="catogary" lay-verify="required">
                <option value="">选择分类</option>
                <option value="1">华南理工大学大学城</option>
                <option value="2">华南理工大学五山校区</option>
                <option value="3">中山大学珠海校区</option>
                <option value="4">中山大学大学城校区</option>
            </select>
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">保存数据</button>
        </div>
    </div>




</form>


<script>
    layui.use('form', function(){
        var form = layui.form;
        form.render('select');

        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));

            console.log(ADDBOOK)
            $.post(ADDBOOK,data.field,function(){

            })

            return false;
        });


    })
</script>

</body>
</html>