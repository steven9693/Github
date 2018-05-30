<?php
namespace Home\Controller;
use Think\Controller;

use QL\QueryList;


class IndexController extends Controller {


    public function index(){


        $this->display();

    }


    public function add(){
        $data=M('category')->order('category_id desc')->select();
        //dump($data);
        $this->display();
//      echo json_encode($data);
    }



    public function addcatogary(){

        $title=I('post.title');

        $data['name']=$title;
        $data['ctime']=time();

        $id=M('category')->add($data);

        echo $id;
    }
}