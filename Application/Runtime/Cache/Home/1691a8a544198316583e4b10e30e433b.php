<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
		<link rel="stylesheet" href="/booksystem/Public/css/common.css" />
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<link rel="stylesheet" href="/booksystem/Public/layui/css/layui.css" />
		<script type="text/javascript" src="/booksystem/Public/layui/layui.js" ></script>
		<style type="text/css">
		.layui-table-view{
			margin-top: 0px;
		}
</style>
	</head>
	<body>
	<form class="layui-form" action="">
	<input type="hidden" id="roleId" name="roleId" value="<?php echo ($roleId); ?>"/>
	<div class="layui-form-item">
			<table class="layui-table">
		  <colgroup>
		    <col width="200">
		    <col>
		  </colgroup>
		  <thead>
		    <tr>
		      <th>一级导航</th>
		      <th>二级导航</th>
		    </tr> 
		  </thead>
		  <tbody></tbody>
		</table>
		</div>
<div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
	</form>
	</body>
	<script type="text/javascript">
	var APP = "/booksystem/index.php";
	var PUBLIC = "/booksystem/Public";
	$(function(){
		//获得导航-----------------------------------------------------------------------
		$.ajax({
			  type: "post",
			  contentType:'application/x-www-form-urlencoded',
			  url: APP+"/Home/Role/powerTreeList?roleId="+$("#roleId").val(),
			  async:false,
			  success: function(data){
				  data = eval("("+data+")");
				  console.info(data);
				  for(var i=0;i<data.length;i++){
					  if(data[i].parentid == "0"){
						  $("tbody").append("<tr><td></td><td></td></tr>");
						  if(data[i].roleid == null){
							  $($("tbody tr:last").find("td")[0]).html('<input type="checkbox" parentid="'+data[i].parentid+'" name="powerId['+i+']" value="'+data[i].id+'" title="'+data[i].powername+'">');
						  }else{
							  $($("tbody tr:last").find("td")[0]).html('<input type="checkbox" parentid="'+data[i].parentid+'" name="powerId['+i+']" value="'+data[i].id+'" title="'+data[i].powername+'" checked>');
						  }
					  }else{
						  if(data[i].roleid == null){
							  $($("tbody tr:last").find("td")[1]).append('<input type="checkbox" parentid="'+data[i].parentid+'" name="powerId['+i+']" value="'+data[i].id+'" title="'+data[i].powername+'">');
						  }else{
							  $($("tbody tr:last").find("td")[1]).append('<input type="checkbox" parentid="'+data[i].parentid+'" name="powerId['+i+']" value="'+data[i].id+'" title="'+data[i].powername+'" checked>');
						  }
					  }
				  }
			  } 
		});
		//将table转化为表单-----------------------------------------------------------------
		layui.use('form', function(){
			  var form = layui.form;
			  //监听复选框
			  form.on('checkbox', function(data){
				 /*  console.log(data.elem); //得到checkbox原始DOM对象
				  console.log(data.elem.checked); //是否被选中，true或者false
				  console.log(data.othis); //得到美化后的DOM对象
				  console.info($(data.elem).attr("parentid")); */
				  if($(data.elem).attr("parentid") == "0"){
					  //勾选所有二级
					  if(data.elem.checked == true){
						  $(data.elem).parent().next().find("input").prop('checked', true);
					  }else{
						  $(data.elem).parent().next().find("input").prop('checked', false);
					  }
					  form.render('checkbox');
				  }else{
					  //勾选对应一级
					  if(data.elem.checked == true){
						  $(data.elem).parent().prev().find("input").prop('checked', true);
					  }
					  form.render('checkbox');
				  }
				}); 
			  //监听提交
			  form.on('submit(formDemo)', function(data){
				  var data = JSON.stringify(data.field);
				  $.ajax({ 
					  type: "post",
					  contentType:'application/x-www-form-urlencoded',
					  url: APP+"/Home/Role/changePower", 
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
	});
	//点击一级导航，选中他的二级-------------------------------------------------------------
	function checkAll(){
		console.info($(this));
	}
	</script>
</html>