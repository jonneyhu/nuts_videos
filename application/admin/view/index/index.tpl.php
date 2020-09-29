{include file="public/toper" /}
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">
      <a href="<?php echo url('index/index/index') ?>" target="_blank">
          <?php if(isset($settings['logo']) && $settings['logo']){?>
              <img src="<?php echo $settings['logo']; ?>" alt="">
          <?php } ?>

      </a>
    </div>
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item layui-this">
        <a href="javascript:void(0)">首页</a>
      </li>
      <li class="layui-nav-item">
        <a href="javascript:void(0)">栏目</a>
      </li>
      <li class="layui-nav-item content_item">
        <a href="javascript:void(0)">内容</a>
      </li>
      <!--<li class="layui-nav-item">
        <a href="javascript:void(0)">留言</a>
      </li>-->
      <li class="layui-nav-item">
        <a href="javascript:void(0)">设置</a>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <!-- <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="{$admin_user['avatar']}" class="layui-nav-img">
          {if $admin_user['name']}{$admin_user['name']}{else}{$admin_user['username']}{/if}
        </a>
        <dl class="layui-nav-child">
          <dd><a href="<?php echo url('admin/edit') ?>" target="main">基本资料</a></dd>
          <dd><a class="update_cache" href="javascript:void(0)">更新缓存</a></dd>
          <dd><a href="/" target="_blank">网站首页</a></dd>
        </dl>
      </li> -->
      <li class="layui-nav-item"><a href="/" target="_blank">网站首页</a></li>
      <li class="layui-nav-item"><a class="update_cache" href="javascript:void(0)">更新缓存</a></li>
      <li class="layui-nav-item"><a class="logout_btn" href="javascript:void(0)">退了</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <ul class="layui-nav layui-nav-tree left_menu_ul">
        <li class="layui-nav-item layui-nav-title">
          <a href="<?php echo url('index/home') ?>" target="main">首页</a>
        </li>
        <li class="layui-nav-item first-item layui-this">
          <a href="<?php echo url('index/home') ?>" target="main">
            <i class="layui-icon">&#xe638;</i>
            <cite>首页面板</cite>
          </a>
        </li>
        <li class="layui-nav-item ">
          <a href="<?php echo url('admin/edit') ?>" target="main">
            <i class="layui-icon">&#xe612;</i>
            <cite>管理员资料</cite>
          </a>
        </li>
      </ul>
      <ul class="layui-nav layui-nav-tree left_menu_ul layui-hide">
        <li class="layui-nav-item layui-nav-title">
          <a href="<?php echo url('category/index') ?>" target="main">栏目管理</a>
        </li>
        <li class="layui-nav-item first-item">
          <a href="<?php echo url('category/index') ?>" target="main">
            <i class="layui-icon">&#xe60a;</i>
            <cite>栏目列表</cite>
          </a>
        </li>
        <li class="layui-nav-item content_manage">
          <a href="<?php echo url('category/add') ?>" target="main">
            <i class="layui-icon">&#xe609;</i>
            <cite>添加栏目</cite>
          </a>
        </li>
        <li class="layui-nav-item">
          <a href="<?php echo url('category/add','model_id=0') ?>" target="main">
            <i class="layui-icon">&#xe62c;</i>
            <cite>添加外部链接</cite>
          </a>
        </li>              
      </ul>
      <ul class="layui-nav layui-nav-tree left_menu_ul layui-hide">
        <li class="layui-nav-item layui-nav-title first-item">
          <a href="<?php echo url('category/content_manage_search') ?>" target="main">内容管理</a>
        </li>
        <div id="content_manage_tree"></div>
      </ul>
      <!--<ul class="layui-nav layui-nav-tree left_menu_ul layui-hide">
        <li class="layui-nav-item layui-nav-title">
          <a href="<?php /*echo url('feedback/index') */?>" target="main">留言管理</a>
        </li>
        <li class="layui-nav-item first-item">
          <a href="<?php /*echo url('feedback/index') */?>" target="main">
            <i class="layui-icon">&#xe63a;</i>
            <cite>留言列表</cite>
          </a>
        </li>            
      </ul>-->
      <ul class="layui-nav layui-nav-tree left_menu_ul setting_ul layui-hide">
        <li class="layui-nav-item layui-nav-title">
          <a href="<?php echo url('setting/base','tab=2') ?>" target="main">相关设置</a>
        </li>

        <li class="layui-nav-item  first-item">
          <a href="<?php echo url('setting/base','tab=2') ?>" target="main">
            <i class="layui-icon">&#xe620;</i>
            <cite>站点设置</cite>
          </a>
        </li>

        <!--<li class="layui-nav-item">
          <a href="<?php /*echo url('setting/sitemap') */?>" target="main">
            <i class="layui-icon">&#xe60d;</i>
            <cite>Sitemap</cite>
          </a>
        </li>-->
        <li class="layui-nav-item">
          <a href="<?php echo url('focus/index') ?>" target="main">
            <i class="layui-icon">&#xe634;</i>
            <cite>首页轮播图</cite>
          </a>
        </li>
        <!--<li class="layui-nav-item">
          <a href="<?php /*echo url('link/index') */?>" target="main">
            <i class="layui-icon">&#xe62c;</i>
            <cite>友情连接</cite>
          </a>
        </li>-->
        
        
      </ul>

    </div>
  </div>
  
  <div class="layui-body iframe-container">
      <div class="iframe-mask" id="iframe-mask"></div>
      <iframe class="admin-iframe" id="admin-iframe" name="main" src="<?php echo url('home') ?>"></iframe>
  </div>
  
  <div class="layui-footer">
    <a target="_blank" href="/">{$settings['copy']}</a>
  </div>
</div>
<script>
//JavaScript代码区域
layui.use(['layer', 'element','tree'], function(){
  var layer = layui.layer
  ,element = layui.element //导航的hover效果、二级菜单等功能，需要依赖element模块
  ,$ = layui.jquery

  //头部菜单切换
  $('.layui-layout-left .layui-nav-item').click(function(){
    var menu_index = $(this).index('.layui-layout-left .layui-nav-item');
    $('.left_menu_ul').addClass('layui-hide');
    $('.left_menu_ul:eq('+menu_index+')').removeClass('layui-hide');
    $('.left_menu_ul .layui-nav-item').removeClass('layui-this');
    $('.left_menu_ul:eq('+menu_index+')').find('.first-item').addClass('layui-this');
    var url = $('.left_menu_ul:eq('+menu_index+')').find('.first-item a').attr('href');
    $('.admin-iframe').attr('src',url);
    //出现遮罩层
    $("#iframe-mask").show();
    var timeout = setTimeout(function(){
      show_msg('请求超时！',2);
      $("#iframe-mask").fadeOut(100);
    },30000)
    //遮罩层消失
    $("#admin-iframe").load(function(){ 
      clearTimeout(timeout);  
      $("#iframe-mask").fadeOut(100);
    });
  });
  $('.layui-layout-left .content_item').click(function(){
    loading = custom_loading();
    $.ajax({
        type:'get',
        dataType:'json',
        url:'{:url("category/manage_tree")}',
        success:function(data){
            $('#content_manage_tree').empty();
            layui.tree({
              elem: '#content_manage_tree' //传入元素选择器
              ,skin: 'white'
              ,target: 'main'
              ,nodes: data
            });
            $('.left_menu_ul').addClass('hide');
            $('.content_manage_container').removeClass('hide');
            layer.close(loading);
        },
        error:function(result){
            show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
        }
    });
  });


  //左边菜单点击
  $('.left_menu_ul .layui-nav-item').click(function(){
    $('.left_menu_ul .layui-nav-item').removeClass('layui-this');
    $(this).addClass('layui-this');
    //出现遮罩层
    $("#iframe-mask").show();
    var timeout = setTimeout(function(){
      show_msg('请求超时！',2);
      $("#iframe-mask").fadeOut(100);
    },30000)
    //遮罩层消失
    $("#admin-iframe").load(function(){ 
      clearTimeout(timeout);    
      $("#iframe-mask").fadeOut(100);
    });
  });
  
  //更新缓存
  $('.update_cache').click(function(){
    loading = custom_loading(2,"更新缓存中 ······");
    $.ajax({
        type:'get',
        dataType:'json',
        url:'{:url("cache/update")}',
        success:function(data){
            if(data.code == 200){
                show_msg(data.msg,1,'reload');
            }else{
                show_msg(data.msg,2);
            }
        },
        error:function(result){
            show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
        }
    });
  });
  //退出登陆
  $('.logout_btn').click(function(){
    loading = custom_loading();
    $.ajax({
        type:'get',
        dataType:'json',
        url:'{:url("login/logout")}',
        success:function(data){
            if(data.code == 200){
                show_msg(data.msg,1,'reload');
            }else{
                show_msg(data.msg,2);
            }
        },
        error:function(result){
            show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
        }
    });
  });

});
</script>
{include file="public/footer" /}