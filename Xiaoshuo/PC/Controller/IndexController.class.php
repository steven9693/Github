<?php
namespace PC\Controller;
use Think\Controller;



class IndexController extends Controller {

    public $path='/Github/Xiaoshuo';

    public function setpath(){
        $this->assign('path',$this->path);
    }

    public function index(){


        $this->setpath();

        $this->assign('version',randtime());
        $this->display();

    }



    public function category(){

        $this->setpath();

        $this->assign('version',randtime());
        $this->display();
    }
}