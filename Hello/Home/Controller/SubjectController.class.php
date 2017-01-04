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
			$this->redirect('Index/index');
			return;
		}

		// 不带任何参数 自动定位当前操作的模板文件
		$this->assign('account',$user_info['account']);
        $this->display();
	}

	public function queryBlankfill(){
		//获取用户ID
		$user_id = $_SESSION['user_info']['user_id'];

		$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
		// 检查用户统计记录是否符合类别列表
		$checkSql  = "select id ";
		$checkSql .= "from think_category ";
		$checkSql .= "where id not in( ";
		$checkSql .= "select category_id ";
		$checkSql .= "from think_statistics ";
		$checkSql .= "where user_id = ".$user_id;
		$checkSql .= ")";
		$checkResult = $Model->query($checkSql);
		if(null != $checkResult){
			//在统计记录中添加用户缺失的类别记录
			foreach($checkResult as $cr){ 
		    	\Think\Log::write("ID为".$user_id."的用户缺失类别ID为".$cr['id']."的类别",'INFO');
		    	$Statistics = D('Statistics');
		    	$Statistics->user_id = $user_id;
				$Statistics->category_id = $cr['id'];
				$Statistics->add();
		    } 
		}
		
		// 查询统计中最少量的类别ID
		$queryMinSql  = "select category_id ";
		$queryMinSql .= "from think_statistics ";
		$queryMinSql .= "where user_id = ".$user_id;
		$queryMinSql .= " order by count asc ";
		$queryMinSql .= "limit 1";
		$queryMinResult = $Model->query($queryMinSql);

		$category_id_condition = $queryMinResult[0]['category_id'];
		echo $category_id_condition;

		// 以类别ID作为条件查询题目，查不到直接查询未做过的题目
		return;

		// 查找用户未做过的题目
		$sql  = "select b.id id,b.caption caption,c.name category_name,b.subject subject ";
		$sql .=	"from think_blankfill b ";
		$sql .=	"left join think_category c ";
		$sql .=	"on b.category_id=c.id ";
		$sql .=	"where b.id not in( ";
		$sql .=	"	select blankfill_id ";
		$sql .=	"	from think_record ";
		$sql .=	"	where user_id = ".$user_id;
		$sql .=	")";
		$result = $Model->query($sql);
		$len = count($result);	//结果级长度
		$this->ajaxReturn($result[0]);
	}

	public function respondence(){
		//获取用户输入答案和题目ID
        $id = $_POST['id'];
        $inSolution = $_POST['solution'];

        //根据题目ID查询题目答案
        $Blankfill = M("Blankfill"); // 实例化User对象
		$solution = $Blankfill->where('id='.$id)->getField('solution');

		$response = array();
		if($solution == $inSolution){
			//将答题记录插入数据库

			//返回正确信息
			$response['status'] = 200;
			$response['message'] = "答题正确！";
			$response['data'] = true;
		}else{
			//返回错误信息
			$response['status'] = 400;
			$response['message'] = "答题错误！";
			$response['data'] = false;
		}
		$this->ajaxReturn($response);
	}
}