<?php

namespace Home\Controller;
use Think\Controller;


class LoginController extends Controller {

    public function login(){
        $this->display();
    }


    public function tologin(){

    }



    public function createuser(){
        $data['username']="管理员";
        $data['loginphone']="15920581277";
        $data['password']=MD5("zz15920581277");
        $data['ctime']=time();
        M('admin')->add($data);
    }

}
