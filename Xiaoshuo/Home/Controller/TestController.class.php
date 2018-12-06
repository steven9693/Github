<?php
namespace Home\Controller;
use Think\Controller;

use QL\QueryList;

class TestController extends Controller {

    public function index(){

        $url='http://www.ting56.com/mp3/4427.html';

        $rules=array(
            'content'=>array('.jj','text')
        );

        $data = QueryList::Query($url,$rules,'','UTF-8','GB2312',true)->getData();

        dump($data);
    }


    public function fn163(){

        header("Content-type: text/html; charset=utf-8");
        $url='http://news.sina.com.cn/gov/xlxw/2018-06-19/doc-iheauxvz3475773.shtml';

        $rules=array(
            'content'=>array('.article','text')
        );

        $data = QueryList::Query($url,$rules,'','','',true)->getData();

        dump($data);
    }




    public function fn() {
        header("Content-type: text/html; charset=utf-8");
        $url='http://www.ting56.com/mp3/8488.html';
        echo '<textarea style="width:800px;height:500px">'.$this->curl($url).'</textarea>';
    }





    public function curl()
    {
        $ch = curl_init();
        
        $url="http://www.ting56.com/video/17306-0-3.html";

// 2. 设置选项
//        $cookie='adv=1; bdshare_firstime=1526351137824; UM_distinctid=163b4d67aac361-0610dc12b297eb-39614807-100200-163b4d67aad483; Hm_lvt_f48885d046488759be0f43cb09d34403=1527746887,1528094532,1528875853,1529376592; adv=2; CNZZDATA3055531=cnzz_eid%3D539051506-1527745097-http%253A%252F%252Fwww.ting56.com%252F%26ntime%3D1529385276; cscpvcouplet8776_fidx=1; Hm_lpvt_f48885d046488759be0f43cb09d34403=1529388734';
        curl_setopt ( $ch, CURLOPT_COOKIE,$cookie);
        curl_setopt($ch, CURLOPT_URL, $url);  // 设置要抓取的页面地址
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);              // 抓取结果直接返回（如果为0，则直接输出内容到页面）
        curl_setopt($ch, CURLOPT_HEADER, true);                      // 不需要页面的HTTP头
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

// 3. 执行并获取HTML文档内容，可用echo输出内容
        $output = curl_exec($ch);

// 4. 释放curl句柄
        curl_close($ch);
        
        echo $output;

//        return  $output;
    }
    
    



        //抓取文字小说

    //    function doCurl($url, $data=array(), $header=array(), $referer='', $timeout=30){
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
//
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//
//
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
//
//        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36');
//
//
//        // 模拟来源
//        curl_setopt($ch, CURLOPT_REFERER, $referer);
//
//        $response = curl_exec($ch);
//
//        if($error=curl_error($ch)){
//            die($error);
//        }
//
//        curl_close($ch);
//
//        return $response;
//
//    }
//
//    function demo(){
//        // 调用
//        $url = 'https://www.booktxt.net/2_2096/4412409.html';
//        $data = array();
//
//// 设置IP
//        $header = array(
//            'CLIENT-IP: 192.168.1.100',
//            'X-FORWARDED-FOR: 192.168.1.100'
//        );
//
//// 设置来源
//        $referer = 'https://www.booktxt.net';
//
//        $response = $this->doCurl($url, $data, $header, $referer, 5);
//
//        echo '<textarea style="width:980px;height:800px">'.$response.'</textarea>';
//
//    }
//







}







