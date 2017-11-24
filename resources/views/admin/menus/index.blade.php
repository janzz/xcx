<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>菜单管理</title>
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
</style>

<body>
<div class="container-fluid" style="margin-top: 10px">
    <div class="panel panel-primary">
        <div class="panel-heading" style="background-color: #1ab394;border-color: #1ab394;">
            <span class="badge" style=" color: #1ab394;" >菜单列表</span>
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
            <th>菜单名称</th>
            <th>上级菜单</th>
            <th>路径</th>
            <th>是否显示</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($pageMenus as $val):?>
        <tr>
            <td><?php echo $val->name;?></td>
            <td><?php echo $val->pname;?></td>
            <td><?php echo $val->route;?></td>
            <td><?php if($val->display == 1)echo '是';else echo '否'?></td>
            <td><?php echo $val->sort;?></td>
            <td>
                <a class="edit" attr="<?php echo $val->id?>" href="#"></a>
                <a class="delete" attr="<?php echo $val->id?>" pid="<?php echo $val->pid?>" href="#"  table="menu"></a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>


<!--分页-->
<div class="container-fluid">
    {!! $pageMenus->render() !!}
</div>

<div class="container-fluid" id="add-manage-popup" style="display:none;margin-left:20px;margin-top:20px">
    <form class="layui-form layui-form-pane" action="">

        <div class="layui-form-item">
            <label class="layui-form-label">菜单名称</label>
            <div class="layui-input-inline">
                <input name="menuname"  placeholder="请输入菜单名称" class="layui-input" type="text" id="menuname">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上级菜单</label>
            <div class="layui-input-inline">
                <select name="quiz3" lay-verify=""  id="menuup" >
                    <option value="0">顶级菜单</option>
                    <?php foreach($allMenus as $val):?>
                    <option value="<?php echo $val['id']?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val['name']?></option>
                    <?php if(!empty($val['son'])):?>
                    <?php foreach($val['son'] as $v):?>
                    <option value="<?php echo $v['id']?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $v['name']?></option>
                    <?php endforeach;endif;endforeach;?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">菜单路径</label>
            <div class="layui-input-inline">
                <input name="menuroute"  placeholder="请输入菜单路径"  class="layui-input" type="text" id="menuroute">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input onkeyup='this.value=this.value.replace(/\D/gi,"")' name="menusort" placeholder="请输入排序数字" class="layui-input" type="text" id="menusort">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">图标</label>
            <div class="layui-input-inline">
                <input name="menuicon" placeholder="例如：fa-home"  class="layui-input" type="text" id="menuicon">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否显示</label>
            <div class="layui-input-block">
                <input name="show" value="1" title="是" checked="" type="radio">
                <input name="show" value="0" title="否" type="radio">
            </div>
        </div>

        <div class="layui-form-item" style="text-align:center; width:100%;height:100%;margin-left:-28px; " >
            <div class="layui-btn"   id="sub-btn" attr="">提交</div>
        </div>
    </form>

</div>
</body>

<script type="text/javascript">
    $(function(){
        //点击添加
        $("#add-manager").click(function(){
            menuFn.emptyInput();
            globalFn.checkRadio(0);
            $('#method').hide();
            globalFn.lyPopup('添加菜单', ['550px', '580px'],'add-manage-popup',1);

        });

        //点击提交
        $('#sub-btn').click(function(){
            layui.use('layer', function(){
                _index = layui.layer.load();
            });
            $.ajax({
                url: "{{route('menu.create')}}",
                type:"post",     //请求类型
                data:{
                    '_token':'{{csrf_token()}}',
                    menuid:$('#sub-btn').attr('attr'),
                    name:$('#menuname').val(),
                    menupid:$('dl').find('dd.layui-this').attr('lay-value'),
                    menuroute:$('#menuroute').val(),
                    menusort:$('#menusort').val(),
                    menuicon:$('#menuicon').val(),
                    menushow: $('.layui-form-radioed').find('span').text() == '是' ? 1 :0,
                },  //请求的数据
                dataType:"json",  //数据类型
                success: function(data){
                    data.status == 1 ? globalFn.remind(_index, data.msg,"{{route('menu.index')}}")
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
        });

        //点击编辑
        $('.edit').click(function(){
            menuFn.emptyInput();
            globalFn.checkRadio(0);
            menuFn.methodEmptyInput();
            $.post("{{route('menu.find')}}",{'_token':'{{csrf_token()}}',id:$(this).attr('attr')},function(data){
                //var data = JSON.parse(data);
                console.log(data);
                $('#menuname').val(data.name);
                data.pname && $('.layui-unselect').val(data.pname);
                $('dl dd').each(function(){
                    $(this).attr('lay-value') == data.pid ? $(this).addClass('layui-this'):$(this).removeClass('layui-this')
                });
                $('#menuroute').val(data.route);
                $('#menusort').val(data.sort);
                $('#menuicon').val(data.icon_class);
                $("#mtd-btn").attr("mpid",data.id); //增加方法的父菜单id
                $('#sub-btn').attr('attr',data.id);
                globalFn.checkRadio(val = data.display == 0 ? 1 :0);

                /*if(data.method.length>0) {
                    for (var i in data.method) {
                        var trStr = "<tr class='m_"+data.method[i].id+"'>" +
                            "<td class='mname_"+data.method[i].id+"'>" + data.method[i].name + "</td>" +
                            "<td class='mroute_"+data.method[i].id+"'>" + data.method[i].route + "</td>" +
                            "<td>" +
                            "<i class='layui-icon medit' attr='"+data.method[i].id+"' style='font-size: 18px;margin-right:5px'>&#xe642;</i>" +
                            "<i class='layui-icon mdel' attr='"+data.method[i].id+"' style='font-size: 18px;'>&#xe640;</i>" +
                            "</td>" +
                            "</tr>";
                        $("#method tbody").append(trStr);
                    }
                }*/
                $('#method').show();
                globalFn.lyPopup('编辑菜单', ['600px', '600px'],'add-manage-popup',1);
            })
        });


        //点击删除
        $('.delete').click(function(){
            //询问框
            var id = $(this).attr('attr');
            var table = $(this).attr('table');
            var pid = $(this).attr('pid') == 0 ?  $(this).attr('attr') : 'no';
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('您确定要删除该菜单吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    _index1 = layer.load();
                    $.post("{{route('menu.del')}}",{'_token':'{{csrf_token()}}',id:id,pid:pid},function(res){
                        res.status == 1 ? globalFn.remind(_index1, res.msg,"{{route('menu.index')}}")
                            : globalFn.remind(_index1, res.msg);
                    })
                });
            });

        });

        //layer表单
        layui.use(['form', 'layedit', 'laydate'], function(){})
    });

    var menuFn = {
        emptyInput:function(){
            $('#menuname').val("");
            $('#sub-btn').attr('attr','');
            $('.layui-unselect').val('顶级菜单');
            $('#menuroute').val("");
            $('#menusort').val("");
            $('#menuicon').val("");
            $('dl dd').each(function(){
                $(this).attr('lay-value') == 0 ? $(this).addClass('layui-this'):$(this).removeClass('layui-this');
            })
        },

        methodEmptyInput:function(){
            $("#method tbody").children().remove();
            $("#mtd-btn i").html("&#xe654;");
            $("#methodname").val('');
            $("#methodroute").val('');
        },

        checkMethodInput:function(){
            if($.trim($("#methodname").val()) == ''){
                layui.use('layer', function(){

                    layui.layer.msg('请输入方法名称');

                });
                return false;
            }else{
                return true;
            }

            if($.trim($("#methodroute").val()) == ''){
                layui.use('layer', function(){
                    layui.layer.msg('请输入方法路径');
                });
                return false;

            }else{

                return true;
            }
        },

    }


</script>

</html>