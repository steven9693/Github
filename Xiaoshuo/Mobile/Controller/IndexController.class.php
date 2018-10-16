<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller {

//    public $realpath="/Github/Xiaoshuo/Mobile/View"; //本地测试
    public $realpath="/Xiaoshuo/Mobile/View"; //网上路径

//    public $playpath="/Github/index.php/play/"; //本地测试
    public $playpath="/index.php/play/"; //网上路径

//    public $domain="http://localhost/Github/index.php";

//    public $domain="/index.php";


    public function setpath(){
        $this->assign('playpath',$this->playpath);
        $this->assign('realpath',$this->realpath);
    }

    public function index(){

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        //最近更新
        $latest=M('books')->where(array('isshow'=>1))->order('lastupdate desc')->limit(10)->select();
        $latestupdate=$this->getCategory($latest,$category);

        //刑侦推理
        $xztl=M('books')->where(array('isshow'=>1,'category_id'=>7))->order('lastupdate desc')->limit(10)->select();
        $xingzhentuili=$this->getCategory($xztl,$category);


        //玄幻武侠
        $xh=M('books')->where(array('isshow'=>1,'category_id'=>1))->order('bookid desc')->limit(10)->select();
        $xuanhuan=$this->getCategory($xh,$category);

        //都市言情
        $ds=M('books')->where(array('isshow'=>1,'category_id'=>2))->order('bookid desc')->limit(10)->select();
        $dushi=$this->getCategory($ds,$category);

        $this->assign('dushi',$dushi);


        $this->assign('latestupdate',$latestupdate);

        $this->assign('xingzhentuili',$xingzhentuili);

        $this->assign('xuanhuan',$xuanhuan);

        $this->assign('category',$category);

        $this->assign('isindex',1); //隐藏首页的返回

        $this->assign('random',$this->setrandom());

//        $this->assign('random','123');
        $this->setpath();

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
        for($k=0;$k<count($da);$k++){
            $da[$k]['lastupdate']=date('Y-m-d',$da[$k]['lastupdate']);
            $da[$k]['count']=M('voicelist')->where(array('bookid'=>$da[$k]['bookid']))->count();
        }

        return $da;
    }


    public function categorytime(){

        $arg=I('get.cid'); //分类ID-分页页码
        $page=0;

        if(strpos($arg,'-')>0){
            $arrs=explode('-',$arg);
            $category_id=$arrs[0];
            $page=$arrs[1];
        }else{
            $category_id=$arg;
        }

        $pagesize=10;


        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        $map['isshow']=1;

        $map['category_id']=$category_id;

        $da=M('books')->where($map)->order('lastupdate desc')->limit($pagesize*$page,$pagesize)->select();

        $count=M('books')->where($map)->count();

        $data=$this->getCategory($da,$category);

        $this->assign('data',$data);

        $this->assign('category',$category);

        $this->assign('random',$this->setrandom());

        $this->assign('category_id',$category_id);

        $this->assign('page',$page);

        $this->assign('all',ceil($count/$pagesize));

        $this->assign('domain',$this->domain);

        $ca=$data[0]['category'];
        $this->assign('settitle',1);
        $this->assign('title',$ca);

        $this->setpath();

        $this->display();
    }



    public function book(){

        $bookid=I('get.id');

        $book=M('books')->where(array('bookid'=>$bookid))->find();

        $ca = M('category')->where(array('category_id'=>$book['category_id']))->find();

        $book['category']=$ca['name'];

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        $this->assign('book',$book);

        $count=M('voicelist')->where(array('bookid'=>$bookid))->count();

        $data=M('voicelist')->where(array('bookid'=>$bookid))->select();

        if($data){
        	for($i=0;$i<count($data);$i++){
        		$data[$i]['num']=$data[$i]['defindex']+1;
        		$data[$i]['defindex']=$data[$i]['defindex'];
        	}
        }

        // $ra=$this->randombook($book['category_id'],3);

	$ra=M('books')->where(array('category_id'=>$book['category_id'],'isshow'=>1))->order('bookid desc')->limit(5)->select();

		$viewitem['bookname']=$book['bookname'];
		$viewitem['bookid']=$book['bookid'];
		$viewitem['count']=$count;

		$this->assign('viewitem',json_encode($viewitem));


        $rand=$this->getCategory($ra,$category);

        $this->assign('count',$count);

        $this->assign('rand',$rand);

        $this->assign('data',$data);

        $this->assign('bookid',$bookid);

        $this->assign('random',$this->setrandom());

        $this->assign('category',$category);

        $this->setpath();

        $this->assign('settitle',1);
        $this->assign('title',$book['bookname']);

        $this->assign('domain',$this->domain);


        $this->display();
    }



    public function play(){

        //书本ID -0- 集数

        $arg=I('get.id');

        $args=explode('-',$arg);


        $map['bookid']=$args[0];

        $map['defindex']=$args[2];

        $next=$args[2]+1;//下一集
        
        $this->assign('next',$next);

        $data=M('voicelist')->where($map)->find();

//        dump($data);
        $voice=$data['voice'];
//        echo $voice;
//        echo '<br/>';
        if(strpos($voice,'.m4a')){
            $voice=substr($voice,0,strpos($voice,'.m4a')).'.m4a';
        }

        if(strpos($voice,'.mp3')){
            $voice=substr($voice,0,strpos($voice,'.mp3')).'.mp3';
        }

//        echo $voice;

//        echo $voice;
//        echo '<br>';
        $encodevoice='';
        if($voice){
            for($i=0;$i<strlen($voice);$i++){
                $encodevoice.=ord($voice[$i]).'*';
            }
            $encodevoice=substr($encodevoice,0,(strlen($encodevoice)-1));
        }

//        echo $encodevoice;
        $this->assign('encodevoice',$encodevoice);

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        $book=M('books')->where(array('bookid'=>$args[0]))->find();

        // $rand=$this->randombook($book['category_id'],5);

        $where['category_id']=$book['category_id'];
        $where['isshow']=1;
        $rand=M('books')->where($where)->order('bookid desc')->limit(10)->select();
        $cate=M('category')->where(array('category_id'=>$book['category_id']))->find();

        if($rand){
        	for($i=0;$i<count($rand);$i++){
        		$rand[$i]['category']=$cate['name'];
        		$rand[$i]['lastupdate']=date('Y-m-d H:i:s',$rand[$i]['lastupdate']);
        	}
        }

        $this->assign('book',$book);

        $this->assign('rand',$rand);

        $this->assign('data',$data);

//        dump($data);

        $this->assign('bookid',$args[0]);

        $this->assign('showindex',$data['showindex']);

        $this->assign('defindex',$data['defindex']);

        $this->assign('random',$this->setrandom());

        $this->assign('category',$category);

        $this->assign('settitle',1);

        $this->assign('title',$book['bookname']);

        $this->assign('domain',$this->domain);

        $this->setpath();

        $this->display();

    }


    //随机选取同一分类下的书本

    public function randombook($categoryid,$number){

        $data=M('books')->order('bookid desc')->where(array('category_id'=>$categoryid,'isshow'=>1))->select();
        $rand=array_rand($data,$number) ;

        for($i=0;$i<count($rand);$i++){
            $result[]=$data[$rand[$i]];
        }
        return $result;
    }

    //查询书本
    public function mobilesearch(){

    	header("Content-type:text/html;charset=utf-8");

        $book=I('get.book');

        $page=I('get.page') ? I('get.page'):0;

        $pagesize=10;

        $map['bookname'] = array('like','%'.$book.'%');

        $map['isshow']=1;

        $res=M('books')->where($map)->order('bookid desc')->limit($pagesize*$page,$pagesize)->select();

        $len=M('books')->where($map)->count();

        if($res){
            //找到书本
            $this->assign('isexist',1);

            for($i=0;$i<count($res);$i++){
            	$cate = M('category')->where(array('category_id'=>$res[$i]['category_id']))->find();
            	$count=M('voicelist')->where(array('bookid'=>$res[$i]['bookid']))->count();
            	$res[$i]['category']=$cate['name'];
            	$res[$i]['count']=$count;
            	$res[$i]['lastupdate']=date('Y-m-d H:i:s',$res[$i]['lastupdate']);
            }
            // dump($res);
            $this->assign('books',$res);

            $this->assign('search',$book);
            $this->assign('page',$page);

            $all=ceil($len/$pagesize);

            $this->assign('all',$all);

        }else{
            //不存在书本
            $this->assign('isexist',0);

            $recommend = M('books')->where(array('isshow'=>1))->order('bookid desc')->limit(10)->select();

            for($i=0;$i<count($recommend);$i++){
            	$cate = M('category')->where(array('category_id'=>$recommend[$i]['category_id']))->find();
            	$count=M('voicelist')->where(array('bookid'=>$recommend[$i]['bookid']))->count();
            	$recommend[$i]['category']=$cate['name'];
            	$recommend[$i]['count']=$count;
            	$recommend[$i]['lastupdate']=date('Y-m-d H:i:s',$recommend[$i]['lastupdate']);
            }

            $this->assign('recommend',$recommend);
        }

        if($len>$pagesize){
        	$this->assign('pagenav',1);
        }

        $this->assign('random',$this->setrandom());

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();
        $this->assign('category',$category);


        $this->setpath();

        $this->display();
    }






    public function setrandom(){
        return time();
    }

}