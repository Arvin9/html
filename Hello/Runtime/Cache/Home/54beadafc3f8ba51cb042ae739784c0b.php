<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>登陆</title>
    <!-- 引入 WeUI -->
    <link rel="stylesheet" href="/Public/weui/css/weui.min.css"/>
</head>
<body>
	<div class="page">
    	<div class="page__hd">
    		<div class="weui-flex">
            	<div class="weui-flex__item">
            		<div class="placeholder"></div>
            	</div>
            	<div class="weui-flex__item">
            		<div class="placeholder">
            			<h1 class="page__title">登陆</h1>
						
            		</div>
            	</div>
            	<div class="weui-flex__item">
            		<div class="placeholder"></div>
            	</div>
        	</div>
    		
			<FORM id="form" method="post" action="/hello.php/Home/Subject/login">

				<div class="weui-cells weui-cells_form">
					<div class="weui-cell">
			            <div class="weui-cell__hd">
			            	<label class="weui-label">账&nbsp;&nbsp;号：</label>
			            </div>
			            <div class="weui-cell__bd">
			                <input class="weui-input" type="text" name="account" placeholder="请输入账号"/>
			            </div>
			        </div>
			     	<div class="weui-cells__tips">底部说明文字底部说明文字</div>

			        <div class="weui-cell">
			            <div class="weui-cell__hd">
			            	<label class="weui-label">密&nbsp;&nbsp;码：</label>
			            </div>
			            <div class="weui-cell__bd">
			                <input class="weui-input" type="password" id="password" placeholder="请输入账号"/>
			                <input type="password" name="password" hidden="hidden" />
			            </div>
			        </div>
			        <div class="weui-cells__tips">底部说明文字底部说明文字</div>

			        <div class="weui-btn-area">
			            <input class="weui-btn weui-btn_primary" type="submit" value="确定" />
			        </div>
				</div>
			</FORM>

		</div>
	</div>

	<script src="/Public/weui/js/jquery-2.1.4.js"></script>
	<script src="/Public/weui/js/jquery-weui.js"></script>
	<script src="/Public/weui/js/md5.min.js"></script> 
	<script src="/Public/weui/js/fastclick.js"></script>
	<script>
		$(function() {
	  		//$.alert(window.screen.height);
	    	//$('#panel').height(window.screen.height-50);
	    });

	  	$("#form").submit(function(e){
	  		var password = $("#password").val();
	  		password = hex_md5(password);
	  		$("input[name='password']")[0].value = password;
		});
	</script>
	
</body>
</html>