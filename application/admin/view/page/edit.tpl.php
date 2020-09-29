{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item"><?php echo $categorys[$category_id]['name']; ?> - 编辑</div>
    </ul>
    <div class="layui-tab-content">
      <div class="layui-tab-item layui-show">
        <form class="layui-form">
      		  <input type="hidden" name="id" value="<?php echo $page['id'] ?>">
      		  <input type="hidden" name="category_id" value="<?php echo $category_id ?>">
            <?php echo Form::input('title',$page['title']?$page['title']:$categorys[$category_id]['name'],'标题','标题','请输入标题','required');?>
            <?php echo Form::file('image_url',$page['image_url'],'图片','图片','图片地址','','选择','images');?>
            <?php  echo Form::$settings['editor']('content',$page['content'],'内容');?>
            <?php echo Form::textarea('description',$page['description'],'摘要','留空，则截取内容的前200个字符为摘要','请输入摘要');?>
            <div class="layui-form-item">
              <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="page_edit">立即提交</button>
              </div>
            </div>
        </form>
      </div>
    </div>
</div>
<script type="text/javascript">
layui.use(['element', 'form'], function(){
  var element = layui.element
  ,form = layui.form
  ,$ = layui.jquery;
  
  //监听提交
  form.on('submit(page_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("page/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          $('textarea[name=description]').val(data.description);
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
  
})
</script>

{include file="public/footer" /}