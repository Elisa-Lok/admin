<?php
// error_reporting(0);
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
ini_set('display_errors', '0');
if (APP_DEBUG) {
	ini_set('display_errors', '1');
	error_reporting(-1);
}
// 资金记录, 0系统修改,1挂单上架,2挂单下架,3.交易卖出,4交易买入,5充入,6提走,7奖励
const BAL_SYS = 0, BAL_ENTRUST = 1, BAL_REDEEM = 2, BAL_SOLD = 3, BAL_BOUGHT = 4, BAL_RECHARGE = 5, BAL_WITHDRAW = 6, BAL_REWARD = 7, BAL_COMMISSION = 8, BAL_CANCEL = 9;
const BAL_REC = [BAL_SYS => '系统修改', BAL_ENTRUST => '挂单上架', BAL_REDEEM => '挂单下架', BAL_SOLD => '交易卖出', BAL_BOUGHT => '交易买入', BAL_RECHARGE => '充入', BAL_WITHDRAW => '提出', BAL_REWARD => '奖励', BAL_COMMISSION => '佣金', BAL_CANCEL => '交易取消'];
return [
	// | auth配置
	'auth_config'                => [
		'auth_on'           => 1, // 权限开关
		'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
		'auth_group'        => 'think_auth_group', // 用户组数据不带前缀表名
		'auth_group_access' => 'think_auth_group_access', // 用户-用户组关系不带前缀表
		'auth_rule'         => 'think_auth_rule', // 权限规则不带前缀表
		'auth_user'         => 'think_admin', // 用户信息不带前缀表
	],
	// | 应用设置
	'url_route_on'               => TRUE,     //开启路由功能
	'route_config_file'          => ['route'],   // 设置路由配置文件列表
	// | Trace设置 开启 app_trace 后 有效
	'app_trace'                  => FALSE,      //开启应用Trace调试
	'trace'                      => ['type' => 'html'],// 在当前Html页面显示Trace信息,显示方式console、html
	'sql_explain'                => FALSE,     // 是否需要进行SQL性能分析
	'extra_config_list'          => ['database', 'route', 'validate'],//各模块公用配置
	'app_debug'                  => APP_DEBUG,
	'default_module'             => 'home',//默认模块
	//'default_filter' => ['strip_tags', 'htmlspecialchars'],
	//默认错误跳转对应的模板文件
	'dispatch_error_tmpl'        => APP_PATH . 'admin/view/public/error.tpl',
	//默认成功跳转对应的模板文件
	'dispatch_success_tmpl'      => APP_PATH . 'admin/view/public/success.tpl',
	//'exception_tmpl'             => APP_PATH . 'admin/view/public/error.tpl',
	// | 日志设置
	'log'                        => [
		'type'  => 'File',// 日志记录方式，内置 file socket 支持扩展
		'path'  => LOG_PATH,// 日志保存目录
		'level' => ['error', 'critical', 'alert', 'emergency'],// 日志记录级别 debug, info, notice, warning, error, critical, alert, emergency,sql
		// 'level' => ['error', 'critical', 'alert', 'emergency', 'sql'],
	],
	// | 缓存设置
	// 'cache'                      => ['type' => 'file', 'path' => CACHE_PATH, 'prefix' => '', 'expire' => 0,],
	'cache'                      => ['type' => 'redis', 'host' => '127.0.0.1', 'prefix' => 'cache_', 'expire' => 0],
	// | 会话设置
	'session'                    => [
		'type'       => 'redis',// 驱动方式 支持redis memcache memcached
		'auto_start' => TRUE,// 是否自动开启 SESSION
		'expire'     => 5184000,
	],
	// | Cookie设置
	'cookie'                     => [
		'prefix'    => '',        // cookie 名称前缀
		'expire'    => 5184000,    // cookie 保存时间
		'path'      => '/',        // cookie 保存路径
		'domain'    => '',        // cookie 有效域名
		'secure'    => FALSE,    // cookie 启用安全传输
		'httponly'  => '',        // httponly设置
		'setcookie' => TRUE,    // 是否使用 setcookie
	],
	//分页配置
	'paginate'                   => [
		'type'      => 'bootstrap',
		'var_page'  => 'page',
		'list_rows' => 15,
	],
	// | 数据库设置
	'data_backup_path'           => '../data/',   //数据库备份路径必须以 / 结尾；
	'data_backup_part_size'      => '20971520',  //该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M
	'data_backup_compress'       => '1',          //压缩备份文件需要PHP环境支持gzopen,gzwrite函数        0:不压缩 1:启用压缩
	'data_backup_compress_level' => '9',    //压缩级别   1:普通   4:一般   9:最高
	// | 验证类型
	'verify_type'                => '1',   //验证码类型：0拖动滑块验证， 1数字验证码
	'auth_key'                   => 'JUD6FCtZsqrmVXc2apev4TRn3O8gAhxbSlH9wfPN', //默认数据加密KEY
	'pages'                      => '10',//分页数
	'salt'                       => 'wZPb~yxvA!ir38&Z!!@',//加密串
	//订单超时时间
	'order_expire'               => 8,
	'paid_expire'                => 900,
	'is_send_sms'                => TRUE,
];