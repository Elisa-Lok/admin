<?php
namespace app\admin\model;
use think\Model;

class BannerModel extends Model {
	protected $name = 'banner';

	/**
	 * 根据条件获取列表信息
	 * @param $where
	 * @param $nowPage
	 * @param $limits
	 */
	public function getAdAll($map, $nowPage, $limits) {
		return $this->field('think_banner.*,name')->join('think_banner_position', 'think_banner.ad_position_id = think_banner_position.id')->where($map)->page($nowPage, $limits)->order('orderby desc')->select();
	}

	/**
	 * 插入信息
	 * @param $param
	 */
	public function insertAd($param) {
		try {
			$result = $this->validate('AdValidate')->allowField(TRUE)->save($param);
			if (FALSE === $result) {
				return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
			}
			return ['code' => 1, 'data' => '', 'msg' => '添加挂单成功'];
		} catch (PDOException $e) {
			return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
		}
	}

	/**
	 * 编辑信息
	 * @param $param
	 */
	public function editAd($param) {
		try {
			$result = $this->validate('AdValidate')->allowField(TRUE)->save($param, ['id' => $param['id']]);
			if (FALSE === $result) {
				return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
			}
			return ['code' => 1, 'data' => '', 'msg' => '编辑挂单成功'];
		} catch (PDOException $e) {
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}

	/**
	 * 根据id获取一条信息
	 * @param $id
	 */
	public function getOneAd($id) {
		return $this->where('id', $id)->find();
	}

	/**
	 * 删除信息
	 * @param $id
	 */
	public function delAd($id) {
		try {
			$map['closed'] = 1;
			$this->save($map, ['id' => $id]);
			return ['code' => 1, 'data' => '', 'msg' => '删除挂单成功'];
		} catch (PDOException $e) {
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}
}