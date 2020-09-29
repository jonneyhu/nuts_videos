{include file="public/toper" /}
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ybphnSknmjArumgc6NoLovHvHclsHtjt"></script>
<style type="text/css">
    body, html {width: 100%;height: 100%;margin:0;font-family:"微软雅黑";font-family:"微软雅黑";}
    #allmap{width:100%;height:100%;}
</style>
<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
layui.use(['layer'], function(){
  var layer = layui.layer 
  ,$ = layui.jquery;
  // 百度地图API功能
  {if $Request.get.point}
  var point = new BMap.Point({$Request.get.point});
  {else}
  var point = new BMap.Point(116.404, 39.915);
  {/if}
  var map = new BMap.Map("allmap");
  map.centerAndZoom(point, 10);
  map.setDefaultCursor("default");
  map.enableScrollWheelZoom(true);
  map.addControl(new BMap.CityListControl({
    anchor: BMAP_ANCHOR_TOP_LEFT,
  }));
  //单击获取点击的经纬度
  map.addEventListener("click",function(e){
  	$('input[name={$Request.get.name}]', window.parent.document).val(e.point.lng + "," + e.point.lat);
  	/*var index = layer.open({
  		title: '您拾取的坐标为',
	  	content: e.point.lng + "," + e.point.lat
	  })*/;
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
	  parent.layer.close(index);
	  parent.layer.msg('拾取成功', {icon: 1, time: 1000});
  });
});
</script>