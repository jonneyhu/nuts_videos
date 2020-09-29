{include file="public/toper" /}
<form class="layui-form">
<div class="layui-tab layui-tab-brief main-tab-container" lay-filter="main-tab">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">相关设置</div>
      <!--<li class="<?php /*if(input('param.tab')==1) echo 'layui-this'; */?>">公司信息</li>-->
      <li class="<?php if(input('param.tab')==2) echo 'layui-this'; ?>">站点设置</li>
      <!--<li class="<?php /*if(input('param.tab')==3) echo 'layui-this'; */?>">SEO设置</li>-->
      <!--<li class="<?php /*if(input('param.tab')==4) echo 'layui-this'; */?>">水印设置</li>-->
      <!--<li class="<?php /*if(input('param.tab')==5) echo 'layui-this'; */?>">移动端设置</li>-->
    </ul>    
    <div class="layui-tab-content"> 
      <!--<div class="layui-tab-item <?php /*if(input('param.tab')==1) echo 'layui-show'; */?>">
        <?php /*echo Form::input('company_name',$setting['company_name'],'公司名称','公司名称','请输入公司名称');*/?>
        <?php /*echo Form::input('company_point',$setting['company_point'],'地图坐标','百度地图坐标 <a href="javascript:void(0)" id="get_point"> [点击拾取坐标]</a>','请输入百度地图坐标');*/?>
        <?php /*echo Form::textarea('company_address',$setting['company_address'],'公司地址','公司地址','请输入公司地址');*/?>
        <?php /*echo Form::file('company_qrcode',$setting['company_qrcode'],'二维码','公众号二维码，将显示在网站前台','图片地址','','选择','images');*/?>
        <?php /*echo Form::input('company_email',$setting['company_email'],'公司邮箱','公司邮箱','请输入公司邮箱');*/?>
        <?php /*echo Form::input('company_tel',$setting['company_tel'],'服务热线','服务热线','请输入服务热线');*/?>
        <?php /*echo Form::input('company_qq',$setting['company_qq'],'客服QQ','客服QQ','请输入客服QQ');*/?>
        <?php /*echo Form::textarea('company_kefu_btn',$setting['company_kefu_btn'],'在线客服链接','在线客服链接','请输入在线客服链接');*/?>
        <?php /*echo Form::textarea('company_kefu_global',$setting['company_kefu_global'],'客服全局代码','在线客服全局代码','请输入在线客服全局代码');*/?>
      </div>-->
      <div class="layui-tab-item <?php if(input('param.tab')==2) echo 'layui-show'; ?>">
        <?php echo Form::input('site_name',$setting['site_name'],'站点名称','站点名称，将显示在浏览器窗口标题等位置','请输入站点名称');?>    
        <?php echo Form::file('logo',$setting['logo'],'网站logo','网站logo，将显示在网站前台','图片地址','','选择','images');?>
        <?php echo Form::input('icp',$setting['icp'],'网站备案号','在此输入网站ICP备案号，它将显示在页面底部','请输入网站备案号');?>
    	<?php echo Form::textarea('copy',$setting['copy'],'网站版权信息','在此输入网站版权信息，它将显示在页面底部','请输入网站版权信息');?>
        <?php echo Form::textarea('site_statistice',$setting['site_statistice'],'第三方统计代码','页面底部可以显示第三方统计','请输入第三方统计代码');?>
        <?php echo Form::textarea('head_html',$setting['head_html'],'网站头部代码','网站头部代码将出现在&lt;head&gt;&lt;/head&gt;之间','');?>
        <?php //echo Form::checkbox('search_model',$setting['search_model'],'前台检索模型','选中的模型在前台搜索会出现该模型的内容',$model_select);?>
        <?php //echo Form::radio('editor',$setting['editor']?$setting['editor']:'umeditor','后台编辑器','后台内容编辑所用的富文本编辑器',array('umeditor'=>'umeditor','layedit'=>'layedit'));?>
        <?php echo Form::radio('site_status',$setting['site_status'],'网站是否关闭','暂时将站点关闭，其他人无法访问，但不影响管理员访问',array(1=>'关闭',0=>'开启'),'site_status');?>
        <?php echo Form::textarea('site_closedreason',$setting['site_closedreason'],'站点关闭原因','请填写站点关闭原因，将在前台显示','请填写站点关闭原因，将在前台显示');?>
        
      </div>
      
      <!--<div class="layui-tab-item <?php /*if(input('param.tab')==3) echo 'layui-show'; */?>">
        <?php /*echo Form::input('title_add',$setting['title_add'],'标题附加字','本附加字设置出现在站点名称后，如有多个关键字，建议用分隔符分隔','请输入标题附加字');*/?>
        <?php /*echo Form::textarea('keywords',$setting['keywords'],'网站关键词','Keywords项出现在页面头部的标签中，用于记录本页面的关键字','请输入网站关键词');*/?>
        <?php /*echo Form::textarea('description',$setting['description'],'关键词描述','Description出现在页面头部的Meta标签中，用于记录本页面的摘要与描述','请输入网站关键词描述');*/?>
      </div>-->
      <!--<div class="layui-tab-item <?php /*if(input('param.tab')==4) echo 'layui-show'; */?>">
        <?php /*echo Form::radio('is_watermark',$setting['is_watermark'],'是否启用水印','只有图片高度大于500px并且高度大于300px才会添加水印',array(1=>'开启',0=>'关闭'));*/?>
        <?php /*echo Form::input('watermark_width',$setting['watermark_width'],'被水印图片宽度','输入数字，被添加水印的图片大于此宽度才会被添加水印','请输入被水印图片宽度');*/?>
        <?php /*echo Form::input('watermark_height',$setting['watermark_height'],'被水印图片高度','输入数字，被添加水印的图片大于此高度才会被添加水印','请输入被水印图片高度');*/?>
        <?php /*echo Form::file('watermark',$setting['watermark'],'水印图片','水印图片，网站上传的图片会加上此水印','图片地址','','选择','images');*/?>
        <?php /*echo Form::radio('watermark_locate',$setting['watermark_locate'],'水印位置','水印图片在图片中显示的位置',array(1=>'左上角',2=>'上居中',3=>'右上角',4=>'左居中',5=>'全居中',6=>'右居中',7=>'左下角',8=>'下居中',9=>'右下角'));*/?>
        <?php /*echo Form::input('watermark_alpha',$setting['watermark_alpha'],'水印透明度','输入1~100的数字，0为完全透明，100为完全不透明','请输入水印透明度');*/?>
      </div>-->
      <!--<div class="layui-tab-item <?php /*if(input('param.tab')==5) echo 'layui-show'; */?>">
        <?php /*echo Form::radio('wap_enabled',$setting['wap_enabled'],'是否开启移动端','开启之后用移动端访问，则显示移动端样式',array(1=>'开启',0=>'关闭'),'wap_enabled');*/?>
        <?php /*echo Form::radio('wap_jump',$setting['wap_jump'],'是否自动跳转','是否允许移动端设备自动识别并跳转到移动端域名',array(1=>'开启',0=>'关闭'),'wap_jump');*/?>
         <?php /*echo Form::input('wap_domain',$setting['wap_domain'],'移动端域名','移动端专属域名,不带http及末尾的/(如：m.lzcms.com)','请输入移动端域名','required');*/?>
      </div>-->

      <div class="layui-form-item">
        <div class="layui-input-block">
          <button class="layui-btn" lay-submit="" lay-filter="site_base">立即提交</button>
        </div>
      </div>
    </div>
</div>
</form>

<script>
layui.use(['form', 'element'], function(){
  var element = layui.element 
  ,form = layui.form
  ,$ = layui.jquery;
  //监听radio
  form.on('radio(site_status)', function(data){
    if(data.value=='1'){
      $('textarea[name=site_closedreason]').parents('.layui-form-item').show();
    }else{
      $('textarea[name=site_closedreason]').parents('.layui-form-item').hide();
    }
  }); 
  if($('input[name=site_status]:checked').val()=='0'){
    $('textarea[name=site_closedreason]').parents('.layui-form-item').hide();
  }
  //监听radio
  form.on('radio(wap_jump)', function(data){
    if(data.value=='1'){
      $('input[name=wap_domain]').parents('.layui-form-item').show();
      $('input[name=wap_domain]').attr('lay-verify','required');
    }else{
      $('input[name=wap_domain]').parents('.layui-form-item').hide();
      $('input[name=wap_domain]').attr('lay-verify','');
    }
  }); 
  if($('input[name=wap_jump]:checked').val()=='0'){
    $('input[name=wap_domain]').parents('.layui-form-item').hide();
    $('input[name=wap_domain]').attr('lay-verify','');
  }
  //监听提交
  form.on('submit(site_base)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("setting/base")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1);
        }else{
          show_msg(data.msg,2);
        }
      },
      error:function(result){
        show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
      }
    });
    return false;
  });
  
  //拾取地图坐标
  $('#get_point').click(function(){
    var company_point = $('input[name=company_point]').val();
    layer.open({
      type: 2, 
      title: '坐标拾取',
      area: ['800px', '500px'],
      content: ['{:url("setting/get_point")}?point='+company_point+'&name=company_point','no']
    })
  });
  //选项卡切换监听，改变iframe外层导航选项
  element.on('tab(main-tab)', function(data){
  	//console.log(data.index); //得到当前Tab的所在下标
  	var index = 1 + data.index;
  	$('.setting_ul .layui-nav-item', window.parent.document).removeClass('layui-this');
  	$('.setting_ul .layui-nav-item:eq('+index+')', window.parent.document).addClass('layui-this');
  });

});
</script>
</body>
</html>