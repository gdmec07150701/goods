<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<title>系统信息</title>
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

var SELF = '/goods/Seller/Index/index.html';
var URL = '/goods/Seller/Index';
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
	<h1>系统信息</h1>
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
		<h5>版权信息</h5>
		<div class="buttons">									
		</div>
	</div>

	<div class="widget-content">
		<div class="invoice-content">					
			<div>
				<table class="table table-bordered">
				<thead><tr><th colspan="2">	&nbsp; </th></tr></thead>
				<tfoot>
				<tr><th colspan="3">&nbsp;</th></tr></tfoot>
				<tbody>
				<tr><td>系统名称</td><td><?php echo (C("SYS_NAME")); ?></td></tr>
				<tr><td>当前版本</td><td><?php echo (C("SYS_NAME")); ?>  V1.0</td></tr>
				<tr><td>清除缓存</td><td><a href="<?php echo U('delrun');?>">更新网站缓存</a> <?php echo ($runtime); ?></td></tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
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

</body>
</html>