<?php
use Admin\Model\BaseModel;
?>
        <!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:16:41 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>Page-后台</title>

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <link rel="shortcut icon" href="favicon.ico">
    <link href="/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.min.css" rel="stylesheet">
    <link href="/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    <style>
        #editpwd{
            border-radius: 3px;
            color: inherit;
            font-weight: 400;
            line-height: 25px;
            margin: 4px;
            cursor: pointer;
            padding: 3px 20px;
            display: block;
        }
    </style>
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"><strong class="font-bold">{{session('adminInfo.uname')}}</strong></span>
                                <span class="text-muted text-xs block">{{implode(',', session('adminRole'))}}<b class="caret"></b></span>
                                </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><span class="J_menuItem" id="editpwd" >修改密码</span>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{route('index.logout')}}" >安全退出</a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">Page
                    </div>
                </li>
                <?php foreach(session('menuInfo') as $key => $val):?>
                <li>
                    <?php if(!empty($val['son'])):?>
                    <a href="#">
                        <i class="fa <?php echo $val['icon_class']?>"></i>
                        <span class="nav-label"><?php echo $val['name']?></span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <?php foreach($val['son'] as $k => $v):?>
                        <li>
                            <a class="J_menuItem" href="<?php echo routeName($v['route'])?>" data-index="0"><?php echo $v['name']?></a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <?php else:?>
                    <a class="J_menuItem" href="<?php echo routeName($val['route'])?>"><i class="fa <?php echo $val['icon_class']?>"></i> <span class="nav-label"><?php echo $val['name']?></span></a>
                    <?php endif;?>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="{{route('index.main')}}">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                    </li>
                </ul>
            </div>
            <a href="{{route('index.logout')}}" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{route('index.main')}}" frameborder="0" data-id="{{route('index.main')}}" seamless></iframe>
        </div>
        <div class="footer" style=" left: 0; position: fixed; bottom: 0; width: 100%; z-index: 100;  ">
            <div class="pull-right">Copyright@2017 www.phicomm.com.All Rights Reserved</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->

    <!--修改密码-->
    <div class="container-fluid" id="add-manage-popup" style="display:none;margin-left:20px;margin-top:35px">
        <form class="layui-form layui-form-pane" action="">

            <div class="layui-form-item" id="pwd-ipt">
                <label class="layui-form-label">新密码</label>
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

            <div class="layui-form-item" style="text-align:center; width:100%;height:100%;margin-left:-28px; " >
                <div class="layui-btn" lay-submit="" lay-filter="demo1" id="sub-btn">修改</div>
            </div>
        </form>

    </div>
</div>
<script src="/js/jquery.min.js?v=2.1.4"></script>
<script src="/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/js/plugins/layer/layer.min.js"></script>
<script src="/js/hplus.min.js?v=4.1.0"></script>
<script type="text/javascript" src="/js/contabs.min.js"></script>
<script src="/js/plugins/pace/pace.min.js"></script>
<script src="/js/layui/layui.js"></script>
<script type="text/javascript" src="/js/global.js"></script>

<script>
    $(function(){
        $('#editpwd').click(function(){
            //alert(123);
            globalFn.lyPopup('修改密码', ['390px', '275px'],'add-manage-popup',1);

            layui.use(['form'], function(){
                var form = layui.form(),layer = layui.layer;
                //监听提交s
                form.on('submit(demo1)', function(data){
                    if($("input[name='pwd']").val() != $("input[name='repwd']").val()){
                        layer.msg('两次输入的密码不一致');
                        return false;
                    }
                    _index = layer.load();
                    $.post("{:U('access')}", {data:JSON.stringify(data.field)},function(res){
                        res.status == 1 ? globalFn.remind(_index, res.info,"{:U('Index/logout')}")
                            : globalFn.remind(_index, res.info);
                    });
                    return false;
                });
            })
        })
    })
</script>
</body>


<!-- Mirrored from www.zi-han.net/theme/hplus/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:17:11 GMT -->
</html>
