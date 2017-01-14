<?php
namespace Home\Controller;
use Think\Controller;
class AnalyzeController extends Controller {
	//访问blankFilling时重定向到Subject下
    public function blankfill(){
        $this->redirect('Subject/blankfill');	// 重定向
    }
    //访问home时重定向到Index下
    public function home(){
        $this->redirect('Index/home');   // 重定向
    }
    
	//主页面
    public function analyze(){
        // 检验用户是否登陆
        
        $user_info = $_SESSION['user_info'];
        if(is_null($user_info['user_id'])){
            $this->display('Index/index');
            return;
        }
        // 插入用户进入分析页面动态
        $Dynamic = D('Dynamic');
        $Dynamic->user_id = $user_info['user_id'];
        $Dynamic->action_id = 3;
        $Dynamic->create_time = date("Y-m-d H:i:s",time());
        $Dynamic->add();
        

        $this->assign('account',$user_info['account']);
        $this->display();

    }




}