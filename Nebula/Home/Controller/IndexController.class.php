<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
       //1、将timestamp,nonce,token按字典序排序
		$timestamp	= $_GET['timestamp'];
		$echostr   	= $_GET['echostr'];
		$nonce		= $_GET['nonce'];
		$token		= 'nebula';
		$signature	= $_GET['signature'];
		$array		= array($timestamp,$nonce,$token);
		//2、将排序后的三个参数拼接后用sha1加密
		$tempstr = implode('',$array);
		$tempstr = sha1( $tempstr );
		//3、将加密后的字符串与signature进行对比，判断该请求是否来自微信
		if( $tempstr == $signature  && $echostr){
			echo $echostr;
			\Think\Log::write("连接成功",'WARN');
			exit;
		}else{
			$this->responseMSg();
			\Think\Log::write("调用",'WARN');
		}
    }

    public function responseMSg(){
    	//1、获取到微信推送过来的post数据（xml格式）
    	$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
    	//2、出来消息类型，并设置回复类型和内容
    	/*
			<xml>
			<ToUserName><![CDATA[toUser]]></ToUserName>
			<FromUserName><![CDATA[FromUser]]></FromUserName>
			<CreateTime>123456789</CreateTime>
			<MsgType><![CDATA[event]]></MsgType>
			<Event><![CDATA[subscribe]]></Event>
			</xml>
    	*/
		$postObj = simplexml_load_string( $postArr );
		//$postObj->ToUserName = '';
		//判断该数据包是否是订阅消息的推送
		if(strtolower( $postObj->MsgType == 'event' )){
			//如果是关注 subscribe 事件
			if(strtolower( $postObj->Event == 'subscribe' )){
				//回复用户消息
				$toUser 	= $postObj->FromUserName;
				$fromUser 	= $postObj->ToUserName;
				$time 		= time();
				$msgType	= 'text';
				$content 	= '欢迎关注Nebulas~';
				$template	= "<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[%s]]></MsgType>
								<Content><![CDATA[%s]]></Content>
								</xml>";
				$info		= sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
				echo $info;
			}
		}
    }
}