<?php
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application');
$tags       = []; // Tags对象
$paths      = []; // Path数组
$module_dir = opendir(APP_PATH);
while (($module_name = readdir($module_dir)) !== FALSE) {
	$module_path = APP_PATH . DIRECTORY_SEPARATOR . $module_name;    //构建子目录路径
	if (is_dir($module_path)) {
		$module           = strtolower($module_name);
		$module_child_dir = opendir($module_path);
		while (($module_child_name = readdir($module_child_dir)) !== FALSE) {
			$module_child_path = $module_path . DIRECTORY_SEPARATOR . $module_child_name;    //构建子目录路径
			if (is_dir($module_child_path) && $module_child_name == 'controller') {
				$controller_dir = opendir($module_child_path);
				while (($controller_file = readdir($controller_dir)) !== FALSE) {
					$controller_path = $module_child_path . DIRECTORY_SEPARATOR . $controller_file;    //构建子目录路径
					$controller_name = strtolower(basename($controller_path, '.php'));
					$contents        = file_get_contents($controller_path);
					if (preg_match_all('/swagger:\s*([^\n]+)/i', $contents, $swagger_matches)) {
						// 添加tag
						$found_tag = FALSE;
						foreach ($tags as $tag) {
							if ($tag['name'] == $controller_name) {
								$found_tag = TRUE;
								break;
							}
						}
						if (!$found_tag) {
							array_push($tags, [
									'name'        => $controller_name,
									'description' => $swagger_matches[1][0]
							]);
						}
						// 添加path
						if (preg_match_all('/\/\*((?!\*\/).)+\*\//s', $contents, $func_matches)) {
							$length = count($func_matches[0]);
							if ($length > 1) {
								for ($i = 1; $i < $length; $i++) {
									$func_array = [];
									// 解析每个方法
									$func_contents = $func_matches[0][$i];
									// 方法说明
									if (!preg_match_all('/(get|post|delete)\s*:\s*([^\n]+)/i', $func_contents, $matches)) {
										break;
									}
									$method  = $matches[1][0];
									$summary = $matches[2][0];
									// 路径
									if (!preg_match_all('/path\s*:\s*([^\n]+)/i', $func_contents, $matches)) {
										break;
									}
									$path = $matches[1][0];
									// 方法名称
									$operations  = explode('/', $path);
									$operationId = $operations[0];
									if (preg_match_all('/method\s*:\s*([^\n]+)/i', $func_contents, $matches)) {
										$operationId = $matches[1][0];
									}
									$paths[$path] = [];
									$parameters   = [];
									$func         = [
											'tags'        => [$controller_name],
											'summary'     => $summary,
											'description' => '',
											'operationId' => $operationId,
											'produces'    => ['application/json']
									];
									// 参数
									$pattern = '/param\s*:\s*(?<name>\w+)\s*-\s*\{(?<type>\w+(?<array>\[\])?)\}\s*(=\s*((\[(?<enum>[^]]+)\])|(?<default>[^\s]+))\s*)?(?<summary>[^*]+)/i';
									if (preg_match_all($pattern, $func_contents, $matches)) {
										$names        = $matches['name'];    // 参数名称
										$types        = $matches['type'];    // 参数类型
										$enums        = $matches['enum'];    // 参数枚举
										$defaults     = $matches['default']; // 默认值
										$summarys     = $matches['summary']; // 参数说明
										$arrays       = $matches['array'];   // 参数说明
										$params_count = count($names);
										for ($j = 0; $j < $params_count; $j++) {
											$in = $method == 'get' ? 'query' : 'formData';
											if (strpos($path, '{' . $names[$j] . '}') !== FALSE) {
												$in = 'path';
											}
											$parameter = [
													'name'        => $names[$j],
													'in'          => $in,
													'required'    => TRUE,
													'description' => $summarys[$j]
											];
											if ($defaults[$j] !== '') {
												$parameter['required']     = FALSE;
												$parameter['defaultValue'] = $defaults[$j];
											}
											$type = str_replace('[]', '', $types[$j]);
											if ($type == 'int') {
												$type = 'integer';
											}
											if ($arrays[$j] != '') { // 是否数据参数
												$parameter['type']             = 'array';
												$parameter['items']            = [
														'type' => str_replace('[]', '', $type)
												];
												$parameter['collectionFormat'] = 'brackets'; // 字带中括号
												//$parameter['collectionFormat'] = 'multi'; 
											} elseif ($enums[$j] != '') { // 是否枚举参数
												$enum              = explode('|', $enums[$j]);
												$parameter['type'] = $type;
												$parameter['enum'] = $enum;
											} else {
												$parameter['type'] = $type;
											}
											array_push($parameters, $parameter);
										}
									}
									$func['parameters'] = $parameters;
									// 生成api访问路径
									$paths['/' . $module . '/' . $controller_name . '/' . $path][$method] = $func;
								}
							}
						}
					}
				}
				closedir($controller_dir);
			}
		}
		closedir($module_child_dir);
	}
}
closedir($module_dir);
$swagger = [
		'swagger'             => '2.0',
		'info'                => [
				'description'    => 'Creator by tianjianlong',
				'version'        => '1.0.0',
				'title'          => '轮回系统API接口管理',
				'termsOfService' => 'http://ilunhui.cn/',
				'contact'        => [
						'email' => ''
				]
		],
		'host'                => $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'],
		'basePath'            => '',
		'tags'                => $tags,
		'schemes'             => [
				'http'
		],
		'paths'               => $paths,
		'securityDefinitions' => [],
		'definitions'         => []
];
$jsonFile = fopen("swagger/swagger.json", "w") or die("Unable to open file!");
fwrite($jsonFile, json_encode($swagger));
fclose($jsonFile);
// 跳转到Swagger UI
$url = '/swagger/index.html';
Header('HTTP/1.1 303 See Other');
Header("Location: $url");
exit;