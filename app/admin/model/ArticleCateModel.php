<?php
namespace app\admin\model;
use think\Model;

class ArticleCateModel extends Model {
	protected $name = 'article_cate';
	// 开启自动写入时间戳
	protected $autoWriteTimestamp = TRUE;

	/**
	 * [getAllCate 获取全部分类]
	 */
	public function getAllCate() {
		return $this->order('id ASC')->select();
	}

	/**
	 * [insertCate 添加分类]
	 */
	public function insertCate($param) {
		try {
			return FALSE === $this->save($param) ? ['code' => -1, 'data' => '', 'msg' => $this->getError()] : ['code' => 1, 'data' => '', 'msg' => '分类添加成功'];
		} catch (PDOException $e) {
			return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
		}
	}

	/**
	 * [editMenu 编辑分类]
	 */
	public function editCate($param) {
		try {
			$result = $this->save($param, ['id' => $param['id']]);
			if (FALSE === $result) {
				return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
			}
			return ['code' => 1, 'data' => '', 'msg' => '分类编辑成功'];
		} catch (PDOException $e) {
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}

	/**
	 * [getOneMenu 根据分类id获取一条信息]
	 * @return [type] [description]
	 */
	public function getOneCate($id) {
		return $this->where('id', $id)->find();
	}

	/**
	 * [delMenu 删除分类]
	 * @return [type] [description]
	 */
	public function delCate($id) {
		try {
			$this->where('id', $id)->delete();
			return ['code' => 1, 'data' => '', 'msg' => '分类删除成功'];
		} catch (PDOException $e) {
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}
}