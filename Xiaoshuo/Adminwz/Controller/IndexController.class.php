<?php

namespace Adminwz\Controller;
use Think\Controller;
use Pagenav\Pagenav;

header("Content-type: text/html; charset=utf-8");
class IndexController extends Controller {

    public function index(){

        $this->assign('path',setpath());
        $this->display();
    }

    public function category(){

        $data = M('wz_category')->order('issort desc')->select();

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
        $data['issort']=0;
        $data['ctime']=time();
        M('wz_category')->add($data);
        $res['status']=1;
        echo json_encode($res);
    }


    public function addbook(){

        $id=I('get.bookid');
        if($id){
            $book = M('wz_books')->where(array('bookid'=>$id))->find();

            $category = M('wz_category')->where(array('cid'=>$book['cid']))->find();

            $book['category']=$category['category'];

            $book['updatetime']=date('Y-m-d H:i:s',$book['updatetime']);

            $book['total']=M('wz_chapter')->where(array('bookid'=>$id))->count();

            $this->assign('book',$book);
        }

        $this->assign('path',setpath());
        $this->display();
    }

    public function search(){
        $bookname=I('post.bookname');

        $book = M('wz_books')->where(array('bookname'=>$bookname))->find();

        $res['status']=1;
        $res['data']=$book;
        echo json_encode($res);
    }

    //设置显示、隐藏
    public function setshow(){
        $isshow=I('post.isshow');
        $bookid=I('post.bookid');
        M('wz_books')->where(array('bookid'=>$bookid))->save(array('isshow'=>$isshow));
        echo json_encode(array('status'=>1));
    }

    //设置完结
    public function setover(){
        $isover=I('post.isover');
        $bookid=I('post.bookid');
        M('wz_books')->where(array('bookid'=>$bookid))->save(array('isover'=>$isover));
        echo json_encode(array('status'=>1));
    }


    //设置图片名称

    public function setpicture(){
        $picname=I('post.picname');
        $bookid=I('post.bookid');

        $data['cover']=$picname;
        M('wz_books')->where(array('bookid'=>$bookid))->save($data);
        echo json_encode(array('status'=>1));
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

        $exsit=M('wz_books')->where(array("def_bookid"=>$def_bookid))->find();

        if($exsit){
            echo json_encode(array('status'=>2));
        }else{
            $data['defurl']=$url;
            $data['def_bookid']=$def_bookid;
            $data['bookname']=$bookname;
            $data['ctime']=$ctime;
            $data['updatetime']=$ctime;
            $data['cid']=$category;
            M('wz_books')->add($data);
            echo json_encode(array('status'=>1));
        }



    }

    public function booklist(){

        $booklist = M("wz_books")->field('bookid,def_bookid,ctime,updatetime,isshow,bookname,isover,author')->order('bookid desc')->limit(10)->select();


        for($i=0;$i<count($booklist);$i++){
            $booklist[$i]['ctime']=date('Y-m-d',$booklist[$i]['ctime']);
            $booklist[$i]['updatetime']=date('Y-m-d',$booklist[$i]['updatetime']);
            $booklist[$i]['total'] = M('wz_chapter')->where(array('def_bookid'=>$booklist[$i]['def_bookid']))->count();
        }

        $this->assign('booklist',$booklist);

        $this->assign('path',setpath());
        $this->display();
    }



    public function setdetail(){

        $bookid=I('get.bookid');

        $book = M('wz_books')->where(array('bookid'=>$bookid))->find();

        $this->assign('book',$book);

        $this->assign('path',setpath());

        $this->display();
    }


    public function setdetailinfo(){

        $author=I('post.author');
        $description=I('post.description');
        $bookid=I('post.bookid');

        $data['author']=$author;
        $data['description']=$description;
        $data['updatetime']=time();

        M('wz_books')->where(array('bookid'=>$bookid))->save($data);
        echo json_encode(array('status'=>1));
    }



    public function setcategoryshow(){
        $isshow = I('post.isshow');
        $cid=I('post.cid');

        M('wz_category')->where(array('cid'=>$cid))->save(array('isshow'=>$isshow));

        echo json_encode(array('status'=>1));
    }



    public function setsort(){
        $cid=I('post.cid');
        $sort=I('post.sort');
        M('wz_category')->where(array('cid'=>$cid))->save(array("issort"=>$sort));
        echo json_encode(array('status'=>1));
    }









    public function getdetial(){

        $def_bookid=I('post.def_bookid');
        $def_chapterid=I('post.def_chapterid');
        $url='https://www.xbiquge6.com/'.$def_bookid.'/'.$def_chapterid.'.html';

        $data = curl($url,false,true,true);

        preg_match_all('/<div id=\"content\">(.*)<\/div>/',$data,$arr);

        $map['def_bookid']=$def_bookid;
        $map['def_chapterid']=$def_chapterid;

        $str = str_replace("&nbsp;" , " " , $arr[1][0]) ;

        $content['content']=$str;
        M('wz_chapter')->where($map)->save($content);

        $res['updatetime']=time();
        M('wz_books')->where(array('def_bookid'=>$def_bookid))->save($res);
        echo $str;

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

        // dump($res);

        $map['def_bookid']=$book['def_bookid'];

        $exsit=M('wz_chapter')->field('def_chapterid')->where($map)->select();

        $lasts = M('wz_chapter')->where($map)->order('chapterid desc')->limit(1)->select();


        $this->assign('lasts',$lasts);


        if($exsit){
            $exsitarr = array();
            for($k=0;$k<count($exsit);$k++){
                $exsitarr[]=$exsit[$k]['def_chapterid'];
            }

            // dump($exsitarr);

            $newdata = array();

            for($j=0;$j<count($res);$j++){
                //不存在数据库
                if(!in_array($res[$j]['def_chapterid'],$exsitarr)){ 
                    $newdata[]=$res[$j];
                }

                
            }

        }else{
            $newdata=$res;
        }


        $this->assign('liststr',json_encode($newdata));

        $this->assign('bookid',$id);

        $this->assign('lists',$newdata);

        $this->assign('path',setpath());

        $this->display();


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
                $item['content']='';
                M('wz_chapter')->add($item);
            }

            echo json_encode(array('status'=>1));
        }
    }

    //获取章节详情
    public function getcontent(){



//        $def_bookid = I('get.def_bookid');
//
//        if($def_bookid){
//            $map['def_bookid']=$def_bookid;
//        }
//
        $map['contempty']=array('eq',0);

        $data = M('wz_chapter')->where($map)->order('chapterid')->limit(30)->select();

        $this->assign('datastr',json_encode($data));
        $this->assign('data',$data);
        $this->assign('count',count($data));
        $this->assign('path',setpath());
        $this->display();
    }


    function latest(){

        $page=I('get.page')?(I('get.page')-1):0;

        $pagesize=10;

        $data=M('wz_books')->order('updatetime desc')->limit($pagesize*$page,$pagesize)->select();

        $pagenav=new Pagenav();

        $url="./index.php?m=Adminwz&c=Index&a=latest";

        $count=M('wz_books')->order('bookid desc')->count();


        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);

        if($data){
            for($i=0;$i<count($data);$i++){
                $data[$i]['updatetime']=date('Y-m-d H:i:s',$data[$i]['updatetime']);
            }
        }

        $this->assign('data',$data);
        $this->assign('page',$pagehtml);
        $this->assign('path',setpath());
        $this->display();
    }

    function chapterlist(){

        $page=I('get.page')?(I('get.page')-1):0;

        $def_bookid='77_77425';

        $pagesize=100;

        $data=M('wz_chapter')->field('chapterid,title,isshow,ctime,updatetime')->where(array('def_bookid'=>$def_bookid))->limit('100')->select();

        if($data){
            for($i=0;$i<count($data);$i++){
                $data[$i]['ctime']=date('Y-m-d H:i:s',$data[$i]['ctime']);
                if($data[$i]['updatetime']){
                    $data[$i]['updatetime']=date('Y-m-d H:i:s',$data[$i]['updatetime']);
                }

            }
        }
        $count=M('wz_chapter')->where(array('def_bookid'=>$def_bookid))->count();

        $pagenav=new Pagenav();

        $url="./index.php?m=Adminwz&c=Index&a=chapterlist";

        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);

        $this->assign('page',$pagehtml);

        $this->assign('data',$data);
        $this->assign('path',setpath());

        $this->display();
    }

    function getdetail(){

        $chapterid=I('get.id');

        $data=M('wz_chapter')->where(array('chapterid'=>$chapterid))->find();

        $this->assign('data',$data);

        $this->assign('path',setpath());

        $this->display();
    }



    function showdata(){
        $bookid=I('get.id');
        $data = M('wz_chapter')->where(array('def_bookid'=>$bookid))->select();
        dump($data);
    }




    function demo(){
        $data = M('wz_chapter')->where(array('def_bookid'=>'77_77425'))->order('chapterid desc')->limit(10)->select();
        echo M('wz_chapter')->getLastSql();
        dump($data);
    }





}
