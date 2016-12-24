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
    	
		$postObj = simplexml_load_string( $postArr );


		//判断该数据包是否是订阅消息的推送
		/*
			<xml>
			<ToUserName><![CDATA[toUser]]></ToUserName>
			<FromUserName><![CDATA[FromUser]]></FromUserName>
			<CreateTime>123456789</CreateTime>
			<MsgType><![CDATA[event]]></MsgType>
			<Event><![CDATA[subscribe]]></Event>
			</xml>
    	*/
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

		//接收普通消息
		/*
			 <xml>
			 <ToUserName><![CDATA[toUser]]></ToUserName>
			 <FromUserName><![CDATA[fromUser]]></FromUserName>
			 <CreateTime>1348831860</CreateTime>
			 <MsgType><![CDATA[text]]></MsgType>
			 <Content><![CDATA[this is a test]]></Content>
			 <MsgId>1234567890123456</MsgId>
			 </xml>
		*/
		if(strtolower( $postObj->MsgType == 'text' )){
			if($postObj->Content == 'hello'){
				//回复用户消息
				$toUser 	= $postObj->FromUserName;
				$fromUser 	= $postObj->ToUserName;
				$time 		= time();
				$msgType	= 'text';
				$content 	= '你好呀~我是我';
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

	function getWxAccessToken(){
		//1.请求url地址
		$appid = 'wx634b55986ce038e1';
		$appsecret =  '526531b8a84c7b071be973d5339eed27';
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
		//2初始化
		$ch = curl_init();
		//3.设置参数
		curl_setopt($ch , CURLOPT_URL, $url);
		curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
		//4.调用接口 
		$res = curl_exec($ch);
		//5.关闭curl
		curl_close( $ch );
		if( curl_errno($ch) ){
			var_dump( curl_error($ch) );
		}
		$arr = json_decode($res, true);
		var_dump( $arr );
	}

	function getWxServerIp(){
		$accessToken = "ySzZW9fgMABx5pauplC6D7Jw_4x3tIdk6qMyjStOPW_LZFFzSzx5wyX0ED9loytv3H-rAgdRk-e9fp71PhHUkyImI7UghEDx96qeLMbsCpHFdYhKc7UsZ-3YxMjtmMQ6BEEgAIAXAA";
		$url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$res = curl_exec($ch);
		curl_close($ch);
		if(curl_errno($ch)){
			var_dump(curl_error($ch));
		}
		$arr = json_decode($res,true);
		echo "<pre>";
		var_dump( $arr );
		echo "</pre>";
	}

}