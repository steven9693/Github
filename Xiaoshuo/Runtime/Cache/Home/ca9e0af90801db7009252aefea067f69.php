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


    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
        </colgroup>

        <tbody>
        <tr>
            <td><img src="<?php echo ($src); ?>"/></td>
            <td><a href="" class="layui-btn">保存</a></td>
        </tr>

        </tbody>
    </table>



</body>
</html>