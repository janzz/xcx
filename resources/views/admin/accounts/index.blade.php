<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>管理员信息</title>
    <link rel="stylesheet" href="/css/content.css" />
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/layui/layui.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/global.js"></script>
</head>
<style>
    .panel-body{
        margin: 15px;
    }
    .panel-primary{
        border-color: #1ab394;
    }
    a{
        text-decoration: none !important;
    }
    .layui-anim-upbit{
        position: fixed !important;
    }
</style>

<body>
<!--<div class="container-fluid" style="margin-top: 10px">
    <div class="panel panel-primary">
        <div class="panel-heading" style="background-color: #1ab394;border-color: #1ab394;">
            <span class="badge" style=" color: #1ab394;">管理员列表</span>
                <i id="add-manager" class="layui-icon" style="float:right;font-size: 20px;margin-top:-5px;cursor:pointer">&#xe654;</i>
        </div>
        <div class="panel-body">
            <form method="get" action="__ACTION__" class='form-inline'>
                <div class="row top_search">

                    <div class="input-group">
                        <div class="input-group-addon">用户名：</div>
                        <input name="search_uname" value="{$search_uname}"
                               type="text" class="form-control" placeholder="请输入用户名">
                    </div>

                </div>

                <div class="row top_search" style="margin-top: 10px">
                    <input type='submit' value='筛选' class='pull-left btn btn-default'/>
                    <a href="__ACTION__" class='pull-left btn btn-default' style="margin-left:10px;"/>重置</a>
                </div>
            </form>
        </div>
    </div>
</div>-->
<div class="container-fluid" style="margin-top: 10px">
    <div class="panel panel-primary">
        <div class="panel-heading" style="background-color: #1ab394;border-color: #1ab394;">
            <span class="badge" style=" color: #1ab394;" >管理员列表</span>
            <i id="add-manager" class="layui-icon" style="float:right;font-size: 20px;margin-top:-5px;cursor:pointer">&#xe654;</i>
        </div>
    </div>
</div>
<div class="container-fluid">
    <table class="layui-table" >
        <colgroup>
            <col width="150">
            <col width="200">
            <col width="200">
            <col width="200">
            <col width="200">
            <col width="100">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>用户名</th>
            <th>姓名</th>
            <th>创建时间</th>
            <th>最后登录时间</th>
            <th>角色</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($pageData as $val):?>
        <tr>
            <td><?php echo $val->uname;?></td>
            <td><?php echo $val->nickname;?></td>
            <td><?php echo $val->reg_time;?></td>
            <td><?php echo $val->last_time;?></td>
            <td><?php foreach($val->roles as $va){
                    echo $va->role_name.',';
                }?>
            </td>
            <td>
                <?php //if($val['role_id'] != 1):?>
                <a class="edit" href="#" attr="<?php echo $val->id;?>"></a>
                <a class="delete" href="#" attr="<?php echo $val->id;?>"></a>
                <?php //endif;?>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>



<div class="container-fluid">
    {!! $pageData->render() !!}
</div>

<div class="container-fluid" id="add-manage-popup" style="display:none;margin-left:20px;margin-top:35px">
<form class="layui-form layui-form-pane" action="">

    <div class="layui-form-item" id="username-ipt">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-inline">
            <input name="uname" lay-verify="required" placeholder="请输入用户名"  class="layui-input" type="text" id="username">
        </div>
    </div>
    <div class="layui-form-item" >
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-inline">
            <input name="name"  placeholder="请输入姓名"  class="layui-input" type="text" id="name">
        </div>
    </div>

    <div class="layui-form-item" id="pwd-ipt">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
            <input name="pwd" placeholder="请输入密码" lay-verify="required" class="layui-input" type="password" id="pwd">
        </div>
    </div>

    <div class="layui-form-item" id="repwd-ipt">
        <label class="layui-form-label">确认密码</label>
        <div class="layui-input-inline">
            <input name="repwd" placeholder="请重复输入密码" lay-verify="required" class="layui-input" type="password" id="repwd">
        </div>
    </div>

    <div class="layui-form-item" >
        <label class="layui-form-label">角色</label>
        <div class="layui-input-inline" style="width:300px">
            <?php foreach($roles as $key => $val):?>
            <input type="checkbox" name="role_{{$val->id}}" title="{{$val->role_name}}" />
            <?php endforeach;?>
        </div>
    </div>

    <div class="layui-form-item" style="text-align:center; width:100%;height:100%;margin-left:-28px; " >
        <div class="layui-btn" lay-submit="" lay-filter="demo2" id="sub-btn">添加</div>
        <input name="action" type="hidden" class="layui-input" value="add" id="action">
        <input name="eid" type="hidden" class="layui-input" value="" id="eid">
    </div>
</form>

</div>
</body>

<script>
    $(function () {
        //分页
        //globalFn.lypage('page', "{$data['pages']}", "Admin/Account/index");

        //点击删除
        $('.delete').click(function(){
            //询问框
            var id = $(this).attr('attr');
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('您确定要删除该账号吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    _index1 = layer.load();
                    $.post("{{route('account.del')}}",{'_token':'{{csrf_token()}}',id:id},function(res){
                        res.status == 1 ? globalFn.remind(_index1, res.msg,"{{route('account.index')}}")
                            : globalFn.remind(_index1, res.msg);
                    })
                });
            });

        });

        //点击添加
        $("#add-manager").click(function(){
            accountFn.emptyInput();
            accountFn.inputShow();
            globalFn.lyPopup('添加管理员', ['500px', '500px'],'add-manage-popup',1);
        })

        //点击编辑
        $(".edit").click(function(){
            accountFn.emptyInput();
            $.post("{{route('account.find')}}",{'_token':'{{csrf_token()}}',id:$(this).attr('attr')},function(data){
                $("#name").val(data.account.nickname);
                $("#eid").val(data.account.id);

                if(data.role.length>0) {
                    for (var i in data.role)

                      $("input:checkbox[name='role_"+data.role[i].id+"']").next().addClass('layui-form-checked')

                }

                accountFn.inputHide();
            })

            globalFn.lyPopup('编辑管理员', ['500px', '300px'],'add-manage-popup',1);
        })

        layui.use(['form'], function(){
            var form = layui.form,layer = layui.layer;
            //监听提交
            form.on('submit(demo2)', function(data){
                if($("input[name='pwd']").val() != $("input[name='repwd']").val()){
                    layer.msg('两次输入的密码不一致');
                    return false;
                }
                if(!$('.layui-form-checkbox').hasClass('layui-form-checked')){
                    layer.msg('请选择分类');
                    return false;
                }
                _index = layer.load();
                //layui.form.render();
                if($('#eid').val()){
                    var idarr = [];
                    $('.layui-form-checkbox ').each(function(){
                        $(this).hasClass('layui-form-checked') && idarr.push($(this).prev().attr('name'))
                    })
                }
                $.ajax({
                    url: "{{route('account.create')}}",
                    type:"post",     //请求类型
                    data:{
                        '_token':'{{csrf_token()}}',
                        uname:$('#username').val(),
                        eid:$('#eid').val(),
                        idarr: idarr,
                        data:JSON.stringify(data.field),
                    },  //请求的数据
                    dataType:"json",  //数据类型
                    success: function(data){
                        data.status == 1 ? globalFn.remind(_index, data.msg,"{{route('account.index')}}")
                            : globalFn.remind(_index, data.msg);
                    },

                    error: function(msg) {
                        var json=JSON.parse(msg.responseText);
                        layui.use('layer', function(){
                            var layer = layui.layer;
                            setTimeout(function () { layer.close(_index); }, 1000);
                            setTimeout(function () { layer.msg(json.message) }, 1000);
                        });
                    },

                })
                return false;
            });
        })
    })

    var accountFn = {
        emptyInput:function(){
            $('.layui-form-checkbox').removeClass('layui-form-checked');
            $('#username,#name,#pwd,#repwd,#eid').val('');

        },

        inputShow:function(){
            $('#username-ipt,#pwd-ipt,#repwd-ipt').show();
            $('#username,#pwd,#repwd').attr('lay-verify','required');
            $('#action').val("add");
            $('#sub-btn').text('添加');

        },

        inputHide:function(){
            $('#username-ipt,#pwd-ipt,#repwd-ipt').hide();
            $('#username,#pwd,#repwd').removeAttr('lay-verify');
            $('#action').val("edit");
            $('#sub-btn').text('编辑');

        },

    }

</script>

</html>