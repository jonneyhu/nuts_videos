{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">栏目管理</div>
      <a href="<?php echo url('category/index') ?>"><li class="layui-this">栏目列表</li></a>
      <a href="<?php echo url('category/add') ?>"><li>添加栏目</li></a>
      <a href="<?php echo url('category/add','model_id=0') ?>"><li>添加外部链接</li></a>
    </ul>
    <div class="layui-tab-content">
      <div class="layui-tab-item layui-show">
      <form class="layui-form">
        <table class="layui-table" lay-even>
          <colgroup>
            <col width="70">
            <col width="90">
            <col>
            <col>
            <!--<col width="110">-->
            <col width="90">
            <col width="120">
          </colgroup>
          <thead>
            <tr>
              <th>排序</th>
              <th>ID</th>
              <th>栏目名称</th>
              <th>所属模型</th>
              <!--<th style="text-align: center;">开启封面页</th>-->
              <th style="text-align: center;">导航显示</th>
              <th>操作</th>
            </tr> 
          </thead>
          <tbody>
          <?php foreach ($category_list as $v) { ?>
            <tr>
              <td class="input_td"><input name="sorts[<?php echo $v['id'] ?>]" type='text' value="<?php echo $v['sort'] ?>" lay-verify="number" class='layui-input'></td>
              <td><?php echo $v['id'] ?></td>
              <td>
                <?php echo $v['sep_name']; ?> 
                <?php if($v['image_url']){ ?>
                <a class="thumb" href="<?php echo $v['image_url'] ?>" target="_blank" thumb="<?php echo thumb($v['image_url'],200,200) ?>"><i class="layui-icon">&#xe64a;</i></a>
                <?php  } ?> 
                <?php if($v['url'] && $v['model_id'] == 0){ ?>
                <a href="<?php echo $v['url'] ?>" target="_blank" class="link"><i class="layui-icon">&#xe64c;</i></a>
                <?php  } ?> 
              </td>
              <td><?php 
              if($v['model_id'] == 0){
                echo '<span style="color:red">外部链接</span>';
              }else{
                echo $v['model_name'];
              }
              ?></td>
              <!--<td align="center">
              <?php /*if(isset($categorys[0][$v['id']])){ */?>
                <?php /*if($v['is_cover'] != 1){ */?>
                  <a href="javascript:void(0)" class="list-switch list-switch-off is_cover" category-id="<?php /*echo $v['id'] */?>" title="点击开启"><i class="layui-icon">&#x1006;</i></a>
                <?php /*}else{ */?>
                  <a href="javascript:void(0)" class="list-switch list-switch-on is_cover" category-id="<?php /*echo $v['id'] */?>" title="点击关闭"><i class="layui-icon">&#xe605;</i></a>
                <?php /*} */?>
              <?php /*}else{ */?>
                -
              <?php /*} */?>
              </td>-->
              <td align="center">
              <?php if($v['is_menu'] != 1){ ?>
                <a href="javascript:void(0)" class="list-switch list-switch-off is_menu" category-id="<?php echo $v['id'] ?>" title="点击开启"><i class="layui-icon">&#x1006;</i></a>
              <?php }else{ ?>
                <a href="javascript:void(0)" class="list-switch list-switch-on is_menu" category-id="<?php echo $v['id'] ?>" title="点击关闭"><i class="layui-icon">&#xe605;</i></a>
              <?php } ?>
              </td>
              <td class="btn_td" align="center">
              <a href="<?php echo url('category/edit','id='.$v['id']) ?>" class="layui-btn layui-btn-mini" title="编辑"><i class="layui-icon">&#xe642;</i></a>
              <a class="layui-btn layui-btn-mini layui-btn-danger del_btn" category-id="<?php echo $v['id'] ?>" title="删除" category-name='<?php echo $v['name'] ?>'><i class="layui-icon">&#xe640;</i></a>
              </td>
            </tr>
          <?php } ?>
          </tbody>
          <thead>
            <tr>
              <th colspan="7"><button class="layui-btn layui-btn-mini" lay-submit lay-filter="sort">排序</button></th>
            </tr> 
          </thead>
        </table>
      </form>
      </div>
    </div>
</div>

<script type="text/javascript">
layui.use(['element', 'form'], function(){
  var element = layui.element
  ,$ = layui.jquery
  ,form = layui.form;

  //图片预览
  $('.layui-table td .thumb').hover(function(){
    $(this).append('<img class="thumb-show" src="'+$(this).attr('thumb')+'" >');
  },function(){
    $(this).find('img').remove();
  });
  //链接预览
  $('.layui-table td .link').hover(function(){
    var link = $(this).attr('href');
    layer.open({
      type: 4,
      shade: false,
      closeBtn : false,
      content: [link, this] //数组第二项即吸附元素选择器或者DOM
    });
  },function(){
    layer.closeAll('tips');
  });

  //监听提交
  form.on('submit(sort)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("category/sort")}',
      data:param,
      success:function(data){
        if(data.code == 200){
          show_msg(data.msg,1,'reload');
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

  //ajax删除
  $('.del_btn').click(function(){
    var name = $(this).attr('category-name');
    var id = $(this).attr('category-id');
    layer.confirm('确定删除【'+name+'】?', function(index){
      loading = custom_loading();
      $.ajax({
        type:'post',
        dataType:'json',
        url:'{:url("category/del")}',
        data:{'id':id},
        success:function(data){
          if(data.code == 200){
            show_msg(data.msg,1,'reload');
          }else{
            show_msg(data.msg,2);
          }
        },
        error:function(result){
          show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
        }
      });
    });
  });

  //导航是否显示
  $('.is_menu').click(function(){
    var id = $(this).attr('category-id');
    loading = custom_loading();
    var row = $(this);
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("category/menu_switch")}',
      data:{'id':id},
      success:function(data){
        if(data.code == 200){
          if(row.hasClass('list-switch-off')){
            row.removeClass('list-switch-off').find('.layui-icon').html('&#xe605;');
            row.attr('title','点击开启');
          }else{
            row.addClass('list-switch-off').find('.layui-icon').html('&#x1006;');
            row.attr('title','点击关闭');
          }
          show_msg(data.msg,1);
        }else{
          show_msg(data.msg,2);
        }
      },
      error:function(result){
        show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
      }
    });
  });
  //是否显示封面
  $('.is_cover').click(function(){
    var id = $(this).attr('category-id');
    loading = custom_loading();
    var row = $(this);
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("category/cover_switch")}',
      data:{'id':id},
      success:function(data){
        if(data.code == 200){
          if(row.hasClass('list-switch-off')){
            row.removeClass('list-switch-off').find('.layui-icon').html('&#xe605;');
            row.attr('title','点击开启');
          }else{
            row.addClass('list-switch-off').find('.layui-icon').html('&#x1006;');
            row.attr('title','点击关闭');
          }
          show_msg(data.msg,1);
        }else{
          show_msg(data.msg,2);
        }
      },
      error:function(result){
        show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
      }
    });
  });

})
</script> 
</body>
</html>