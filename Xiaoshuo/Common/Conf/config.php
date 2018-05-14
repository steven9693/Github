<?php
return array(
	//'配置项'=>'配置值'



    //配置路由
    'URL_ROUTER_ON'   => true,

    'MODULE_ALLOW_LIST' => array('Home','Admin','Common'),
    //'DEFAULT_MODULE'       =>    'Home',  // 默认模块
    //'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    //'DEFAULT_ACTION'        =>  'index', // 默认操作名称

    //配置静态路由
    'URL_ROUTE_RULES'=>array(
        '/^book-(\d+)$/' => 'Index/test?id=:1'
    ),

    //伪静态
    'URL_HTML_SUFFIX' =>'html'

);