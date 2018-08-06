<?php
return array(
	//'配置项'=>'配置值'

    //数据库配置信息

    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'xiaoshuo', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增


    //配置路由
    'URL_ROUTER_ON'   => true,

    'MODULE_ALLOW_LIST' => array('Home','PC','Mobile'),
    'DEFAULT_MODULE'       =>'PC',  // 默认模块
    //'DEFAULT_CONTROLLER'    =>  'Pc', // 默认控制器名称
    //'DEFAULT_ACTION'        =>  'index', // 默认操作名称

    //配置静态路由
    'URL_ROUTE_RULES'=>array(

        //移动端路由
        'mindex'=>'Mobile/Index/index',
        'book/:id'=>'Mobile/Index/book',
        'categorytime/:cid'=>'Mobile/Index/categorytime',
		'play/:id'=>'Mobile/Index/play',
        'search'=>'Mobile/Index/search',

        //PC上的路由
        'index'=>'PC/Pc/index',
        'cate/:cid'=>'PC/Pc/category',
        'mp3/:bid'=>'PC/Pc/book',
        'video/:id'=>'PC/Pc/player',
        'search'=>'PC/Pc/search'
    ),

    //伪静态
    'URL_HTML_SUFFIX' =>'html'

);

