<?php
return array(
    //'配置项'=>'配置值'
    
    /*数据库配置*/
    'DB_TYPE' => 'mysql',                // 数据库类型
    'URL_MODEL' => 2,                    //如果你的环境不支持PATHINFO 请设置为3
    'DB_HOST' => '127.0.0.1',            // 服务器地址
    'DB_NAME' => 'goods',                // 数据库名
    // 'DB_USER' => 'root', 				// 用户名
    // 'DB_PWD' => 'root',						// 密码
    'DB_USER' => 'root',                // 用户名
    'DB_PWD' => 'root',                        // 密码
    'DB_PORT' => '3306',                // 端口
    'DB_PREFIX' => 'gd_',            // 数据库表前缀
    'DATA_CACHE_TYPE' => 'Memcached',
    'MEMCACHED_SERVER' => array('127.0.0.1', 11211, 0),
    /* 日志设置 */
    //'LOG_RECORD' => false,				// 默认不记录日志
    /* 日志设置 */
    'LOG_RECORD' => true,   // 记录日志
    /*缓存设置*/
    'TMPL_CACHE_ON' => true,
    
    'LOG_TYPE' => 'File', // 日志记录类型 默认为文件方式
    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR',// 允许记录的日志级别
    
    /* 应用设定 */
    'APP_AUTOLOAD_PATH' => '@.TagLib',// 自动加载的路径 关闭APP_USE_NAMESPACE后有效
    
    
    'DATA_CACHE_TYPE' => 'Memcache',
    'MEMCACHED_HOST' => '127.0.0.1',
    'MEMCACHED_PORT' => '11211',
    
    /* 默认设定 */
    //'MODULE_ALLOW_LIST'    =>    array('Api'),
    'DEFAULT_MODULE' => 'Api',// 默认模块
    'APP_GROUP_MODE' => 1,
    'SHOW_PAGE_TRACE' => 0,    //显示调试信息
    // 'URL_CASE_INSENSITIVE' => true,// 默认false 表示URL区分大小写 true则表示不区分大小写
    'VAR_PAGE' => 'p',
    'MY_APP_NAME' => '/qfb',//定义IIS应用的名称，如果是二级域名需要定义，如果是一级域名不需要
    'WXPAY_PATH' => '/wxpay',
    'TMPL_PARSE_STRING' => array(        // 添加输出替换
        '__UPLOAD__' => __ROOT__ . '/Public/Uploads',
        '__PUBLIC__' => __ROOT__ . '/Public/',
    ),
    //'TMPL_EXCEPTION_FILE'=>'./App/Tpl/error.html',
    //'TMPL_EXCEPTION_FILE'=>'./App/Tpl/dispatch_jump.html',    //测试代码，正式使用改成error.html
    //'COPYRIGHT' => '广州Rexmix信息科技有限公司',   //版权信息
    'LOAD_EXT_CONFIG' => 'wx',
    'listRows' => 20,   //分页记录数
    'LOG_RECORD' => true,
);