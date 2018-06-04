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

<a href="javascript:void(0)" class="layui-btn layui-btn-radius" id="addbook">添加书本</a>
<hr/>

<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="150">
        <col width="150">
        <col width="150">
        <col width="250">
        <col width="200">
    </colgroup>
    <thead>
    <tr>
        <th>书名</th>
        <th>封面图片</th>
        <th>编辑基本信息</th>
        <th>获取音频</th>
        <th>设置封面</th>
        <th>采集链接</th>
    </tr>
    </thead>
    <tbody>
        <?php if(is_array($books)): $i = 0; $__LIST__ = $books;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$book): $mod = ($i % 2 );++$i;?><tr>
                <td><?php echo ($book["bookname"]); ?></td>
                <td><img src="<?php echo ($book["cover"]); ?>"></td>
                <td><a href="javascript:void(0)" data-src="./index.php?m=Home&c=Index&a=getbook&id=<?php echo ($book["bookid"]); ?>" class="getdetail layui-btn layui-btn-sm">获取详情</a></td>
                <td><a href="javascript:void(0)" data-src="./index.php?m=Home&c=Ajax&a=index&id=<?php echo ($book["bookid"]); ?>" class="getvoice layui-btn layui-btn-sm">获取音频</a></td>

                <td>
                    <a href="javascript:void(0)" data-src="./index.php?m=Home&c=Index&a=getpicture&id=<?php echo ($book["bookid"]); ?>" class="getpicture layui-btn layui-btn-sm">保存封面</a>
                    <a href="javascript:void(0)" data-src="./index.php?m=Home&c=Index&a=getpicturebyurl&id=<?php echo ($book["bookid"]); ?>" class="getpicturebyurl layui-btn layui-btn-sm">通过URL</a>
                    <a href="javascript:void(0)" data-src="./index.php?m=Home&c=Index&a=getpictureupload&id=<?php echo ($book["bookid"]); ?>" class="getpictureupload layui-btn layui-btn-sm">上传</a>
                </td>

                <td><?php echo ($book["originalurl"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>

<script>
    $(function(){
        $('#addbook').click(function(){

            layer.open({
                type: 2,
                title:'添加书本',
                content:'./index.php?m=Home&c=Index&a=addbook',
                area:["900px","500px"]

            });
        })


        $('.getdetail').click(function(){
            var url=$(this).attr('data-src');

            layer.open({
                type: 2,
                title:'获取书本信息',
                content:url,
                area:["900px","500px"]

            });
        })


        //保存图片
        $('.getpicture').click(function(){
            var url=$(this).attr('data-src');

            layer.open({
                type: 2,
                title:'获取书本封面图',
                content:url,
                area:["900px","500px"]

            });
        })


        //通过URL保存

        $('.getpicturebyurl').click(function(){
            var url=$(this).attr('data-src');

            layer.open({
                type: 2,
                title:'获取书本封面图通过URL',
                content:url,
                area:["900px","500px"]

            });
        })


        //直接上传图片

        $('.getpictureupload').click(function(){
            var url=$(this).attr('data-src');

            layer.open({
                type: 2,
                title:'上传封面图',
                content:url,
                area:["900px","500px"]

            });
        })


        //获取音频
        $('.getvoice').click(function(){
            var url=$(this).attr('data-src');

            layer.open({
                type: 2,
                title:'获取音频链接',
                content:url,
                area:["900px","500px"]

            });
        })

    })
</script>


</body>
</html>