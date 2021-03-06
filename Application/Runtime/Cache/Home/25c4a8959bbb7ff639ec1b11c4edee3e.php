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
    <label class="layui-form-label">用戶名</label>
    <div class="layui-input-block">
      <input type="text" name="userName" lay-verify="required" autocomplete="off" placeholder="请输入" class="layui-input">
    </div>
  </div>
  
<div class="layui-form-item">
    <label class="layui-form-label">真实姓名</label>
    <div class="layui-input-block">
      <input type="text" name="trueName" lay-verify="required" autocomplete="off" placeholder="请输入" class="layui-input">
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">角色</label>
    <div class="layui-input-block">
    	<?php if(is_array($roleList)): $i = 0; $__LIST__ = $roleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?><input type="checkbox" name="roleId[<?php echo ($key); ?>]" value="<?php echo ($role["id"]); ?>" title="<?php echo ($role["rolename"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
      <!-- <input type="checkbox" name="like[write]" title="写作">
      <input type="checkbox" name="like[read]" title="阅读" checked="">
      <input type="checkbox" name="like[game]" title="游戏"> -->
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
					  var data = JSON.stringify(data.field)
					  $.ajax({ 
						  type: "post",
						  contentType:'application/x-www-form-urlencoded',
						  url: APP+"/Home/User/add", 
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