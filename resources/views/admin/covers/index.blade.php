<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>商品管理</title>
    <link rel="stylesheet" href="/css/content.css" />
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/js/webuploader-0.1.5/webuploader.css">
    <link rel="stylesheet" href="/js/zoomify/dist/zoomify.min.css">
    <link rel="stylesheet" href="/js/zoomify/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/layui/layui.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/webuploader-0.1.5/webuploader.js"></script>
    <script type="text/javascript" src="/js/zoomify/dist/zoomify.min.js"></script>
    <script type="text/javascript" src="/js/global.js"></script>
</head>
<style>
    .panel-primary{
        border-color: #1ab394;
    }
    .panel-body{
        margin: 15px;
    }
    a{
        text-decoration: none !important;
    }


</style>

<body>
<!--<div class="container-fluid" style="margin-top: 10px">
    <div class="panel panel-primary">
        <div class="panel-heading" style="background-color: #1ab394;border-color: #1ab394;">
            <span class="badge" style=" color: #1ab394;">文章列表</span>
            <i id="add-manager" class="layui-icon" style="float:right;font-size: 20px;margin-top:-5px;cursor:pointer">&#xe654;</i>
        </div>
        <div class="panel-body">
            <form method="get" action="__ACTION__" class='form-inline'>
                <div class="row top_search">

                    <div class="input-group">
                        <div class="input-group-addon">文章标题：</div>
                        <input name="title" value="{$title}"
                               type="text" class="form-control" placeholder="请输入文章标题">
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
            <span class="badge" style=" color: #1ab394;" >商品列表</span>
                <i id="add-manager" class="layui-icon" style="float:right;font-size: 20px;margin-top:-5px;cursor:pointer">&#xe654;</i>
        </div>
    </div>
</div>
<div class="container-fluid">
    <table class="layui-table" >
        <thead>
        <tr>
            <th>ID</th>
            <th>封面</th>
            <th>商品名称</th>
            <th>所属分类</th>
            <th>销售价</th>
            <th>库存</th>
            <th>排序</th>
            <th>是否上架</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        </tr>
    </table>
</div>
<div class="container-fluid">
</div>

</body>

<script>
    $(function() {

        globalFn.zoomify();

        //点击删除
        $('.delete').click(function () {
            //询问框
            var id = $(this).attr('attr');
            layui.use('layer', function () {
                var layer = layui.layer;
                layer.confirm('您确定要删除该商品？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    _index1 = layer.load();
                    $.post("{{route('product.del')}}", {'_token':'{{csrf_token()}}',id: id}, function (res) {
                        res.status == 1 ? globalFn.remind(_index1, res.msg, "{{route('product.index')}}")
                            : globalFn.remind(_index1, res.msg);
                    })
                });
            });

        });

        $("#add-manager").click(function () {
            window.location.href = "{{route('cover.find')}}";
        })
    })
</script>

</html>