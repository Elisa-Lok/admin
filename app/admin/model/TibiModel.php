<?php
namespace app\admin\model;
use think\db;
use think\Exception\DbException;
use think\Model;

class TibiModel extends Model {
	protected $name       = 'merchant_withdraw';
	protected $createTime = 'addtime';
	protected $updateTime = 'endtime';

	public function getTibiByWhere($map, $nowPage, $limits) {
		$join = [['__MERCHANT__ b', 'b.id=a.merchant_id', 'LEFT'],];
		return $this->field('a.*, b.mobile')->alias('a')->join($join)->where($map)->page($nowPage, $limits)->order('a.id desc')->select();
	}

	public function getAllCount($map) {
		return $this->where($map)->count();
	}

	public function getOneByWhere($param, $field) {
		return $this->where($field, $param)->find();
	}

	public function editWithdraw($param) {
		try {
			$result = $this->save($param, ['id' => $param['id']]);
			if (FALSE === $result) {
				return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
			}
			return ['code' => 1, 'data' => '', 'msg' => '操作成功'];
		} catch (PDOException $e) {
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}

	public function cancel($id) {
		$find = $this->where('id', $id)->find();
		if ($find['status'] != 0) {
			return ['code' => 0, 'data' => '', 'msg' => '操作失败：订单状态错误'];
		}
		Db::startTrans();
		try {
			$rs1 = balanceChange(FALSE, $find['merchant_id'], $find['num'], 0, -$find['num'], 0, BAL_WITHDRAW, $id, '拒绝提币');
			$rs2 = $this->where('id', $id)->update(['status' => 2, 'endtime' => time()]);
			if ($rs1 && $rs2) {
				// 提交事务
				Db::commit();
				return ['code' => 1, 'data' => '', 'msg' => '操作成功'];
			}
			// 回滚事务
			Db::rollback();
			return ['code' => 0, 'data' => '', 'msg' => '操作失败'];
		} catch (DbException $e) {
			// 回滚事务
			Db::rollback();
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}
}

?>