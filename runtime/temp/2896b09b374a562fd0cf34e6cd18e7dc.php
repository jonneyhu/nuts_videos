<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"/www/wwwroot/video.com/application/admin/view/index/home.tpl.php";i:1601086203;s:66:"/www/wwwroot/video.com/application/admin/view/public/toper.tpl.php";i:1530175630;s:67:"/www/wwwroot/video.com/application/admin/view/public/footer.tpl.php";i:1503323382;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>后台管理中心</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="__STATIC__layui/css/layui.css">
	<script type="text/javascript" src="__STATIC__layui/layui.js"></script>
	<script type="text/javascript" src="__STATIC__js/common.js"></script>
	<link rel="stylesheet" href="__STATIC__css/style.css">
</head>
<body>
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">首页面板</div>
    </ul>
    <div class="layui-tab-content index_panel_container">
        <div class="left">
            <blockquote class="layui-elem-quote">
                <p>服务器系统：<span class="os_info">加载中...</span></p><hr>
                <p>WEB运行环境：<span class="web_info">加载中...</p><hr>
                <p>运行PHP版本：<span class="php_info">加载中...</p><hr>
                <p>数据库信息：<span class="mysql_info">加载中...</p><hr>
                <p>上传大小限制：<span class="upload_size_info">加载中...</p><hr>
                <p>POST大小限制：<span class="post_size_info">加载中...</p><hr>
            </blockquote> 
        </div>
        <div class="right">
           <blockquote class="layui-elem-quote">
                <p>系统版本：<?php echo LZ_VERSION; ?></p><hr>
                <p>ThinkPHP 版本：<?php echo THINK_VERSION; ?></p><hr>
                <p>Layui 版本：<?php echo LAYUI_VERSION; ?></p><hr>

            </blockquote>
        </div>
    </div>
</div>
<script type="text/javascript">
layui.use(['form'],function(){ 
    var form = layui.form
    ,$ = layui.jquery;

    $.ajax({
      type:'post',
      dataType:'json',
      url:'<?php echo url("index/ajax_system_info"); ?>',
      success:function(data){
        if(data.code == 200){
          //show_msg(data.msg,1);
          $.each(data.data,function(i,item){
            $('.'+i).text(item);
          })
        }else{
          show_msg(data.msg,2);
        }
      },
      error:function(result){
        show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
      }
    });
});
</script>
</body>
</html>