<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>商品中心-商品列表</title>
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

var SELF = '/goods/Seller/Goods/lst.html';
var URL = '/goods/Seller/Goods';
var APP	 =	 '/goods';
var PUBLIC = '/goods/Public/';
var GROUP = '__GROUP__';
var UPLOAD = '/goods/Public/Uploads';


</script>
</head>
<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
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
                        <h5>商品列表<span style="color:red;"></span></h5>
                        <form method="post" action="" enctype="multipart/form-data">
                                 <h3>导入Excel表：</h3><input  type="file" name="file_stu" />
                                   <input type="submit"  value="导入" />
                        </form>
                        <div class="buttons">
                            <a title="新建商品" class="btn btn-mini" href="<?php echo U('add');?>"><i class="icon-plus"></i></a>
                        </div>
                    </div>
                    <div class="widget-content">
                        <div class="invoice-content">
                            <div class="alert alert-error hide" id="alert_info">
                                <button type="button" class="close" onclick="$('#alert_info').hide();">×</button>
                                <div class="alert-body"><span id="modal"></span></div>
                            </div>

                            <div>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>商品编号</th>
                                        <th>商品名称</th>
                                        <th>条形码</th>
                                        <th>货品类别</th>
                                        <th>货品单位</th>
                                        <th>库存</th>
                                        <th>操作数目</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th colspan="9">
                                            <div class="pagination alternate"><?php echo ($page); ?></div>
                                        </th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="list_data_<?php echo ($vo["id"]); ?>" class="center">

                                            <td><?php echo ($vo["good_num"]); ?></td>
                                            <td><?php echo ($vo["name"]); ?></td>
                                            <td><?php echo ($vo["tx_num"]); ?></td>
                                            <td><?php echo (getSortName($vo['sort_id'] )); ?></td>
                                            <td><?php echo ($vo["good_depart"]); ?></td>
                                            <td id="s<?php echo ($vo['id']); ?>"><?php echo ($vo["stock"]); ?></td>
                                            <td><input type="text" style="width: 50px;" id="num<?php echo ($vo['id']); ?>" value="0">
                                            </td>
                                            <!--<td><div class="btn" onclick="minus(<?php echo ($vo['id']); ?>)"><i class="icon-minus"></i></div><input  id="s<?php echo ($vo['id']); ?>" type="text" value="<?php echo ($vo["stock"]); ?>" style="width: 50px;margin-bottom: 0px;" disabled><div class="btn" onclick="plus(<?php echo ($vo['id']); ?>)"><i class="icon-plus"></i></div></td>-->
                                            <td class="center">
                                                <a class="btn btn-info" onclick="saveStock(<?php echo ($vo['id']); ?>,1)">
                                                    <i class="icon-chevron-down icon-white"></i>
                                                    进货
                                                </a>
                                                <a class="btn btn-info" onclick="saveStock(<?php echo ($vo['id']); ?>,2)">
                                                    <i class="icon-chevron-up icon-white"></i>
                                                    出货
                                                </a>
                                                <!--<a class="btn btn-info" onclick="saveStock(<?php echo ($vo['id']); ?>)">-->
                                                <!--<i class="icon-edit icon-white"></i>-->
                                                <!--保存-->
                                                <!--</a>-->
                                                <a class="btn btn-info" href="<?php echo U('edit?id='.$vo['id']);?>">
                                                    <i class="icon-edit icon-white"></i>
                                                    编辑
                                                </a>
                                                <a class="btn btn-danger" data-toggle="modal" href="#static"
                                                   onclick="$('#del_mid').val(<?php echo ($vo["id"]); ?>);">
                                                    <i class="icon-trash icon-white"></i>
                                                    删除
                                                </a>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
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

    <div id="static" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-body">
            <p>确认删除当前信息？</p>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn">取消</button>&nbsp;
            <input name="del_mid" id="del_mid" type="hidden" value=""/>
            <button type="button" data-dismiss="modal" class="btn btn-primary" onclick="del();">确认</button>
        </div>
    </div>

    
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
        function del() {
            var mid = $('#del_mid').val();
            $('#alert_info').hide();
            $.ajax({
                type: 'POST',
                url: "<?php echo U('Goods/del');?>",
                data: {id: mid},
                dataType: "json",
                success: function (json) {
                    console.log(json)
                    if (json.status == 1)
                        $('#list_data_' + mid).hide();
                    $('#alert_info').show();
                    $('#modal').html('<font style="font-family:Arial;font-size:12px;color:#c3413f">' + json.info + '</font>');
                }

            });
        }

        function saveStock(id, type) {
            //当前库存量
            var stock = Number($('#s' + id).text());
            //操作的库存量
            var num = Number($('#num' + id).val());
            if (type == 2) {
                //判断减去的数是否大于库存数
                if (num > stock) {
                    alert('库存不足，操作失败')
                    return
                }
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo U('Goods/saveStock');?>",
                data: {id: id, num: num, type: type},
                dataType: "json",
                success: function (json) {

                    if (json.status == 1)
                        if (type == 1) {
                            $('#s'+id).text(stock+num);
                        }else if(type == 2){
                            $('#s'+id).text(stock-num);
                        }
                    $('#alert_info').show();
                    $('#modal').html('<font style="font-family:Arial;font-size:12px;color:#c3413f">' + json.info + '</font>');

                }

            });
        }

        function minus(id) {
            if ($('#s' + id).val() < 1) {
                alert('库存不足');
                return
            }
            $('#s' + id).val($('#s' + id).val() - 1);
            $.ajax({
                type: 'POST',
                url: "<?php echo U('Goods/changeStock');?>",
                data: {id: id, act: 'minus'},
                dataType: "json",
                success: function (json) {
                    console.log(json)
                    if (json.status == 1)
                        $('#alert_info').show();
                    $('#modal').html('<font style="font-family:Arial;font-size:12px;color:#c3413f">' + json.info + '</font>');
                }

            });
        }

        function plus(id) {
            $('#s' + id).val(Number($('#s' + id).val()) + 1);
            $.ajax({
                type: 'POST',
                url: "<?php echo U('Goods/changeStock');?>",
                data: {id: id, act: 'plus'},
                dataType: "json",
                success: function (json) {
                    console.log(json)
                    if (json.status == 1)
                        $('#alert_info').show();
                    $('#modal').html('<font style="font-family:Arial;font-size:12px;color:#c3413f">' + json.info + '</font>');
                }

            });
        }

        $("#role").val("<?php echo ($_GET['role']); ?>");
        $('.selectpicker').selectpicker('refresh');
        //-->
    </script>


</body>
</html>