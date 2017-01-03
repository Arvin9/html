<?php
namespace Home\Controller;
use Think\Controller;
class SubjectController extends Controller {
	// 填空题页面
	public function blankFilling(){
		// 检验用户是否登陆
		$user_info = $_SESSION['user_info'];
		if(is_null($user_info['user_id'])){
			$this->display('Index/index');
			return;
		}

		// 不带任何参数 自动定位当前操作的模板文件
		$this->assign('name',"dddddd");


		echo $user_info['user_id'];
        $this->display();
	}
}