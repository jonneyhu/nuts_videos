{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">轮播图 - 管理</div>
      <a href="<?php echo url('focus/index') ?>"><li>列表</li></a>
      <a href="<?php echo url('focus/add') ?>"><li>添加</li></a> 
      <a href="<?php echo url('focus/edit',['id'=>$focus['id']]) ?>"><li class="layui-this">修改</li></a> 
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <input type="hidden" name="id" value="<?php echo $focus['id'] ?>">
            <input type="hidden" name="type" value="1">
          <?php echo Form::input('title',$focus['title'],'标题','','请输入标题','required');?>
          <?php echo Form::file('image_url',$focus['image_url'],'图片','图片','图片地址','','选择','images');?>
          <?php echo Form::input('url',$focus['url'],'链接地址','链接地址','以http://开头');?>
          <?php echo Form::textarea('description',$focus['description'],'描述','轮播图描述，最多不超过250个字符');?>
          <?php echo Form::input('sort',$focus['sort'],'排序','数字越小越靠前','数字','number');?>
          <?php echo Form::radio('is_show',$focus['is_show'],'是否启用','用于前台显示调用',array(1=>'是',0=>'否'));?>
          
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="focus_edit">立即提交</button>
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
  form.on('submit(focus_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("focus/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("focus/index")}');
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