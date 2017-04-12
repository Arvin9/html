<?php 
		//1、将timestamp,nonce,token按字典序排序
		$timestamp	= $_GET['timestamp'];
		$nonce		= $_GET['nonce'];
		$token		= 'nebula';
		$signature	= $_GET['signature'];
		$array		= array($timestamp,$nonce,$token);
		//2、将排序后的三个参数拼接后用sha1加密
		$tempstr = implode('',$array);
		$tempstr = sha1( $tempstr );
		//3、将加密后的字符串与signature进行对比，判断该请求是否来自微信
		if( $tempstr == $signature ){
			echo $_GET['echostr'];
			exit;
		}
?>