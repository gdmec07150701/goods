<?php
define('ROOT_DIR_PATH', 'D:/fyit_svn/project2/kaoqin/backend/release');
return array(
		//'配置项'=>'配置值'
		'SESSION_AUTO_START'        =>  true,
		'USER_AUTH_KEY'             =>  'adminAuthId',	// 用户认证SESSION标记
		'USER_AUTH_INFO'             =>  'adminAuthInfo',	// 当前用户对象保存SESSION标记


		'SYS_NAME'              => 'Remix个人版后台管理系统',
		'TMPL_ACTION_SUCCESS' =>   APP_PATH. 'Seller/View/Public/dispatch_jump.html',
		'TMPL_ACTION_ERROR' => APP_PATH. 'Seller/View/Public/dispatch_jump.html',
		'APP_AUTOLOAD_PATH' => '@.TagLib',
		'TAGLIB_BUILD_IN' => 'cx,hd',


		//'URL_HTML_SUFFIX' => 'html', // URL伪静态后缀设置
);
