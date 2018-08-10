<?php
/**规则控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 14:51:24
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-26 22:04:21
 */
namespace Admin\Controller;
class AuthRuleController extends PublicController{
	public function _initialize()
	{
		parent::_initialize();
		$rules = $this->model->get_all();
		$this->assign('rules',$rules);
	}
	public function index()
	{
		$this->display();
	}

	/**
	 * [sort 排序]
	 * @return [type] [description]
	 */
	public function sort()
	{
		$sort = I('post.sort');
		
		foreach($sort as  $k=>$v)
		{
			$this->model->save(array('id'=>$k,'sort'=>$v));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'排序成功'));
	}
}