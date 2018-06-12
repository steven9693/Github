<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller {


    public function index(){

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        //今日推荐
        $todayrecommend=M('books')->where(array('isshow'=>1,'todayrecommend'=>1))->order('issort desc,bookid desc')->limit(3)->select();

        //玄幻武侠
        $xh=M('books')->where(array('isshow'=>1,'category_id'=>1))->order('issort desc,bookid desc')->limit(10)->select();
        $xuanhuan=$this->getCategory($xh,$category);


        $this->assign('todayrecommend',$todayrecommend);

        $this->assign('xuanhuan',$xuanhuan);

        $this->assign('category',$category);



        $this->assign('random',$this->setrandom());
        $this->display();
    }

    public function getCategory($da,$ca){
        for($i=0;$i<count($da);$i++){
            for($j=0;$j<count($ca);$j++){
                if($da[$i]['category_id']==$ca[$j]['category_id']){
                    $da[$i]['category']=$ca[$j]['name'];
                }
            }
        }
        return $da;
    }


    public function categorytime(){

        $this->assign('random',$this->setrandom());
        $this->display();
    }





    public function setrandom(){
        return time();
    }
}