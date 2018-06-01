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
    .wrap{padding:20px 50px 0}
</style>

<div class="wrap">
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">书名</label>
            <div class="layui-input-block">
                <input type="text" name="bookname" required  lay-verify="required" placeholder="书名" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">网址</label>
            <div class="layui-input-block">
                <input type="text" name="url" required  lay-verify="required" placeholder="原始URL" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">选择框</label>

            <div class="layui-input-block">
                <select id="edit_exam_school" name="catogary" lay-verify="required">
                    <option value="">选择分类</option>
                    <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["category_id"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
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
</div>

<script>
    layui.use('form', function(){
        var form = layui.form;
        form.render('select');

        //监听提交
        form.on('submit(formDemo)', function(data){
            // layer.msg(JSON.stringify(data.field));

            console.log(SETBOOK)
            $.post(SETBOOK,data.field,function(data){
                console.log(data)
            },'json')

            return false;
        });


    })
</script>

</body>
</html>