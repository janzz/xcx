<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PAGE后台登录</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!-- load css -->
    <link rel="stylesheet" type="text/css" href="/js/layui/css/layui.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/login.css" media="all">
</head>
<body>
<div class="layui-canvs"></div>
<div class="layui-layout layui-layout-login">
    <h1>
        <strong>管理系统后台</strong>
        <em>Management System</em>
    </h1>
    <div class="layui-user-icon larry-login">
        <input type="text" placeholder="账号" class="login_txtbx username"/>
    </div>
    <div class="layui-pwd-icon larry-login">
        <input type="password" placeholder="密码" class="login_txtbx password"/>
    </div>
    <!--<div class="layui-val-icon larry-login">
    	<div class="layui-code-box">
    		<input type="text" id="code" name="code" placeholder="验证码" maxlength="4" class="login_txtbx">
            <img src="images/verifyimg.png" alt="" class="verifyImg" id="verifyImg" onclick="javascript:this.src='xxx'+Math.random();">
    	</div>
    </div>-->
    <div class="layui-submit larry-login">
        <input type="button" value="立即登陆" class="submit_btn"/>
    </div>
    <div class="layui-login-text">
        <p>© 2017-2018 jan 版权所有</p>
    </div>
</div>
<script type="text/javascript" src="/js/layui/layui.all.js"></script>
<script type="text/javascript" src="/js/login.js"></script>
<script type="text/javascript" src="/js/jparticle.jquery.js"></script>
<script type="text/javascript">
    $(function(){
        $(".layui-canvs").jParticle({
            background: "#141414",
            color: "#E6E6E6"
        });

        //登录链接测试，使用时可删除
        $(".submit_btn").click(function(){
            var username = $.trim($('.username').val());
            var password = $.trim($('.password').val());
            $.ajax({
                url: "{{route('index.verifyLogin')}}",
                type:"post",     //请求类型
                data:{'_token':'{{csrf_token()}}',uname:username,password:password},  //请求的数据
                dataType:"json",  //数据类型
                success: function(data){

                    if(data.status == 0){
                        layui.use('layer', function(){
                            var layer = layui.layer;
                            layer.msg(data.msg,{icon:2,time:2000});
                        });
                    }else if(data.status == 1){
                        layui.use('layer', function(){
                            var layer = layui.layer;
                            layer.msg('登录成功',{icon:1,time:2000}, function(){ window.location.href="{{route('index.index')}}";});
                        });
                    }
                },

                error: function(msg) {
                    var json=JSON.parse(msg.responseText);
                    layui.use('layer', function(){
                        var layer = layui.layer;
                        layer.msg(json.message,{icon:2,time:2000});
                    });
                },

            })

        });
    });
</script>
</body>
</html>