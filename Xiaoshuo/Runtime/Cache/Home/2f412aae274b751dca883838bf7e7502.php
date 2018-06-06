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


<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">有声小说后台管理</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <!--
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>-->
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    <?php echo ($username); ?>
                </a>
                <!--
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>-->
            </li>
            <li class="layui-nav-item"><a href="javascript:void(0)" class="loginout">退了</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:void(0);">ting56 有声小说</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:void(0);" class="change" data-url="./index.php?m=Home&c=Index&a=add">添加分类</a></dd>
                        <dd><a href="javascript:void(0);" class="change" data-url="./index.php?m=Home&c=Index&a=booklist">添加书本</a></dd>
                        <dd><a href="javascript:void(0);" class="change" data-url="">书本管理</a></dd>
                        <dd><a href="javascript:void(0)">书本</a></dd>
                    </dl>
                </li>
                <!--
                <li class="layui-nav-item">
                    <a href="javascript:;">解决方案</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;">列表一</a></dd>
                        <dd><a href="javascript:;">列表二</a></dd>
                        <dd><a href="">超链接</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="">云市场</a></li>
                <li class="layui-nav-item"><a href="">发布商品</a></li>
                -->
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;height:600px">
            <iframe height="100%" width="100%"  frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes" id="main" src="./index.php?m=Home&c=Index&a=add"></iframe>
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('.change').on('click',function(){
            var src = $(this).attr('data-url');
            $('#main').attr('src',src);
        })


        $('.loginout').on('click',function(){
            var href=window.location.href
            $.post(LOGINOUT,{},function(){
                window.location.href=href;
            })
        })


    })
</script>


</body>
</html>