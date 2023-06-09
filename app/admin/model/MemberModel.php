<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class MemberModel extends Model {
	protected $name               = 'member';
	protected $autoWriteTimestamp = TRUE;   // 开启自动写入时间戳

	/**
	 * 根据搜索条件获取用户列表信息
	 */
	public function getMemberByWhere($map, $nowPage, $limits) {
		return $this->field('think_member.*,group_name')->join('think_member_group', 'think_member.group_id = think_member_group.id')->where($map)->page($nowPage, $limits)->order('id DESC')->select();
	}

	/**
	 * 根据搜索条件获取所有的用户数量
	 * @param $where
	 */
	public function getAllCount($map) {
		return $this->where($map)->count();
	}

	/**
	 * 插入信息
	 */
	public function insertMember($param) {
		try {
			$result = $this->validate('MemberValidate')->allowField(TRUE)->save($param);
			if (FALSE === $result) {
				return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
			}
			return ['code' => 1, 'data' => '', 'msg' => '添加成功'];
		} catch (PDOException $e) {
			return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
		}
	}

	/**
	 * 编辑信息
	 * @param $param
	 */
	public function editMember($param) {
		try {
			$result = $this->validate('MemberValidate')->allowField(TRUE)->save($param, ['id' => $param['id']]);
			if (FALSE === $result) {
				return ['code' => 0, 'data' => '', 'msg' => $this->getError()];
			}
			return ['code' => 1, 'data' => '', 'msg' => '编辑成功'];
		} catch (PDOException $e) {
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}

	/**
	 * 根据管理员id获取角色信息
	 * @param $id
	 */
	public function getOneMember($id) {
		return $this->where('id', $id)->find();
	}

	/**
	 * 删除管理员
	 * @param $id
	 */
	public function delUser($id) {
		try {
			$this->where('id', $id)->delete();
			Db::name('auth_group_access')->where('uid', $id)->delete();
			return ['code' => 1, 'data' => '', 'msg' => '删除成功'];
		} catch (PDOException $e) {
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}

	public function delMember($id) {
		try {
			$map['closed'] = 1;
			$this->save($map, ['id' => $id]);
			return ['code' => 1, 'data' => '', 'msg' => '删除成功'];
		} catch (PDOException $e) {
			return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
		}
	}
}