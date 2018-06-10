<?php

namespace Home\Controller;
use Think\Controller;


class LoginController extends Controller {

    public function login(){

        $this->assign('version',$this->clearcache());

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

    public function gotologin(){

        $phone=I('post.phone');
        $pwd=I('post.pwd');
        $data=M('admin')->where(array('loginphone'=>$phone))->find();

        if($data){

            if(MD5($pwd)==$data['password']){

                echo json_encode(array('status'=>1));
                session('userid',$data['id']);
                session('username',$data['username']);
                session('loginphone',$data['loginphone']);

            }else{
                //密码不正确
                echo json_encode(array('status'=>2));
            }

        }else{
            //用户不存在
            echo json_encode(array('status'=>3));
        }
    }


    public function loginout(){
        session(null);
    }


    public function clearcache(){
        return time();
    }


}
