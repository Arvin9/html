<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class SubjectController extends Controller {
	//访问analyze时重定向到Analyze下
    public function analyze(){
        $this->redirect('Analyze/analyze');	// 重定向
    }
    //访问home时重定向到Index下
    public function home(){
        $this->redirect('Index/home');   // 重定向
    }

	// 填空题页面
	public function blankfill(){
		// 检验用户是否登陆
		$user_info = $_SESSION['user_info'];
		if(is_null($user_info['user_id'])){
			$this->redirect('Index/index');
			return;
		}

		// 插入用户进入答题页面动态
        $Dynamic = D('Dynamic');
        $Dynamic->user_id = $user_info['user_id'];
        $Dynamic->action_id = 2;
        $Dynamic->create_time = date("Y-m-d H:i:s",time());
        $Dynamic->add();

		// 不带任何参数 自动定位当前操作的模板文件
		$this->assign('account',$user_info['account']);
        $this->display();
	}



	/**
	 * 主要思想：
	 * 优先查找未做过的题目，并按统计的count进行顺序排序，也就是说未做过的且统计记录中类别数最小的优先
	 * 其次查找做错的题目，按照错误次数顺序排序
	 */
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

		// 查找未做过的题目，按照statistics统计count排序
		$sqlCategory  = "select b.id id,b.caption caption,b.category_id category_id,b.subject subject,c.name category_name ";
		$sqlCategory .=	"from ((think_blankfill b ";
		$sqlCategory .=	"left join think_category c ";
		$sqlCategory .=	"on b.category_id=c.id) ";
		$sqlCategory .=	"	left join think_statistics s ";
		$sqlCategory .=	"	on c.id=s.category_id) ";
		$sqlCategory .=	"where b.id not in(  ";
		$sqlCategory .=	"	select blankfill_id";
		$sqlCategory .=	"	from think_record ";
		$sqlCategory .=	"	where user_id=".$user_id;
		$sqlCategory .=	") ";
		$sqlCategory .=	"order by s.count asc";
		$result = $Model->query($sqlCategory);
		if(null == $result){
			// 查找用户未做错的题目，按照record记录的count排序
			$sql  = "select b.id id,b.caption caption,b.category_id category_id,b.subject subject,c.name category_name ";
			$sql .=	"from ((think_record r ";
			$sql .=	"left join think_blankfill b ";
			$sql .=	"on b.id=r.blankfill_id) ";
			$sql .=	"	left join think_category c ";
			$sql .=	"	on b.category_id=c.id) ";
			$sql .=	"where r.is_correct=0 ";
			$sql .=	"and r.user_id=".$user_id;
			$sql .=	" order by r.count asc ";
			$result = $Model->query($sql);
		}
		
		$len = count($result);	//结果级长度
		$this->ajaxReturn($result[0]);
	}

	public function respondence(){
		//获取用户ID
		$user_id = $_SESSION['user_info']['user_id'];

		//获取用户输入答案和题目ID
        $id = $_POST['id'];
        $category_id = $_POST['category_id']; 
        $inSolution = $_POST['solution'];

        //根据题目ID查询题目答案
        $Blankfill = M("Blankfill"); // 实例化User对象
		$solution = $Blankfill->where('id='.$id)->getField('solution');

		$response = array();  //声明返回数组

		// 查询是否有答题记录，没有则创建
		$Record = D('Record'); // 实例化Record对象
		$condition['user_id'] = $user_id;
		$condition['blankfill_id'] = $id;
		$flag = $Record->where($condition)->select();
		if(null == $flag){
			// 创建答题记录
			$Record = D('Record');
			$Record->user_id = $user_id;
			$Record->blankfill_id = $id;
			$Record->add();
		} 

		if($solution == $inSolution){
			// 更新答题记录
			$Record = D('Record'); 
			$condition['user_id'] = $user_id;
			$condition['blankfill_id'] = $id;
			$Record->where($condition)->setField('is_correct',1);			
			
			// 更新统计记录
			$Statistics = D('Statistics'); 
			$condition['user_id'] = $user_id;
			$condition['category_id'] = $category_id;
			$Statistics->where($condition)->setInc('count'); //count记录加1
			
			// 返回正确信息
			$response['status'] = 200;
			$response['message'] = "答题正确！";
			$response['data'] = true;
		}else{
			// 更新答题错误记录
			$Record = D('Record'); 
			$condition['user_id'] = $user_id;
			$condition['blankfill_id'] = $id;
			$Record->where($condition)->setInc('count'); //count记录加1
			//返回错误信息
			$response['status'] = 400;
			$response['message'] = "答题错误！";
			$response['data'] = false;
		}
		$this->ajaxReturn($response);
	}
}