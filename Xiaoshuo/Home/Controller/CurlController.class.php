<?php
namespace Home\Controller;
use Think\Controller;

header("Content-Type:text/html;charset=UTF-8");

class CurlController extends Controller {

    public function index(){

        $id=I('get.id');

        $book=M('books')->where(array('bookid'=>$id))->find();


        $url=$book['originalurl'];

        $curl = new Curl($url);

        $output = $curl->getHTML_id('vlink_1');

        //dump($output);

        $reg1="/<a .*?>.*?<\/a>/";

        preg_match_all($reg1,$output[3],$aarray);

        //dump($aarray);

        $reg2="/href=\'([^\']+)/";
        $reg3="/title=\'([^\']+)/";

        //$allitem=array();

        for($i=0;$i<count($aarray[0]);$i++){
            $item=array();
            preg_match_all($reg2, $aarray[0][$i], $hrefarray);
            preg_match_all($reg3, $aarray[0][$i], $titlearray);
            $item['href']=$hrefarray[1][0];
            $item['title']=$titlearray[1][0];

            $allitem[]=$item;
        }

        //dump($allitem);

        $this->getdata($allitem);



        //echo '<textarea style="width:800px;height:500px">'.$output[3].'</textarea>';

    }

    public function getdata($data){
        $result=array();

        for($i=0;$i<3;$i++){

            $curl = new Curl('http://www.ting56.com'.$data[$i]['href']);
            $html=$curl->getHtml();

            $reg1="/<script>var datas=.*?<\/script>/";

            preg_match_all($reg1,$html,$aarray);

            $reg3="/FonHen_JieMa\(\'(.*?[^\)])\'\)/";

            preg_match_all($reg3, $aarray[0][0], $matchitem);

            $code = explode("*",$matchitem[1][0]);

            $url='';

            //echo $matchitem[1][0];

            //dump($code);

            if($code){
                for($k=0;$k<count($code);$k++){
                    $url.=ltrim(chr($code[$k]));
                }
            }

            $result[]=$url;

        }

        dump($result);

    }




}



class Curl{

    public $output;


    public function __construct($url){

        // 1. 初始化
        $ch = curl_init();

        $this_header = array(
            "content-type: application/x-www-form-urlencoded;charset=UTF-8"
        );

        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);

        curl_setopt($ch, CURLOPT_URL, $url);  // 设置要抓取的页面地址

        // 2. 设置选项
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);              // 抓取结果直接返回（如果为0，则直接输出内容到页面）
        curl_setopt($ch, CURLOPT_HEADER, 0);                      // 不需要页面的HTTP头

        //curl抓取页面时遇到重定向的解决方法
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        // 3. 执行并获取HTML文档内容，可用echo输出内容
        $output = curl_exec($ch);

        // 4. 释放curl句柄
        curl_close($ch);

        $this->output=mb_convert_encoding($output, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');

    }

    //删除空格
    public function trimall($str){

        $oldchar=array(""," ","\t","\n","\r");
        $newchar=array("","","","","");

        return str_replace($oldchar,$newchar,$str);

    }

    //返回清除空格，换行的字符串
    public function getHtml(){
        return  $this->output;
    }

    public function getHTML_id($id){

        $preg_id='#<[a-zA-Z0-9][^>]+?id=[^>]+?>.*?</div>#is';
        $str = $this->getHtml();
        preg_match_all($preg_id,$str,$r);

        return $r[0];


    }



}









