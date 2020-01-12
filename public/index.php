<?php
// 定义应用目录
const APP_PATH     = __DIR__ . '/../application/';
const UPLOAD_PATH  = __DIR__ . '/../public';   // 定义上传目录
const RUNTIME_PATH = __DIR__ . '/../runtime/'; // 定义应用缓存目录
const APP_DEBUG    = FALSE;                    // 开启调试模式
const ADMIN_KEY    = '123Abc';
error_reporting(0);
ini_set('display_errors', '0');
if (APP_DEBUG) {
	ini_set('display_errors', '1');
	error_reporting(-1);
}
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';