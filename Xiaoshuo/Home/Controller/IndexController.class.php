<?php
namespace Home\Controller;
use Think\Controller;

use QL\QueryList;

header("Content-Type:text/html;charset=UTF-8");

class IndexController extends Controller {

    //首页
    public function index(){

        $this->display();

    }

    //添加分类
    public function add(){
        $category=M('category')->order('category_id desc')->select();
        $this->assign('category',$category);
        $this->display();
    }


    //添加书本分类
    public function addcatogary(){

        $title=I('post.title');

        $data['name']=$title;
        $data['ctime']=time();

        $id=M('category')->add($data);

        $result['status']=1;
        $result['data']=array('id'=>$id);
        echo json_encode($result);
    }





    //添加书本
    public function addbook(){

        $category=M('category')->order('category_id desc')->select();

        $this->assign('category',$category);

        $this->display();
    }


    //保存书本信息
    public function setbook(){

        $bookname=I('post.bookname');
        $url=I('post.url');
        $category=I('post.category');
        $setid=I('post.setid');
        $time=time();

        $data['bookname']=$bookname;
        $data['originalurl']=$url;
        $data['category_id']=$category;
        $data['ctime']=$time;
        $data['setid']=$setid;
        $data['lastupdate']=$time;

        //判端是否已经添加了该书本
        $isbook=M('books')->where(array('setid'=>$setid))->find();


        if($isbook){ //已经添加了
            $result['status']=2;
            echo json_encode($result);
        }else{
            $id=M('books')->add($data);
            $result['status']=1;
            echo json_encode($result);
        }



    }


    public function booklist(){

        $data=M('books')->order('bookid desc')->select();

        $this->assign('books',$data);

        $this->display();
    }


    public function getbook(){

        $id=I('get.id');

        $book=M('books')->where(array('bookid'=>$id))->find();

        $url=$book['originalurl'];

        $rules=array(
            'content'=>array('div.jj','text'),
            'author'=>array('div.zz','text')
        );

        $data = QueryList::Query($url,$rules,'','UTF-8','GB2312')->getData();

        $info= $data[1]['content'];

        $msg=$data[0]['author'];

        $this->assign('info',$info);
        $this->assign('msg',$msg);
        $this->assign('id',$id);

        $this->display();
    }


    //保存书本信息
    public function updatebook(){

        $id=I('post.id');
        $author=I('post.author');
        $voice=I('post.voice');
        $description=I('post.description');

        $data['description']=$description;
        $data['author']=$author;
        $data['bojiang']=$voice;

        //M('books')->where(array('bookid'=>$id))->save($data);

        $result['status']=1;

        echo json_encode($result);

    }



    //书本封面图
    public function getpicture(){


        $id=I('get.id');

        $book=M('books')->where(array('bookid'=>$id))->find();
        //dump($book);
        $url=$book['originalurl'];

        $rules=array(
            'src'=>array('.r-img img','src')
        );

        $data = QueryList::Query($url,$rules)->getData();
        //dump($data);
        $this->assign('src', $data[0]['src']);

        $this->display();
    }

    public function getpicturebyurl(){

        $this->display();
    }


    public function getpictureuplaod(){

        $this->display();
    }



}