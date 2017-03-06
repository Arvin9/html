<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class MeController extends Controller {
	  //访问blankFilling时重定向到Subject下
    public function blankfill(){
        $this->redirect('Subject/blankfill');	// 重定向
    }
    //访问home时重定向到Index下
    public function home(){
        $this->redirect('Index/home');   // 重定向
    }
    //访问analyze时重定向到Analyze下
    public function analyze(){
        $this->redirect('Analyze/analyze');     // 重定向
    }


	  //主页面
    public function me(){
        // 检验用户是否登陆
        $user_info = $_SESSION['user_info'];
        if(is_null($user_info['user_id'])){
            $this->display('Index/index');
            return;
        }

        $this->assign('account',$user_info['account']);
        $this->display();
    }

    // 退出登录
    public function logout(){
        $_SESSION = array();
        $this->redirect('Index/index');
    }
    // 修改密码
    public function changePassword(){
        $user_info  = $_SESSION['user_info'];
        $user_id    = $user_info['user_id'];
        $account    = $user_info['account'];
        $password   = $_POST['password'];

        $salt = md5(time());
        //将用户输入的密码+用户名+salt并进行MD5操作
        $md5_password = md5($password.$account.$salt);

        // 更新用户密码
        $User = D('User');
        // 要修改的数据对象属性赋值
        $data['salt'] = $salt;
        $data['password'] = $md5_password;
        $condition['id'] = $user_id;

        $result = $User->where($condition)->save($data);

        if($result) {
            $response['message'] = "修改成功,请重新登录！";
            $response['data'] = true;
        }else{
            $response['message'] = "修改失败！";
            $response['data'] = false;
        }
        $this->ajaxReturn($response);
    }


}
