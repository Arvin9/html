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
			                    <p>分析页面</p>
			                </div>
			                <div class="weui-cell__ft">
			                	<?php echo ($account); ?>
			                </div>
			            </div>
			        </div>
					
			        <br>
			        <div class="weui-media-box__bd">
				        <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
	    				<div id="radar" style="width: 100%;height:400px;"></div>
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
	                <a href="/hello.php/Home/Analyze/blankfill" class="weui-tabbar__item">
	                    <img src="/Public/weui/images/icon_tabbar.png" alt="" class="weui-tabbar__icon">
	                    <p class="weui-tabbar__label">填空</p>
	                </a>
	                <a href="/hello.php/Home/Analyze/analyze" class="weui-tabbar__item">
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
	<script src="/Public/weui/js/echarts.min.js"></script>
	<script>
		$(function() {
			// 基于准备好的dom，初始化echarts实例
        	var myChart = echarts.init(document.getElementById('radar'));
			// 使用刚指定的配置项和数据显示图表。
        	myChart.setOption(option);
	    });

	    option = {
		    title : {
		        text: '多雷达图',
		        subtext: '纯属虚构'
		    },
		    tooltip : {
		        trigger: 'axis'
		    },
		    legend: {
		        x : 'right',
		        bottom : '20px',
		        data:['降水量','蒸发量']
		    },
		    toolbox: {
		        show : true,
		        feature : {
		            mark : {show: true},
		            dataView : {show: true, readOnly: false},
		            restore : {show: true},
		            saveAsImage : {show: true}
		        }
		    },
		    calculable : true,
		    polar : [
		        {
		            indicator : [{text:'1月',max:10},{text:'2月',max:10},{text:'3月',max:10},{text:'4月',max:100},{text:'5月',max:100},{text:'6月',max:100},{text:'7月',max:100},{text:'8月',max:100},{text:'9月',max:100},{text:'10月',max:100},{text:'11月',max:100},{text:'12月',max:150}],
		            center : ['50%', '50%'],
		            radius : '50%'
		        }
		    ],
		    series : [
		    	{
		            type: 'radar',
		            polarIndex : 0,
		            itemStyle: {normal: {areaStyle: {type: 'default'}}},
		            data : [
		                {
		                    name : '降水量',
		                    value : [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 75.6, 82.2, 48.7, 18.8, 6.0, 2.3],
		                },
		                {
		                    name:'蒸发量',
		                    value:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 35.6, 62.2, 32.6, 20.0, 6.4, 150]
		                }
		            ]
		        }
		    ]
		};
                    
	  	
	</script>

</body>
</html>