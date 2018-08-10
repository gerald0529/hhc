<?php
/**角色管理
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 14:29:02
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-26 00:00:40
 */
namespace Admin\Controller;
class AuthGroupController extends PublicController{
	public function rule()
	{
		if(IS_POST)
		{
			if(!$this->model->alter_rule())
				$this->error($this->model->getError());
			$this->success('规则设置成功',U('index'));
			die;
		}
		$rule = D('AuthRule')->get_all(1);
		$this->assign('rule',$rule);

		$field  = $this->model->get_one(I('get.id'));
		$this->assign('field',$field);
		$this->display();
	}
}