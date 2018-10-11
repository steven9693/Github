<?php

namespace Adminwz\Controller;
use Think\Controller;

header("Content-type: text/html; charset=utf-8");
class IndexController extends Controller {

    public function index(){

        $this->assign('path',setpath());
        $this->display();
    }

    public function category(){

        $data = M('wz_category')->select();

        $this->assign('data',$data);

        $this->assign('path',setpath());
        $this->display();
    }

    public function addcategory(){

        $this->assign('path',setpath());
        $this->display();
    }

    public function additem(){
        $category = I('post.category');
        $data['category']=$category;
        $data['ctime']=time();
        M('wz_category')->add($data);
        $res['status']=1;
        echo json_encode($res);
    }


    public function addbook(){
        $this->assign('path',setpath());
        $this->display();
    }

    public function addbookinfo(){

        $category = M('wz_category')->select();

        $this->assign('category',$category);

        $this->assign('path',setpath());
        $this->display();
    }

    public function editbookinfo(){ //编辑书本信息
        $url = I('post.url');
        $def_bookid = I('post.def_bookid');
        $bookname = I('post.bookname');
        $category=I('post.category');
        $ctime=time();

        $data['defurl']=$url;
        $data['def_bookid']=$def_bookid;
        $data['bookname']=$bookname;
        $data['ctime']=$ctime;
        $data['	updatetime']=$ctime;
        $data['cid']=$category;

        M('wz_books')->add($data);

    }

    public function booklist(){

        $booklist = M("wz_books")->select();

        $this->assign('booklist',$booklist);

        $this->assign('path',setpath());
        $this->display();
    }







    public function getdetial(){

        $def_bookid=I('post.def_bookid');
        $def_chapterid=I('post.def_chapterid');
        $url='https://www.xxbiquge.com/'.$def_bookid.'/'.$def_chapterid.'.html';

        $data = curl($url,false,true,true);


        preg_match_all('/<div id=\"content\">(.*)<\/div>/',$data,$arr);

//        dump($arr);
//        echo '<textarea style="width:980px;height:500px">'.$arr[1][0].'</textarea>';

        $map['def_bookid']=$def_bookid;
        $map['def_chapterid']=$def_chapterid;

        $str = str_replace("&nbsp;" , " " , $arr[1][0]) ;

        $content['content']=$str;

        M('wz_chapter')->where($map)->save($content);
    }






    function lists(){

        $id=I('get.id');

        $book = M('wz_books')->where(array('bookid'=>$id))->find();

        $data =curl($book['defurl'],false,true,true);

        preg_match_all('/<dd>.*<\/dd>/',$data,$arr);

        $str = $arr[0][0];

        preg_match_all('/<a .*?<\/a>/is',$str,$strarr);

//        dump($strarr[0]);

        $res=array();

        if($strarr[0]){

            for($i=0;$i<count($strarr[0]);$i++){
                $item=array();
                $onestr=$strarr[0][$i];
                preg_match_all('/<a href="(.*)">(.*)<\/a>/is',$onestr,$result);
                $item['title']=$result[2][0];

                $str = str_replace('.html','',(str_replace('" class="empty','',$result[1][0])));

                $arr = (explode("/", $str));

//                $item[]=$result[1][0];
                $item['def_bookid']=$arr[1];
                $item['def_chapterid']=$arr[2];
                $res[]=$item;
            }
        }

//        echo json_encode($res);
//        dump($res);

        $this->assign('liststr',json_encode($res));

        $this->assign('bookid',$id);

        $this->assign('lists',$res);

        $this->assign('path',setpath());
        $this->display();


//        $onestr  =$strarr[0][0];
//        echo $onestr;

//        preg_match_all('/<a href="(.*)">(.*)<\/a>/is',$onestr,$result);
//
//        dump($result);
//
//        $res = $result[1][0];
//
////        echo $res;
//
//        $resarr  =explode(" ", $res);
//
//        echo str_replace('"','',$resarr[0]);
//
//        echo '<textarea style="width:980px;height:500px">'.$strarr[0][0].'</textarea>';

    }

    public function savelist(){

        $lists=I('post.lists');
        $bookid=I('post.bookid');

        $lists = htmlspecialchars_decode($lists);

        $listsarr = json_decode($lists,true);

//         htmlspecialchars($listsarr);

        if($listsarr){
            for($i=0;$i<count($listsarr);$i++){
                $item['bookid']=$bookid;
                $item['def_bookid']=$listsarr[$i]['def_bookid'];
                $item['def_chapterid']=$listsarr[$i]['def_chapterid'];
                $item['ctime']=time();
                $item['title']=$listsarr[$i]['title'];
                M('wz_chapter')->add($item);
            }

            echo json_encode(array('status'=>1));
        }
    }

    //获取章节详情
    public function getcontent(){

        $def_bookid = I('get.def_bookid');

        if($def_bookid){
            $map['def_bookid']=$def_bookid;
        }

        $map['content']=array('eq','');

        $data = M('wz_chapter')->where($map)->select();

        $this->assign('datastr',json_encode($data));
        $this->assign('data',$data);
        $this->assign('path',setpath());
        $this->display();
    }





}
