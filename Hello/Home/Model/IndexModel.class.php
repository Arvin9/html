<?php
namespace Home\Model;
use Think\Model;
class IndexModel extends Model {
    // 定义自动验证
    protected $_validate    =   array(
        array('account','require','用户名不能为空！'),
        array('password','require','密码不能为空！'),
    );
    // 定义自动完成
    protected $_auto    =   array(
        array('create_time','time',1,'function'),
    );
 }