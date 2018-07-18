<?php
namespace PC\Controller;
use Think\Controller;
use Pagenav\Pagenav;

class PcController extends Controller {

    public $path='/Github/Xiaoshuo';

    public function setpath(){
        $this->assign('path',$this->path);
    }

    //首页
    public function index(){


        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);


        //返回当前所有的分类
        $category=$this->getallcate();

        //最近更新
        $lastupdate = M('books')->where(array('isshow'=>1))->order('lastupdate desc')->limit(16)->select();
        if($lastupdate){
            for($i=0;$i<count($lastupdate);$i++){
                for($j=0;$j<count($category);$j++){
                    if($lastupdate[$i]['category_id']==$category[$j]['category_id']){
                        $lastupdate[$i]['category']=$category[$j]['name'];
                    }
                }
            }


            for($k=0;$k<count($lastupdate);$k++){
                $bookid=$lastupdate[$k]['bookid'];
                $count=M('voicelist')->where(array('bookid'=>$bookid))->count();
                $lastupdate[$k]['count']=$count;
            }
        }


        //获取玄幻武侠分类
        $this->assign('wuxia',$this->getcategorybook(1));

        //获取都市言情分类
        $this->assign('dushi',$this->getcategorybook(2));


        $friend = M('friend')->where(array('isshow'=>1))->select();
        $this->assign('friend',$friend);


        $this->assign('lastupdate',$lastupdate);

        $this->setpath();
        $this->assign('version',randtime());
        $this->display();


    }

    //获取分类

    public function getcategorybook($category_id,$pagesize=16,$page=0){
        //$category_id=1;
        $cate = M('category')->where(array('category_id'=>$category_id))->find();
        $where['category_id']=$category_id;
        $where['isshow']=1;
        $books=M('books')->where($where)->order('todayrecommendsort desc , todayrecommend desc,lastupdate desc')->limit($pagesize*$page,$pagesize)->select();

        if($books){
            for($i=0;$i<count($books);$i++){
                $books[$i]['category']=$cate['name'];
            }

            for($k=0;$k<count($books);$k++){
                $bookid=$books[$k]['bookid'];
                $count = M('voicelist')->where(array('bookid'=>$bookid))->count();
                $books[$k]['count']=$count;
            }
        }
        return $books;
    }

    //获取并返回所有的分类

    public function getallcate(){
        $where['isshow']=1;
        $data = M('category')->where($where)->order('category_id desc')->select();
        return $data;
    }


    //分类
    public function category(){

        $category_id=I('get.cid');
        $page=I('get.page')?I('get.page')-1 : 0;

        $pagenav=new Pagenav();
        $url="./index.php?m=Home&c=Pc&a=booklist";
        $count=M('books')->where(array('category_id'=>$category_id))->count();
        $pagesize=10;
        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);
        $this->assign('pagenav',$pagehtml);

        //生成当前分类信息
        $category = M('category')->where(array('category_id'=>$category_id))->find();
        $this->assign('category',$category);

        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);


        $categorybooks = $this->getcategorybook($category_id,$pagesize,$page);
        $this->assign('categorybooks',$categorybooks);


        $this->setpath();
        $this->assign('version',randtime());
        $this->display();


    }


    //书本详情
    public function book(){

        $bookid=I('bid');

        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);

        $book = M('books')->where(array('bookid'=>$bookid))->find();
        $this->assign('book',$book);

        $category_id=$book['category_id'];
        $category=M('category')->where(array('category_id'=>$category_id))->find();

        $this->assign('category',$category);

        $this->setpath();

        $this->assign('version',randtime());
        $this->display();
    }


    //播放页面
    public function player(){

        $arg=I('get.id');
        $args=explode('-',$arg);
        $bookid=$args[0];
        $voiceid=$args[2];


        M('books')->where(array('bookid'=>$bookid))->find();
        $book = M('books')->where(array('bookid'=>$bookid))->find();
        $this->assign('book',$book);

        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);


        $category_id=$book['category_id'];
        $category=M('category')->where(array('category_id'=>$category_id))->find();
        $this->assign('category',$category);

        $this->assign('voiceid',$voiceid);

        //大家都在听
        $listen = $this->alllisten($category_id,10);
        $this->assign('listen',$listen);


        $this->setpath();
        $this->assign('version',randtime());
        $this->display();
    }


    //设置大家都在听

    public function alllisten($category_id,$pagesize){
        //$category_id=1;
        $data = M('books')->where(array('category_id'=>$category_id))->order('lastupdate desc')->limit($pagesize)->select();
        if($data){
            for($i=0;$i<count($data);$i++){
                $count = M('voicelist')->where(array('bookid'=>$data[$i]['bookid']))->count();
                $data[$i]['count']=$count;
            }
        }
        return $data;
    }


    //设置分类导航
    public function getnav(){
        $where=array('isshow'=>1);
        $data = M('category')->where($where)->order('issort desc,category_id desc')->select();
        return $data;
    }




}