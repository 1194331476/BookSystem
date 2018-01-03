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
	<body style="padding-left: 10px;padding-right: 10px;">
	
	<div class="layui-row" style="padding-top: 30px;">
    <font style="font-size: 25px;color: gray;">图书列表&nbsp;&nbsp;&nbsp;<i class="layui-icon">&#xe65b;</i> </font>
	<hr class="layui-bg-gray">
	<div style="margin-top: 30px;" class="layui-form-item">
		<label class="layui-form-label" style="text-align: center;">书名</label>
		<div class="layui-input-inline">
			<input type="text" id='bookname' name="bookname" lay-verify="required"
				placeholder="请输入" autocomplete="off" class="layui-input">
		</div>
		<button class="layui-btn" onclick="search()"><i class="layui-icon">&#xe615;</i></button>
	</div>
	<div style="margin-top: 20px;margin-bottom: 10px;width: 100%;text-align: right;" class="layui-btn-group">
	    <button class="layui-btn" onclick="toAdd()">新增</button>
	    <button class="layui-btn" onclick="toEdit()">编辑</button>
	    <button class="layui-btn" onclick="del()">删除</button>
	  </div>
  </div>
<div class="layui-row">
    <table id="demo" lay-filter="test"></table>
  </div>
	<script type="text/javascript">
			var APP = "/booksystem/index.php";
			var PUBLIC = "/booksystem/Public";
			var tableHeight = $("body").height()-$($(".layui-row")[0]).height()-50;
			layui.use('table', function(){
			  var table = layui.table;
			  //第一个实例
			  table.render({
			    elem: '#demo'
			    ,id: 'idTest'
			    ,height: tableHeight
			    ,url: APP + '/Home/Book/getPageList' //数据接口
			    ,where: {'truename': $("#truename").val()} //如果无需传递额外参数，可不加该参数
			    ,page: true //开启分页
			    ,limit:10
			    ,limits:[10,20,30]
			    ,cols: [[ 
			      {checkbox: true}
			     ,{field: 'bookname', title: '图书名',width:200}
			     ,{field: 'author', title: '作者',width:160}
			    ,{field: 'num', title: '剩余数量',width:120}
			    ,{field: 'price', title: '价格',width:120}
			    ]]
			  });
			});
			//条件查询------------------------------------------------------------------------------------
			function search(){
				layui.use('table', function(){
				  var table = layui.table;
				  table.reload('idTest', {
					  url: APP + '/Home/Book/getPageList' //数据接口
					  ,where: {'bookname': $("#bookname").val()} //如果无需传递额外参数，可不加该参数
					  //,height: 300
					});
				});
			};
			//跳转新增图书页面------------------------------------------------------------------------
			function toAdd(){
				var layer = window.top.layer;
				layer.open({
				  type: 2, 
				  title:'新增图书',
				  area: ['40%', '62%'],
				  content: APP + '/Home/Book/toAdd', //数据接口
				  end : function(){
					  //window.location.reload();
				  }
				});
			};
			//跳转编辑图书页面------------------------------------------------------------------------
			function toEdit(){
				var layer = window.top.layer;
				layui.use('table', function(){
					var table = layui.table;
					var checkStatus = table.checkStatus('idTest'); //test即为基础参数id对应的值
					var rows = checkStatus.data;
					var layer = window.top.layer;
					if(rows.length == 1){
						layer.open({
						  type: 2, 
						  title:'编辑图书',
						  area: ['40%', '80%'],
						  content: APP + '/Home/Book/toEdit?id='+rows[0].id, //数据接口
						  end : function(){
							  //window.location.reload();
						  }
						});
					}else{
						layer.msg("请选择一条记录！");
					}
				});
			};
			//删除图书页面------------------------------------------------------------------------
			function del(){
				layui.use('table', function(){
					var table = layui.table;
					var checkStatus = table.checkStatus('idTest'); //test即为基础参数id对应的值
					var rows = checkStatus.data;
					var layer = window.top.layer;
					if(rows.length == 0){
						layer.msg("请选择至少一条记录！");
					}else{
						var id = "";
						console.info(rows);
						for(var i=0;i<rows.length;i++){
							id += rows[i].id+",";
						}
						$.ajax({
							  type: "post",
							  contentType:'application/x-www-form-urlencoded',
							  url: APP+"/Home/Book/del", 
							  data: {"id":id},
							  success: function(data){
								  data = eval("("+data+")");
								  layer.msg(data.msg);
								  location.reload();//刷新页面
							  } 
						});
					}
				});
			};
			
		</script>
	</body>
</html>