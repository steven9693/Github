<?php
namespace PC\Controller;
use Think\Controller;
use Pagenav\Pagenav;


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


        $pagenav=new Pagenav();

        $url="./index.php?m=Home&c=Index&a=booklist";

        $count=100;

        $pagesize=10;

        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);

        $this->assign('pagenav',$pagehtml);

        $this->setpath();

        $this->assign('version',randtime());
        $this->display();
    }

    public function book(){







        $this->setpath();

        $this->assign('version',randtime());
        $this->display();
    }


}