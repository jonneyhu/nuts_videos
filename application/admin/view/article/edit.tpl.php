{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item"><?php echo $categorys[$article["category_id"]]['name']; ?> - 管理</div>
      <a href="<?php echo url('article/index','category_id='.$article["category_id"]) ?>"><li>列表</li></a>
      <a href="<?php echo url('article/add','category_id='.$article["category_id"]) ?>"><li>添加</li></a>
      <a href="<?php echo url('article/edit','id='.$article["id"]) ?>"><li class="layui-this">修改</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <input type="hidden" name="id" value="<?php echo $article['id'] ?>">
          <?php echo Form::select_no_option('category_id','','所属栏目','',$model_category_select_option,'required');?>
          <?php echo Form::input('title',$article['title'],'标题','','请输入标题','required');?>
          <?php echo Form::file('image_url',$article['image_url'],'图片','图片','图片地址','','选择','images');?>
          <?php echo Form::umeditor('content',$article['content'],'内容');?>
          <?php echo Form::input('keywords',$article['keywords'],'关键词','关键词以英文逗号隔开');?>
          <?php echo Form::textarea('description',$article['description'],'描述','留空时默认截取内容的前250个字符');?>
          <?php echo Form::radio('is_recommend',$article['is_recommend'],'是否推荐','用于前台推荐调用',array(1=>'是',0=>'否'));?>
          <?php echo Form::date('create_time',$article['create_time'],'添加时间','默认是当前时间');?>
          <?php echo Form::input('hits',$article['hits'],'点击量','请输入数字','请输入点击量，默认是0','number');?>
          <?php echo Form::input('url',$article['url'],'链接地址','外链地址，非外链文章则留空','以http://开头');?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="article_edit">立即提交</button>
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
  form.on('submit(article_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("article/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("article/index",["category_id"=>$article["category_id"]])}');
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