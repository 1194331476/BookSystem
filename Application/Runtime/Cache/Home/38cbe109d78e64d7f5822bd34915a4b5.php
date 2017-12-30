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
	<form class="layui-form" action="" lay-filter="register" style="padding-top: 20px;padding-left: 5px;">
   <input type="hidden" name="id" value="<?php echo ($power["id"]); ?>" lay-verify="required" autocomplete="off"  class="layui-input">
   <input type="hidden" id="oldParentId" value="<?php echo ($power["parentid"]); ?>" lay-verify="required" autocomplete="off"  class="layui-input">

<div class="layui-form-item">
    <label class="layui-form-label">权限名</label>
    <div class="layui-input-block">
      <input type="text" name="powerName" value="<?php echo ($power["powername"]); ?>" lay-verify="required" autocomplete="off"  class="layui-input">
    </div>
  </div>
  
<div class="layui-form-item">
    <label class="layui-form-label">权限地址</label>
    <div class="layui-input-block">
      <input type="text" name="powerUrl" value="<?php echo ($power["powerurl"]); ?>" autocomplete="off"  class="layui-input">
    </div>
  </div>
  
<div class="layui-form-item">
    <label class="layui-form-label">权限图标</label>
    <div class="layui-input-block">
      <input type="text" name="icon" value="<?php echo ($power["icon"]); ?>" autocomplete="off"  class="layui-input">
    </div>
  </div>
  
<div class="layui-form-item">
    <label class="layui-form-label">父节点</label>
    <div class="layui-input-block">
      <select name="parentId" lay-filter="parentId">
        <option value="0">顶级节点</option>
        <?php if(is_array($powerList)): $i = 0; $__LIST__ = $powerList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$power): $mod = ($i % 2 );++$i;?><option value="<?php echo ($power["id"]); ?>"><?php echo ($power["powername"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
     </select>
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
				  //将父节点下拉框默认设置以前的值
				  var oldParentId = $("#oldParentId").val();
				  $("option[value='"+oldParentId+"']").prop("selected","selected");
				  form.render('select');
				  //监听提交
				  form.on('submit(formDemo)', function(data){
					  var data = JSON.stringify(data.field)
					  $.ajax({ 
						  type: "post",
						  contentType:'application/x-www-form-urlencoded',
						  url: APP+"/Home/Power/edit", 
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