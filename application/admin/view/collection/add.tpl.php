{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
        <div class="main-tab-item">《<?php echo $video['title']; ?>》 - 管理</div>
        <a href="<?php echo url('collection/index','video_id='.$video['id']) ?>"><li >列表</li></a>
        <a href="<?php echo url('collection/add','video_id='.$video['id']) ?>"><li class="layui-this">添加</li></a>
    </ul>
    <div class="layui-tab-content">
        <form class="layui-form">
            <div class="layui-tab-item layui-show">
                <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">
                <?php echo Form::input('num','','剧集数','','请输入剧集数','required');?>
                <?php echo Form::input('title','','标题','','请输入标题');?>
                <?php echo Form::file('video_url','','视频地址','视频','视频地址','','选择','file');?>
                <?php echo Form::date('create_time',date('Y-m-d H:i:s'),'添加时间','默认是当前时间');?>
                <?php echo Form::input('hits',0,'点击量','请输入数字','请输入点击量，默认是0','number');?>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="collection_add">立即提交</button>
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
        form.on('submit(collection_add)', function(data){
            loading = custom_loading();
            var param = data.field;
            $.ajax({
                type:'post',
                dataType:'json',
                url:'{:url("collection/add")}',
                data:param,
                success:function(data){
                    if(data.code == 200){
                        show_msg(data.msg,1,'{:url("collection/index",["video_id"=>$video[\'id\']])}');
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