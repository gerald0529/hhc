<?php
/**友情链接管理
 * @Author: cl
 * @Date:   2015-08-09 11:23:17
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-10 23:02:43
 */
namespace Addons\Link\Controller;
use Admin\Controller\AddonsController;
class LinkController extends AddonsController{



	public function _initialize()
	{
		parent::_initialize();
		// 实例化模型
		$this->model = D('Addons://Link/Link');
	}

	/**
	 * [add 添加]
	 */
	public function add()
	{
		if(IS_AJAX)
		{
			if(!$this->model->create())
				$this->error($this->model->getError());
			$this->model->add();
	
			$this->success('添加成功',U('Admin/Addons/index',array('name'=>'Link','verifystate'=>I('post.verifystate'))));
		}
	}

	/**
	 * [edit 编辑]
	 * @return [type] [description]
	 */
	public function edit()
	{
		if(IS_AJAX)
		{
			if(!$this->model->create())
				$this->error($this->model->getError());

			
			$this->model->save();
		
			$this->success('编辑成功',U('Admin/Addons/index',array('name'=>'Link','verifystate'=>I('post.verifystate'))));
		}
	}

	/**
	 * [del 删除]
	 * @return [type] [description]
	 */
	public function del()
	 {
	 	$pk = $this->model->getPk();
		$id  = I('get.'.$pk);
		$status = $this->model->delete($id);

		$uploadModel = D('Upload');
		$upload = $uploadModel->where(array('type'=>'link','relation'=>$id))->select();

		if($upload)
		{
			foreach($upload as $v)
			{
				$fullpath  =$v['path'].'/'.$v['name'];
				is_file($fullpath) && unlink($fullpath);
				$uploadModel->delete($v['id']);
			}
		}
		$this->success('删除成功',U('index',array('name'=>'Link','verifystate'=>I('get.verifystate'))));
	 }



	  /**
	  * [sort 排序]
	  * @return [type] [description]
	  */
	 public function sort()
	 {
	 	$sort = I('post.sort');
	 	foreach($sort as $k=> $v)
	 	{
	 		$this->model->where(array('lid'=>$k))->save(array('sort'=>$v));
	 	}
	 	$this->ajaxReturn(array('status'=>1,'info'=>'排序成功'));
	 	
	 }


	 /**
	 * [check 审核]
	 * @return [type] [description]
	 */
	public function check()
	{
		$ids  = I('post.lid');
		
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		foreach($ids as  $k=>$v)
		{
			$this->model->save(array('lid'=>$v,'verifystate'=>2));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'审核成功'));
	}


	/**
	 * [cancel_check 取消审核]
	 * @return [type] [description]
	 */
	public function cancel_check()
	{
		$ids  = I('post.lid');
		
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		foreach($ids as  $k=>$v)
		{
			$this->model->save(array('lid'=>$v,'verifystate'=>1));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'取消审核成功'));
	}





   

	
}
