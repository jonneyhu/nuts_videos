{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">轮播图 - 管理</div>
      <a href="<?php echo url('focus/index') ?>"><li class="layui-this">列表</li></a>
      <a href="<?php echo url('focus/add') ?>"><li>添加</li></a> 
    </ul>
    <div class="layui-tab-content">
      <div class="layui-tab-item layui-show">
        <div class="table_top_bar"> 
          <a href="javascript:void(0)" id="batches_delete"><i class="layui-icon">&#xe640;</i>删除</a>
          <div class="spacer-gray"></div>
          <a href="<?php echo url('focus/index') ?>"><i class="layui-icon">&#x1002;</i>刷新</a>
        </div>
        <form class="layui-form">
        <table class="layui-table" lay-even>
          <colgroup>
            <col width="48">
            <col width="70">
            <col width="80">
            <col>
            <col width="90">
            <col width="94">
          </colgroup>
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" lay-skin="primary" lay-filter="checkAll"></th>
              <th>排序</th>
              <th>ID</th>
              <th>标题</th>
              <th>是否启用</th>
              <th>操作</th>
            </tr> 
          </thead>
          <tbody>
          <?php foreach ($focuss['data'] as $v) { ?>
            <tr>
              <td><input type="checkbox" name="ids[<?php echo $v['id'] ?>]" value="<?php echo $v['id'] ?>" lay-skin="primary" lay-filter="checkOne"></td>
              <td class="input_td"><input name="sorts[<?php echo $v['id'] ?>]" type='text' value="<?php echo $v['sort'] ?>" lay-verify="number" class='layui-input'></td>
              <td><?php echo $v['id']; ?></td>
              <td>
                <?php echo $v['title']; ?>
                <?php if($v['image_url']){ ?>
                <a class="thumb" href="<?php echo $v['image_url'] ?>" target="_blank" thumb="<?php echo thumb($v['image_url'],200,200) ?>"><i class="layui-icon">&#xe64a;</i></a>
                <?php  } ?> 
              </td>
              <td style="text-align: center;">
                <?php if($v['is_show'] != 1){ ?>
                <a href="javascript:void(0)" class="list-switch list-switch-off is_show" data-id="<?php echo $v['id'] ?>" title="点击开启"><i class="layui-icon">&#x1006;</i></a>
                <?php }else{ ?>
                <a href="javascript:void(0)" class="list-switch list-switch-on is_show" data-id="<?php echo $v['id'] ?>" title="点击关闭"><i class="layui-icon">&#xe605;</i></a>
                <?php } ?>
              </td>
              <td>
                <a href="<?php echo url('focus/edit',['id'=>$v['id']]) ?>" class="layui-btn layui-btn-mini" title="编辑"><i class="layui-icon">&#xe642;</i></a>
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" focus-id="<?php echo $v['id'] ?>" title="删除"><i class="layui-icon">&#xe640;</i></a>
              </td>
            </tr>
          <?php } ?>
          </tbody>
          <thead>
            <tr>
              <th colspan="8"><button class="layui-btn layui-btn-mini" lay-submit lay-filter="sort">排序</button></th>
            </tr>  
          </thead>
        </table>
        </form>
      </div>
    </div>
</div>
<script type="text/javascript">
layui.use(['element','table','form','laypage'], function(){
  var element = layui.element
  ,table = layui.table
  ,form = layui.form
  ,laypage = layui.laypage
  ,$ = layui.jquery;

  //图片预览
  $('.layui-table td .thumb').hover(function(){
    $(this).append('<img class="thumb-show" src="'+$(this).attr('thumb')+'" >');
  },function(){
    $(this).find('img').remove();
  });
  //全选
  form.on('checkbox(checkAll)', function(data){
    if(data.elem.checked){
      $("input[type=checkbox]").prop('checked',true);
    }else{
      $("input[type=checkbox]").prop('checked',false);
    }
    form.render('checkbox');
  }); 
  form.on('checkbox(checkOne)', function(data){
    var is_check = true;
    if(data.elem.checked){
      $("input[lay-filter=checkOne]").each(function(){
        if(!$(this).prop('checked')){ is_check = false; }
      });
      if(is_check){
        $("input[lay-filter=checkAll]").prop('checked',true);
      }
    }else{
      $("input[lay-filter=checkAll]").prop('checked',false);
    } 
    form.render('checkbox');
  });

  //批量删除
  $('#batches_delete').click(function(){
    var ids = [];
    $("input[lay-filter=checkOne]").each(function(){
      if($(this).prop('checked')){ ids.push($(this).val()); }
    });
    if(ids.length<1){show_msg('请选择数据',2);return false;}
    //确认删除
    layer.confirm('确定删除['+ids+']?', function(index){
      loading = custom_loading();
      $.ajax({
        type:'post',
        dataType:'json',
        url:'{:url("focus/batches_delete")}',
        data:{'ids':ids},
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
      })
    });
  });
  //ajax删除
  $('.del_btn').click(function(){
    var this_tr = $(this).parents('tr');
    var id = $(this).attr('focus-id');
    layer.confirm('确定删除【'+id+'】?', function(index){
      loading = custom_loading();
      $.ajax({
        type:'post',
        dataType:'json',
        url:'{:url("focus/del")}',
        data:{'id':id},
        success:function(data){
          if(data.code == 200){
            this_tr.remove();
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
  });
  //监听提交
  form.on('submit(sort)', function(data){
    loading = custom_loading();
    var param = data.field;
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("focus/sort")}',
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
  //推荐
  $('.is_show').click(function(){
    loading = custom_loading();
    var row = $(this);
    var id = $(this).attr('data-id');
    $.ajax({
      type:'post',
      dataType:'json',
      url:'{:url("focus/to_show")}',
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
    })
  });

})
</script>

{include file="public/footer" /}