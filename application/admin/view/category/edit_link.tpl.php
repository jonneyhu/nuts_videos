{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">栏目管理</div>
      <a href="<?php echo url('category/index') ?>"><li>栏目列表</li></a>
      <a href="<?php echo url('category/add') ?>"><li>添加栏目</li></a>
      <a href="<?php echo url('category/add','model_id=0') ?>"><li>添加外部链接</li></a>
      <a href="<?php echo url('category/edit',['id'=>$category['id']]) ?>"><li class="layui-this">修改外部链接</li></a>
    </ul>
    <div class="layui-tab-content">
      <div class="layui-tab-item layui-show">
        <form class="layui-form">
          <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
              <li class="layui-this">基本选项</li>
            </ul>
            <div class="layui-tab-content">
              <div class="layui-tab-item layui-show">
                <input type="hidden" name="id" value="<?php echo $category['id'] ?>">
                <input type="hidden" name="model_id" value="<?php echo $category['model_id'] ?>">
                <?php echo Form::select('parent_id',$category['parent_id'],'上级栏目','',$category_select);?>
                <?php echo Form::input('name',$category['name'],'栏目名称','栏目名称','请输入栏目名称','required');?>
                <?php //echo Form::input('en_name',$category['en_name'],'英文名称','栏目名称','请输入英文名称');?>
                <?php echo Form::input('url',$category['url'],'链接地址','链接地址以http://开始','http://开始','url');?>
                <?php echo Form::file('image_url',$category['image_url'],'栏目图片','栏目图片','图片地址','','选择','images');?>
                <?php echo Form::textarea('description',$category['description'],'栏目描述','','请输入栏目描述');?>
                <?php echo Form::input('sort',$category['sort'],'排序','数字越小越靠前','','number');?>
                <?php echo Form::radio('is_menu',$category['is_menu'],'是否导航显示','',array(1=>'是',0=>'否'));?>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit="" lay-filter="cate_edit">立即提交</button>
                </div>
              </div>
              
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
  form.on('submit(cate_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("category/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("category/index")}');
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
</body>
</html>