<?php
/**留言控制器
 * @Author: cl
 * @Date:   2015-07-22 21:55:57
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-22 22:29:05
 */
namespace Admin\Controller;
class FeedbackController extends PublicController{

	

	/**
	 * [check 设置已读]
	 * @return [type] [description]
	 */
	public function check()
	{
		$ids  = I('post.fd_id');
		
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		foreach($ids as  $k=>$v)
		{
			$this->model->save(array('fd_id'=>$v,'lookstate'=>2));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'设置已读成功'));
	}


	/**
	 * [cancel_check 设置未读]
	 * @return [type] [description]
	 */
	public function cancel_check()
	{
		$ids  = I('post.fd_id');
		
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		foreach($ids as  $k=>$v)
		{
			$this->model->save(array('fd_id'=>$v,'lookstate'=>2));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'设置未读成功'));
	}


	/**
	 * [batch_delete 删除]
	 * @return [type] [description]
	 */
	public function batch_delete()
	{
		$ids  = I('post.fd_id');
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$this->model->del(implode(',', $ids));
		$this->ajaxReturn(array('status'=>1,'info'=>'删除成功'));
	}
}