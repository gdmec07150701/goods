<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>商品中心-商品维护</title>
<meta charset="utf-8">
<meta name="keywords" content="" />
<meta name="description" content="">
<meta name="author" content="BBCMS Team">	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="shortcut icon" href="/goods/Public//img/logo.png" type="img/x-ico" />
<link href='/goods/Public//Admin/css/bootstrap.min.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/bootstrap-responsive.min.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/colorpicker.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/datepicker.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/fullcalendar.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/jquery.gritter.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/unicorn.main.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/uniform.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/unicorn.grey.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/bootstrap-select.min.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/select2.css' rel="stylesheet" >
<link href='/goods/Public//Admin/css/xhj.css' rel="stylesheet" >

<!-- <link rel="stylesheet" href="/goods/Public//qfb/css/bootstrap-grid.min.css"> -->
<link rel="stylesheet" href="/goods/Public//qfb/dist/zoomify.min.css"> 
<!-- <link rel="stylesheet" href="/goods/Public//qfb/css/style.css">  -->

<link href='/goods/Public//Admin/css/jquery.fancybox-1.3.1.css' rel="stylesheet" >
<link href="/goods/Public//Admin/js/jbox/Blue/jbox.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">

var SELF = '/goods/index.php/Seller/Goods/add.html';
var URL = '/goods/Seller/Goods';
var APP	 =	 '/goods';
var PUBLIC = '/goods/Public/';
var GROUP = '__GROUP__';
var UPLOAD = '/goods/Public/Uploads';


</script>
</head>
<body>
<div id="header"><h1><a href="<?php echo U('Index/index');?>">MISS.JADY</a></h1></div>
<div id="user-nav" class="navbar navbar-inverse tip-bottom">
	<ul class="nav btn-group">
		<li class="btn btn-inverse"><a title="" ><i class="icon icon-user"></i> <span class="text"><?php echo ($app_manager["account"]); ?></span></a></li>
		<!-- <li class="btn btn-inverse"><a title="修改资料" href="#"><i class="icon icon-cog"></i> <span class="text">修改资料</span></a></li> -->
		<li class="btn btn-inverse"><a title="退出系统" href="<?php echo U('Public/logout');?>"><i class="icon icon-share-alt"></i> <span class="text">退 出</span></a></li>
	</ul>
</div>
      
<div id="sidebar">
	<a href="<?php echo U('Index/index');?>" class="visible-phone"><i class="icon icon-home"></i> 系统首页</a>
	<ul>
		<li class="<?php if((CONTROLLER_NAME) == "Index"): ?>active<?php endif; ?>"><a href="<?php echo U('Index/index');?>"><i class="icon icon-home"></i> <span>系统首页</span></a></li>
		
		<?php $arc="xc_w11";if(chkArc($arc)){ ?><li class="submenu <?php if(in_array((CONTROLLER_NAME), explode(',',"Data"))): ?>active open<?php endif; ?>">
				<a><i class="icon icon-bookmark active"></i> <span>数据</span></a>
				<ul>
				<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Data"))): if(in_array((ACTION_NAME), explode(',',"lst"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Data/lst');?>">查看数据</a></li><?php } ?>
				</ul>
			</li><?php } ?>



		<?php $arc="xc_w11";if(chkArc($arc)){ ?><li class="submenu <?php if(in_array((CONTROLLER_NAME), explode(',',"Goods,Sort"))): ?>active open<?php endif; ?>">
				<a><i class="icon icon-gift active"></i> <span>商品</span></a>
				<ul>
				<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Goods"))): if(in_array((ACTION_NAME), explode(',',"lst"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Goods/lst');?>">商品管理</a></li><?php } ?>
					<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Sort"))): if(in_array((ACTION_NAME), explode(',',"lst"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Sort/lst');?>">类别管理</a></li><?php } ?>
				</ul>
			</li><?php } ?>

		<?php $arc="xc_w1";if(chkArc($arc)){ ?><li class="submenu <?php if(in_array((CONTROLLER_NAME), explode(',',"Manager,Log"))): ?>active open<?php endif; ?>">
			<a><i class="icon icon-user active"></i> <span>管理员中心</span></a>
			<ul>
				<li <?php if(in_array((CONTROLLER_NAME), explode(',',"Manager"))): if(in_array((ACTION_NAME), explode(',',"managers"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Manager/index');?>">管理员列表</a></li>
				<li <?php if(in_array((CONTROLLER_NAME), explode(',',"Manager"))): if(in_array((ACTION_NAME), explode(',',"managers_log"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Manager/log');?>">管理日志</a></li>
				<li <?php if(in_array((CONTROLLER_NAME), explode(',',"Log"))): if(in_array((ACTION_NAME), explode(',',"lst"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Log/lst');?>">进出库错误回滚</a></li>

				
				<!-- <?php if(($app_manager["role"]) == "1"): ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Manager"))): if(in_array((ACTION_NAME), explode(',',"card_log"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Manager/card_log');?>">优惠券日志</a></li><?php endif; ?> -->
			</ul>
		</li><?php } ?> 


	
		<li>
			<a href="<?php echo U('Public/logout');?>"><i class="icon icon-share-alt"></i> <span>退出系统</span></a>
		</li>
	</ul>
</div>
<div id="content">
    <div id="content-header">
        <h1>商品中心</h1>
    </div>
    
    <!--主要内容-->

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
		<span class="icon">
			<i class="icon-th-list"></i>
		</span>
                        <h5>
                            添加 商品信息
                        </h5>
                    </div>
                    <div class="alert alert-error hide" id="alert_info">
                        <button type="button" class="close" onclick="$('#alert_info').hide();">×</button>
                        <div class="alert-body"><span id="modal"></span></div>
                    </div>

                    <div class="widget-content nopadding">
                        <form id="act_form" method="post" class="form-horizontal" action="<?php echo U('Goods/add');?>"/>
                        <input type="hidden" name="id" value="<?php echo ($vo['id']?$vo['id']:''); ?>">
                        <div class="control-group">
                            <label class="control-label" for="appendedInput">商品名称 ：</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input size="32" name="name" class="input-append " type="text"
                                           value="<?php echo ($vo['name']?$vo['name']:''); ?>">
                                </div>
                                <span class=" help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="appendedInput">商品编号 ：</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input size="32" name="good_num" class="input-append " type="text"
                                           value="<?php echo ($vo['good_num']?$vo['good_num']:''); ?>">
                                </div>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="appendedInput">条形码 ：</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input size="32" name="tx_num" class="input-append " type="text"
                                           value="<?php echo ($vo['tx_num']?$vo['tx_num']:''); ?>">
                                </div>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="appendedInput">货品类别 ：</label>
                            <div class="controls">
                                <div class="input-append">
                                    <select name="sort_id">
                                        <?php if(is_array($sorts)): $i = 0; $__LIST__ = $sorts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sort): $mod = ($i % 2 );++$i;?><option value="<?php echo ($sort['id']); ?>"
                                            <?php if($vo['sort_id'] == $sort['id']): ?>selected="selected"<?php endif; ?>
                                            ><?php echo ($sort['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="appendedInput">货品单位 ：</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input size="16" name="good_depart" class="input-append " type="text"
                                           value="<?php echo ($vo['good_depart']?$vo['good_depart']:''); ?>">
                                </div>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <?php if($vo['stock'] == ''): ?><div class="control-group">
                                <label class="control-label" for="appendedInput">库存 ：</label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input size="16" name="stock" class="input-append " type="text"
                                               value="<?php echo ($vo['stock']?$vo['stock']:''); ?>">
                                    </div>
                                    <span class="help-inline"></span>
                                </div>
                            </div><?php endif; ?>
                        <div class="form-actions">
                            <input name="sub" type="hidden" id="sub" value="sub"/>
                            <button type="button" id="btn_submit" class="btn btn-primary">提交</button>&nbsp;
                            <a href="<?php echo ($reurl); ?>" class="btn">取消</a>
                        </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>


        <!--主要内容end-->
        <div class="row-fluid">
<div id="footer" class="span12"><?php echo (substr(date('Y-m-d g:i a',time()),0,4)); ?> &copy; <?php echo (C("SYS_NAME")); ?> <?php echo ($copyright); ?>版权所有 All rights reserved</div>
</div>
    </div><!--end content-->
    
		<!--<script src="/goods/Public//Admin/js/jquery.min.js"></script>	-->
		
		<script src="/goods/Public//Admin/js/jquery-1.7.2.min.js"></script>
		<script src="/goods/Public//Admin/js/jquery.ajaxfileupload.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.dataTables.min.js"></script>
		<script src="/goods/Public//Admin/js/jquery.form.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.gritter.min.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.peity.min.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.ui.custom.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.uniform.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.validate.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.wizard.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.autogrow-textarea.js"></script>	
		<script src="/goods/Public//Admin/js/jquery.iphone.toggle.js"></script>			
		<script src="/goods/Public//Admin/js/unicorn.js"></script>		
		<script src="/goods/Public//Admin/js/unicorn.chat.js"></script>	
		<script src="/goods/Public//Admin/js/unicorn.tables.js"></script>
		<script src="/goods/Public//Admin/js/unicorn.form_common.js"></script>	
		<script src="/goods/Public//Admin/js/unicorn.form_validation.js"></script>
		<script src="/goods/Public//Admin/js/bootstrap-colorpicker.js"></script>	
		<script src="/goods/Public//Admin/js/bootstrap-datepicker.js"></script>	
		<script src="/goods/Public//Admin/js/bootstrap.min.js"></script>	
		<script src="/goods/Public//Admin/js/excanvas.min.js"></script>	
		<script src="/goods/Public//Admin/js/fullcalendar.min.js"></script>			
		<script src="/goods/Public//Admin/js/jquery.jBox-2.3.min.js"></script>
		<script src="/goods/Public//Admin/js/jbox/jquery.jBox-zh-CN.js"></script>	
		<script src="/goods/Public//Admin/js/bootstrap-select.min.js"></script>		
		<script src="/goods/Public//Admin/js/select2.min.js"></script>	
		<script src="/goods/Public//Admin/js/bootbox.js"></script>		
		<script src="/goods/Public//Admin/js/xhj.js"></script>	
		
		<script src="/goods/Public//Admin/js/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
		<script src="/goods/Public//Admin/js/fancybox/jquery.fancybox-1.3.1.js"></script>
		<script src="/goods/Public//Admin/js/fancybox/pngobject.js"></script>

<?php echo R('Menu/wxmenu',array(''),'Widget');?>


    <script language="JavaScript">
        <!--
        function role_r() {
            obj = $("#act_form");
            wt = obj.find("input[name='role']:checked").val()
            obj.find("div[id=fun]").hide();
            if (wt == "2") {
                obj.find("div[id=fun]").show();
            }
        }

        role_r();
        $(document).ready(function () {
            $("#act_form").find("input[name='role']").bind("click", function () {
                role_r();
            });
            $('#btn_submit').click(function () {
                $('#alert_info').hide();
                $('#act_form').ajaxSubmit(function (json) {
                    if (json.status == 1) {
                        $('#alert_info').show();
                        $('#modal').html('<font style="font-family:Arial;font-size:12px;color:#c3413f">' + json.info + '</font>');
                        jBox.tip(json.info, 'success');
                        return;
                    }

                    $('#modal').html('<font style="font-family:Arial;font-size:12px;color:#c3413f">' + json.info + '</font>');
                    jBox.tip(json.info, 'error');
                });
                return false;
            });
        });

        $('.selectpicker').selectpicker('refresh');
        //-->
    </script>

</body>
</html>