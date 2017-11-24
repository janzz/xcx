<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>色列表</title>

    <link rel="stylesheet" href="/css/content.css" />
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/layui/layui.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/global.js"></script>
</head>
<style>
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
            <span class="badge" style=" color: #1ab394;" >角色列表</span>
                <i id="add-manager" class="layui-icon" style="float:right;font-size: 20px;margin-top:-5px;cursor:pointer">&#xe654;</i>
        </div>
    </div>
</div>
<div class="container-fluid">
    <table class="layui-table" >
        <colgroup>
            <col width="150">
            <col width="200">
            <col width="60">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>角色名称</th>
            <th>角色说明</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($pageData as $val):?>
        <tr>
            <td><?php echo $val->role_name;?></td>
            <td><?php echo $val->role_declare;?></td>
            <td>
                <?php if($val->id != 1):?>
                <a class="edit" href="{{route('role.find', ['id'=>$val->id])}}"></a>
                <a class="delete" href="#" attr="{{$val->id}}"></a>
                <?php endif;?>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<div class="container-fluid">
    {!! $pageData->render() !!}
</div>


</body>

<script>
    //分页
    //globalFn.lypage('page', "{$data['pages']}","Admin/Role/index");

    $('.delete').click(function(){
        //询问框
        var id = $(this).attr('attr');
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.confirm('您确定要删除该角色吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                _index = layer.load();
                $.post("{{route('role.del')}}",{'_token':'{{csrf_token()}}',id:id},function(data){
                    data.status == 1 ? globalFn.remind(_index, data.msg,"{{route('role.index')}}")
                        : globalFn.remind(_index, data.msg);
                })
            });
        });
    })

    $("#add-manager").click(function(){
        window.location.href ="{{route('role.create')}}";
    })

    layui.use(['form'], function(){})
</script>

</html>