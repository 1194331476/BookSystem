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
	<form class="layui-form layui-form-pane" action="" lay-filter="register" style="padding-top: 20px;padding-left: 5px;">
	
	<input type="hidden" name="id" value="<?php echo ($user["id"]); ?>" readonly="readonly" lay-verify="required" autocomplete="off"  class="layui-input">
		
<div class="layui-form-item">
    <label class="layui-form-label">用戶名</label>
    <div class="layui-input-block">
      <input type="text" name="userName" value="<?php echo ($user["username"]); ?>" readonly="readonly" lay-verify="required" autocomplete="off"  class="layui-input">
    </div>
  </div>
  
<div class="layui-form-item">
    <label class="layui-form-label">真实姓名</label>
    <div class="layui-input-block">
      <input type="text" name="trueName" value="<?php echo ($user["truename"]); ?>" lay-verify="required" autocomplete="off"  class="layui-input">
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">角色</label>
    <div class="layui-input-block">
    	<?php if(is_array($roleList)): $i = 0; $__LIST__ = $roleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i; if($role["userid"] == '' ): ?><input type="checkbox" name="roleId[<?php echo ($key); ?>]" value="<?php echo ($role["id"]); ?>" title="<?php echo ($role["rolename"]); ?>" >
			    <?php else: ?> 
			    <input type="checkbox" name="roleId[<?php echo ($key); ?>]" value="<?php echo ($role["id"]); ?>" title="<?php echo ($role["rolename"]); ?>" checked><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </div>
  </div>
						  
						  
						   <div class="layui-form-item">
							    <div class="layui-input-block">
							      <button class="layui-btn" lay-submit="" lay-filter="formDemo">修改</button>
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
					  var data = JSON.stringify(data.field)
					  $.ajax({ 
						  type: "post",
						  contentType:'application/x-www-form-urlencoded',
						  url: APP+"/Home/User/edit", 
						  data: data,
						  success: function(data){
							  data = eval("("+data+")");
							  var layer = window.top.layer;
							  layer.msg(data.msg);
							  if(data.success == 'true'){
								  layer.closeAll('iframe'); //关闭所有的iframe层
								  ///window.top.location = APP + "/Home/Index/index";
							  }
							} 
						});
					  return false;
				  });
				});
		</script>
	</body>
</html>