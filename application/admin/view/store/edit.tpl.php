{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item"><?php echo $categorys[$store["category_id"]]['name']; ?> - 管理</div>
      <a href="<?php echo url('store/index','category_id='.$store["category_id"]) ?>"><li>列表</li></a>
      <a href="<?php echo url('store/add','category_id='.$store["category_id"]) ?>"><li>添加</li></a>
      <a href="<?php echo url('store/edit','id='.$store["id"]) ?>"><li class="layui-this">修改</li></a>
    </ul> 
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <input type="hidden" name="id" value="<?php echo $store['id'] ?>">
          <?php echo Form::select_no_option('category_id','','所属栏目','',$model_category_select_option,'required');?>
          <?php echo Form::input('title',$store['title'],'标题','','请输入标题','required');?>
          <?php echo Form::input('tel',$store['tel'],'电话','','请输入电话');?>
           <?php echo Form::input('point',$store['point'],'门店坐标','百度地图坐标 <a href="javascript:void(0)" id="get_point"> [点击拾取坐标]</a>','请输入百度地图坐标');?>
          <?php echo Form::textarea('address',$store['address'],'门店地址','小于250个字符');?>
          <?php echo Form::file('image_url',$store['image_url'],'图片','图片','图片地址','','选择','images');?>
          <?php echo Form::input('keywords',$store['keywords'],'标签','标签以英文逗号隔开');?>
          <?php echo Form::textarea('description',$store['description'],'门店简介','小于250个字符');?>
          <?php echo Form::radio('is_recommend',$store['is_recommend'],'是否推荐','用于前台推荐调用',array(1=>'是',0=>'否'));?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="store_edit">立即提交</button>
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
  form.on('submit(store_edit)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("store/edit")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'{:url("store/index",["category_id"=>$store["category_id"]])}');
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

  //拾取地图坐标
  $('#get_point').click(function(){
    var point = $('input[name=point]').val();
    layer.open({
      type: 2, 
      title: '坐标拾取',
      area: ['800px', '500px'],
      content: ['{:url("setting/get_point")}?point='+point+'&name=point','no']
    })
  });   

})
</script>

{include file="public/footer" /}