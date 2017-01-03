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
			                <label class="weui-form-preview__label">付款金额</label>
			                <em class="weui-form-preview__value">¥2400.00</em>
			            </div>
			            <div class="weui-form-preview__bd">
			                <div class="weui-form-preview__item">
			                    <label class="weui-form-preview__label">商品</label>
			                    <span class="weui-form-preview__value">电动打蛋机</span>
			                </div>
			                <div class="weui-form-preview__item">
			                    <label class="weui-form-preview__label">标题标题</label>
			                    <span class="weui-form-preview__value">名字名字名字</span>
			                </div>
			                <div class="weui-form-preview__item">
			                    <label class="weui-form-preview__label">标题标题
			                    </label>
			                    <span class="weui-form-preview__value">
崇祯十七年间，更易宰相，多达五十多人；民国一年到十三年，内阁更迭三十五次；乱世的政局乱象，早已演出过多次了，难道世人不懂这是不应该的？难道有识之士没有建立稳定政权的共识？道理是明摆着的，但是有志之士却不得不得不独善其身，为什么？因为政治败坏、时局糜烂已极，非一二君子所能争得来的。可见，这“时势”二字了不得！
			                    	
			                    </span>
			                </div>

			            </div>
			            <div class="weui-cells weui-cells_form">
					        <div class="weui-cell">
					            <div class="weui-cell__hd">
					            	<label class="weui-label">答案</label>
					            </div>
					            <div class="weui-cell__bd">
					                <input class="weui-input" type="number"  placeholder="请输入答案"/>
					            </div>
					        </div>
					    </div>
			            <div class="weui-form-preview__ft">
			                <a class="weui-form-preview__btn weui-form-preview__btn_default" href="javascript:">辅助操作</a>
			                <button type="submit" class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:">操作</button>
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
	                <a href="/hello.php/Home/Subject/blankFilling" class="weui-tabbar__item">
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

</body>
</html>