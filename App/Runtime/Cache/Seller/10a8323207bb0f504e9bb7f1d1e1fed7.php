<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<title><?php echo (C("SYS_NAME")); ?></title>
<meta charset="utf-8">
<meta name="keywords" content="<?php echo (C("SYS_NAME")); ?>" />
<meta name="description" content="<?php echo (C("SYS_NAME")); ?>">
<meta name="author" content="BBCMS Team">	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/goods/Public//Admin/css/bootstrap.min.css" />
<link rel="stylesheet" href="/goods/Public//Admin/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="/goods/Public//Admin/css/unicorn.login.css" />
</head>
    <body>
        <div id="logo">
            <img src="/goods/Public//Uploads/logo.jpg" alt="<?php echo (C("SYS_NAME")); ?>" />
        </div>
<?php if(isset($message)): ?><div class="alert alert-error" id="alert_info">
				<button type="button" class="close" onclick="$('#alert_info').hide();">×</button>						
				<div class="alert-body"><span id="modal"><?php echo($message); ?></span></div>
			</div>
<?php else: ?>
	<div class="alert alert-error" id="alert_info">
				<button type="button" class="close" onclick="$('#alert_info').hide();">×</button>						
				<div class="alert-body"><span id="modal"><?php echo($error); ?></span></div>
			</div><?php endif; ?>
			


        <div id="loginbox">  

          	<p><?php echo (C("SYS_NAME")); ?></p>
					

                <div class="control-group">
                    页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>

                </div>
		

        </div>
        
<script src="/goods/Public//Admin/js/jquery.min.js"></script>  
<script src="/goods/Public//Admin/js/unicorn.login.js"></script> 
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>

</body>
</html>