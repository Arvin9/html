<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class IndexController extends Controller {
	//访问blankFilling时重定向到Subject下
    public function blankfill(){
        $this->redirect('Subject/blankfill');	// 重定向
    }
    //访问analyze时重定向到Analyze下
    public function analyze(){
        $this->redirect('Analyze/analyze');     // 重定向
    }
    //访问me时重定向到Me下
    public function me(){
        $this->redirect('Me/me');     // 重定向
    }

    //注册页面
    public function register(){
        $this->display(); // 不带任何参数 自动定位当前操作的模板文件
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
        $this->assign('account',$user_info['account']);
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
            $real_name = $result[0]['real_name'];
            $passwordHandle = $result[0]['password'];

            //将用户输入的密码+用户名+salt并进行MD5操作
            $temp = md5($password.$account.$salt);

            //将处理过后的密码与数据库中存放的进行验证
            if ($temp == $passwordHandle) {
                //声明用户信息并存入session中
                $user_info  = array();
                $user_info['user_id'] = $id;
                if ($real_name) {
                    $user_info['account'] = $real_name;
                } else {
                    $user_info['account'] = $account;
                }
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
    // 获取用户动态信息
    public function getDynamics() {

        $Model = new Model(); // 实例化一个model对象 没有对应任何数据表
        // 检查用户统计记录是否符合类别列表
        $sql  = "select u.account account,a.description description,a.url url,d.create_time create_time ";
        $sql .= "from ((think_dynamic d ";
        $sql .= "left join think_user u ";
        $sql .= "on d.user_id=u.id) ";
        $sql .= "  left join think_action a ";
        $sql .= "  on d.action_id=a.id ";
        $sql .= ")";
        $sql .= "order by d.create_time desc ";
        $sql .= "limit 6 ";
        $result = $Model->query($sql);

        $this->ajaxReturn($result);
    }

    // 用户名检验
    function verifyUsername(){
        // 获取用户名
        $username = $_POST['username'];
        //设置查询条件
        $condition['_logic'] 	= 'AND';
        $condition['account'] 	= $username;
        $User = M("User"); // 实例化User对象

        // 把查询条件传入查询方法
        $result = $User->where($condition)->select();
        if ($result) {
            // 返回用户已存在
            $response['message'] = "用户已存在！";
            $response['data'] = false;
        } else {
            // 返回用户已存在
            $response['message'] = "用户不存在，可以进行注册";
            $response['data'] = true;
        }
        $this->ajaxReturn($response);
    }

    // 用户进行注册
    function registerUser(){
        //获取用户输入账号密码
        $account 	= $_POST['username'];
        $password 	= $_POST['password'];
        $salt = md5(time());
        //将用户输入的密码+用户名+salt并进行MD5操作
        $md5_password = md5($password.$account.$salt);

        // 注册用户
        $User = D('User');

        $User->account = $account;
        $User->password = $md5_password;
        $User->salt = $salt;
        $User->add_time = date("Y-m-d H:i:s",time());

        $result = $User->add();
        if($result) {
            $response['message'] = "注册成功";
            $response['data'] = true;
        }else{
            $response['message'] = "注册失败";
            $response['data'] = false;
        }
        $this->ajaxReturn($response);
    }
}
