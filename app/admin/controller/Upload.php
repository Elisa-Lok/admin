<?php
namespace app\admin\controller;
class Upload extends Base {
	//图片上传
	public function upload() {
		$file = request()->file('file');
		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/images');
		if ($info) {
			echo $info->getSaveName();
		} else {
			echo $file->getError();
		}
	}

	//会员头像上传
	public function uploadface() {
		$file = request()->file('file');
		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/face');
		if ($info) {
			echo $info->getSaveName();
		} else {
			echo $file->getError();
		}
	}

	//商户身份证
	public function uploadidcard() {
		$file = request()->file('file');
		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/idcard');
		if ($info) {
			echo $info->getSaveName();
		} else {
			echo $file->getError();
		}
	}
}