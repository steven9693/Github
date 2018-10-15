<?php
namespace PC\Controller;
use Think\Controller;

class PcController extends Controller {

    public function setpath(){
        $this->assign('path',filepath());
        $this->assign('searchurl',searchurl());
    }

    public function ismobile(){

        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);

        if(preg_match('/mobile/',$useragent)){
            return true;
        }else{
            return false;
        }
    }

    //首页
    public function index(){

//        if($this->ismobile()){
//            header('Location: '.tomobile());
//            exit;
//        }


        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);


        //返回当前所有的分类
        $category=$this->getallcate();

        //最近更新
        $lastupdate = M('books')->where(array('isshow'=>1))->order('lastupdate desc')->limit(16)->select();
        if($lastupdate){
            for($i=0;$i<count($lastupdate);$i++){
                for($j=0;$j<count($category);$j++){
                    if($lastupdate[$i]['category_id']==$category[$j]['category_id']){
                        $lastupdate[$i]['category']=$category[$j]['name'];
                    }
                }
            }


            for($k=0;$k<count($lastupdate);$k++){
                $bookid=$lastupdate[$k]['bookid'];
                $count=M('voicelist')->where(array('bookid'=>$bookid))->count();
                $lastupdate[$k]['count']=$count;
            }
        }


        //获取玄幻武侠分类
        $this->assign('wuxia',$this->getcategorybook(1,12));

        //获取都市言情分类
        $this->assign('dushi',$this->getcategorybook(2,12));

        //获取刑侦推理分类
        $this->assign('xingzhen',$this->getcategorybook(7,12));

        //获取职场商战分类
        $this->assign('zhichang',$this->getcategorybook(8,8));

        //获取百家讲坛分类
        $this->assign('baijia',$this->getcategorybook(9,8));

        //获取军事历史分类
        $this->assign('junshi',$this->getcategorybook(6,8));


        $friend = M('friend')->where(array('isshow'=>1))->select();
        $this->assign('friend',$friend);


        $this->assign('lastupdate',$lastupdate);

        $this->assign('indexurl',toindex());

        $this->setpath();
        $this->assign('version',randtime());


        $this->assign('title','有声小说_有声小说在线收听网_听书网_听小说_在线听书_语音小说_56听书网_夜听_夜听小说 - 小微夜听');

        $this->assign('keywords','听书网,小微夜听,有声小说,有声小说在线收听网,有声小说下载,在线听书网,在线听小说,听书网');

        $this->assign('description','小微夜听,听书,听书网,在线听书,有声读物在线收听,免费有声小说,有声小说排行榜,本听书网提供最新最全热门有声小说,有声小说每日更新,最好的听书网');

        $this->assign('ishere',0);


        $this->assign('hotbooks',$this->sethotsearch());

        $this->display();


    }

    //获取分类

    public function getcategorybook($category_id,$pagesize=16,$page=0){
        //$category_id=1;
        $cate = M('category')->where(array('category_id'=>$category_id))->find();
        $where['category_id']=$category_id;
        $where['isshow']=1;
        $books=M('books')->where($where)->order('bookid desc')->limit($pagesize*$page,$pagesize)->select();

        if($books){
            for($i=0;$i<count($books);$i++){
                $books[$i]['category']=$cate['name'];
                $books[$i]['lastupdate']=date('Y-m-d H:i:s',$books[$i]['lastupdate']);
            }

            for($k=0;$k<count($books);$k++){
                $bookid=$books[$k]['bookid'];
                $count = M('voicelist')->where(array('bookid'=>$bookid))->count();
                $books[$k]['count']=$count;
            }
        }
        return $books;
    }

    //获取并返回所有的分类

    public function getallcate(){
        $where['isshow']=1;
        $data = M('category')->where($where)->order('category_id desc')->select();
        return $data;
    }


    //分类
    public function category(){

        $cid=I('get.cid');

        $cidArr=explode('_',$cid);
        $category_id=$cidArr[0];

        $page=$cidArr[1]?$cidArr[1]-1: 0;

        //设置分页
        $url=setpagenavurl().$category_id;
        $count=M('books')->where(array('category_id'=>$category_id,'isshow'=>1))->count();
        $pagesize=10;

        $pagehtml=pagenav($count,$pagesize,$url,$page);

        $this->assign('pagenav',$pagehtml);

        //生成当前分类信息
        $category = M('category')->where(array('category_id'=>$category_id))->find();
        $this->assign('category',$category);

        //标识当前的分类
        $this->assign('ishere',$category_id);


        $map['category_id']=$category_id;
        $map['isshow']=1;

        //获取最新推荐数据
        $latest=M('books')->where($map)->order('lastupdate desc')->limit(15)->select();
        $this->assign('latest',$latest);


        //本类热门有声小说人气TOP15

        $hotbook=M('books')->where($map)->order('score desc')->limit(15)->select();
        $this->assign('hotbook',$hotbook);

        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);


        $categorybooks = $this->getcategorybook($category_id,$pagesize,$page);
        $this->assign('categorybooks',$categorybooks);

        $this->assign('indexurl',toindex()); //首页链接

        $this->setpath();
        $this->assign('version',randtime());

        $title = $category['name'].'有声小说在线收听'.($page>0?'(第'.($page+1).'页)':'').'-小微夜听';

        $this->assign('title',$title);
        $this->assign('keywords',$category['name'].','.$category['name'].'有声小说');

        $this->assign('description','');

        $this->assign('hotbooks',$this->sethotsearch());

        $this->display();


    }


    //书本详情
    public function book(){

        $bookid=I('bid');

        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);

        $book = M('books')->where(array('bookid'=>$bookid))->find();
        $book['lastupdate']=date('Y-m-d H:i:s',$book['lastupdate']);

        //获取所有的集数

        $count = M('voicelist')->where(array('bookid'=>$bookid))->count();

        $book['count']=$count;

        $voicelist=array();
        if($count){
            for($i=0;$i<$count;$i++){
                $voicelist[]=array('bookid'=>$bookid,'index'=>$i);
            }
        }

        $this->assign('voicelist',$voicelist);

        $this->assign('book',$book);

        $this->assign('ishere',$book['category_id']);

        $category_id=$book['category_id'];
        $category=M('category')->where(array('category_id'=>$category_id))->find();

        $this->assign('category',$category);

        $this->setpath();
        $this->assign('bookid',$bookid);



        //获取最新推荐数据

        $map['category_id']=$category_id;
        $map['isshow']=1;

        $latest=M('books')->where($map)->order('lastupdate desc')->limit(8)->select();

        //过滤掉当前的书本
        $filterlatest=array();

        if($latest){
            for($i=0;$i<count($latest);$i++){
                if($latest[$i]['status']==1){
                    $latest[$i]['count']='完结';
                }else{
                    $voicecount=M('voicelist')->where(array('bookid'=>$latest[$i]['bookid']))->count();
                    $latest[$i]['count']="更新至".$voicecount."集";
                }

                if($latest[$i]['bookid']!=$bookid){
                    $filterlatest[]=$latest[$i];
                }
            }
        }

        $this->assign('latest',$filterlatest);

        //获取音频列表链接
//        $this->assign('getvideo',getvideolist());





//        $volicelist=M('voicelist')->where(array('bookid'=>$bookid))->count();


        //跳转到播放页的链接
        $this->assign('url',playerurl());

        //首页链接
        $this->assign('indexurl',toindex());

        $this->assign('version',randtime());


        $title = $book['bookname'].'有声小说_'.$book['bookname'].'有声小说在线收听_'.'有声小说'.$book['bookname'].'_'.$book['bookname'].'打包下载 - 小微夜听';
        $this->assign('title',$title);

        $keywords=$book['bookname'].','.$book['bookname'].'有声小说在线收听,'.$book['bookname'].'有声小说';
        $this->assign('keywords',$keywords);

        $description=$book['bookname'].'有声小说全集,'.$book['bookname'].'小说在线收听,'.$book['bookname'].'有声小说打包下载,有声小说'.$book['bookname'].',《'.$book['bookname'].'有声小说》';
        $this->assign('description',$description);

        $this->assign('hotbooks',$this->sethotsearch());

        $this->display();
    }


    //播放页面
    public function player(){

        $arg=I('get.id');
        $args=explode('-',$arg);
        $bookid=$args[0];
        $voiceid=$args[2];


        $book = M('books')->where(array('bookid'=>$bookid))->find();

        $count=M('voicelist')->where(array('bookid'=>$bookid))->count();
        $book['count']=$count;



        //获取当前音频链接
        $map['bookid']=$bookid;
        $map['defindex']=$voiceid;
        $data=M('voicelist')->where($map)->find();
        $voice=$data['voice'];
        if(strpos($voice,'.m4a')){
            $voice=substr($voice,0,strpos($voice,'.m4a')).'.m4a';
        }

        if(strpos($voice,'.mp3')){
            $voice=substr($voice,0,strpos($voice,'.mp3')).'.mp3';
        }
        $encodevoice='';
        if($voice){
            for($i=0;$i<strlen($voice);$i++){
                $encodevoice.=ord($voice[$i]).'*';
            }
            $encodevoice=substr($encodevoice,0,(strlen($encodevoice)-1));
        }

        $this->assign('encodevoice',$encodevoice);



        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);


        $category_id=$book['category_id'];
        $category=M('category')->where(array('category_id'=>$category_id))->find();
        $this->assign('category',$category);

        $this->assign('voiceid',$voiceid);
        
        $this->assign('bookid',$bookid);
        
        //上一集
        if($voiceid==0){
            $prev=$voiceid;
        }else{
            $prev=$voiceid-1;
        }
        $this->assign('prev',$prev);
        //下一集
        if($voiceid>=$count){
            $next=$count;
        }else{
            $next=$voiceid+1;
        }
        $this->assign('next',$next);
        
        

        $this->assign('ishere',$category_id);//标识当前的分类

        //大家都在听
//        $listen = $this->alllisten($category_id,10);

        //最近更新
        $where['category_id']=$category_id;

        $where['isshow']=1;

        $listen = M('books')->where($where)->limit(10)->order('lastupdate desc')->select();

        $filterlisten = array();

        $filterID=array();

        if($listen){
            for($k=0;$k<count($listen);$k++){
                if($listen[$k]['status']==1){
                    $listen[$k]['count']="完结";
                }else{
                    $voicecount = M('voicelist')->where(array('bookid'=>$listen[$k]['bookid']))->count();
                    $listen[$k]['count']="更新至".$voicecount."集";
                }
                $filterID[]=$listen[$k]['bookid'];
                if($listen[$k]['bookid']!=$bookid){
                    $filterlisten[]=$listen[$k];
                }
            }
        }

        $this->assign('listen',$filterlisten);

        $this->assign('indexurl',toindex()); //首页链接



        //喜欢听的人也喜欢听
        $lastupdate = $book['lastupdate'];


        $whafter['lastupdate']=array('lt',$lastupdate);
        $whafter['isshow']=1;
        $whafter['category_id']=$category_id;
        $whafter['bookid']=array('not in',$filterID);

        //根据最后的更新时间去获取书本
        $recommend= M('books')->where($whafter)->limit(22)->order('lastupdate desc')->select();


        $this->assign('recommend',$recommend);


        $this->setpath();

        $this->assign('version',randtime());



        $book['lastupdate']=date('Y-m-d H:i:s',$book['lastupdate']);

        $this->assign('book',$book);


        $title=$book['bookname']."有声小说第".($voiceid+1)."集在线收听-小微夜听";
        $this->assign('title',$title);

        $keywords=$book['bookname'].','.$book['bookname']."有声小说第".($voiceid+1)."集在线收听";
        $this->assign('keywords',$keywords);

        $description='您正在收听的是由小微夜听提供的'.$book['bookname'].'有声小说第8集,'.'正在播放的是'.$book['bookname'].'有声小说第2章';

        $this->assign('description',$description);

        $this->assign('hotbooks',$this->sethotsearch());

        $this->display();
    }


    //设置大家都在听

    public function alllisten($category_id,$pagesize){
        //$category_id=1;
        $data = M('books')->where(array('category_id'=>$category_id,'isshow'=>1))->order('lastupdate desc')->limit($pagesize)->select();
        if($data){
            for($i=0;$i<count($data);$i++){
                $count = M('voicelist')->where(array('bookid'=>$data[$i]['bookid']))->count();
                $data[$i]['count']=$count;
            }
        }
        return $data;
    }


    //设置分类导航
    public function getnav(){
        $where=array('isshow'=>1);
        $data = M('category')->where($where)->order('issort desc,category_id desc')->select();
        return $data;
    }



    //获取音频列表
    public function getvideo(){
        $bookid = I('post.bookid');
        $num = M('voicelist')->where(array('bookid'=>$bookid))->count();
        if($num){
            $res['status']=1;
            $res['num']=$num;
            echo json_encode($res);
        }else{
            $res['status']=0;
            echo json_encode($res);
        }
    }


    function test(){
        $this->display();
    }



    function search(){

        $bookname= I('search');
        $map['bookname']=array('like',"%$bookname%");
        $map['isshow']=1;
        $data=M('books')->where($map)->limit(10)->select();

        $len = count($data)? count($data) : 0;
        $this->assign('len',$len);

        if($data){
            for($i=0;$i<count($data);$i++){
                $count=M('voicelist')->where(array('bookid'=>$data[$i]['bookid']))->count();
                $data[$i]['lastupdate']=date('Y-m-d H:i:s',$data[$i]['lastupdate']);
                $data[$i]['count']=$count;
            }

        }

        $this->assign('bookdata',$data);

        //生成导航
        $nav=$this->getnav();
        $this->assign('nav',$nav);


        $this->assign('indexurl',toindex());
        $this->setpath();
        $this->assign('version',randtime());

        $this->assign('hotbooks',$this->sethotsearch());


        $this->display();
    }


    function sethotsearch(){

        $map['isshow']=1;
        $map['ishot']=array('neq',0);

        $hotbook = M('books')->where($map)->order('ishot desc , bookid desc')->limit(8)->select();
//        dump($hotbook);
        return $hotbook;
    }



}