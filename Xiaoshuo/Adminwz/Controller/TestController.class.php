<?php

namespace Adminwz\Controller;
use Think\Controller;

header("Content-type: text/html; charset=utf-8");
class TestController extends Controller {

    public function index(){
//        echo '采集测试';

        ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.

        $i=0;
        do{
            $i++;
            $data['description']=$i;
            M('wz_test')->add($data);

            sleep(1);// 等待5分钟
        }
        while($i<10);


    }

}
