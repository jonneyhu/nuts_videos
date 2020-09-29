{include file="public/toper" /}
<style type="text/css">html{background: #eee;}</style>
<div class="login_page">
    <?php if(isset($settings['logo']) && $settings['logo']){?>
        <img class="logo-login" src="<?php echo $settings['logo']; ?>" alt="logo">
    <?php } ?>

    <h1>欢迎使用</h1>
    <form class="layui-form">
        <div class="layui-form-item">
            <div class="layui-input-inline input-custom-width">
                <input type="text" name="username" lay-verify="required" placeholder="用户名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline input-custom-width">
                <input type="password" name="password" lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline input-custom-width">
                <input type="text" name="captcha" lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">
                <div class="captcha"><img src="{:captcha_src()}" alt="captche" title='点击切换' onclick="this.src='/captcha?id='+Math.random()"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline input-custom-width">
              <button class="layui-btn input-custom-width" lay-submit="" lay-filter="login">立即登陆</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
layui.use('form',function(){
    var form = layui.form
    ,$ = layui.jquery;
    //监听提交
      form.on('submit(login)', function(data){
        loading = custom_loading();
        var param = data.field;
        $.ajax({
            type:'post',
            dataType:'json',
            url:'{:url("login/login")}',
            data:param,
            success:function(data){
                if(data.code == 200){
                    show_msg(data.msg,1,'{:url("index/index")}');
                }else{
                    show_msg(data.msg,2);
                    $('.captcha img').attr('src','/captcha?id='+Math.random());
                }
            },
            error:function(result){
                console.log(result);
                show_msg(result.statusText+'，状态码：'+result.status,2,'',2000);
            }
        });
        return false;
      });
});
</script>
{include file="public/footer" /}