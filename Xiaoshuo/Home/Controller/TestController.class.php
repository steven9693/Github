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





    public function curl($url)
    {
        $ch = curl_init();

// 2. 设置选项
        $cookie='adv=1; bdshare_firstime=1526351137824; UM_distinctid=163b4d67aac361-0610dc12b297eb-39614807-100200-163b4d67aad483; Hm_lvt_f48885d046488759be0f43cb09d34403=1527746887,1528094532,1528875853,1529376592; adv=2; CNZZDATA3055531=cnzz_eid%3D539051506-1527745097-http%253A%252F%252Fwww.ting56.com%252F%26ntime%3D1529385276; cscpvcouplet8776_fidx=1; Hm_lpvt_f48885d046488759be0f43cb09d34403=1529388734';
        curl_setopt ( $ch, CURLOPT_COOKIE,$cookie);
        curl_setopt($ch, CURLOPT_URL, $url);  // 设置要抓取的页面地址
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);              // 抓取结果直接返回（如果为0，则直接输出内容到页面）
        curl_setopt($ch, CURLOPT_HEADER, 0);                      // 不需要页面的HTTP头

// 3. 执行并获取HTML文档内容，可用echo输出内容
        $output = curl_exec($ch);

// 4. 释放curl句柄
        curl_close($ch);

        return  $output;
    }








}







