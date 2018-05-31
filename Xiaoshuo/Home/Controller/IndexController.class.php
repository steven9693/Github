<?php
namespace Home\Controller;
use Think\Controller;

use QL\QueryList;

header("Content-Type:text/html;charset=UTF-8");

class IndexController extends Controller {


    public function index(){


        $this->display();

    }









    public function addbook(){
        $this->display();
    }



    public function add(){
        $bookname=I('post.bookname');
        $url=I('post.url');
        $catogary=I('post.catogary');

        $data['bookname']=$bookname;
        $data['originalurl']=$url;
        $data['catogary_id']=$catogary;
        $data['ctime']=time();

        M('books')->add($data);
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



    public function updatebook(){

        $id=I('post.id');
        $author=I('post.author');
        $voice=I('post.voice');
        $description=I('post.description');

        $data['description']=$description;
        $data['author']=$author;
        $data['bojiang']=$voice;

        M('books')->where(array('bookid'=>$id))->save($data);

    }



}