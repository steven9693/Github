<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,initial-scale=1.0,width=device-width" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
<title>无标题文档</title>
    <script type="text/javascript" src="./Home/View/js/zepto.min.js"></script>
    <script type="text/javascript" src="./Home/View/js/html2canvas.min.js"></script>
    <script type="text/javascript" src="./Home/View/js/canvas2image.js"></script>
</head>
<style>
    *{margin:0;padding:0}
    .main{width:280px;margin:0 auto}
    .header{min-height:32px;line-height:32px;font-size:14px;color:#04569A}
    .area img{display:block;width:280px;}


</style>
<body>

    <div class="main" id="main">
        <div class="header">这是一个测试标题</div>
        <div class="area">
            <img src="./Home/View/images/1.jpg">
        </div>
    </div>
    <a href="javascript:void(0)" id="create" >生成图片</a>

</body>

<script>
    $(function(){
        $('#create').click(function(){
            convert2canvas()

        })







        function convert2canvas() {

            var cntElem = $('#main')[0];

            var shareContent = cntElem;//需要截图的包裹的（原生的）DOM 对象
            var width = shareContent.offsetWidth; //获取dom 宽度
            var height = shareContent.offsetHeight; //获取dom 高度
            var canvas = document.createElement("canvas"); //创建一个canvas节点
            var scale = 2; //定义任意放大倍数 支持小数
            canvas.width = width * scale; //定义canvas 宽度 * 缩放
            canvas.height = height * scale; //定义canvas高度 *缩放
            canvas.getContext("2d").scale(scale, scale); //获取context,设置scale
            var opts = {
                scale: scale, // 添加的scale 参数
                canvas: canvas, //自定义 canvas
                // logging: true, //日志开关，便于查看html2canvas的内部执行流程
                width: width, //dom 原始宽度
                height: height,
                useCORS: true // 【重要】开启跨域配置
            };

            html2canvas(shareContent, opts).then(function (canvas) {

                var context = canvas.getContext('2d');
                // 【重要】关闭抗锯齿
                context.mozImageSmoothingEnabled = false;
                context.webkitImageSmoothingEnabled = false;
                context.msImageSmoothingEnabled = false;
                context.imageSmoothingEnabled = false;

                /*
                // 【重要】默认转化的格式为png,也可设置为其他格式
                var img = Canvas2Image.convertToJPEG(canvas, canvas.width, canvas.height);

                document.body.appendChild(img);

                $(img).css({
                    "width": canvas.width / 2 + "px",
                    "height": canvas.height / 2 + "px",
                }).addClass('f-full');
                */




                /*
                var image = new Image();
                image.style.cssText="width:"+(canvas.width/2)+'px;height:'+(canvas.height/2)+'px'
                image.src = canvas.toDataURL("image/png");
                document.body.appendChild(image);
                */

                var img=Canvas2Image.saveAsPNG(canvas, true,canvas.width/2,canvas.height/2);
                document.body.appendChild(img)

            });
        }


    })
</script>
</html>