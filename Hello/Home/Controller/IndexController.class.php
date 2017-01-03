<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        // 不带任何参数 自动定位当前操作的模板文件
        $this->display();
    }
    public function blankFilling(){
        // 重定向
        $this->redirect('Subject/blankFilling');
    }



    public function login(){
        $account 	= $_POST['account'];
        $password 	= $_POST['password'];

        echo $password;

        $condition['_logic'] 	= 'AND';
        $condition['account'] 	= $account;
        $condition['password'] 	= $password;

        $User = M("User"); // 实例化User对象
       
         // 把查询条件传入查询方法
        $result = $User->where($condition)->select();
        
        if($result){

            $this->assign('account',$account);
            $this->assign('password',$password);
            $this->display('home');
        }else{
            $this->error('账号密码错误！');
        }
    }

    public function getBytes($string) { 
        $bytes = array();
        $str = ""; 
        for($i = 0; $i < strlen($string); $i++){ 
             $bytes[i] = ord($string[$i]);
             $str = $str.$bytes[i]; 
        }
        echo $str;  
    } 
}