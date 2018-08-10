<?php
/**用户组权限表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 15:43:19
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-23 16:03:41
 */
namespace Common\Model;
use Think\Model;
class AuthGroupAccessModel extends Model{
	protected $tableName ='auth_group_access';


	public function alter_auth_group_access($uid)
	{
		$this->where(array('uid'=>$uid))->delete();
		$groupId = I('post.group_id');
		if(!$groupId)
			return ;
		foreach($groupId as $v)
		{
			$data[] =array(
				'group_id'=>$v,
				'uid'=>$uid,
			);
		}
		$this->addAll($data);
	}


	/**
	 * [delete_auth_group_access 删除]
	 * @return [type] [description]
	 */
	public function delete_auth_group_access()
	{
		$where['uid'] = I('get.uid');
		$this->where($where)->delete();
	}
}