<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link rel="stylesheet" href="/basesystem/Public/css/common.css" />
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<link rel="stylesheet" href="/basesystem/Public/layui/css/layui.css" />
		<script type="text/javascript" src="/basesystem/Public/layui/layui.js" ></script>
	</head>
	<body>
	<form class="layui-form layui-form-pane" action="" style="padding-top: 20px;padding-left: 5px;">
   
  
<div class="layui-form-item">
    <label class="layui-form-label">角色名</label>
    <div class="layui-input-block">
      <input type="text" name="roleName" lay-verify="required" autocomplete="off" placeholder="请输入" class="layui-input">
    </div>
  </div>
  
  
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
	<script type="text/javascript">
			var APP = "/basesystem/index.php";
			var PUBLIC = "/basesystem/Public";
			layui.use('form', function(){
				  var form = layui.form;
				  //监听提交
				  form.on('submit(formDemo)', function(data){
					  var data = JSON.stringify(data.field);
					  $.ajax({ 
						  type: "post",
						  contentType:'application/x-www-form-urlencoded',
						  url: APP+"/Home/Role/add", 
						  data: data,
						  success: function(data){
							  data = eval("("+data+")");
							  var layer = window.top.layer;
							  layer.msg(data.msg);
							  if(data.success == 'true'){
								  layer.closeAll('iframe'); //关闭所有的iframe层
							  }
							} 
						});
					  return false;
				  });
				});
		</script>
	</body>
</html>