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
        <col width="150">
        <col width="150">
        <col width="150">
        <col width="150">
        <col width="200">
    </colgroup>
    <thead>
    <tr>
        <th>书名</th>
        <th>创建时间</th>
        <th>操作</th>
        <th>封面图片</th>
        <th>封面</th>
        <th>采集链接</th>
    </tr>
    </thead>
    <tbody>
        <?php if(is_array($books)): $i = 0; $__LIST__ = $books;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$book): $mod = ($i % 2 );++$i;?><tr>
                <td><?php echo ($book["bookname"]); ?></td>
                <td><?php echo ($book["ctime"]); ?></td>
                <td><a href="./index.php?m=Home&c=Index&a=getbook&id=<?php echo ($book["bookid"]); ?>" target="_blank">获取详情</a></td>
                <td><img src="<?php echo ($book["cover"]); ?>"></td>
                <td><a href="">上传封面</a></td>
                <td><?php echo ($book["originalurl"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>



</body>
</html>