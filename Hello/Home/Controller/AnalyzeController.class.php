<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class AnalyzeController extends Controller {
	//访问blankFilling时重定向到Subject下
    public function blankfill(){
        $this->redirect('Subject/blankfill');	// 重定向
    }
    //访问home时重定向到Index下
    public function home(){
        $this->redirect('Index/home');   // 重定向
    }
    //访问me时重定向到Me下
    public function me(){
        $this->redirect('Me/me');     // 重定向
    }

	  //主页面
    public function analyze(){
        // 检验用户是否登陆
        $user_info = $_SESSION['user_info'];
        if(is_null($user_info['user_id'])){
            $this->redirect('Index/index');
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
    /**
     * 学习指标
     */
    public function exerciseIndicator(){
        //获取用户ID
        $user_id = $_SESSION['user_info']['user_id'];

        $Model = new Model(); // 实例化一个model对象 没有对应任何数据表
        // 查询个类别题目总量及用户答题情况
        $sql  = "select c.id id,c.`name` text,count(b.category_id) max,s.count count ";
        $sql .= "from (think_blankfill b ";
        $sql .= "  left join think_category c ";
        $sql .= "  on b.category_id=c.id) ";
        $sql .= "left join think_statistics s ";
        $sql .= "on b.category_id=s.category_id ";
        $sql .= "where s.user_id = ".$user_id." ";
        $sql .= "group by c.id ";

        $result = $Model->query($sql);
        // 数据处理
        $response['indicator'] = $result;

        $value = array();
        $arrlength=count($result);
        for($x = 0; $x < $arrlength; $x++){
            $value[$x] = $result[$x]['count'];
        }
        $response['value'] = $value;

        $this->ajaxReturn($response);
    }
    /**
     * 完成率
     */
    public function finishRate(){
        //获取用户ID
        $user_id = $_SESSION['user_info']['user_id'];

        $Model = new Model(); // 实例化一个model对象 没有对应任何数据表
        // 查询个类别题目总量及用户答题情况
        $sql  = "select count(b.id) blankfills,sum(r.is_correct) answers ";
        $sql .= "from think_blankfill b ";
        $sql .= "left join ( ";
        $sql .= "  select * ";
        $sql .= "  from think_record r ";
        $sql .= "where  r.user_id = ".$user_id." ) r ";
        $sql .= "on b.id = r.blankfill_id ";

        $result = $Model->query($sql);
        if ($result) {
            // 数据处理
            $response['data'] = round(($result[0]['answers'] / $result[0]['blankfills'])*100,2);
            $response['state'] = true;
        } else {
            // 返回用户已存在
            $response['message'] = "查询失败！";
            $response['state'] = false;
        }
        $this->ajaxReturn($response);
    }

}
