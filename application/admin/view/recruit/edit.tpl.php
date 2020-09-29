{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item"><?php echo $categorys[$recruit["category_id"]]['name']; ?> - 管理</div>
      <a href="<?php echo url('recruit/index','category_id='.$recruit["category_id"]) ?>"><li>列表</li></a>
      <a href="<?php echo url('recruit/add','category_id='.$recruit["category_id"]) ?>"><li>添加</li></a>
      <a href="<?php echo url('recruit/edit','id='.$recruit["id"]) ?>"><li class="layui-this">修改</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <input type="hidden" name="id" value="<?php echo $recruit['id'] ?>">
          <?php echo Form::select_no_option('category_id','','所属栏目','',$model_category_select_option,'required');?>
          <?php echo Form::input('title',$recruit['title'],'标题','','请输入标题','required');?>
          <?php echo Form::input('type',$recruit['type'],'职位类别','','请输入职位类别');?>
          <?php echo Form::input('salary',$recruit['salary'],'职位薪水','如：6000/月 或者 面议','请输入职位薪水');?>
          <?php echo Form::input('address',$recruit['address'],'工作地点','','请输入工作地点');?>
          <?php echo Form::input('nums',$recruit['nums'],'招聘人数','如：5人 或者 不限','请输入招聘人数');?>
          <?php echo Form::$settings['editor']('duty',$recruit['duty'],'工作职责');?>
          <?php echo Form::$settings['editor']('requirement',$recruit['requirement'],'岗位要求');?>
          <?php echo Form::radio('is_recommend',$recruit['is_recommend'],'是否推荐','用于前台推荐调用',array(1=>'是',0=>'否'));?>
          <?php echo Form::date('create_time',$recruit['create_time'],'添加时间','默认是当前时间');?>
          <?php echo Form::input('hits',$recruit['hits'],'点击量','请输入数字','请输入点击量，默认是0','number');?>
          <?php echo Form::input('url',$recruit['url'],'链接地址','外链地址，非外链则留空','以http://开头');?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="recruit_edit">立即提交</button>
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
  form.on('submit(recruit_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("recruit/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("recruit/index",["category_id"=>$recruit["category_id"]])}');
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