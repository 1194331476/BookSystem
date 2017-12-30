<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link rel="stylesheet" href="/booksystem/Public/css/common.css" />
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<link rel="stylesheet" href="/booksystem/Public/layui/css/layui.css" />
		<script type="text/javascript" src="/booksystem/Public/layui/layui.js" ></script>
	</head>
	<body>
		<div class="layui-row">
			<div class="layui-col-xs6 layui-col-md12" style="background-color: #393D49;background-image: url('/booksystem/Public/img/systemName.png'); background-repeat: no-repeat;">
				<div class="grid-demo grid-demo-bg2">
					<div class="layui-col-xs6 layui-col-sm6 layui-col-md3">
					      &nbsp;
					    </div>
					    <div class="layui-col-xs6 layui-col-sm6 layui-col-md7">
					     &nbsp;
					    </div>
					    <div class="layui-col-xs4 layui-col-sm12 layui-col-md2">
					      		<ul class="layui-nav">
								<li class="layui-nav-item" lay-unselect="">
									<a href="javascript:;"><img src="http://t.cn/RCzsdCq" class="layui-nav-img"><?php echo ($_SESSION['user']['truename']); ?></a>
									<dl class="layui-nav-child">
										<dd>
											<a href="/booksystem/index.php/Home/Index/index">退了</a>
										</dd>
									</dl>
								</li>
							</ul>
					    </div>
					
					
				</div>
			</div>
			<div class="layui-col-xs6 layui-col-md2">
				<div class="grid-demo">
					<ul id="dh" style="width: 100%;" class="layui-nav layui-nav-tree layui-bg-cyan layui-inline" lay-filter="demo">
						<?php $_result=session('userPowerList');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$power): $mod = ($i % 2 );++$i;?><li class="layui-nav-item">
								<a href="javascript:;"><?php echo ($power["powername"]); ?></a>
								<dl class="layui-nav-child">
									<?php if(is_array($power["children"])): $i = 0; $__LIST__ = $power["children"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($i % 2 );++$i;?><dd link-url="<?php echo ($son["powerurl"]); ?>">
										<a><?php echo ($son["powername"]); ?></a>
									</dd><?php endforeach; endif; else: echo "" ;endif; ?>
								</dl>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			</div>
			<div class="layui-col-xs12 layui-col-md10">
				<div style="margin: 0px;width: 99.5%;" class="layui-tab layui-tab-card" lay-allowClose="true" lay-filter="tabs">
				  <ul class="layui-tab-title"></ul>
				  <div style="padding: 0px;" class="layui-tab-content"></div>
			</div>
		</div>
	</div>
		<script type="text/javascript">
			var APP = "/booksystem/index.php";
		</script>
		<script type="text/javascript" src="/booksystem/Public/js/admin.js" ></script>
	</body>
</html>