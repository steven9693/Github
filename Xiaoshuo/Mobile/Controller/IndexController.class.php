<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller {


    public function index(){

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        //今日推荐
        $todayrecommend=M('books')->where(array('isshow'=>1,'todayrecommend'=>1))->order('todayrecommendsort desc,bookid desc')->limit(3)->select();

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

//        $category_id=I('get.cid'); //获取分类ID
        $category_id=1;

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();


        $map['isshow']=1;
        $map['category_id']=$category_id;

        $da=M('books')->where($map)->order('lastupdate desc')->select();

        $data=$this->getCategory($da,$category);

        $this->assign('data',$data);

        $this->assign('category',$category);

        $this->assign('random',$this->setrandom());
        $this->display();
    }



    public function book(){

        $bookid=3;

        $book=M('books')->where(array('bookid'=>$bookid))->find();

        $this->assign('book',$book);

//        dump($book);

        $count=M('voicelist')->where(array('bookid'=>$bookid))->count();

        $this->assign('count',$count);

        $this->assign('bookid',$bookid);

        $this->assign('random',$this->setrandom());




        $this->display();
    }



    public function play(){


        $data=M('voicelist')->where(array('voiceid'=>5))->find();
        $this->assign('data',$data);

        $this->assign('random',$this->setrandom());

        $this->display();
    }





    public function setrandom(){
        return time();
    }
}