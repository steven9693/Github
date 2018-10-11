<?php
namespace Home\Controller;
use Think\Controller;

header("Content-type: text/html; charset=utf-8");

class TextbookController extends Controller {

    public function index(){


        $data = $this->curl('https://www.xxbiquge.com/68_68480/3578649.html',false,true,true);


        preg_match_all('/<div id=\"content\">(.*)<\/div>/',$data,$arr);

//        dump($arr);
       echo '<textarea style="width:980px;height:500px">'.$arr[1][0].'</textarea>';
    }



    public function curl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();

        $header=array(
            "Accept: text/html",
            "Content-Type: application/json;charset=utf-8",
            "Accept-Encoding: gzip, deflate",
            'Client-ip:183.222.96.223',
            'X-FORWARDED-FOR:183.222.96.223'
        );




        // 模拟来源
        curl_setopt($ch, CURLOPT_REFERER, 'https://www.booktxt.net/');

        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

//        curl_setopt($ch, CURLOPT_PROXY , "183.222.96.223:443");

//        curl_setopt( $ch, CURLOPT_HEADER, 1);


        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36');

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


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



    function lists(){

        $data = $this->curl('https://www.xxbiquge.com/68_68480/',false,true,true);

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
                $item['bookname']=$result[2][0];

                $str = str_replace('.html','',(str_replace('" class="empty','',$result[1][0])));

                $arr = (explode("/", $str));

//                $item[]=$result[1][0];
                $item['bookid']=$arr[1];
                $item['bookitem']=$arr[2];
                $res[]=$item;
            }
        }

        dump($res);



//        $onestr  =$strarr[0][0];
//        echo $onestr;

//        preg_match_all('/<a href="(.*)">(.*)<\/a>/is',$onestr,$result);
//
//        dump($result);
//
//        $res = $result[1][0];
//
////        echo $res;
//
//        $resarr  =explode(" ", $res);
//
//        echo str_replace('"','',$resarr[0]);
//
//        echo '<textarea style="width:980px;height:500px">'.$strarr[0][0].'</textarea>';

    }






}







