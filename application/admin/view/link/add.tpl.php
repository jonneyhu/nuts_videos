{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">友情链接 - 管理</div>
      <a href="<?php echo url('link/index') ?>"><li>列表</li></a>
      <a href="<?php echo url('link/add') ?>"><li class="layui-this">添加</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <?php echo Form::input('title','','标题','','请输入标题','required');?>
          <?php echo Form::file('image_url','','图片','图片','图片地址','','选择','images');?>
          <?php echo Form::input('url','','链接地址','链接地址','以http://开头');?>
          <?php //echo Form::textarea('description','','描述','友情链接描述，最多不超过250个字符');?>
          <?php echo Form::input('sort','20','排序','数字越小越靠前','数字','number');?>
          <?php echo Form::radio('is_show',1,'是否启用','用于前台显示调用',array(1=>'是',0=>'否'));?>
          
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="link_add">立即提交</button>
            </div>
          </div>
        </div>   
      </form>
    </div>
</div>
<script type="text/javascript">
layui.use(['element', 'form'], function(){
  var element = layui.element
  ,form = layui.form
  ,$ = layui.jquery;

  //监听提交
  form.on('submit(link_add)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("link/add")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("link/index")}');
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

})
</script>

{include file="public/footer" /}