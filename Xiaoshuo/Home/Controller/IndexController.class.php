<?php
namespace Home\Controller;
use Think\Controller;

use QL\QueryList;


class IndexController extends Controller {

    public function test(){
        echo I('get.id');
        $this->display();
    }


    public function index(){

        //采集某页面所有的超链接
        $data = QueryList::Query('http://www.woaitingshu.com/video/16160-0-1.html', array('href' => array('script','html')),'','UTF-8','GB2312')->data;
        //打印结果
        dump($data);
    }
}