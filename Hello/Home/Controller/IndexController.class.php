<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	//访问blankFilling时重定向到Subject下
    public function blankfill(){
        $this->redirect('Subject/blankfill');	// 重定向
    }
    //访问analyze时重定向到Analyze下
    public function analyze(){
        $this->redirect('Analyze/analyze');     // 重定向
    }


    //登陆页面
    public function index(){
        // 检验用户是否登陆
        $user_info = $_SESSION['user_info'];
        if(is_null($user_info['user_id'])){
            $this->display('Index/index');
            return;
        }
        // 不带任何参数 自动定位当前操作的模板文件
        $this->display();
    }

    //主页面
    public function home(){
        // 检验用户是否登陆
        $user_info = $_SESSION['user_info'];
        if(is_null($user_info['user_id'])){
            $this->display('Index/index');
            return;
        }
        $this->display();
    }



    //登陆请求
    public function login(){
        //获取用户输入账号密码
        $account 	= $_POST['account'];
        $password 	= $_POST['password'];

        //设置查询条件
        $condition['_logic'] 	= 'AND';
        $condition['account'] 	= $account;
        //$condition['password'] 	= $password;

        $User = M("User"); // 实例化User对象
       
        // 把查询条件传入查询方法
        $result = $User->where($condition)->select();
        
        // 检验查询结果
        if($result){
            $id = $result[0]['id'];
            $salt = $result[0]['salt'];
            $passwordHandle = $result[0]['password'];

            //将用户输入的密码+用户名+salt并进行MD5操作
            $temp = md5($password.$account.$salt);

            //将处理过后的密码与数据库中存放的进行验证
            if ($temp == $passwordHandle) {
                //声明用户信息
                $user_info  = array();
                $user_info['user_id'] = $id;
                $user_info['account'] = $account;
                $_SESSION['user_info'] = $user_info;

                // 插入用户登录成功动态
                $Dynamic = D('Dynamic');
                $Dynamic->user_id = $id;
                $Dynamic->action_id = 1;
                $Dynamic->create_time = date("Y-m-d H:i:s",time());
                $Dynamic->add();

                $this->assign('account',$account);
                $this->assign('password',$password);
                $this->display('home');
            }else{
                $this->error('密码错误！');
            }
        }else{
            $this->error('无此用户！');
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