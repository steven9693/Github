<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller {


    public function index(){

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        //今日推荐
        $recommend=M('books')->where(array('isshow'=>1,'todayrecommend'=>1))->order('todayrecommendsort desc,bookid desc')->limit(3)->select();
        $todayrecommend=$this->getCategory($recommend,$category);

        //玄幻武侠
        $xh=M('books')->where(array('isshow'=>1,'category_id'=>1))->order('issort desc,bookid desc')->limit(10)->select();
        $xuanhuan=$this->getCategory($xh,$category);


        $this->assign('todayrecommend',$todayrecommend);

        $this->assign('xuanhuan',$xuanhuan);

        $this->assign('category',$category);

        $this->assign('isindex',1); //隐藏首页的返回

        $this->assign('random',$this->setrandom());
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

        $pagesize=8;


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

        $this->display();
    }



    public function book(){

        $bookid=I('get.id');

//        echo $bookid;

        $book=M('books')->where(array('bookid'=>$bookid))->find();

        $ca = M('category')->where(array('category_id'=>$book['category_id']))->find();

        $book['category']=$ca['name'];

        $category=M('category')->where(array('isshow'=>1))->order('issort desc,category_id desc')->select();

        $this->assign('book',$book);

        $count=M('voicelist')->where(array('bookid'=>$bookid))->count();

        $ra=$this->randombook($book['category_id'],3);

        $rand=$this->getCategory($ra,$category);

        $this->assign('rand',$rand);

        $this->assign('count',$count);

        $this->assign('bookid',$bookid);

        $this->assign('random',$this->setrandom());

        $this->assign('category',$category);


        $this->display();
    }



    public function play(){

        //书本ID -0- 集数

        $arg=I('get.id');

        $args=explode('-',$arg);


        $map['bookid']=$args[0];

        $map['defindex']=$args[2];

        $data=M('voicelist')->where($map)->find();

//        dump($data);
        $voice=$data['voice'];
//        echo $voice;
//        echo '<br/>';
        if(strpos($voice,'.m4a')){
            $voice=substr($voice,0,strpos($voice,'.m4a')).'.m4a';
        }

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

        $rand=$this->randombook($book['category_id'],5);

        $this->assign('rand',$rand);

        $this->assign('data',$data);

        $this->assign('bookid',$args[0]);

        $this->assign('defindex',$args[2]);

        $this->assign('random',$this->setrandom());

        $this->assign('category',$category);

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


    public function setrandom(){
        return time();
    }

}