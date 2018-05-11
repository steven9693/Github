<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    //赐赏
    public $appid="wx60b619c389d98a57";
    public $secret = "7e08a3a893c13bc735685a1de806b32a";


    public function index(){

        $this->display();

    }
}