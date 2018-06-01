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

<style>
    .box{padding:20px 30px 0}
</style>

<div class="box">

    <table class="layui-table">
        <colgroup>
            <col width="50">
            <col width="200">
        </colgroup>

        <tbody>
        <tr>
            <td>简介</td>
            <td><?php echo ($info); ?></td>
        </tr>
        <tr>
            <td>作者、播音</td>
            <td><?php echo ($msg); ?></td>
        </tr>
        </tbody>
    </table>


    <div class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">作者</label>
            <div class="layui-input-block">
                <input type="text" name="author" required  lay-verify="required" placeholder="作者" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">播音</label>
            <div class="layui-input-block">
                <input type="text" name="voice" required  lay-verify="required" placeholder="播音" autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">小说简介</label>
            <div class="layui-input-block">
                <textarea name="description" placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>


        <div class="layui-form-item layui-form-text">
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
            layer.msg(JSON.stringify(data.field));

            var id="<?php echo ($id); ?>";
            data.field.id=id

            console.log(UPDATEBOOK)

            $.post(UPDATEBOOK, data.field, function(){});

            //return false;
        });
    });
</script>







</body>
</html>