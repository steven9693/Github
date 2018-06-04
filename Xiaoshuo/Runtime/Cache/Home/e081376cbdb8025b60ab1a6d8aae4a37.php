<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="./Home/View/js/jquery-1.11.1.min.js"></script>
    <link href="./Home/View/css/global.css" rel="stylesheet">
    <link href="./Home/View/layui/css/layui.css" rel="stylesheet">
    <script src="./Home/View/layui/layui.all.js"></script>
    <script src="./Home/View/js/urls.js?v=2"></script>
    <script src="./Home/View/js/doT.js"></script>
</head>
<body>

<!--
<blockquote class="layui-elem-quote">设置书本ID</blockquote>
<hr class="layui-bg-green">
<div class="layui-form" style="padding:20px">
    <div class="layui-form-item">
        <label class="layui-form-label">设置书本ID</label>
        <div class="layui-input-inline">
            <input type="text" name="setid" required  lay-verify="required" placeholder="设置对应的书本ID" autocomplete="off" class="layui-input" value="<?php echo ($setid); ?>">
        </div>
        <?php if($setid == ''||$setid == 0): ?><div class="layui-input-inline">
            <button class="layui-btn" lay-submit lay-filter="formDemo">保存</button>
        </div><?php endif; ?>
    </div>
</div>
-->

<div class="layui-form" style="padding:20px">

    <table class="layui-table">
        <colgroup>
            <col width="80">
            <col width="200">
        </colgroup>
        <thead>
            <tr>
                <th>最后一集</th>
                <th>最后一集音频链接</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?php echo ($defindex); ?></td>
                <td><?php echo ($voice); ?></td>
            </tr>
        </tbody>


    </table>



    <div class="layui-form-item">
        <label class="layui-form-label">起始集</label>
        <div class="layui-input-block">
            <input type="text" name="start" required  lay-verify="required" placeholder="设置对应的书本ID" autocomplete="off" class="layui-input" value="0">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">结束集</label>
        <div class="layui-input-block">
            <input type="text" name="end" required  lay-verify="required" placeholder="设置对应的书本ID" autocomplete="off" class="layui-input" value="0">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="getData">获取数据</button>
        </div>
    </div>
</div>


<script type="text/javascript">

    layui.use('form', function() {
        var form = layui.form;
        //
        // form.on('submit(formDemo)', function (data) {
        //
        //     var setid="<?php echo ($setid); ?>";
        //     data.field.setid=setid;
        //     $.post(SETBOOKID,data.field,function(){
        //
        //     },'json')
        //
        //     return false;
        // });
        //



        //获取页面数据
        form.on('submit(getData)', function (data) {
            var loading=layer.load();
            var setid="<?php echo ($setid); ?>";
            data.field.setid=setid;
            console.log(data.field)
            $.post(GETDATA,data.field,function(ret){

                console.log(ret);
                var voiceTemp = $('#voiceTemp').html();
                var temp = doT.template(voiceTemp);
                $('#urlarea').html(temp(ret));
                window.ret=ret;
                layer.close(loading);
            },'json')


            return false;
        });
    })
</script>


</body>

<div id="urlarea">

</div>


<script id="voiceTemp" type="text/x-dot-template">

    <table class="layui-table">
        <colgroup>
            <col width="50">
            <col width="200">

        </colgroup>
        <thead>
        <tr>
            <th>集数</th>
            <th>音频链接</th>
        </tr>
        </thead>
        <tbody>
        {{ for(var prop in it) { }}
            <tr>
                <td>{{=it[prop]['index']}}</td>
                <td>{{=it[prop]['voice']}}</td>
            </tr>
        {{ } }}

        <tr>
            <td colspan="2"><a href="javascript:void(0)" class="layui-btn js-save">保存数据</a></td>
        </tr>

        </tbody>
    </table>


</script>

<script>
    $(function(){
        $(document).on('click','.js-save',function(){
            console.log(window.ret)
            var args={}
            args['setid']="<?php echo ($setid); ?>";
            args['bookid']="<?php echo ($bookid); ?>"
            args['data']=JSON.stringify(window.ret);
            var href=window.location.href;
            $.post(SAVEVOICE,args,function(data){
                if(data.status==1){
                    window.location.href=href;
                }
            },"json")
        })
    })
</script>

</html>