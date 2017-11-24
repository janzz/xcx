<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>分类管理</title>
    <link rel="stylesheet" href="/css/content.css" />
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/js/webuploader-0.1.5/webuploader.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/layui/layui.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/webuploader-0.1.5/webuploader.js"></script>
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
    #show{
        position:absolute;
        top:280px;
        left:100px;
        margin-top: -160px;
        margin-left: 343px;
        width: 112px;
        height: 112px;
        background: #fff none repeat scroll 0 0;
        border: 1px solid #dedede;
        box-shadow: 0 0 5px #dedede;
        opacity: 100;
        overflow: hidden;
    }
</style>

<body>
<div class="container-fluid" style="margin-top: 10px">
    <div class="panel panel-primary">
        <div class="panel-heading" style="background-color: #1ab394;border-color: #1ab394;">
            <span class="badge" style=" color: #1ab394;" >分类列表</span>
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
            <th>分类名称</th>
            <th>分类排序</th>
            <th>是否显示</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($pageData as $val):?>
        <tr>
            <td><?php echo $val->name;?></td>
            <td><?php echo $val->sort;?></td>
            <td><?php if($val->display == 1)echo '是';else echo '否'?></td>
            <td>
                <a class="edit" attr="<?php echo $val->id?>" href="#"></a>
                <a class="delete" attr="<?php echo $val->id?>" href="#" ></a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>


<!--分页-->
<div class="container-fluid">
    {!! $pageData->render() !!}
</div>

<div class="container-fluid" id="add-manage-popup" style="visibility: hidden;margin-left:20px;margin-top:20px">
    <form class="layui-form layui-form-pane" action="">

        <div class="layui-form-item">
            <label class="layui-form-label">分类图片</label>
            <div class="layui-input-inline" style="margin-right: 115px">
                <input name="categorypicurl"  class="layui-input" type="text" id="categorypicurl" style="width:282px" readonly>
            </div>
            <div id="uploader-demo" style="float: left">
                <div id="fileList" class="uploader-list" style="display: none;"></div>
                <div id="filePicker">选择图片</div>
            </div>
            <div class="layui-btn" id="preview" style="float: left;margin-left: 10px;background: #92cb05 none repeat scroll 0 0;" >预览</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-inline">
                <input name="categoryame"  placeholder="请输入菜单名称" class="layui-input" type="text" id="categoryname">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input onkeyup='this.value=this.value.replace(/\D/gi,"")' name="categorysort" placeholder="请输入排序数字" class="layui-input" type="text" id="categorysort">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">所属分类</label>
            <div class="layui-input-inline">
                <select name="categorytype" id="categorytype" style="height:50px" lay-verify="required" >
                    <?php foreach($types as $key => $val):?>
                    <option value="<?php echo $key?>"><?php echo $val?></option>
                    <?php endforeach;?>
                </select>
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
            <img src="" style="width: 110px; height: 110px;" />
        </div>

        <div class="layui-form-item" style="text-align:center; width:100%;height:100%;margin-left:-28px; " >
            <div class="layui-btn"  lay-submit="" lay-filter="demo2">提交</div>
            <input name="action" type="hidden" class="layui-input" value="add" id="action">
            <input name="eid" type="hidden" class="layui-input" value="" id="eid">
        </div>
    </form>

</div>

<div style="display: none" id="show-img">
    <img src="">
</div>
</body>

<script type="text/javascript">
    $(function(){

        //上传图片
        globalFn.webUpload("{{route('category.upload')}}",'{{csrf_token()}}','show', 'categorypicurl', 'show-img');

        globalFn.preview('show-img');

        $(document).on('click', '.layui-layer-close', function () {
            $('#add-manage-popup').css( "visibility" ,"hidden");
        })
        //点击添加
        $("#add-manager").click(function(){
            categoryFn.emptyInput();
            globalFn.checkRadio(0);
            $('#add-manage-popup').css( "visibility" ,"visible");
            globalFn.lyPopup('添加分类', ['650px', '410px'],'add-manage-popup',1);

        });

        //点击编辑
        $('.edit').click(function(){
            categoryFn.emptyInput();
            globalFn.checkRadio(0);
            $.post("{{route('category.find')}}",{'_token':'{{csrf_token()}}',id:$(this).attr('attr')},function(data){
                //var data = JSON.parse(data);
                console.log(data);
                $('#categorypicurl').val(data.cover_show);
                $('#show-img img').attr('src', '{{webDomain()}}/'+data.cover_show);
                $('#show img').attr('src', '{{webDomain()}}/'+data.cover_show);
                $('#categoryname').val(data.name);
                $('#categorysort').val(data.sort);
                $('#eid').val(data.id);
                $("#categorytype  option[value='"+data.type+"'] ").attr("selected",true)
                $('.layui-unselect').val($("dd[lay-value='"+data.type+"']").text());
                $('dl dd').each(function(){
                    $(this).attr('lay-value') == data.type ? $(this).addClass('layui-this'):$(this).removeClass('layui-this')
                });
                globalFn.checkRadio(val = data.display == 0 ? 1 :0);

                $('#add-manage-popup').css( "visibility" ,"visible");
                globalFn.lyPopup('编辑分类', ['650px', '410px'],'add-manage-popup',1);
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
                layer.confirm('您确定要删除该分类吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    _index1 = layer.load();
                    $.post("{{route('category.del')}}",{'_token':'{{csrf_token()}}',id:id},function(res){
                        res.status == 1 ? globalFn.remind(_index1, res.msg,"{{route('category.index')}}")
                            : globalFn.remind(_index1, res.msg);
                    })
                });
            });

        });

        layui.use(['form'], function(){
            var form = layui.form,layer = layui.layer;
            //监听提交
            form.on('submit(demo2)', function(data){
                if($.trim($('#categoryname').val()) == ''){
                    layer.msg('请填写分类名称');
                    return false;
                }
                _index = layer.load();
                $.ajax({
                    url: "{{route('category.create')}}",
                    type:"post",     //请求类型
                    data:{
                        '_token':'{{csrf_token()}}',
                        name:$('#categoryname').val(),
                        eid:$('#eid').val(),
                        categorysort:$('#categorysort').val(),
                        categoryshow: $('.layui-form-radioed').find('span').text() == '是' ? 1 :0,
                        categorystype:$('.layui-this').attr('lay-value'),
                        categorysimg:$('#categorypicurl').val(),
                    },  //请求的数据
                    dataType:"json",  //数据类型
                    success: function(data){
                        data.status == 1 ? globalFn.remind(_index, data.msg,"{{route('category.index')}}")
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
    });

    var categoryFn = {
        emptyInput:function(){
            $('#categoryname').val("");
            $('#categorysort').val("");
            $('#categorypicurl').val("");
            $('#eid').val('');
            $('dl dd').each(function(){
                $(this).attr('lay-value') == 0 ? $(this).addClass('layui-this'):$(this).removeClass('layui-this');
            })

            $('.layui-unselect').val($("dd[lay-value='0']").text());

            $('#show img').attr('src', '');
            $('#show-img img').attr('src', '');

        }

    }


</script>

</html>