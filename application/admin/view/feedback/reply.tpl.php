{include file="public/toper" /}
<div class="layui-tab-content">
<form class="layui-form">
<div class="layui-tab-item layui-show">
  <input type="hidden" name="id" value="<?php echo $feedback['id'] ?>">
  <?php echo Form::$settings['editor']('reply',$feedback['reply'],'回复内容','','250');?>
  <?php echo Form::date('reply_time',($feedback['reply_time']>0)?date('Y-m-d H:i:s',$feedback['reply_time']):date('Y-m-d H:i:s'),'回复时间','默认当前时间');?>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit="" lay-filter="reply">立即提交</button>
    </div>
  </div>
</div>   
</form>
</div>

<script type="text/javascript">
layui.use(['element', 'form'], function(){
  var element = layui.element
  ,form = layui.form
  ,$ = layui.jquery;

  //监听提交
  form.on('submit(reply)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("feedback/reply")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          layer.msg(data.msg, {icon: 1, time: 1000}, function(){
            var ifram = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.location.reload(); //刷新父层页面
            parent.layer.close(ifram); //再执行关闭   
          });
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