{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item"><?php echo $categorys[$download["category_id"]]['name']; ?> - 管理</div>
      <a href="<?php echo url('download/index','category_id='.$download["category_id"]) ?>"><li>列表</li></a>
      <a href="<?php echo url('download/add','category_id='.$download["category_id"]) ?>"><li>添加</li></a>
      <a href="<?php echo url('download/edit','id='.$download["id"]) ?>"><li class="layui-this">修改</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <input type="hidden" name="id" value="<?php echo $download['id'] ?>">
          <?php echo Form::select_no_option('category_id','','所属栏目','',$model_category_select_option,'required');?>
          <?php echo Form::input('title',$download['title'],'标题','','请输入标题','required');?>
          <?php echo Form::file('image_url',$download['image_url'],'图片','图片','图片地址','','选择','images');?>
          <?php echo Form::file('file_url',$download['file_url'],'下载文件','文件','文件地址','','选择','file');?>
          <?php echo Form::input('filename',$download['filename'],'文件名','前台下载之后的文件名','请输入文件名');?>
          <?php echo Form::input('demo_url',$download['demo_url'],'演示地址','链接以http://开始','请输入演示地址');?>
          <?php echo Form::$settings['editor']('content',$download['content'],'文件详情');?>
          <?php echo Form::textarea('description',$download['description'],'文件描述');?>
          <?php echo Form::radio('is_recommend',$download['is_recommend'],'是否推荐','用于前台推荐调用',array(1=>'是',0=>'否'));?>
          <?php echo Form::date('create_time',$download['create_time'],'添加时间','默认是当前时间');?>
          <?php echo Form::input('hits',$download['hits'],'点击量','请输入数字','请输入点击量，默认是0','number');?>
          <?php echo Form::input('download_num',$download['download_num'],'下载量','请输入数字','请输入下载量，默认是0','number');?>
          <?php echo Form::input('url',$download['url'],'链接地址','外链地址，非外链文件则留空','以http://开头');?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="download_edit">立即提交</button>
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
  form.on('submit(download_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("download/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("download/index",["category_id"=>$download["category_id"]])}');
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