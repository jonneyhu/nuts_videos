{include file="public/toper" /}
<div class="layui-tab layui-tab-brief main-tab-container">
    <ul class="layui-tab-title main-tab-title">
      <div class="main-tab-item">资料修改</div>
    </ul>
    <div class="layui-tab-content">
       <form class="layui-form">
        <div class="layui-tab-item layui-show">
          <input type="hidden" name="id" value="<?php echo $admin_user['id'] ?>">
          <?php echo Form::input('username',$admin_user['username'],'用户名','','请输入用户名','username');?>
          <?php echo Form::pass('password','','密码','留空则为不修改','请输密码','password');?>
          <?php echo Form::input('name',$admin_user['name'],'姓名','管理员姓名','请输入姓名');?>
          <?php echo Form::file('avatar',$admin_user['avatar'],'头像','管理员头像','图片地址','','选择','images');?>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="" lay-filter="edit">立即提交</button>
            </div>
          </div>
        </div>   
      </form>
    </div>
</div>
<script type="text/javascript">
layui.use(['form', 'upload'],function(){ 
    var form = layui.form
    ,upload = layui.upload
    ,$ = layui.jquery;

    //自定义验证规则
      form.verify({
        username: function(value,item){
          if(value.length < 4){
            return '用户名至少得4个字符';
          }
          if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
            return '用户名不能有特殊字符';
          }
          if(/(^\_)|(\__)|(\_+$)/.test(value)){
            return '用户名首尾不能出现下划线\'_\'';
          }
          if(/^\d+\d+\d$/.test(value)){
            return '用户名不能全为数字';
          }
        }
        ,password: function(value,item){
          if(value.length > 0 && value.length < 6 ){
            return '密码至少也得6位吧';
          }
        }
      });

    //监听提交
      form.on('submit(edit)', function(data){
        loading = custom_loading();
        var param = data.field;
        $.ajax({
          type:'post',
          dataType:'json',
          url:'{:url("admin/edit")}',
          data:param,
          success:function(data){
            if(data.code == 200){
              show_msg(data.msg,1);
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
});
</script>
{include file="public/footer" /}