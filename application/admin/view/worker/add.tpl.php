{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item"><?php echo $categorys[$category_id]['name']; ?> - 管理</div>
      <a href="<?php echo url('worker/index','category_id='.$category_id) ?>"><li>列表</li></a>
      <a href="<?php echo url('worker/add','category_id='.$category_id) ?>"><li class="layui-this">添加</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <?php echo Form::select_no_option('category_id','','所属栏目','',$model_category_select_option,'required');?>
          <?php echo Form::input('name','','姓名','','请输入姓名','required');?>
          <?php echo Form::input('post','','职位','','请输入职位');?>
          <?php echo Form::input('exp','','工作经验','','请输入工作经验，如：五年');?>
          <?php echo Form::file('image_url','','图片','图片','图片地址','','选择','images');?>
          <?php echo Form::textarea('description','','描述','留空时默认截取内容的前250个字符');?>
          <?php echo Form::input('sort','20','排序','数字越小越靠前','数字','number');?>
          <?php echo Form::radio('is_show',1,'是否显示','用于前台显示调用',array(1=>'是',0=>'否'));?>
          <?php echo Form::date('create_time',date('Y-m-d H:i:s'),'添加时间','默认是当前时间');?>
          <?php echo Form::input('url','','链接地址','外链地址，非外链则留空','以http://开头');?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="worker_add">立即提交</button>
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
  form.on('submit(worker_add)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("worker/add")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("worker/index",["category_id"=>$category_id])}');
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