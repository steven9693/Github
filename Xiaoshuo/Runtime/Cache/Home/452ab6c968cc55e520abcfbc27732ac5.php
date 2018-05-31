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


<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>昵称</th>
        <th>加入时间</th>
        <th>签名</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>贤心</td>
        <td>2016-11-29</td>
        <td>人生就像是一场修行</td>
    </tr>
    <tr>
        <td>许闲心</td>
        <td>2016-11-28</td>
        <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
    </tr>
    </tbody>
</table>






</body>

<script>
    $(function(){
        $('#addCatogry').click(function(){

            var layer = layui.layer;

             layer.open({
                 title:'添加分类',
                 area:['800px','580px'],
                 type: 2,
                 content: "./index.php?m=Home&c=Index&a=addcategory"
             });

        })
    })
</script>


</html>