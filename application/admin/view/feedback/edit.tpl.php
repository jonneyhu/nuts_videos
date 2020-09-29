{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">留言 - 管理</div>
      <a href="<?php echo url('feedback/index') ?>"><li>列表</li></a>
      <a href="<?php echo url('feedback/edit','id='.$feedback["id"]) ?>"><li class="layui-this">修改</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <input type="hidden" name="id" value="<?php echo $feedback['id'] ?>">
          <?php echo Form::input('name',$feedback['name'],'姓名','','请输入姓名');?>
          <?php echo Form::input('mobile',$feedback['mobile'],'电话','','请输入电话');?>
          <?php echo Form::date('create_time',$feedback['create_time'],'留言时间');?>
          <?php echo Form::$settings['editor']('content',$feedback['content'],'内容','','250');?>
          <?php echo Form::$settings['editor']('reply',$feedback['reply'],'回复内容','','250');?>
          <?php echo Form::date('reply_time',($feedback['reply_time']>0)?date('Y-m-d H:i:s',$feedback['reply_time']):date('Y-m-d H:i:s'),'回复时间','默认当前时间');?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="feedback_edit">立即提交</button>
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
  form.on('submit(feedback_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("feedback/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("feedback/index")}');
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