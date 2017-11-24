<!DOCTYPE html><html lang="zh-CN"><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1">    <meta name="description" content="">    <meta name="author" content="">    <title>商品管理</title>    <link rel="stylesheet" href="/css/content.css" />    <link rel="stylesheet" href="/css/upload.css" />    <link rel="stylesheet" href="/js/layui/css/layui.css">    <link rel="stylesheet" type="text/css" href="/js/webuploader-0.1.5/webuploader.css">    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">    <script src="/js/jquery.min.js?v=2.1.4"></script>    <script src="/js/layui/layui.js"></script>    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>    <script type="text/javascript" src="/js/webuploader-0.1.5/webuploader.js"></script>    <script src="/js/kindeditor/kindeditor.js" type="text/javascript"></script>    <script src="/js/kindeditor/lang/zh_CN.js" type="text/javascript"></script>    <script src="/js/kindeditor/plugins/code/prettify.js" type="text/javascript"></script>    <script type="text/javascript" src="/js/global.js"></script></head><script>    var editor;    KindEditor.ready(function(K) {        editor = K.create('#pdetails', {            resizeType : 1,            allowPreviewEmoticons : false,            allowImageUpload : true,            uploadJson : "{:U('kindEditorUpload')}",            items : [                'source','undo','clearhtml','hr',                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',                'insertunorderedlist', "fontsize","forecolor",'|', 'emoticons', 'image','link', 'unlink','baidumap','lineheight','table','anchor','preview','print','template','code',/*'cut', 'music', 'video'*/],            afterBlur: function(){this.sync();}        });    });</script><style>    .panel-primary{        border-color: #1ab394;    }    a{        text-decoration: none !important;    }    .layui-form-label{        width:auto;    }    .layui-form-item{        margin-bottom: 30px;    }    .unit{        position: absolute;        top:15px;        margin-left:195px;    }    .ipt-red{        color:red    }</style><body><div class="container-fluid" style="margin-top: 10px">    <div class="panel panel-primary">        <div class="panel-heading" style="background-color: #1ab394;border-color: #1ab394;">            <span class="badge" style=" color: #1ab394;" >添加商品</span>        </div>    </div></div><div class="container-fluid" id="add-manage-popup" style="margin-left:20px;margin-top:20px" >    <form class="layui-form" action="">        <div class="layui-form-item">            <label class="layui-form-label"><span class='ipt-red'>*</span>所属分类</label>            <div class="layui-input-block" style="margin-left: 88px; width:400px;">                <?php foreach($categorys as $key => $val):?>                <input type="checkbox" name="cate_{{$val->id}}" title="{{$val->name}}" {{checkBoxChecked($val->id, $product['cateId'])}} />                <?php endforeach;?>            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label" ><span class='ipt-red'>*</span>商品名称</label>            <div class="layui-input-inline">                <input name="name" value="{{$product['product']->name}}" placeholder="请输入商品名称"  class="layui-input" type="text" id="pname" style="width:470px">            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label"><span class='ipt-red'>*</span>封面图片</label>            <div class="layui-input-inline" style="margin-right: 115px">                <input name="pimgurl" value="{{$product['product']->cover_show}}" class="layui-input" type="text" id="pimgurl" style="width:282px" readonly>            </div>            <div id="uploader-demo" style="float: left">                <div id="fileList" class="uploader-list" style="display: none;"></div>                <div id="filePicker">选择图片</div>            </div>            <div class="layui-btn" id="preview" style="float: left;margin-left: 10px;background: #92cb05 none repeat scroll 0 0;" >预览</div>        </div>        <div class="layui-form-item layui-form-text">            <label class="layui-form-label">商品简介</label>            <div class="layui-input-block" style="width:470px;margin-left: 88px;">                <textarea name="pintro" id="pintro" placeholder="请输入简介" class="layui-textarea">{{$product['product']->intro}}</textarea>            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label" ><span class='ipt-red'>*</span>销售价格</label>            <div class="layui-input-inline">                <input name="psprice" value="{{$product['product']->sales_price}}" onkeyup="clearNoNum(this)" placeholder="请输入商品销售价格"  class="layui-input" type="text" id="psprice" style="width:190px;"><span class="unit">元</span>            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label" >市场价格</label>            <div class="layui-input-inline">                <input name="pmprice" value="{{$product['product']->market_price}}"  onkeyup="clearNoNum(this)" placeholder="请输入商品市场价格"  class="layui-input" type="text" id="pmprice" style="width:190px"><span class="unit">元</span>            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label" >商品重量</label>            <div class="layui-input-inline">                <input onkeyup='this.value=this.value.replace(/\D/gi,"")' name="pweight" value="{{$product['product']->weight}}" placeholder="请输入商品重量"  class="layui-input" type="text" id="pweight" style="width:190px"><span class="unit">g</span>            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label" ><span class='ipt-red'>*</span>总库存量</label>            <div class="layui-input-inline">                <input onkeyup='this.value=this.value.replace(/\D/gi,"")' name="pstore" value="{{$product['product']->store}}" placeholder="请输入商品总库存量"  class="layui-input" type="text" id="pstore" style="width:190px">            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label" >销售基数</label>            <div class="layui-input-inline">                <input onkeyup='this.value=this.value.replace(/\D/gi,"")' name="psbase" value="{{$product['product']->sales_base}}" placeholder="请输入商品销售基数"  class="layui-input" type="text" id="psbase" style="width:190px">            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label">商品排序</label>            <div class="layui-input-inline">                <input onkeyup='this.value=this.value.replace(/\D/gi,"")' name="sort" value="{{$product['product']->sort}}" placeholder="请输入排序数字" class="layui-input" type="text" id="articlesort" style="width:190px" >            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label">是否上架</label>            <div class="layui-input-block">                <input name="show" value="1" title="是" type="radio" <?php if($product['product']->racking == 1 || !isset($product['product']->racking))echo 'checked'?> >                <input name="show" value="0" title="否" type="radio" <?php if($product['product']->racking == 0 && isset($product['product']->racking))echo 'checked'?> >            </div>        </div>        <div class="layui-form-item">            <label class="layui-form-label">商品详情</label>            <textarea name="pdetails" id="pdetails"  style="width:688px;height:350px;" class="layui-textarea">{{$product['product']->details}}</textarea>        </div>        <div class="layui-form-item" style="margin-left:100px; " >            <div class="layui-btn layui-btn-big" lay-submit="" lay-filter="demo2" id="sub-btn" style="margin-top: 20px;">保存</div>            <input name="action" type="hidden" class="layui-input" value="" id="action">            <input name="eid" type="hidden" class="layui-input" value="{{$product['product']->id}}" id="eid">        </div>    </form></div><div style="display: none" id="show-img">    <img src="{{asset($product['product']->cover_show)}}"></div></body><script>    $(function () {        //上传图片        globalFn.webUpload("{{route('product.upload')}}",'{{csrf_token()}}','show-img', 'pimgurl');        //预览        globalFn.preview('show-img');        layui.use(['form', 'layedit', 'laydate'], function(){            var form = layui.form,layer = layui.layer;            //监听提交            form.on('submit(demo2)', function(data){                if(!$('.layui-form-checkbox').hasClass('layui-form-checked')){                    layer.msg('请选择分类');                    return false;                }                if($('#pname').val() == ''){                    layer.msg('请输入商品名称');                    return false;                }                if($('#pimgurl').val() == ''){                    layer.msg('请上传商品封面图片');                    return false;                }                if($('#psprice').val() == ''){                    layer.msg('请输入销售价格');                    return false;                }                if($('#pstore').val() == ''){                    layer.msg('请输入商品库存');                    return false;                }                _index = layer.load();                $.post("{{route('product.create')}}", {'_token':'{{csrf_token()}}',data:JSON.stringify(data.field)},function(res){                    res.status == 1 ? globalFn.remind(_index, res.msg,"{{route('product.index')}}")                        : globalFn.remind(_index, res.msg);                });                return false;            });        });    });    function clearNoNum(obj){        obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数        if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额            obj.value= parseFloat(obj.value);        }else if(obj.value.length == 1){            obj.value= '';        }    }</script></html>