<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 定义上传目录
define('UPLOAD_PATH', __DIR__ . '/../public');
// 定义应用缓存目录
define('RUNTIME_PATH', __DIR__ . '/../runtime/');
// 开启调试模式
define('APP_DEBUG', false);

define('ADMIN_KEY', '123Abc');
error_reporting(0);
ini_set('display_errors', '0');
if(APP_DEBUG){
	ini_set('display_errors', '1');
	error_reporting(-1);
}
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
