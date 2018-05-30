<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="./Home/View/js/jquery-1.11.1.min.js"></script>
    <link href="./Home/View/css/global.css" rel="stylesheet">
    <link href="./Home/View/layui/css/layui.css" rel="stylesheet">
    <script src="./Home/View/layui/layui.all.js"></script>

</head>


<body>
<a href="javascript:void(0)" class="layui-btn layui-btn-radius" id="addCatogry">添加分类</a>
<hr/>

</body>

<script>
    $(function(){
        $('#addCatogry').click(function(){

            var layer = layui.layer;

             layer.open({
                 title:'添加分类',
                 area:['800px','400px'],
                 type: 2,
                 content: "./index.php?m=Home&c=Index&a=addcatogary"
             });

        })
    })
</script>


</html>