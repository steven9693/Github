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
        $data = QueryList::Query('http://www.ting56.com/mp3/8256.html', array('href' => array('#vlink_1 a','href')),'','UTF-8','GB2312')->data;
        //打印结果

        $result=array();

        for($i=0;$i<2;$i++){
            $result[]=QueryList::Query('http://www.ting56.com'.$data[$i]['href'], array('href' => array('script','html')),'','UTF-8','GB2312')->getData(function($item){
                if($item['href']!=''){
                    return $item['href'];
                }
            });
        }

        dump($result);

    }
}