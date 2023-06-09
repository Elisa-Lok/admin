<?php
namespace app\home\model;
use think\db;
use think\Exception\DbException;
use think\Model;
use think\request;

class TibiModel extends Model {
	protected $name = 'merchant_withdraw';

	public function getWithdraw($where, $order) {
		return $this->where($where)->order($order)->paginate(20, FALSE, ['query' => Request::instance()->param()]);
	}

	public function getAllByWhere($where, $order) {
		return $this->where($where)->order($order)->select();
	}

	public function cancel($id) {
		$find = $this->where('id', $id)->find();
		if ($find['status'] != 0) {
			return ['code' => 0, 'data' => '', 'msg' => '撤销失败：订单状态错误'];
		}
		Db::startTrans();
		try {
			$rs1 = balanceChange(FALSE, $find['merchant_id'], $find['num'], 0, -$find['num'], 0, BAL_CANCEL, $id, '提币订单取消');
			$rs2 = $this->where('id', $id)->update(['status' => 3]);
			if ($rs1 && $rs2) {
				// 提交事务
				Db::commit();
				return ['code' => 1, 'data' => '', 'msg' => '撤销成功'];
			} else {
				// 回滚事务
				Db::rollback();
				return ['code' => 0, 'data' => '', 'msg' => '撤销失败'];
			}
		} catch (DbException $e) {
			// 回滚事务
			Db::rollback();
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}
}

?>