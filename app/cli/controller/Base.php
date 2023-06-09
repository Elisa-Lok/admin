<?php
namespace app\cli\controller;
use think\Controller;

(PHP_SAPI != 'cli') && die('error');

class Base extends Controller {
	public $uid;

	public function _initialize() {
		$this->setConfig();
	}

	protected function setConfig() {
		$config = cache('db_config_data');
		if (!$config) {
			$config = api('Config/lists');
			cache('db_config_data', $config);
		}
		config($config);
	}

	public function test(){
		die('this is a test');
	}
}