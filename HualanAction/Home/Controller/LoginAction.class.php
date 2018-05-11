<?php
class LoginAction extends BaseAction {
    //拼八优选
    //public $appid="wx59b2ce8f1969259f";
    //public $secret = "084b7fd7b24d680668b38641f5398d6e";
    
    //八点开始拼
    //public $appid="wx5b8be0f9389fc5cc";
    //public $secret = "036b84e3129791f14ee27bca5cef8141";

    //赐赏
    public $appid="wx60b619c389d98a57";
    public $secret = "7e08a3a893c13bc735685a1de806b32a";
    
    //本地部落
    //public $appid="wx9505d4924d1948e7";
    //public $secret = "0a84960fc3dbb1af925d405532bbf73f";
    
    //返回openid
    function authorCode(){
        $code=$this->_post('code');

        $appid = $this->appid;
        $secret = $this->secret;
        
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $secret . "&js_code=" . $code . "&grant_type=authorization_code";
        $post_data = array();
        $arr = json_decode($this->send_post($url, $post_data));

        $map['openid'] = $arr->openid;
        $userdata = M('cishang_user')->where($map)->find();
        if ($userdata) {
            if(!$userdata['unionid']){
                $userdata['unionid'] = $arr->unionid;
                M('cishang_user')->where($map)->save(array('unionid'=>$arr->unionid));
            }
            $result['status'] = 1;
            $result['data'] = $userdata;
            echo json_encode($result);
        } else {
            $data['ctime'] = time();
            $data['nickname'] = "";
            $data['headimg'] = "";
            $data['sex'] = "";
            $data['openid'] = $arr->openid;
            $data['unionid'] = $arr->unionid;
            $uid = M('cishang_user')->add($data);
            $data['uid'] = $uid;
            $result['status'] = 1;
            $result['data'] = $data;
            echo json_encode($result);
        }
    }
    
    /*
     * 用户登录
     * 返回用户相关信息
     */
    function login(){
        $code = $this->_post('code');
        $headurl = $this->_post('headurl');
        $gender = $this->_post('gender');
        $nickname = $this->_post('nickname');
        $iv=$this->_post('iv');
        $encryptedData=$this->_post('encryptedData');

        $appid = $this->appid;
        $secret = $this->secret;
        
        
        if ($code) {
            $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $secret . "&js_code=" . $code . "&grant_type=authorization_code";
            $post_data = array();
            $arr = json_decode($this->send_post($url, $post_data));
            $map['openid'] = $arr->openid;
            $session_key=$arr->session_key;
            $unionid=$arr->unionid; //直接取到unionid就不需要去解密

            if(!$unionid){ //不能直接获取unionid，进行解密字符串
                $unionid=$this->setunionid($appid, $session_key, $encryptedData, $iv);
            }

            //根据openid查询用户是否存在
            $userdata = M('cishang_user')->where($map)->find();
            //dump($userdata);
            //exit;
            if ($userdata) {
                if (!$userdata['nickname']) {
                    $data['nickname'] = $nickname;
                    $data['headimg'] = $headurl;
                    $data['sex'] = $gender;
                    M('cishang_user')->where($map)->save($data);

                    $userdata['nickname'] = $nickname;
                    $userdata['headimg'] = $headurl;
                    $userdata['sex'] = $gender;
                }
                if(!$userdata['unionid']){
                    $data['unionid'] = $unionid;
                    M('cishang_user')->where($map)->save($data);
                    $userdata['unionid'] = $unionid;
                }

                $result['status'] = 1;
                $result['data'] = $userdata;
                echo json_encode($result);
            } else {
                $data['ctime'] = time();
                $data['nickname'] = $nickname;
                $data['headimg'] = $headurl;
                $data['sex'] = $gender;
                $data['unionid'] = $unionid;
                $data['openid'] = $arr->openid;
                $uid = M('cishang_user')->add($data);
                $data['uid'] = $uid;
                $result['status'] = 1;
                $result['data'] = $data;
                $result['unionid']=$unionid;
                echo json_encode($result);
            }
        }
    }
    

    //以上是发送请求的函数，具体操作如下：
    function send_post($url, $post_data){
        
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST', //or GET
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    
    function setunionid($appid,$session_key,$encryptedData,$iv){
        
        $pc = new WXBizDataCrypt($appid, $session_key);
        $errCode = $pc->decryptData($encryptedData, $iv, $usermsg );

        if ($errCode == 0) {
            $user=json_decode($usermsg);
            return $user->unionId;
        } else {
            return ;
        }
    }
    
    
    function getaccessToken(){
        $appid = $this->appid;
        $secret = $this->secret;
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $result=file_get_contents($url);
        return json_decode($result,true);
    }

    
    
}
