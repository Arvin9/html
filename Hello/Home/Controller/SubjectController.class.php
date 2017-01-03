<?php
namespace Home\Controller;
use Think\Controller;
class SubjectController extends Controller {
	public function blankFilling(){
		// 不带任何参数 自动定位当前操作的模板文件
		$this->assign('name',"dddddd");
		echo __APP__/Subject."";
        $this->display();
	}
}