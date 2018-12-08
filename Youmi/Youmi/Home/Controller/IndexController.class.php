<?php

namespace Home\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
class IndexController extends Controller {
    
    public $webname='悠米小说_书友最值得收藏的网络小说阅读网_网络小说_小说爱好者必备的小说网_我爱看小说';
    public $keywords='悠米小说,网络小说,小说阅读网,88读书网,顶点小说,在线阅读,在线阅读小说,小说阅读,最新小说';
    public $description='小说爱好者最喜欢的小说阅读网,收录了当前最火热的网络小说,免费为您提供小说在线阅读服务,免费提供高质量的小说最新章节，是广大网络小说爱好者必备的小说阅读网。';

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
        
        $this->assign('current','isindex');

        $this->assign('domain',setdomain());
        $this->assign('path',setpath());
        $this->assign('version',setversion());
        
        $this->assign('webname',$this->webname);
        $this->assign('keywords',$this->keywords);
        $this->assign('description',$this->description);
        
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
        
        if($category){
            for($i=0;$i<count($category);$i++){
                if($cid==$category[$i]['cid']){
                    $currentCategory=$category[$i]['category'];
                }
            }
        }
        //分类顶部带封面书本
        $data = M('wz_books')->where($map)->limit(6)->select();
        $this->assign('data',$data);
        
        //分类最近更新
        $latestupdate=$this->latestupdate($cid);
        $this->assign('latestupdate',$latestupdate);
        
        
        //最新入库书本
        $latestadd=$this->latestadd($cid);
        $this->assign('latestadd',$latestadd);
        
        $this->assign('current',$cid);
        $this->assign('domain',setdomain());
        $this->assign('path',setpath());
        $this->assign('version',setversion());
        
        $webname=$currentCategory.'小说_'.'我爱看'.$currentCategory.'小说_'.'悠米小说';
        $keywords=$currentCategory.'小说,免费小说,网络小说,88读书网,顶点小说,在线阅读,在线阅读小说,小说阅读,最新小说';
        $description="悠米小说".$currentCategory."频道，汇集".$currentCategory."精品小说，收录了当前最火热的网络小说,免费为您提供".$currentCategory."小说在线阅读服务,免费提供高质量的小说最新章节，";
        $this->assign('webname',$webname);
        $this->assign('keywords',$keywords);
        $this->assign('description',$description);
        
        $this->assign('currentCategory',$currentCategory);
        
        $this->display();
    }


    function book(){

        $bookid=I('get.bookid');

        $book=M('wz_books')->where(array('bookid'=>$bookid))->find();
        
        $book['updatetime']=date('Y-m-d H:i:s',$book['updatetime']);
        $this->assign('book',$book);

        $xclass=M('wz_category')->where(array('cid'=>$book['cid']))->find();
        $this->assign('xclass',$xclass);
//        dump($xclass);

        $map['bookid']=$book['bookid'];
        $map['isshow']=1;
        $chapter=M('wz_chapter')->field('bookid,chapterid,title,isshow,updatetime')->where($map)->order('chapterid asc')->select();
        $this->assign('chapter',$chapter);
        $this->assign('lastest',$chapter[(count($chapter)-1)]);
        
        $category=$this->setnav();
        $this->assign('category',$category);
        
        $this->assign('domain',setdomain());
        
        $this->assign('current',$book['cid']);
        
        $this->assign('path',setpath());
        $this->assign('version',setversion());
        
        $webname=$book['bookname']."最新章节_".$book['bookname']."全文阅读_".$book['bookname']."新章节目录_悠米小说";
        $keywords=$book['bookname']."最新章节,".$book['bookname']."全文阅读,".$book['bookname']."新章节目录,".$book['bookname'].','.$book['bookname'].'作者'.$book['author'];
        $description=$book['bookname']."最新章节由网友提供,".$book['description'];
        $this->assign('webname',$webname);
        $this->assign('keywords',$keywords);
        $this->assign('description',$this->trimall($description));
        
        
        
        
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
        
        //查询推荐的书本当前的推荐方式是同类书本相邻的5本书
        $where['cid']=$book['cid'];
        $where['isshow']=1;
        $where['bookid']=array('lt',$book['bookid']);
        $recom = M('wz_books')->where($where)->order('bookid desc')->limit(5)->select();
        if(count($recom)<5){
            $where['bookid']=array('gt',$book['bookid']);
            $recom = M('wz_books')->where($where)->order('bookid desc')->limit(5)->select();
        }
        $this->assign('recom',$recom);
//        dump($recom);
        
        $xclass=M('wz_category')->where(array('cid'=>$book['cid']))->find();
        $this->assign('xclass',$xclass);
        
        $this->assign('current',$xclass['cid']);
        
        $category=$this->setnav();
        $this->assign('category',$category);
        $this->assign('domain',setdomain());

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
        
        
        
        $webname=$chapter['title'].'_'.$book['bookname'].'_'.$xclass['category'].'_悠米小说';
        $keywords=$chapter['title'].','.$xclass['category'].'小说'.$book['bookname'].','.$book['bookname'].'作者'.$book['author'];
        $this->assign('webname',$webname);
        $this->assign('keywords',$keywords);
        
        $content=$this->trimall($chapter['content']);
        $content=$book['bookname'].'作者'.$book['author'].' '.$chapter['title'].','.mb_substr($content,0,80,'UTF-8').'...';
        $this->assign('description',$content);
        
        
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
    
    //查找书本
    function search(){
        
        $bookname=I('get.bookname');
        
        $where['bookname'] = array('like','%'.$bookname.'%');
        $where['isshow']=1;
        $data = M('wz_books')->where($where)->order('bookid desc')->limit(10)->select();
        if($data){
            //找到当前书本
            for($i=0;$i<count($data);$i++){
                $data[$i]['updatetime']=date('Y-m-d H:i:s',$data[$i]['updatetime']);
                $map['bookid']=$data[$i]['bookid'];
                $map['isshow']=1;
                $item = M('wz_chapter')->field('title,chapterid')->where($map)->limit(1)->order('chapterid desc')->select();
                $data[$i]['chapter_title']=$item[0]['title'];
                $data[$i]['chapter_chapterid']=$item[0]['chapterid'];
            }
            $this->assign('isfind',1);
            $this->assign('data',$data);
            
        }else{
            $this->assign('bookname',$bookname);
            $str=mb_substr($bookname, 0, 1, 'utf-8');
            
            $wh['bookname'] = array('like','%'.$str.'%');
            $wh['isshow']=1;
            $redata = M('wz_books')->where($wh)->order('bookid desc')->limit(10)->select();
            if($redata){
                $this->assign('redata',$redata);
                $this->assign('isfind',2); //可以推荐
            }else{
                $this->assign('isfind',0); //没有推荐的
            }
            
        }
        
        
        
        
        $category=$this->setnav();
        $this->assign('category',$category);
        
        $this->assign('path',setpath());
        $this->assign('version',setversion());
        $this->display();
    }
    
    function trimall($str){
        $qian=array(" ","　","\t","\n","\r","<br>","<br/>");
        return str_replace($qian, '', $str);   
    }



}
