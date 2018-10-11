<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 0:09
 */


function setpath(){
//    echo 'setpath';
    $path="./Xiaoshuo/Adminwz/View";
    return $path;
}

function setversion(){
    return time();
}



function curl($url, $params = false, $ispost = 0, $https = 0)
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

