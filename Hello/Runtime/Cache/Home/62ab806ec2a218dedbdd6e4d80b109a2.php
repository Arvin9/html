<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<title>blank</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
	<!-- 引入 WeUI -->
    <link rel="stylesheet" href="/Public/weui/css/weui.min.css"/>
    <link rel="stylesheet" href="/Public/weui/css/jquery-weui.min.css"/>
<style type="text/css">
   	html,body{height: 100%;}
</style>
</head>
<body ontouchstart>


	<div class="page tabbar" style="height: 100%;">		
	    <div class="page__bd" style="height: 100%;">
	        <div class="weui-tab" style="height: 100%;">
	            <div id="panel" class="weui-tab__panel" style="height: 100%;">
	            	<div class="weui-cells__title">

	            	</div>
	            	<div class="weui-cells">
			            <div class="weui-cell">
			                <div class="weui-cell__bd">
			                    <p>填空题页面</p>
			                </div>
			                <div class="weui-cell__ft">
			                	<?php echo ($account); ?>
			                </div>
			            </div>
			        </div>
					
			        <br>

					<div class="weui-form-preview">
			            <div class="weui-form-preview__hd">
			                <label class="weui-form-preview__label">
			                	类别
			                </label>
			                <em class="weui-form-preview__value" id="category_name">
			                	没有类别啦！
			                </em>
			                <input id="category_id" hidden="hidden" />
			            </div>
			            <div class="weui-form-preview__bd">
			                <div class="weui-form-preview__item">
			                    <label class="weui-form-preview__label">
			                    	题目
			                    </label>
			                    <span class="weui-form-preview__value" id="caption">
			                    	没有题目啦！
			                    </span>
			                </div>
			                
			                <div class="weui-form-preview__item">
			                    <label class="weui-form-preview__label">
			                    	内容
			                    </label>
			                    <span class="weui-form-preview__value" id="subject">
			                    	没有内容啦！
			                    </span>
			                </div>

			            </div>
			            <div class="weui-cells weui-cells_form">
					        <div class="weui-cell">
					            <div class="weui-cell__hd">
					            	<label class="weui-label">答案</label>
					            </div>
					            <div class="weui-cell__bd">
					            	<input id="id" hidden="hidden" />
					                <input class="weui-input" id="solution" placeholder="请输入答案"/>
					            </div>
					        </div>
					    </div>
			            <div class="weui-form-preview__ft">
			                <a class="weui-form-preview__btn weui-form-preview__btn_default" onclick="skip()">跳过</a>
			                <button class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="respondence()">提交</button>
			            </div>
			        </div>

        		</div>
	            <div class="weui-tabbar">
	                <a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
	                    <span style="display: inline-block;position: relative;">
	                        <img src="/Public/weui/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
	                        <span class="weui-badge" style="position: absolute;top: -2px;right: -13px;">8</span>
	                    </span>
	                    <p class="weui-tabbar__label">微信</p>
	                </a>
	                <a href="/hello.php/Home/Subject/blankfill" class="weui-tabbar__item">
	                    <img src="/Public/weui/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
	                    <p class="weui-tabbar__label">填空</p>
	                </a>
	                <a href="javascript:;" class="weui-tabbar__item">
	                    <span style="display: inline-block;position: relative;">
	                        <img src="/Public/weui/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
	                        <span class="weui-badge weui-badge_dot" style="position: absolute;top: 0;right: -6px;"></span>
	                    </span>
	                    <p class="weui-tabbar__label">发现</p>
	                </a>
	                <a href="javascript:;" class="weui-tabbar__item">
	                    <img src="/Public/weui/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
	                    <p class="weui-tabbar__label">我</p>
	                </a>
	            </div>
	        </div>
	    </div>
	</div>

	<script src="/Public/weui/js/jquery-2.1.4.js"></script>
	<script src="/Public/weui/js/jquery-weui.js"></script>
	<script>
		$(function() {
	  		queryBlankfill();
	    });

	    function queryBlankfill(){
	    	$.post("queryBlankfill",{solution:""},function(data){
	    		// 没有题目时提示没有题目
	    		console.info(data);
	    		if(!data){
		  			$('#subject').text("没有内容啦！");
		  			$('#caption').text("没有题目啦！");
		  			$('#category_name').text("没有类别啦！");
		  			return;
	    		}
	  			
	  			$('#id').val(data.id);
	  			$('#category_id').val(data.category_id);
	  			$('#subject').text(data.subject);
	  			$('#caption').text(data.caption);
	  			$('#category_name').text(data.category_name);
	  		});
	    }

	    function respondence(){
	    	var solution = $('#solution').val();

	    	if("" == solution){
	    		$.alert("答案不能为空！");
	    		return;
	    	}
	    	
	    	$.post("respondence",{
	    			category_id:$('#category_id').val(),
	    			id:$('#id').val(),
	    			solution:solution
	    		},function(data){
		  			console.info(data);
		  			//$('#id').text(data.id);
		  			if('200'==data.status){
		  				$.alert(data.message);
		  				queryBlankfill();
		  			}
		  			if('400'==data.status){
		  				$.alert(data.message);
		  			}
		  			
	  		});
	    }

	    function skip(){
	    	//发送一个错误答案，并重新请求题目
	    	$.post("respondence",{
	    			category_id:$('#category_id').val(),
	    			id:$('#id').val(),
	    			solution:""
	    		},function(data){
		  			console.info(data);
		  			queryBlankfill();
	  		});
	    }
	  	
	</script>

</body>
</html>