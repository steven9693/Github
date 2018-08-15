<?php
namespace Home\Controller;
use Think\Controller;
use QL\QueryList;
use Pagenav\Pagenav;

header("Content-Type:text/html;charset=UTF-8");

class IndexController extends Controller {



    //首页
    public function index(){

        $islogin=session('userid');
        $username=session('username');

        if(!$islogin){
            header("Location: ./index.php?m=Home&c=Login&a=login");
        }else{
            $this->assign('username',$username);
            $this->assign('version',$this->clearcache());
            $this->display();
        }


    }

    //添加分类
    public function add(){
        $category=M('category')->order('issort desc , category_id desc')->select();
        $this->assign('category',$category);
        $this->assign('version',$this->clearcache());
        $this->display();
    }


    //添加书本分类

    public function addcategory(){

        $this->assign('version',$this->clearcache());
        $this->display();
    }

    //保存分类
    public function savecatogary(){

        $title=I('post.title');
        $data['name']=$title;
        $data['ctime']=time();

        $id=M('category')->add($data);

        $result['status']=1;
        $result['data']=array('id'=>$id);
        echo json_encode($result);
    }


    //显示或隐藏分类

    public function setshow(){
        $category_id=I('post.category_id');
        $isshow=I('post.isshow');
        M('category')->where(array('category_id'=>$category_id))->save(array('isshow'=>$isshow));
        echo json_encode(array(status=>1));
    }

    //设置分类排序

    public function setsort(){
        $id=I('post.id');
        $issort=I('post.issort');
        M('category')->where(array('category_id'=>$id))->save(array('issort'=>$issort));
        echo json_encode(array('status'=>1));
    }





    //添加书本
    public function addbook(){

        $category=M('category')->order('category_id desc')->select();

        $this->assign('category',$category);

        $this->assign('version',$this->clearcache());

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

        $page=I('get.page')?(I('get.page')-1):0;

        $pagesize=5;

        $data=M('books')->order('bookid desc')->limit($pagesize*$page,$pagesize)->select();

        $count=M('books')->order('bookid desc')->count();

        $pagenav=new Pagenav();

        $url="./index.php?m=Home&c=Index&a=booklist";

//        $count=100;

        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);

        $this->assign('pagenav',$pagehtml);

        $this->assign('books',$data);

        $this->assign('version',$this->clearcache());

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
        //echo $url;

        $data = QueryList::Query($url,$rules,'','UTF-8','GB2312')->getData();


        $info= $data[1]['content'];

        $msg=$data[0]['author'];

//        dump($book);

        $this->assign('book',$book);

        $this->assign('info',$info);
        $this->assign('msg',$msg);
        $this->assign('id',$id);
        $this->assign('version',$this->clearcache());
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

        M('books')->where(array('bookid'=>$id))->save($data);

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

        $this->assign('version',$this->clearcache());

        $this->display();
    }

    public function getpicturebyurl(){
        $this->assign('version',$this->clearcache());
        $this->display();
    }


    public function getpictureuplaod(){
        $this->assign('version',$this->clearcache());
        $this->display();
    }

    public function clearcache(){
        return time();
    }


    public function control(){

        $category_id=I('get.cid');

        $pagesize=10;

        $page=I('get.page')?I('get.page')-1:0;

        $url="./index.php?m=Home&c=Index&a=control";


        if($category_id){
            $url.='&cid='.$category_id;
        }


        if($category_id){
            $map['category_id']=$category_id;
        }

        $category=M('category')->order('issort desc,category_id desc')->where(array('isshow'=>1))->select();

        $this->assign('category',$category);

        $books = M('books')->where($map)->order('todayrecommend desc,lastupdate desc,bookid desc')->limit($page*$pagesize,$pagesize)->select();

        if($books){
            for($i=0;$i<count($books);$i++){
                $books[$i]['num']=M('voicelist')->where(array('bookid'=>$books[$i]['bookid']))->count();
            }
        }
        $pagenav=new Pagenav();

        $count=M('books')->where($map)->order('bookid desc')->count();

        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);

        $this->assign('pagenav',$pagehtml);

        $this->assign('category_id',$category_id);

        $this->assign('books',$books);

        $this->assign('version',$this->clearcache());

        $this->display();
    }


    //设置书本上架
    public function setbookshow(){
        $bookid=I('post.bookid');
        $isshow=I('post.isshow');
        $map['bookid']=$bookid;
        M('books')->where($map)->save(array('isshow'=>$isshow));
        echo json_encode(array('status'=>1));
    }

    //设置是否放到今日推荐

    public function settodayrecommend(){
        $bookid=I('post.bookid');
        $todayrecommend=I('post.todayrecommend');
        M('books')->where(array('bookid'=>$bookid))->save(array('todayrecommend'=>$todayrecommend));
        echo json_encode(array('status'=>1));
    }


    //设置今日推荐排序
    public function recommendsort(){
        $map['todayrecommend']=1;
        $map['isshow']=1;
        $books=M('books')->where($map)->order('todayrecommendsort desc')->select();
        $this->assign('books',$books);
        $this->assign('version',$this->clearcache());
        $this->display();
    }

    //设置今日推荐指数
    public function todayrecommendsort(){
        $bookid = I('post.bookid');
        $todayrecommendsort = I('post.todayrecommendsort');
        M('books')->where(array('bookid'=>$bookid))->save(array('todayrecommendsort'=>$todayrecommendsort));
        echo json_encode(array('status'=>1));
    }



    //设置分类首页推荐
    public function setcategorytoindex(){
        $bookid=I('post.bookid');
        $settoindex=I('post.settoindex');
        M('books')->where(array('bookid'=>$bookid))->save(array('settoindex'=>$settoindex));
        echo json_encode(array('status'=>1));
    }

    //设置分类首页推荐排序显示
    public function categorysort(){

        $cid=I('get.cid');

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        if(!$cid){
            $cid=$category[0]['category_id'];
        }

        $map['category_id']=$cid;
        $map['settoindex']=1;
        $map['isshow']=1;

        $books = M('books')->where($map)->order('settoindexsort desc,bookid desc')->select();

        $this->assign('cid',$cid);

        $this->assign('books',$books);

        $this->assign('category',$category);

        $this->assign('version',$this->clearcache());

        $this->display();
    }

    //设置分类首页排序指数
    public function setcategorytoindexsort(){
        $bookid=I('post.bookid');
        $settoindexsort=I('post.settoindexsort');
        M('books')->where(array('bookid'=>$bookid))->save(array('settoindexsort'=>$settoindexsort));
        echo json_encode(array('status'=>1));
    }



    //修复音频列表

    public function voicelist(){

        $bookid=I('get.id');

        $pagesize=50;

        $page=I('get.page')?(I('get.page')-1):0;


        $book=M('books')->where(array('bookid'=>$bookid))->find();

        $pagenav=new Pagenav();

        $url="./index.php?m=Home&c=Index&a=voicelist&id=".$bookid;

        $count=M('voicelist')->where(array('bookid'=>$bookid))->count();

        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);

        $this->assign('pagenav',$pagehtml);

        $data=M('voicelist')->where(array('bookid'=>$bookid))->limit($page*$pagesize,$pagesize)->select();

        if($data){
            for($i=0;$i<count($data);$i++){
                $data[$i]['showindex']+=1;
            }
        }

        $this->assign('data',$data);
        $this->assign('book',$book);
        $this->assign('version',$this->clearcache());
        $this->display();
    }

    //调整集数，只调整当前1集

    public function setshowindex(){
        $voiceid=I('post.voiceid');
        $showindex=I('post.showindex')-1;
        M('voicelist')->where(array('voiceid'=>$voiceid))->save(array('showindex'=>$showindex));
        echo json_encode(array('status'=>1));
    }

    //后续全都自动加1

    public function autoaddone(){
        $bookid=I('post.bookid');
        $voiceid=I('post.voiceid');
        $map['bookid']=$bookid;
        $map['voiceid']=array('EGT',$voiceid);
        $data=M('voicelist')->where($map)->select();
        if($data){
            for($i=0;$i<count($data);$i++){
                M('voicelist')->where(array('voiceid'=>$data[$i]['voiceid']))->setInc('showindex');
            }
        }
        echo json_encode(array('status'=>1));
    }



    public function search(){

        $bookid = I('get.id');
        if ($bookid) {

            $book = M('books')->where(array('bookid' => $bookid))->find();

            $this->assign('book', $book);
            $this->assign('issearch',1);
        }
        $this->assign('version',$this->clearcache());

        $this->display();
    }

    public function searchbook(){
        $bookname=I('post.bookname');
        $book=M('books')->where(array('bookname'=>$bookname))->find();

        if($book){
            $res['status']=1;
            $res['data']=$book;
        }else{
            $res['status']=2;
        }
        echo json_encode($res);
    }



    //保存图片
    public function savecover(){
        $id=I('id');
        $cover = I('cover');
        $cover='http://image.weishop.wang/xiaoshuo/'.$cover;
        M('books')->where(array('bookid'=>$id))->save(array('cover'=>$cover));
        $result['status']=1;
        $result['data']=array('cover'=>$cover);
        echo json_encode($result);

    }
    
    
    
    //添加连接
    
    public function friend(){
        $this->display();
    }
    
    public function addfriend(){
        $name=I('post.title');
        $website=I('post.website');
        $isshow=I('post.isshow');
        
        $data['webname']=$name;
        $data['url']=$website;
        $data['isshow']=$isshow;
        
        M('friend')->add($data);
        echo json_encode(array('status'=>1));
    }
    
    public function friendlist(){
        
        
        $page=I('get.page')?(I('get.page')-1):0;

        $pagesize=5;

        $data=M('friend')->order('friend_id desc')->limit($pagesize*$page,$pagesize)->select();

        $count=M('friend')->order('friend_id desc')->count();

        $pagenav=new Pagenav();

        $url="./index.php?m=Home&c=Index&a=friendlist";

//        $count=100;

        $pagehtml=$pagenav->pagenav($count,$pagesize,$url);

        $this->assign('pagenav',$pagehtml);

        $this->assign('friends',$data);

        $this->assign('version',$this->clearcache());

        $this->display();
    }
    
    
    public function setfrishow(){
        $friend_id=I('post.friend_id');
        $isshow=I('post.isshow');
        M('friend')->where(array('friend_id'=>$friend_id))->save(array("isshow"=>$isshow));
        echo json_encode(array('status'=>1));
    }






}