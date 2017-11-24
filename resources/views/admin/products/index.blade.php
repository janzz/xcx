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
    <link rel="stylesheet" href="/js/zoomify/dist/zoomify.min.css">
    <link rel="stylesheet" href="/js/zoomify/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/plugins/purify.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="/js/layui/layui.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/themes/fa/theme.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/locales/zh.js"></script>
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

    #box{
        height: 150px;
        margin: 30px auto;
        padding: 10px;
        position: relative;
    }

    .cover-list{
        height: 70px;
        margin: 6px 6px 6px 6px;
        border: 1px solid #dedede;
        box-shadow: 0px 0px 5px #dedede;
        overflow: hidden;
        float: left;
        filter: alpha(opacity=100);
        opacity: 100;
        background: #FFF;
   }

    .del-cover{
        position:absolute;
        margin-top:-10px;
        margin-left:-7px;
    }

</style>

<body>

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
        <?php foreach($pageData as $val):?>
        <tr>
            <td><?php echo $val->id;?></td>
            <td style="text-align: center;"><img class="zoomIn" id="product<?php echo $val->id;?>" src="{{asset($val->cover_show)}}" style="width:100px;height:50px"/></td>
            <td><?php echo $val->name;?></td>
            <td><?php foreach($val->categorys as $va){
                    echo $va->name.',';
                }?>
            </td>
            <td><?php echo $val->sales_price;?></td>
            <td><?php echo $val->store;?></td>
            <td><?php echo $val->sort;?></td>
            <td><?php if($val->racking == 1)echo '是';else echo '否'?></td>
            <td><?php echo $val->created_at;?></td>

            <td>
                <a class="edit" href="{{route('product.find', ['id'=>$val->id])}}"></a>
                <a class="delete del-product" href="#" attr="<?php echo $val->id;?>"></a>
                <a href="{{route('product.cover', ['id'=>$val->id])}}"><i class="layui-icon btn-upload" style="font-size: 30px; color: #1E9FFF;position: absolute; margin-top:7px;margin-left:5px;cursor: pointer;">&#xe681;</i></a>
                <a href="#" class="preview" attr = "<?php echo $val->id;?>"><i class="layui-icon btn-upload" style="font-size: 25px; color: #E88317;position: absolute; margin-top:7px;margin-left:40px;cursor: pointer;">&#xe64a;</i></a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>

<div class="container-fluid">
    {!! $pageData->render() !!}
</div>

<?php foreach($pageData as $k=>$item):?>
<div  id="bigproduct<?php echo $item->id;?>" class="example"><p><img style="display:none" src="{{asset($val->cover_show)}}" class="img-rounded" alt=""></p></div>
<?php endforeach;?>

<div id="box" style="display: none;">
    <div id="layer-photos-demo" class="layer-photos-demo">
    </div>
</div>

</body>

<script>
    $(function() {

        globalFn.zoomify();

        //点击删除
        $('.del-product').click(function () {
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
            window.location.href = "{{route('product.find')}}";
        })

        //预览
        $('.preview').click(function(){
            $('#layer-photos-demo div').remove();
            var id = $(this).attr('attr');
            $.post("{{route('product.preview')}}", {'_token':'{{csrf_token()}}',id:id},function(res){
                console.log(res);
                if(res.length > 0){
                    var imgStr = '';
                    for (var i in res) {
                        imgStr += '<div class="cover-list" id="cover_'+res[i].id+'"><img layer-pid="" layer-src="'+'{{webDomain()}}/'+res[i].path+'" src="'+'{{webDomain()}}/'+res[i].path+'"  style="width:150px;height:70px" alt="封面" ><a class="del-cover" href="#" attr="'+res[i].id+'"><i class="layui-icon" style="font-size: 10px; font-weight: bold;color: red;">&#x1006;</i></a></div>';
                    }
                    $('#layer-photos-demo').append(imgStr);

                    globalFn.lyPopup('商品封面', ['auto'],'box',1);

                    layui.use('layer', function () {
                        layer.photos({
                            photos: '#layer-photos-demo'
                            ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
                        });
                    })
                }else{
                    layui.use('layer', function () {
                        layer.msg('暂无图片 ');
                    })
                }

            });
        })

        $(document).on('click', '.del-cover', function () {

            var cover_id = $(this).attr('attr');

            layui.use('layer', function () {

                var layer = layui.layer;
                _index1 = layer.load();

                $.post("{{route('product.removeCover')}}", {'_token':'{{csrf_token()}}',id:cover_id},function(res){

                    globalFn.remind(_index1, res.msg);

                    res.status == 1 && setTimeout(function () { $('#cover_'+cover_id).remove() }, 2000);

            })
        });
        })
    })
</script>

</html>