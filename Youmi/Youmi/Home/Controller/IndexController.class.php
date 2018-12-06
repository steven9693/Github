<?php

namespace Home\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class IndexController extends Controller {


    public function setnav(){
        $map['isshow']=1;
        $category = M('wz_category')->where($map)->order('issort desc,cid desc')->select();
        return $category;
    }

    public function index(){

        $category=$this->setnav();
        $this->assign('category',$category);

        //顶部推荐的4本书
        $where['isshow']=1;
        $where['pctop']=1;
        $books = M('wz_books')->where($where)->limit(4)->select();

        //右侧经典推荐
        $wh['isshow']=1;
        $wh['pcrecommend']=1;
        $jingdian = M('wz_books')->where($wh)->limit(10)->select();
        
        if($jingdian){
            for($i=0;$i<count($category);$i++){
                for($k=0;$k<count($jingdian);$k++){
                    if($category[$i]['cid']==$jingdian[$k]['cid']){
                        $jingdian[$k]['category']=$category[$i]['category'];
                    }
                }
            }
        }
//        dump($jingdian);
        $this->assign('jingdian',$jingdian);

        $this->assign('books',$books);

        //分类推荐的书本
        $bookslists=$this->setblocklist();
        $this->assign('bookslists',$bookslists);

        //最近更新的书本
        $latestupdate = $this->latestupdate(false);
//        dump($latestupdate);
        $this->assign('latestupdate',$latestupdate);
        
        
        //最新入库书本
        $latestadd=$this->latestadd(false);
        $this->assign('latestadd',$latestadd);



        $this->assign('path',setpath());
        $this->assign('version',setversion());
        $this->display();
    }

    function setblocklist(){
        $cate = M('wz_category')->where(array('isshow'=>1))->order('issort desc')->limit(6)->select();

        if($cate){
            for($i=0;$i<count($cate);$i++){
                $map['cid']=$cate[$i]['cid'];
                $map['isshow']=1;
                //按照书本的ID排序
                $books=M('wz_books')->where($map)->limit(12)->order('bookid desc')->select();
                for($k=0;$k<count($books);$k++){
                    $chapter=M('wz_chapter')->field('title,chapterid')->where(array('bookid'=>$books[$k]['bookid']))->order('chapterid desc')->limit(1)->select();
                    $books[$k]['chapterid']=$chapter[0]['chapterid'];
                    $books[$k]['chaptertitle']=$chapter[0]['title'];

                }
                $cate[$i]['books']=$books;
            }
        }

//        dump($cate);

        return $cate;
    }


    //最近更新的书本
    function latestupdate($cid){

        $category=M('wz_category')->where(array('isshow'=>1))->select();

        $map['isshow']=1;
        
        if($cid){
            $map['cid']=$cid;
        }
        
        $books = M('wz_books')->where($map)->order('updatetime desc')->limit(30)->select();

        for($i=0;$i<count($books);$i++){

            for($k=0;$k<count($category);$k++){
                if($category[$k]['cid']==$books[$i]['cid']){
                    $books[$i]['category']=$category[$k]['category'];
                }
            }


            $where['bookid']=$books[$i]['bookid'];
            $where['isshow']=1;
            $chapter = M('wz_chapter')->field('chapterid,title,updatetime,bookid,isshow')->where($where)->order('updatetime desc')->find();
            $books[$i]['chapter_title']=$chapter['title'];
            $books[$i]['chapter_chapterid']=$chapter['chapterid'];
            $books[$i]['chapter_updatetime']=$chapter['updatetime'];
            $books[$i]['updatetime']=date('m-d',$books[$i]['updatetime']);
        }


//        dump($books);

        return $books;
    }

    function latestadd($cid){
        $map['isshow']=1;
        if($cid){
            $map['cid']=$cid;
        }
        
        $data = M('wz_books')->where($map)->order('bookid desc')->limit(30)->select();
        return $data;
    }

    function category(){
        
        $cid=I('get.cid');
        $map['cid']=$cid;
        
        
        $category=$this->setnav();
        $this->assign('category',$category);
        
        
        //分类顶部带封面书本
        $data = M('wz_books')->where($map)->limit(6)->select();
        $this->assign('data',$data);
        
        //分类最近更新
        $latestupdate=$this->latestupdate($cid);
        $this->assign('latestupdate',$latestupdate);
        
        
        //最新入库书本
        $latestadd=$this->latestadd($cid);
        $this->assign('latestadd',$latestadd);
        
        

        $this->assign('path',setpath());
        $this->assign('version',setversion());
        $this->display();
    }


    function book(){

        $bookid=I('get.bookid');

        $book=M('wz_books')->where(array('bookid'=>$bookid))->find();


        $book['updatetime']=date('Y-m-d H:i:s',$book['updatetime']);
        $this->assign('book',$book);

        $category=M('wz_category')->where(array('cid'=>$book['cid']))->find();
        $this->assign('category',$category);

        $map['bookid']=$book['bookid'];
        $map['isshow']=1;
        $chapter=M('wz_chapter')->field('bookid,chapterid,title,isshow,updatetime')->where($map)->order('chapterid asc')->select();
        $this->assign('chapter',$chapter);
        $this->assign('lastest',$chapter[(count($chapter)-1)]);

        $this->assign('path',setpath());
        $this->assign('version',setversion());
        $this->display();
    }

    function chapter(){

        $chapterid=I('chapterid');

        $map['chapterid']=$chapterid;
        $map['isshow']=1;

        $chapter = M('wz_chapter')->where($map)->find();

        $bookid=$chapter['bookid'];

        $book=M('wz_books')->where(array('bookid'=>$bookid))->find();
        $this->assign('book',$book);

        //下一集
        $nextpmap['bookid']=$bookid;
        $nextpmap['isshow']=1;
        $nextpmap['chapterid']=array('gt',$chapterid);
        $next=M('wz_chapter')->where($nextpmap)->limit(1)->select();
        if(!$next){
            $this->assign('nonext',1);
        }else{
            $this->assign('next',$next[0]);
        }


        //上一集
        $prepmap['bookid']=$bookid;
        $prepmap['isshow']=1;
        $prepmap['chapterid']=array('lt',$chapterid);
        $prep=M('wz_chapter')->where($prepmap)->order('chapterid desc')->limit(1)->select();
        if(!$prep){
            $this->assign('noprep',1);
        }else{
            $this->assign('prep',$prep[0]);
        }




        $this->assign('chapter',$chapter);


        $this->assign('path',setpath());
        $this->assign('version',setversion());
        $this->display();
    }


    function showdata(){
        header("Content-type: text/html; charset=utf-8");
        echo 'wz_books';
        $book=M('wz_books')->limit(1)->select();
        dump($book);
        echo 'wz_chapter';
        $book=M('wz_chapter')->limit(1)->select();
        dump($book);
        echo 'wz_category';
        $book=M('wz_category')->limit(1)->select();
        dump($book);
    }

    

    function setbooks(){
        M('wz_books')->where(array('isshow'=>0))->save(array('isshow'=>1,'ontime'=>time()));
    }



}
