{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item"><?php echo $categorys[$category_id]['name']; ?> - 管理</div>
      <a href="<?php echo url('example/index','category_id='.$category_id) ?>"><li>列表</li></a>
      <a href="<?php echo url('example/add','category_id='.$category_id) ?>"><li class="layui-this">添加</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <?php echo Form::select_no_option('category_id','','所属栏目','',$model_category_select_option,'required');?>
          <?php echo Form::input('title','','标题','','请输入标题','required');?>
          <?php echo Form::file('image_url','','图片','图片','图片地址','','选择','images');?>
          <?php echo Form::file('index_image_url','','首页效果图','首页效果图','图片地址','','选择','images');?>
          <?php echo Form::file('qrcode_url','','二维码','二维码','二维码图片地址','','选择','images');?>
          <?php echo Form::$settings['editor']('content','','内容');?>
          <?php echo Form::input('keywords','','关键词','关键词以英文逗号隔开');?>
          <?php echo Form::textarea('description','','描述','留空时默认截取内容的前250个字符');?>
          <?php echo Form::radio('is_recommend',0,'是否推荐','用于前台推荐调用',array(1=>'是',0=>'否'));?>
          <?php echo Form::date('create_time',date('Y-m-d H:i:s'),'添加时间','默认是当前时间');?>
          <?php echo Form::input('hits',0,'点击量','请输入数字','请输入点击量，默认是0','number');?>
          <?php echo Form::input('website_link','','案例链接地址','案例链接地址，客户网站链接','以http://开头');?>
          <?php echo Form::input('url','','链接地址','外链地址，非外链案例则留空','以http://开头');?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="example_add">立即提交</button>
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
  form.on('submit(example_add)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("example/add")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("example/index",["category_id"=>$category_id])}');
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