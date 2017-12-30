//计算高度和宽度-----------------------------------------------------------------
var htmlHeight = $("html").height();
//$("#dh").width($("#dh").parent().width());//导航宽度
$("#dh").height(htmlHeight-$(".layui-nav").height());//导航高度
$($(".layui-row").children()[2]).height($($(".layui-row").children()[1]).height());
$(".layui-tab-content").height($($(".layui-row").children()[1]).height()-$(".layui-tab-title").height()-9);
var iframeHeight = $(".layui-tab-content").height();
//绑定导航点击，新增tab页面，并且切换tab的主体---------------------------------------------------
/*$("#dh").find("dd").bind('click', function() {
	var title = $(this).find("a").text();
	$(".layui-tab-title li").removeClass('layui-this');
	$(".layui-tab-title").append('<li class="layui-this">'+title+'</li>');
});*/
//定义框架的导航和tab切换效果---------------------------------------------------------
layui.use(['element', 'layer'], function() {
	var element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块
	//var layer = layui.layer; //导航的hover效果、二级菜单等功能，需要依赖element模块
	//监听导航点击,新增选项卡
	element.on('nav(demo)', function(elem) {
		//新增tab
		var title = elem.text();
		var url = $(elem).attr("link-url");
		var content = '<iframe scrolling="no" width="100%" height="'+iframeHeight+'px" src="'+APP+url+'"></iframe>';
		var id = elem.text();
		active.tabAdd(title,content,id);
		active.tabChange(elem.text());
	});
	//触发事件
	var active = {
		tabAdd: function(title,content,id) {
			active.tabDelete(id);
			//新增一个Tab项
			element.tabAdd('tabs', {
				title: title, //用于演示
				content: content,
				id: id //实际使用一般是规定好的id，这里以时间戳模拟下
			})
		},
		tabDelete: function(id) {
			//删除指定Tab项
			element.tabDelete('tabs', id); //删除：“商品管理”
		},
		tabChange: function(id) {
			//切换到指定Tab项
			element.tabChange('tabs', id); //切换到：用户管理
		}
	};

	$('.site-demo-active').on('click', function() {
		var othis = $(this),
			type = othis.data('type');
		active[type] ? active[type].call(this, othis) : '';
	});

	//Hash地址的定位
	var layid = location.hash.replace(/^#test=/, '');
	element.tabChange('test', layid);

	element.on('tab(test)', function(elem) {
		location.hash = 'test=' + $(this).attr('lay-id');
	});
});
//定义全局弹出层插件--------------------------------------------------------------------------------
var layer;
layui.use('layer',function(){
	layer = layui.layer;
});