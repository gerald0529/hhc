<?php
/**栏目控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-16 11:17:11
 * @Last Modified by:   happy
 * @Last Modified time: 2015-07-16 23:05:40
 */
namespace Admin\Controller;
class CategoryController extends PublicController{

	public function _initialize()
	{
		parent::_initialize();

		$this->assign('model',D('Model')->get_all());
		$this->assign('type',D('Type')->get_all());
		$this->assign('category',$this->model->get_all());
		
		if(ACTION_NAME=='add')
		{
			$parent = $this->model->get_one(I('get.pid'));
			$this->assign('parent',$parent);
		}
		if(ACTION_NAME=='edit')
		{
			$cate = $this->model->get_one(I('get.cid'));
			$pid  = $cate['pid'];
			if($pid)
			{

				$parent = $this->model->get_one($pid);
				$topCname = $parent['cname'];
			}
			else
			{
				$topCname = '顶级栏目';
			}

			$this->assign('topCname',$topCname);
		}

	}

	/**
	 * [index 所有栏目]
	 * @return [type] [description]
	 */
	public function index()
	{
		$this->display();
	}
	
	public function get_data()
	{
		$parent = $this->model->get_one(I('get.id'));
		$this->ajaxReturn(array('status'=>1,'info'=>$parent));
	}


}
