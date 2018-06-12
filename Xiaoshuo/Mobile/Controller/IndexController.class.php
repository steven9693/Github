<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller {


    public function index(){
        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        //今日推荐
        $todayrecommend=M('books')->where(array('isshow'=>1,'todayrecommend'=>1))->order('issort desc,bookid desc')->limit(3)->select();

        //玄幻武侠
        $xuanhuan=M('books')->where(array('isshow'=>1,'category'=>38))->order('issort desc,bookid desc')->limit(3)->select();

        $this->assign('todayrecommend',$todayrecommend);

        $this->assign('xuanhuan',$xuanhuan);
        $this->assign('category',$category);

        $this->assign('random',$this->setrandom());
        $this->display();
    }


    public function categorytime(){

        $this->assign('random',$this->setrandom());
        $this->display();
    }





    public function setrandom(){
        return time();
    }
}