<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class SubjectController extends Controller {
	// 填空题页面
	public function blankfill(){
		// 检验用户是否登陆
		$user_info = $_SESSION['user_info'];
		if(is_null($user_info['user_id'])){
			$this->display('Index/index');
			return;
		}

		// 不带任何参数 自动定位当前操作的模板文件
		$this->assign('account',$user_info['account']);
        $this->display();
	}

	public function queryBlankfill(){
		$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
		$sql  = "select b.id id,b.caption caption,c.name category_name,b.subject subject ";
		$sql .=	"from think_blankfill b ";
		$sql .=	"left join think_category c ";
		$sql .=	"on b.category_id=c.id ";
		$sql .=	"where b.id not in( ";
		$sql .=	"	select blankfill_id ";
		$sql .=	"	from think_record ";
		$sql .=	"	where user_id = 1001 ";
		$sql .=	")";
		$result = $Model->query($sql);
		$this->ajaxReturn($result[0]);
	}
}