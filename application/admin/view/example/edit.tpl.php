{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item"><?php echo $categorys[$example["category_id"]]['name']; ?> - 管理</div>
      <a href="<?php echo url('example/index','category_id='.$example["category_id"]) ?>"><li>列表</li></a>
      <a href="<?php echo url('example/add','category_id='.$example["category_id"]) ?>"><li>添加</li></a>
      <a href="<?php echo url('example/edit','id='.$example["id"]) ?>"><li class="layui-this">修改</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <input type="hidden" name="id" value="<?php echo $example['id'] ?>">
          <?php echo Form::select_no_option('category_id','','所属栏目','',$model_category_select_option,'required');?>
          <?php echo Form::input('title',$example['title'],'标题','','请输入标题','required');?>
          <?php echo Form::file('image_url',$example['image_url'],'图片','图片','图片地址','','选择','images');?>
          <?php echo Form::file('index_image_url',$example['index_image_url'],'首页效果图','首页效果图','图片地址','','选择','images');?>
          <?php echo Form::file('qrcode_url',$example['qrcode_url'],'二维码','二维码','二维码图片地址','','选择','images');?>
          <?php echo Form::$settings['editor']('content',$example['content'],'内容');?>
          <?php echo Form::input('keywords',$example['keywords'],'关键词','关键词以英文逗号隔开');?>
          <?php echo Form::textarea('description',$example['description'],'描述','留空时默认截取内容的前250个字符');?>
          <?php echo Form::radio('is_recommend',$example['is_recommend'],'是否推荐','用于前台推荐调用',array(1=>'是',0=>'否'));?>
          <?php echo Form::date('create_time',$example['create_time'],'添加时间','默认是当前时间');?>
          <?php echo Form::input('hits',$example['hits'],'点击量','请输入数字','请输入点击量，默认是0','number');?>
          <?php echo Form::input('website_link',$example['website_link'],'案例链接地址','案例链接地址，客户网站链接','以http://开头');?>
          <?php echo Form::input('url',$example['url'],'链接地址','外链地址，非外链文章则留空','以http://开头');?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="example_edit">立即提交</button>
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
  form.on('submit(example_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("example/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("example/index",["category_id"=>$example["category_id"]])}');
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