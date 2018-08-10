<?php
/**字段管理
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-15 21:58:48
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-26 23:39:44
 */
namespace Admin\Controller;
class ModelFieldController extends PublicController{
	private $mid;
	public function _initialize()
	{
		parent::_initialize();
		$this->mid = I('mid');
		$model = S('model');
		$this->assign('model',$model[$this->mid]);
	}
	
	/**
	 * [index 模型字段列表]
	 * @return [type] [description]
	 */
	public function index()
	{
		$data = $this->model->get_all($this->mid);
		$this->assign('data',$data);
		$this->display();
	}


	/**
	 * [sort 排序]
	 * @return [type] [description]
	 */
	public function sort()
	{
		$fids  = I('post.fid');
		$sort = I('post.sort');
		if(!$fids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$db  = M('ModelField');
		foreach($fids as  $k=>$v)
		{
			$db->save(array('fid'=>$v,'sort'=>$sort[$k]));

		}

		$this->model->update_cache();
		$this->ajaxReturn(array('status'=>1,'info'=>'排序成功'));
	}

	/**
	 * [batch_delete 删除]
	 * @return [type] [description]
	 */
	public function batch_delete()
	{
		$fid  = I('post.fid');
		if(!$fid)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$this->model->del(implode(',', $fid));
		$this->ajaxReturn(array('status'=>1,'info'=>'删除成功'));
	}
}	