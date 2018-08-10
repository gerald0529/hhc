<?php
/**属性管理控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-16 11:56:27
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-16 13:50:22
 */
namespace Admin\Controller;
class AttrController extends PublicController{

	public function _initialize()
	{
		parent::_initialize();
		$type = D('Type')->get_all();
		$this->assign('type',$type);
		$typename = $type[I('get.typeid')]['typename'];
	
		$this->assign('typename',$typename);
	}

	public function index()
	{
		$typeid = I('get.typeid');
		$data = $this->model->get_all($typeid);
		$this->assign('data',$data);
		$this->display();
	}

}