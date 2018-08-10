<?php
/**用户角色表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 14:33:36
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-23 15:24:43
 */
namespace Common\Model;
use Think\Model;
class AuthGroupModel extends Model{
	protected $tableName ='auth_group';




	// 自动验证
	protected $_validate = array(
		array('title','require','请输入角色名称',1),
		array('title' ,'check_title','角色已经存在',1,'callback'),
	);
	/**
	 * [check_title 验证用户组重复]
	 * @param  [type] $con [description]
	 * @return [type]      [description]
	 */
	protected function check_title($con)
	{
		$id  = I('post.id');
		if($id)
			$where['id'] = array('neq',$id);
		$where['title'] = $con;
		$data = $this->where($where)->find();
		if($data)
			return false;
		return true;
	}

	/**
	 * [get_all 查找所有用户组]
	 * @return [type] [description]
	 */
	public function get_all()
	{
		return $this->order('id asc')->select();
	}


	/**
	 * [find_one 查找一条记录]
	 * @return [type] [description]
	 */
	public function get_one($id)
	{
		return $this->find($id);
	}

	/**
	 * [del 删除用户组]
	 * @return [type] [description]
	 */
	public function del($id)
	{
		$status = D('AuthGroupAccess')->where(array('group_id'=>$id))->getField('uid');
		if($status)
		{
			$this->error='会员组使用中';
			return false;
		}
		$this->delete($id);
		return ture;
	}

	/**
	 * [alter_rule 更新规则]
	 * @return [type] [description]
	 */
	public function alter_rule()
	{
		$rules = I('post.rules');
		$data['rules'] = implode(',', $rules);
		$data['id'] = I('post.id');

		$this->save($data);
		return true;
	}
}