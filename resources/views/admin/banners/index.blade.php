<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>首页banner</title>

    <link rel="stylesheet" href="/css/content.css" />
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    <link rel="stylesheet" href="/js/zoomify/dist/zoomify.min.css">
    <link rel="stylesheet" href="/js/zoomify/css/bootstrap-grid.min.css">
    <link rel="stylesheet" type="text/css" href="/js/webuploader-0.1.5/webuploader.css">
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
    a{
        text-decoration: none !important;
    }

    #show{
        position:absolute;
        margin-top: -210px;
        margin-left: 343px;
        width: 275px;
        height: 185px;
        background: #fff none repeat scroll 0 0;
        border: 1px solid #dedede;
        box-shadow: 0 0 5px #dedede;
        opacity: 100;
        overflow: hidden;
    }
    .layui-form-select dl{
        max-height: 250px !important;
    }
</style>

<body>
<div class="container-fluid" style="margin-top: 10px">
    <div class="panel panel-primary">
        <div class="panel-heading" style="background-color: #1ab394;border-color: #1ab394;">
            <span class="badge" style=" color: #1ab394;" >Banner列表</span>
            <i id="add-manager" class="layui-icon" style="float:right;font-size: 20px;margin-top:-5px;cursor:pointer">&#xe654;</i>
        </div>
    </div>
</div>
<div class="container-fluid">
    <table class="layui-table" >
        <thead>
        <tr>
            <th>ID</th>
            <th>Banner</th>
            <th>所属商品</th>
            <th>标题</th>
            <th>是否显示</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($banners as $val):?>
        <tr>
            <td><?php echo $val->id;?></td>
            <td style="text-align: center;"><img class="zoomIn" id="banner<?php echo $val->id;?>" src="{{asset($val->path)}}" style="width:100px;height:50px"/></td>
            <td><?php echo $val->product->name?></td>
            <td><?php echo $val->title;?></td>
            <td><?php if($val->display == 1)echo '是';else echo '否'?></td>
            <td><?php echo $val->sort;?></td>
            <td>
                <a class="edit" attr="<?php echo $val->id?>" href="#"></a>
                <a class="delete" attr="<?php echo $val->id?>" href="#"></a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<div class="container-fluid">
    {!! $banners->render() !!}
</div>

<div class="container-fluid" id="add-manage-popup" style=" visibility: hidden;margin-left:20px;margin-top:20px" >
    <form class="layui-form layui-form-pane" action="">

        <div class="layui-form-item">
            <label class="layui-form-label">Banner图片</label>
            <div class="layui-input-inline" style="margin-right: 115px">
                <input name="bannerpicurl"  class="layui-input" type="text" id="bannerpicurl" style="width:300px" readonly>
            </div>
            <div id="uploader-demo" style="float: left;margin-left: 35px;">
                <div id="fileList" class="uploader-list" style="display: none;"></div>
                <div id="filePicker">选择图片</div>
            </div>
            <div class="layui-btn" id="preview" style="float: left;margin-left: 10px;background: #92cb05 none repeat scroll 0 0;" >预览</div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">所属商品</label>
            <div class="layui-input-inline">
                <select name="productid" id="productid" style="height:50px" lay-verify="required" >
                    <option value="">请选择商品</option>
                    <?php foreach($products as $val):?>
                    <option value="<?php echo $val->id?>"><?php echo $val->name?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-inline">
                <input name="bannertitle"  placeholder="请输入商品标题"  class="layui-input" type="text" id="bannertitle" style="width:195px">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input onkeyup='this.value=this.value.replace(/\D/gi,"")' name="bannersort" placeholder="请输入排序数字" class="layui-input" type="text" id="bannersort" style="width:195px">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否显示</label>
            <div class="layui-input-block">
                <input name="show" value="1" title="是" checked="" type="radio">
                <input name="show" value="0" title="否" type="radio">
            </div>
        </div>


        <div id="show">
            <img src="" style="width: 273px; height: 183px;" />
        </div>

        <div class="layui-form-item" style="text-align:center; width:100%;height:100%;margin-left:-28px; " >
            <div class="layui-btn" lay-submit="" lay-filter="demo2" id="sub-btn" style="margin-left: -292px; margin-top: 20px;">添加</div>
            <input name="action" type="hidden" class="layui-input" value="add" id="action">
            <input name="eid" type="hidden" class="layui-input" value="" id="eid">
        </div>
    </form>

</div>

<?php foreach($banners as $val):?>
<div  id="bigbanner<?php echo $val->id;?>" class="example"><p><img style="display:none" src="{{asset($val->path)}}" class="img-rounded" alt=""></p></div>
<?php endforeach;?>

<div style="display: none" id="show-banner">
    <img src="">
</div>


</body>

<script>
    $(function() {

        //点击放大缩小
        globalFn.zoomify();

        //预览
        globalFn.preview('show-banner');

        $(document).on('click', '.layui-layer-close', function () {
            $('#add-manage-popup').css( "visibility" ,"hidden");
        })

        //点击添加
        $("#add-manager").click(function () {
            bannerFn.emptyInput();
            globalFn.checkRadio(0);
            $('#add-manage-popup').css( "visibility" ,"visible");
            globalFn.lyPopup('添加Banner', ['700px', '450px'],'add-manage-popup',1);

        });

        //点击编辑
        $('.edit').click(function(){
            bannerFn.emptyInput();
            globalFn.checkRadio(0);
            $.post("{{route('banner.find')}}",{'_token':'{{csrf_token()}}',id:$(this).attr('attr')},function(data){
                console.log(data);
                $('#bannerpicurl').val(data.banner.path);
                $('#show-banner img').attr('src', '{{webDomain()}}/'+data.banner.path);
                $('#show img').attr('src', '{{webDomain()}}/'+data.banner.path);
                $("#bannertitle").val(data.banner.title);
                $("#bannersort").val(data.banner.sort);
                $("#eid").val(data.banner.id);
                $("#action").val('edit');
                $("#sub-btn").text('编辑');
                globalFn.checkRadio(val = data.banner.display == 0 ? 1 :0);
                $("#productid  option[value='"+data.product.id+"'] ").attr("selected",true)
                $('.layui-unselect').val(data.product.name);
                $('dl dd').each(function(){
                    $(this).attr('lay-value') == data.product.id ? $(this).addClass('layui-this'):$(this).removeClass('layui-this')
                });

                $('#add-manage-popup').css( "visibility" ,"visible");
                globalFn.lyPopup('编辑Banner', ['700px', '450px'],'add-manage-popup',1);
            })
        });

        //点击删除
        $('.delete').click(function(){
            //询问框
            var id = $(this).attr('attr');
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('您确定要删除该banner吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    _index1 = layer.load();
                $.post("{{route('banner.del')}}",{'_token':'{{csrf_token()}}',id:id},function(res){
                        res.status == 1 ? globalFn.remind(_index1, res.msg,"{{route('banner.index')}}")
                            : globalFn.remind(_index1, res.msg);
                    })
                });
            });

        });

        //上传图片
        //上传图片
        globalFn.webUpload("{{route('banner.upload')}}",'{{csrf_token()}}','show-banner', 'bannerpicurl', 'show');

        layui.use(['form'], function () {
            var form = layui.form,layer = layui.layer;

            //监听提交
            form.on('submit(demo2)', function(data){
                if($('#bannerpicurl').val() == '' ){
                    layer.msg('请上传图片');
                    return false;
                }
                _index = layer.load();
                $.post("{{route('banner.create')}}", {'_token':'{{csrf_token()}}',data:JSON.stringify(data.field)},function(res){
                    res.status == 1 ? globalFn.remind(_index, res.msg,"{{route('banner.index')}}")
                        : globalFn.remind(_index, res.msg);
                });
                return false;
            });
        })

    })


    var bannerFn = {
        emptyInput:function(){
            $('#bannerpicurl,#bannertitle,#bannersort,#eid').val('');
            $("#action").val('add');
            $("#sub-btn").text('添加');
            $('#show img').attr('src', '');
            $('#show-banner img').attr('src', '');
        },

    }
</script>

</html>