{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">栏目管理</div>
      <a href="<?php echo url('category/index') ?>"><li>栏目列表</li></a>
      <a href="<?php echo url('category/add') ?>"><li>添加栏目</li></a>
      <a href="<?php echo url('category/add','model_id=0') ?>"><li>添加外部链接</li></a>
      <a href="<?php echo url('category/edit',['id'=>$category['id']]) ?>"><li class="layui-this">修改栏目</li></a>
    </ul>
    <div class="layui-tab-content">
      <div class="layui-tab-item layui-show">
        <form class="layui-form"> 
          <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
              <li class="layui-this">基本选项</li>
              <li>模板设置</li>
              <li>SEO设置</li>
            </ul>
            <div class="layui-tab-content">
              <div class="layui-tab-item layui-show">
                <input type="hidden" name="id" value="<?php echo $category['id'] ?>">
                <?php //echo Form::select('model_id',$category['model_id'],'选择模型','模型',$model_select,'required','model_id');?>
                  <input type="hidden" name="model_id" value="10">
                <?php echo Form::select('parent_id',$category['parent_id'],'上级栏目','上级栏目',$category_select);?>
                <?php echo Form::input('name',$category['name'],'栏目名称','栏目名称','请输入栏目名称','required');?>
                <?php //echo Form::input('en_name',$category['en_name'],'英文名称','栏目名称','请输入英文名称');?>
                <?php echo Form::file('image_url',$category['image_url'],'栏目图片','栏目图片','图片地址','','选择','images');?>
                <?php //echo Form::file('wap_image_url',$category['wap_image_url'],'移动端栏目图片','移动端栏目图片','图片地址','','选择','images');?>
                <?php echo Form::textarea('description',$category['description'],'栏目描述','','请输入栏目描述');?>
                <?php echo Form::input('sort',$category['sort'],'排序','数字越小越靠前','数字','number');?>
                <?php echo Form::radio('is_menu',$category['is_menu'],'是否导航显示','',array(1=>'是',0=>'否'));?>
                <?php //echo Form::radio('is_cover',$category['is_cover'],'是否显示封面','无封面页，则进入下级第一个栏目列表页',array(1=>'是',0=>'否'));?>
              </div>
              <div class="layui-tab-item">
              <?php
                echo Form::input('index_template',$category['index_template'],'封面页模版','单页模型只需要填写封面页模板','请输入封面页模版');
                echo Form::input('list_template',$category['list_template'],'列表页模版','','请输入列表页模版');
                echo Form::input('show_template',$category['show_template'],'详情页模版','','请输入详情页模版');
              ?>
              </div>
              <div class="layui-tab-item">
                <?php echo Form::input('meta_keywords',$category['meta_keywords'],'栏目页面关键词','关键字中间用半角逗号隔开','请输入栏目页面关键词');?>
                <?php echo Form::textarea('meta_description',$category['meta_description'],'栏目页面描述','针对搜索引擎设置的网页描述','请输入栏目页面描述');?>
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

  //选择单页隐藏列表页和详情页模板
  //监听radio
  form.on('select(model_id)', function(data){
    if(data.value=='1'){
      $('input[name=list_template]').parents('.layui-form-item').hide();
      $('input[name=show_template]').parents('.layui-form-item').hide();
    }else{
      $('input[name=list_template]').parents('.layui-form-item').show();
      $('input[name=show_template]').parents('.layui-form-item').show();
    }
  }); 
  if($('select[name=model_id]').val()=='1'){
    $('input[name=list_template]').parents('.layui-form-item').hide();
    $('input[name=show_template]').parents('.layui-form-item').hide();
  }
  
})
</script>
</body>
</html>