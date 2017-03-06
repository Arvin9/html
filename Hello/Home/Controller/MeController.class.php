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
        $this->display('Index/index');
    }



}
