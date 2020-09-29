{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">留言 - 管理</div>
      <a href="<?php echo url('feedback/index') ?>"><li class="layui-this">列表</li></a>
    </ul>
    <div class="layui-tab-content">
      <div class="layui-tab-item layui-show">
        <div class="table_top_bar"> 
          <a href="javascript:void(0)" id="batches_delete"><i class="layui-icon">&#xe640;</i>删除</a>
          <div class="spacer-gray"></div>
          <a href="<?php echo url('feedback/index') ?>"><i class="layui-icon">&#x1002;</i>刷新</a>
          <div class="spacer-gray"></div>
          <div class="table_top_search">
            <form class="layui-form">
              搜索：
              <div class="layui-inline">
                <input class="layui-input" name="search[name]" autocomplete="off" placeholder="输入姓名搜索" value="<?php echo input('param.search.name'); ?>">
              </div>
              <button class="layui-btn layui-btn-mini" lay-submit="" lay-filter="search">搜索</button>
            </form>
          </div>
        </div>
        <form class="layui-form">
        <table class="layui-table" lay-even>
          <colgroup>
            <col width="48">
            <col width="80">
            <col width="150">
            <col width="150">
            <col>
            <col width="175">
            <col width="175">
            <col width="94">
          </colgroup>
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" lay-skin="primary" lay-filter="checkAll"></th>
              <th>
                <span>ID</span>
                <span class="layui-table-sort layui-inline" lay-sort="<?php echo isset($url_params_arr['order']['id'])?$url_params_arr['order']['id']:''; ?>"><a href="?<?php echo $url_params_str ?>&order[id]=asc" class="layui-edge layui-table-sort-asc"></a><a href="?<?php echo $url_params_str ?>&order[id]=desc" class="layui-edge layui-table-sort-desc"></a></span>
              </th>
              <th>姓名</th>
              <th>电话</th>
              <th>内容</th>
              <th>
                <span>留言时间</span>
                <span class="layui-table-sort layui-inline" lay-sort="<?php echo isset($url_params_arr['order']['create_time'])?$url_params_arr['order']['create_time']:''; ?>"><a href="?<?php echo $url_params_str ?>&order[create_time]=asc" class="layui-edge layui-table-sort-asc"></a><a href="?<?php echo $url_params_str ?>&order[create_time]=desc" class="layui-edge layui-table-sort-desc"></a></span>
              </th>
              <th>
                <span>回复时间</span>
                <span class="layui-table-sort layui-inline" lay-sort="<?php echo isset($url_params_arr['order']['reply_time'])?$url_params_arr['order']['reply_time']:''; ?>"><a href="?<?php echo $url_params_str ?>&order[reply_time]=asc" class="layui-edge layui-table-sort-asc"></a><a href="?<?php echo $url_params_str ?>&order[reply_time]=desc" class="layui-edge layui-table-sort-desc"></a></span>
              </th>
              <th>操作</th>
            </tr> 
          </thead>
          <tbody>
          <?php foreach ($feedbacks['data'] as $v) { ?>
            <tr>
              <td><input type="checkbox" name="ids[<?php echo $v['id'] ?>]" value="<?php echo $v['id'] ?>" lay-skin="primary" lay-filter="checkOne"></td>
              <td><?php echo $v['id']; ?></td>
              <td><?php echo $v['name']; ?></td>
              <td><?php echo $v['mobile']; ?></td>
              <td><a class="list-title" href="javascript:void(0)" feedback-id="<?php echo $v['id'] ?>"><div class="feedback_content_td"><?php echo $v['content']; ?></div></a></td>
              <td><?php echo $v['create_time']; ?></td>
              <td><?php if($v['reply_time'] != 0){echo date('Y-m-d H:i:s',$v['reply_time']);}else{ echo '未回复[<a class="reply_btn" href="javascript:void(0)" feedback-id="'.$v['id'].'">点击回复</a>]';} ?></td>
              <td>
                <a href="<?php echo url('feedback/edit',['id'=>$v['id']]) ?>" class="layui-btn layui-btn-mini" title="编辑"><i class="layui-icon">&#xe642;</i></a>
                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" feedback-id="<?php echo $v['id'] ?>" title="删除"><i class="layui-icon">&#xe640;</i></a>
              </td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        <div class="layui-table-tool list_page"><div id="page"></div></div>
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
  //留言预览
  $('.list-title').click(function(){ 
    var id = $(this).attr('feedback-id');
    $.post('{:url("feedback/get_content")}',{'id':id}, function(data){
      if(data.code == 200){
        layer.open({
          type: 1,
          area: ['600px'],
          title: '留言内容',
          content: '<div style="padding:15px 20px;min-height: 300px;line-height:26px;">'+data.content+'</div>' //注意，如果str是object，那么需要字符拼接。
        }); 
      }else{
        show_msg(data.msg,2);
      }
      
    });
  });
  //留言回复
  $('.reply_btn').click(function(){
    var id = $(this).attr('feedback-id');
    layer.open({
      type: 2,
      icon: 2,
      maxmin: true,
      area: ['800px','500px'],
      title: '回复内容',
      content: ['{:url("feedback/reply")}?id='+id, 'no']
    });
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
        url:'{:url("feedback/batches_delete")}',
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
    var id = $(this).attr('feedback-id');
    layer.confirm('确定删除【'+id+'】?', function(index){
      loading = custom_loading();
      $.ajax({
        type:'post',
        dataType:'json',
        url:'{:url("feedback/del")}',
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

  //分页
  laypage.render({
    elem: 'page'
    ,count: {$feedbacks['total']}
    ,curr: {$feedbacks['current_page']}
    ,limit: {$feedbacks['per_page']}
    ,limits: [10, 15, 20, 30, 40, 50]
    ,prev: '<i class="layui-icon">&#xe603;</i>'
    ,next: '<i class="layui-icon">&#xe602;</i>'
    ,layout: [ 'prev', 'page', 'next', 'skip', 'count','limit']
    ,jump: function(obj, first){
      //首次不执行
      if(!first){
        location.href = '?<?php echo $url_params_str; ?>&page='+obj.curr+'&limit='+obj.limit;
      }
    }
  });

})
</script>

{include file="public/footer" /}