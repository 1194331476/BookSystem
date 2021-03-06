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
<body style="background-image: url('/booksystem/Public/img/loginBack.jpg'); background-repeat: no-repeat; background-size: 100%;">
	<div class="layui-row" style="height: 360px;">
	</div>
	<div class="layui-row">
		<div id="login" style="width: 18%;margin: 0px auto;">
			<form class="layui-form layui-form-pane" action="">
				<div class="layui-form-item">
					<label class="layui-form-label">用户名</label>
					<div class="layui-input-block">
						<input type="text" name="userName" lay-verify="title"
							autocomplete="off" placeholder="请输入用户名" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">密码</label>
					<div class="layui-input-block">
						<input type="password" name="password" required
							lay-verify="required" placeholder="请输入密码" autocomplete="off"
							class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="login">登录</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
<script>
	var APP = "/booksystem/index.php";
	var PUBLIC = "/booksystem/Public";
	//加载表单模块-----------------------------------------------------------------
	layui.use('form', function(){
	  var form = layui.form;
		//监听提交
	  form.on('submit(login)', function(data){
		  var data = JSON.stringify(data.field)
		  $.ajax({
			  type: "post",
			  contentType:'application/x-www-form-urlencoded',
			  url: APP+"/Home/Index/checkLogin",
			  data: data,
			  success: function(data){
				  data = eval("("+data+")");
				  console.info(data);
				  var layer = window.top.layer;
				  layer.msg(data.msg);
				  if(data.success == 'true'){
					  window.location.href = APP + "/Home/Index/admin";
				  }
				} 
			});
		  return false;
	  });
	});
</script> 
</html>