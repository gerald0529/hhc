<?php
/**评论控制器
 * @Author: cl
 * @Date:   2015-07-22 22:33:18
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-23 13:49:26
 */
namespace Admin\Controller;
class UserCommentController extends PublicController{


	/**
	 * [_search 设置查询条件]
	 * @return [type] [description]
	 */
	public function _search()
	{

		$fields = $this->model->getDbFields();

		if($fields)
		{
			foreach($fields as $v)
			{
				if(I('get.'.$v))
					$map[$v] = I('get.'.$v);
			}
		}

		$keyword = I('get.keyword');
		$keytype = I('get.keytype');
		if($keyword && $keytype)
		{
			$map[$keytype] = array('like','%'.$keyword.'%'); 
		}

		
		

		$startTime = I('get.start_time');
		
		if($startTime)
			$map[] = 'user_comment.addtime >= '.strtotime($startTime);
		$endTime = I('get.end_time');
		if($endTime)
			$map[] = 'user_comment.addtime <= '.(strtotime($endTime) + 3600*24);
		$endTime = I('get.end_time');

		return $map;

	}

	/**
	 * [_list 列表]
	 * @return [type] [description]
	 */
	public function _list()
	{

		// 排序字段 默认为表的主键
		$order = I('post._order',$this->model->getPk());


		// 排序方式 默认为降序排列
		$sort  = I('post._sort','desc');
		// 统计
		$controllerName = strtolower(CONTROLLER_NAME);
		$dbLogic = D(CONTROLLER_NAME.'View','Logic');
		$count = $dbLogic->where($this->map)->count();
		if($count>0)
		{
			import('ORG.Util.Page');
			// 每页显示记录数
			$listRows = I('post.numPerPage',C('PAGE_LISTROWS'));
			// 实例化分页类 传入总记录数和每页显示的记录数
			$page = new \Think\Page($count,$listRows);
			// 当前页数
			$currentPage = I(C('VAR_PAGE'),1);
			// 进行分页数据查询
			$worder[$order]= $sort;
		

			$data = $dbLogic->where($this->map)->order($worder)->page($currentPage.','.$listRows)->select();
			
			// 分页显示输出
			$show = $page->show();

			//列表排序显示
			//排序图标
			$sortImg = $sort; 
			//排序提示
			$sortAlt = $sort == 'desc' ? '降序排列' : '升序排列'; 
			//排序方式
			$sort = $sort =='desc' ? 1 : 0;

			//模板赋值
			$this->assign('data',$data);
			$this->assign('sort',$sort);
			$this->assign('order',$order);
			$this->assign('sortImg',$sortImg);
			$this->assign('sortType',$sortAlt);
			$this->assign('page',$show);
			$this->assign('totalCount',$count);
			$this->assign('numPerPage',$listRows);
			$this->assign('currentPage',$currentPage);
		}
	}


	/**
	 * [check 审核]
	 * @return [type] [description]
	 */
	public function check()
	{
		$cmids  = I('post.cmids');
		
		if(!$cmids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		foreach($cmids as  $k=>$v)
		{
			$this->model->save(array('cmid'=>$v,'verifystate'=>2));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'审核成功'));
	}


	/**
	 * [cancel_check 取消审核]
	 * @return [type] [description]
	 */
	public function cancel_check()
	{
		$cmids  = I('post.cmids');
		
		if(!$cmids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		foreach($cmids as  $k=>$v)
		{
			$this->model->save(array('cmid'=>$v,'verifystate'=>1));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'取消审核成功'));
	}

	/**
	 * [batch_delete 删除]
	 * @return [type] [description]
	 */
	public function batch_delete()
	{
		$cmids  = I('post.cmids');
		if(!$cmids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$this->model->del(implode(',', $cmids));
		$this->ajaxReturn(array('status'=>1,'info'=>'删除成功'));
	}
}