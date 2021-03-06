<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link rel="stylesheet" href="/booksystem/Public/css/common.css" />
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<!-- layui -->
		<link rel="stylesheet" href="/booksystem/Public/layui/css/layui.css" />
		<script type="text/javascript" src="/booksystem/Public/layui/layui.js" ></script>
		
	</head>
	<body>
	
	<form class="layui-form layui-form-pane" action="" style="padding-top: 20px;padding-left: 5px;">
   
  
<div class="layui-form-item">
    <label class="layui-form-label">权限名</label>
    <div class="layui-input-block">
      <input type="text" name="powerName" lay-verify="required" autocomplete="off" placeholder="请输入" class="layui-input">
    </div>
  </div>
  
<div class="layui-form-item">
    <label class="layui-form-label">权限地址</label>
    <div class="layui-input-block">
      <input type="text" name="powerUrl" autocomplete="off" placeholder="请输入" class="layui-input">
    </div>
  </div>
  
<div class="layui-form-item">
    <label class="layui-form-label">权限图标</label>
    <div class="layui-input-block">
      <input type="text" name="icon" autocomplete="off" placeholder="请输入" class="layui-input">
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
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
	<script type="text/javascript">
			var APP = "/booksystem/index.php";
			var PUBLIC = "/booksystem/Public";
			layui.use('form', function(){
				  var form = layui.form;
				  //监听提交
				  form.on('submit(formDemo)', function(data){
					  var data = JSON.stringify(data.field)
					  $.ajax({ 
						  type: "post",
						  contentType:'application/x-www-form-urlencoded',
						  url: APP+"/Home/Power/add", 
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