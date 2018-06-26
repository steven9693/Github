<?php
namespace Home\Controller;
use Think\Controller;


class AjaxController extends Controller {

    public function index(){

        $id=I('get.id');
        $book=M('books')->where(array('bookid'=>$id))->find();
        $this->assign('bookid',$id);
        $this->assign('setid',$book['setid']);

        $latest=M('voicelist')->where(array('bookid'=>$id))->order('voiceid desc')->limit(1)->select();
        $this->assign('defindex',$latest[0]['defindex']);
        $this->assign('voice',$latest[0]['voice']);

        $this->assign('version',$this->clearcache());

        $this->display();
    }

    //设置对应ID

    public function setbook(){

        $setid=I('post.setid');
        $bookid=I('post.id');
        $data['setid']=$setid;

        M('books')->where(array('bookid'=>$bookid))->save($data);
    }



    //获取数据
    public function getdata(){
        header('content-type:text/html;charset=utf-8');
        $setid=I('post.setid');
        $start=I('post.start') ? I('post.start'):0;
        $end=I('post.end');
        $index=$start;
        $str='';

        for($start;$start<=$end;$start++){
            $url="http://www.ting56.com/video/$setid-0-$start.html";
            $str.=$this->curl($url);
        }

        preg_match_all("/FonHen_JieMa\([^\)]*/",$str,$arr);

        if($arr){
            for($i=0;$i<count($arr);$i++){
                $arr[$i]=str_replace('FonHen_JieMa(','',$arr[$i]);
                $arr[$i]=str_replace('\'','',$arr[$i]);
                $_urls[]=$arr[$i];
            }
        }
        $urls=$_urls[0];
        for($k=0;$k<count($urls);$k++){
            $urls[$k]=explode("*",$urls[$k]);
        }



        for($key=0;$key<count($urls);$key++){
            $item['index']=$index; //对应的集
            $index++;
            $mp3='';
            for($kk=0;$kk<count($urls[$key]);$kk++){
                if($urls[$key][$kk]!=''){
                    $mp3.=chr($urls[$key][$kk]);
                }
            }
            $item['voice']=$mp3;
            $result[]=$item;
        }

        echo json_encode($result);

    }


    public function curl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();

        $header=array(
            "Accept: text/html",
            "Content-Type: application/json;charset=gb2312"
        );

        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);


        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }




    public function savevoice(){
        $setid=I('post.setid');
        $bookid=I('post.bookid');
        $data = htmlspecialchars_decode(I('post.data'));
        $result = json_decode($data,true);
        if($result){

            for($i=0;$i<count($result);$i++){
                $item['bookid']=$bookid;
                $item['setid']=$setid;
                $item['voice']=$result[$i]['voice'];
                $item['defindex']=$result[$i]['index'];
                $item['showindex']=$result[$i]['index'];
                M('voicelist')->add($item);
            }
        }

        $res=array('status'=>1);

        echo json_encode($res);
    }



    public function clearcache(){
        return time();
    }




}







