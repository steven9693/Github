<?php
/**
 * Created by PhpStorm.
 * User: st
 * Date: 2018/7/10
 * Time: 0:19
 */

define("DOMAIN",'http://localhost/Github/');

function randtime(){
    return time();
}

function toindex(){
    return DOMAIN.'index.php';
}

//异步获取音频列表
function getvideolist(){
    return DOMAIN.'index.php?m=PC&c=Pc&a=getvideo';
}

//生成跳转到播放页的URL

function playerurl(){
    return DOMAIN.'index.php/video/';
}

