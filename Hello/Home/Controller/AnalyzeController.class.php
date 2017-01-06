<?php
namespace Home\Controller;
use Think\Controller;
class AnalyzeController extends Controller {
	//访问blankFilling时重定向到Subject下
    public function blankfill(){
        $this->redirect('Subject/blankfill');	// 重定向
    }
    
	//主页面
    public function analyze(){
        // 检验用户是否登陆
        /*
        $user_info = $_SESSION['user_info'];
        if(is_null($user_info['user_id'])){
            $this->display('Index/index');
            return;
        }
        */
        $this->display();
    }




}