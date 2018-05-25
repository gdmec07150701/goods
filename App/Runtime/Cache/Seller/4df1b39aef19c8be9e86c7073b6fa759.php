<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<title>帐号中心-管理员维护</title>
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

var SELF = '/goods/index.php/Seller/Manager/add/id/2.html';
var URL = '/goods/index.php/Seller/Manager';
var APP	 =	 '/goods/index.php';
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
		
		<?php $arc="xc_w11";if(chkArc($arc)){ ?><li class="submenu <?php if(in_array((CONTROLLER_NAME), explode(',',"Store"))): ?>active open<?php endif; ?>">
				<a><i class="icon icon-user active"></i> <span>商家管理</span></a>
				<ul>
				<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Store"))): if(in_array((ACTION_NAME), explode(',',"lst"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Store/lst');?>">店铺列表</a></li><?php } ?>					
				</ul>
			</li><?php } ?>

		<?php $arc="xc_w11";if(chkArc($arc)){ ?><li class="submenu <?php if(in_array((CONTROLLER_NAME), explode(',',"Deal"))): ?>active open<?php endif; ?>">
				<a><i class="icon icon-user active"></i> <span>交易管理</span></a>
				<ul>
				<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Deal"))): if(in_array((ACTION_NAME), explode(',',"lst"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Deal/lst');?>">交易列表</a></li><?php } ?>					
				</ul>

				<!-- <ul>
				<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Deal"))): if(in_array((ACTION_NAME), explode(',',"contro"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Deal/contro');?>">交易接口开关</a></li><?php } ?>					
				</ul> -->

				<ul>
				<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Deal"))): if(in_array((ACTION_NAME), explode(',',"config"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Deal/config');?>">配置管理</a></li><?php } ?>					
				</ul>
			</li><?php } ?>

		<?php $arc="xc_w11";if(chkArc($arc)){ ?><li class="submenu <?php if(in_array((CONTROLLER_NAME), explode(',',"Widthdraw"))): ?>active open<?php endif; ?>">
				<a><i class="icon icon-user active"></i> <span>提现管理</span></a>
				<ul>
				<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Widthdraw"))): if(in_array((ACTION_NAME), explode(',',"lst"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Widthdraw/lst');?>">提现记录</a></li><?php } ?>
				<?php $arc="xc_w11";if(chkArc($arc)){ ?><li <?php if(in_array((CONTROLLER_NAME), explode(',',"Widthdraw"))): if(in_array((ACTION_NAME), explode(',',"store"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Widthdraw/store');?>">商户金额</a></li><?php } ?>					
				</ul>
			</li><?php } ?>

		<?php $arc="xc_w1";if(chkArc($arc)){ ?><li class="submenu <?php if(in_array((CONTROLLER_NAME), explode(',',"Manager"))): ?>active open<?php endif; ?>">
			<a><i class="icon icon-user active"></i> <span>管理员中心</span></a>
			<ul>
				<li <?php if(in_array((CONTROLLER_NAME), explode(',',"Manager"))): if(in_array((ACTION_NAME), explode(',',"managers"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Manager/index');?>">管理员列表</a></li>
				<li <?php if(in_array((CONTROLLER_NAME), explode(',',"Manager"))): if(in_array((ACTION_NAME), explode(',',"managers_log"))): ?>class="active"<?php endif; endif; ?>><a href="<?php echo U('Manager/log');?>">管理日志</a></li>
				
				
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
	<h1>帐号中心</h1>
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
		<h5><?php if(($act) == "add"): ?>添加<?php else: ?>修改<?php endif; ?> 管理员信息</h5>
		</div>
			<div class="alert alert-error hide" id="alert_info">
				<button type="button" class="close" onclick="$('#alert_info').hide();">×</button>						
				<div class="alert-body"><span id="modal"></span></div>
			</div>

					<div class="widget-content nopadding">
								<form id="act_form" method="post" class="form-horizontal" />

							<div class="control-group">
								<label class="control-label" for="appendedInput">登录帐号：</label>
								<div class="controls">
								  <div class="input-append">
									<input size="16" name="account" class="input-append <?php if(($act) == "edit"): ?>disabled<?php endif; ?>" type="text" placeholder="<?php echo ($vo["account"]); ?>" value="<?php echo ($vo["account"]); ?>" <?php if(($act) == "edit"): ?>disabled=""<?php endif; ?>>
								  </div>
								  <span class="help-inline"></span>
								</div>

								<!-- <?php if(($app_manager["role"]) == "1"): ?><label class="control-label" for="appendedInput">身份：</label>
									<div class="controls">
										 <label class="radio"><input type="radio" name="role" value="1" <?php if(($vo['role']) == "1"): ?>checked<?php endif; ?>>系统管理员</label>
										 <label class="radio"><input type="radio" name="role" value="2" <?php if(($vo['role']) == "2"): ?>checked<?php endif; ?>>业务管理员</label>
									</div>
									<div id="fun" class="hide">
									<label class="control-label" for="appendedInput">使用权限：</label>
									<div class="controls">
										<fieldset>
										 <ul class="changeapp">
											<li><label><input name="arc[]" type="checkbox" <?php if(in_array('xc_w11',$accountarc)): ?>checked="checked"<?php endif; ?>  value="xc_w11"/> 财务管理</label></li>
											<li><label><input name="arc[]" type="checkbox" <?php if(in_array('xc_w21',$accountarc)): ?>checked="checked"<?php endif; ?>  value="xc_w21"/> 客服管理</label></li>
										</ul>
										</fieldset>									
								
								</div>
								 
								</div><?php endif; ?> -->

								<label class="control-label" for="appendedInput"><?php if(($act) == "edit"): ?>新<?php endif; ?>用户密码：</label>
								<div class="controls">
								  <div class="input-append">
									<input name="password" size="16" type="password">
								  </div>
								  <span class="help-inline"><?php if(($act) == "edit"): ?>设置账户的新密码, 如不修改密码请留空<?php endif; ?> </span>
								</div>
								<label class="control-label" for="appendedInput">确认密码：</label>
								<div class="controls">
								  <div class="input-append">
									<input name="repassword" size="16" type="password">
								  </div>
								  <span class="help-inline"><?php if(($act) == "edit"): ?>请重新输入密码以确认无误, 如不修改密码请留空<?php endif; ?> </span>
								</div>
								<label class="control-label" for="appendedInput">真实姓名：</label>
								<div class="controls">
								  <div class="input-append">
									<input name="nickname" size="16" type="text" value="<?php echo ((isset($_POST['nickname']) && ($_POST['nickname'] !== ""))?($_POST['nickname']):$vo['nickname']); ?>"><span class="add-on">*</span>
								  </div>
								  <span class="help-inline"></span>
								</div>
								<label class="control-label" for="appendedInput">联系手机：</label>
								<div class="controls">
								  <div class="input-append">
									<input name="mobile" size="16" type="tel" value="<?php echo ((isset($_POST['mobile']) && ($_POST['mobile'] !== ""))?($_POST['mobile']):$vo['mobile']); ?>"><span class="add-on">*</span></div>
								  <span class="help-inline"></span>
								</div>
								<!-- <label class="control-label" for="appendedInput">联系电话：</label>
								<div class="controls">
								  <div class="input-append">
									<input name="phone" size="16" type="tel" value="<?php echo ((isset($_POST['phone']) && ($_POST['phone'] !== ""))?($_POST['phone']):$vo['phone']); ?>"></div>
								  <span class="help-inline"></span>
								</div>-->
								<!-- <label class="control-label" for="appendedInput">电子信箱：</label>
								<div class="controls">
								  <div class="input-append">
									<input name="email" size="16" type="email" value="<?php echo ((isset($_POST['email']) && ($_POST['email'] !== ""))?($_POST['email']):$vo['email']); ?>"></div>
								  <span class="help-inline"></span>
								</div> -->
								<label class="control-label" for="appendedInput">是否启用：</label>
								<div class="controls">
								  <div class="input-append">
									<input data-no-uniform="true" name="status" type="checkbox" <?php if(($vo['status']) == "1"): ?>checked<?php endif; ?> class="iphone-toggle">				 
								  </div>
								  <span class="help-inline"></span>
								</div>
								<label class="control-label" for="appendedInput">备注：</label>
								<div class="controls">
									<textarea name='remark'  cols="100" rows="4" ><?php echo ($vo["remark"]); ?></textarea>
								</div>									
							  </div>

							 

							   <div class="control-group">
								<!-- <label class="control-label" for="appendedInput">备注：</label>
								<div class="controls">
								 	 <textarea name="remark" class="autogrow"><?php echo ((isset($_POST['remark']) && ($_POST['remark'] !== ""))?($_POST['remark']):$vo['remark']); ?></textarea>
								</div> -->
							
							  </div>
									<div class="form-actions">
										<input name="sub" type="hidden" id="sub" value="sub" />
										<input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>">
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
function role_r(){
	obj=$("#act_form");
	wt=obj.find("input[name='role']:checked").val()
	obj.find("div[id=fun]").hide();	
	if (wt=="2"){
		obj.find("div[id=fun]").show();
	}
}
role_r();

$(document).ready(function(){
	$("#act_form").find("input[name='role']").bind("click",function(){role_r();});
    $('#btn_submit').click(function(){
			$('#alert_info').hide();
            $('#act_form').ajaxSubmit(function(json){
                if(json.status==1){
					window.location.href=json.url;
					return;
				}
				$('#alert_info').show();
				$('#modal').html( '<font style="font-family:Arial;font-size:12px;color:#c3413f">' +  json.info + '</font>');
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