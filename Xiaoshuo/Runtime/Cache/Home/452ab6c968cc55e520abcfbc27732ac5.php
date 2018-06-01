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
        <col width="200">
        <col width="200">
        <col width="200">
    </colgroup>
    <thead>
    <tr>
        <th>分类</th>
        <th>是否显示</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                <td><?php echo ($item["name"]); ?></td>
                <td><?php echo ($item["isshow"]); ?></td>
                <td></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

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