{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
        <div class="main-tab-item">《<?php echo $video['title']; ?>》 - 管理</div>
        <a href="<?php echo url('collection/index','video_id='.$video['id']) ?>"><li class="layui-this">列表</li></a>
        <a href="<?php echo url('collection/add','video_id='.$video['id']) ?>"><li>添加</li></a>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div class="table_top_bar">
                <a href="javascript:void(0)" id="batches_delete"><i class="layui-icon">&#xe640;</i>删除</a>
                
                <div class="spacer-gray"></div>
                <a href="<?php echo url('collection/index','video_id='.$video['id']) ?>"><i class="layui-icon">&#x1002;</i>刷新</a>
                <div class="spacer-gray"></div>
                <div class="table_top_search">
                    <form class="layui-form">
                        搜索：
                        <div class="layui-inline">
                            <input class="layui-input" name="search[title]" autocomplete="off" placeholder="输入标题搜索" value="<?php echo input('param.search.title'); ?>">
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
                        <col width="80">
                        <col>
                        <col width="150">
                        <col width="110">
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
                        <th>剧集数</th>
                        <th>标题</th>
                        <th>所属视频</th>
                        <th>
                            <span>点击量</span>
                            <span class="layui-table-sort layui-inline" lay-sort="<?php echo isset($url_params_arr['order']['hits'])?$url_params_arr['order']['hits']:''; ?>"><a href="?<?php echo $url_params_str ?>&order[hits]=asc" class="layui-edge layui-table-sort-asc"></a><a href="?<?php echo $url_params_str ?>&order[hits]=desc" class="layui-edge layui-table-sort-desc"></a></span>
                        </th>
                        <th>
                            <span>添加时间</span>
                            <span class="layui-table-sort layui-inline" lay-sort="<?php echo isset($url_params_arr['order']['create_time'])?$url_params_arr['order']['create_time']:''; ?>"><a href="?<?php echo $url_params_str ?>&order[create_time]=asc" class="layui-edge layui-table-sort-asc"></a><a href="?<?php echo $url_params_str ?>&order[create_time]=desc" class="layui-edge layui-table-sort-desc"></a></span>
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($collections['data'] as $v) { ?>
                        <tr>
                            <td><input type="checkbox" name="ids[<?php echo $v['id'] ?>]" value="<?php echo $v['id'] ?>" lay-skin="primary" lay-filter="checkOne"></td>
                            <td><?php echo $v['id']; ?></td>
                            <td><?php echo $v['num']; ?></td>
                            <td><?php echo $v['title']; ?></td>
                            <td><?php echo $v['_video']['title']; ?></td>
                            <td><?php echo $v['hits']; ?></td>
                            <td><?php echo $v['create_time']; ?></td>

                            <td>
                                <a href="<?php echo url('collection/edit',['id'=>$v['id']]) ?>" class="layui-btn layui-btn-mini" title="编辑"><i class="layui-icon">&#xe642;</i></a>
                                <a class="layui-btn layui-btn-danger layui-btn-mini del_btn" collection-id="<?php echo $v['id'] ?>" title="删除"><i class="layui-icon">&#xe640;</i></a>
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
                    url:'{:url("collection/batches_delete")}',
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
            var id = $(this).attr('collection-id');
            layer.confirm('确定删除【'+id+'】?', function(index){
                loading = custom_loading();
                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:'{:url("collection/del")}',
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
            ,count: {$collections['total']}
            ,curr: {$collections['current_page']}
            ,limit: {$collections['per_page']}
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