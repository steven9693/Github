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

        if($book){
            $res['status']=1;
            $res['data']=$book;
        }else{
            $res['status']=0;
        }

        echo json_encode($res);
    }

    //设置显示、隐藏
    public function setshow(){
        $isshow=I('post.isshow');
        $bookid=I('post.bookid');

        $data['isshow']=$isshow;
        $data['ontime']=time();

        M('wz_books')->where(array('bookid'=>$bookid))->save($data);
        echo json_encode(array('status'=>1));
    }

    //设置完结
    public function setover(){
        $isover=I('post.isover');
        $bookid=I('post.bookid');
        M('wz_books')->where(array('bookid'=>$bookid))->save(array('isover'=>$isover));
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

        $page=I('get.page')?(I('get.page')-1):0;

        $pagesize=10;


        $booklist = M("wz_books")->field('bookid,def_bookid,ctime,updatetime,isshow,bookname,isover,author,cover,defurl')->order('bookid desc')->limit($pagesize*$page,$pagesize)->select();

        $pagenav=new Pagenav();

        $url="./index.php?m=Adminwz&c=Index&a=booklist";

        $count=M('wz_books')->order('bookid desc')->count();


        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);





        for($i=0;$i<count($booklist);$i++){
            $booklist[$i]['ctime']=date('Y-m-d',$booklist[$i]['ctime']);
            $booklist[$i]['updatetime']=date('Y-m-d',$booklist[$i]['updatetime']);
            $booklist[$i]['total'] = M('wz_chapter')->where(array('def_bookid'=>$booklist[$i]['def_bookid']))->count();
        }

//        dump($booklist);

        $this->assign('pagehtml',$pagehtml);

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









    public function catchcontent(){

        $def_bookid=I('post.def_bookid');
        $def_chapterid=I('post.def_chapterid');
        $url='https://www.xbiquge6.com/'.$def_bookid.'/'.$def_chapterid.'.html';

        $data = curl($url,false,true,true);

        preg_match_all('/<div id=\"content\">(.*)<\/div>/',$data,$arr);

        $map['def_bookid']=$def_bookid;
        $map['def_chapterid']=$def_chapterid;
        $map['contempty']=0;

        $str = str_replace("&nbsp;" , " " , $arr[1][0]) ;

        $time=time();

        $unsave='正在手打中，请稍等片刻，w Ww.XxBi Quge.c0m新笔趣阁内容更新后，需要重新刷新页面，才能获取最新更新！';

        if($str==$unsave){ //直接过滤掉
            $content['content']=$str;
            $content['contempty']=1;
            $content['updatetime']=$time;
            $content['isshow']=2;
        }else{
            $content['content']=$str;
            $content['contempty']=1;
            $content['updatetime']=$time;
            $content['isshow']=1;
        }


        M('wz_chapter')->where($map)->save($content);

        $res['updatetime']=$time;
        $res['ontime']=$time;
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

        $run=I('get.run'); //判读是否继续

//        $def_bookid = I('get.def_bookid');
//
//        if($def_bookid){
//            $map['def_bookid']=$def_bookid;
//        }
//
        $map['contempty']=array('eq',0);

        $data = M('wz_chapter')->where($map)->order('chapterid')->limit(10)->select();

        $allcount=M('wz_chapter')->where($map)->order('chapterid')->count();
        $this->assign('run',$run);

        if(!$data){
            $this->assign('isfinish',1);
        }

        $this->assign('datastr',json_encode($data));
        $this->assign('data',$data);
        $this->assign('count',$allcount);
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

        $def_bookid=I('get.def_bookid');

        $pagesize=100;
        
        $map['contempty']=1;
        $map['def_bookid']=$def_bookid;

        $data=M('wz_chapter')->field('chapterid,title,isshow,ctime,updatetime,contempty,content')->where($map)->order('chapterid desc')->limit($pagesize*$page,$pagesize)->select();

        if($data){
            for($i=0;$i<count($data);$i++){
                $data[$i]['ctime']=date('Y-m-d H:i:s',$data[$i]['ctime']);
                if($data[$i]['updatetime']){
                    $data[$i]['updatetime']=date('Y-m-d H:i:s',$data[$i]['updatetime']);
                }

            }
        }
        $count=M('wz_chapter')->where($map)->count();

        $pagenav=new Pagenav();

        $url="./index.php?m=Adminwz&c=Index&a=chapterlist&def_bookid=".$def_bookid;

        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);

        $this->assign('page',$pagehtml);

        $this->assign('def_bookid',$def_bookid);

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
    
    
    //设置章节显示隐藏忽略
    
    function setchapter(){
        $chapterid=I('post.chapterid');
        $isshow=I('post.isshow');
        M('wz_chapter')->where(array('chapterid'=>$chapterid))->save(array('isshow'=>$isshow));
        echo json_encode(array('status'=>1));
    }
    
    //设置批量显示
    
    function savedata(){
        $chapter=I('post.chapter');
        $def_bookid=I('post.def_bookid');
        $map['chapterid']=array('in',$chapter);
        M('wz_chapter')->where($map)->save(array('isshow'=>1));
        
        //需要更新书本线上更新时间
        $data['ontime']=time();
        M('wz_books')->where(array('def_bookid'=>$def_bookid))->save($data);

        
        echo json_encode(array('status'=>1));
    }
    
    function savecover(){
        $bookid=I('post.bookid');
        $cover=I('post.cover');

        $url='http://image.weishop.wang/wzxs/'.$cover;
        $w['bookid']=$bookid;
        $data['cover']=$url;
        M('wz_books')->where($w)->save($data);

        $res['status']=1;
        $res['data']=array('cover'=>$url);
        
        echo json_encode($res);
    }
    

    function showdata(){
        $bookid=I('get.id');
        $data = M('wz_chapter')->where(array('def_bookid'=>$bookid))->select();
        dump($data);
    }




    function demo(){
        
        
        $map['contempty']=0;
        $data = M('wz_chapter')->where($map)->limit(500)->select();
        $time=time();
        $res['contempty']=1;
        $res['updatetime']=$time;

        for($i=0;$i<count($data);$i++){
            if($data[$i]['content']!=''){
                M('wz_chapter')->where(array('chapterid'=>$data[$i]['chapterid']))->save($res);
            }
        }
        
        echo M('wz_chapter')->where(array('contempty'=>1))->count();
    }
    
    function show(){
        $data = M('wz_books')->limit(10)->select();
        dump($data);
    }
    

    function setshowfn(){
//        $map['isshow']=0;
//        $data = M('wz_chapter')->where($map)->save(array('isshow'=>1));
//        echo $data;
    }





}
