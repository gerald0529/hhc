<?php
/**后台公用控制器
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-14 22:02:49
 * @Last Modified by:   cl
 * @Last Modified time: 2015-10-11 20:53:09
 */
namespace Admin\Controller;
use Common\Controller\ExtendController;
use Think\Auth;
class PublicController extends  ExtendController{


		public $model;
		public function _initialize()
		{


			//验证是否登录
			if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']))
				$this->redirect('Admin/Login/index');
				
			// 验证是否锁定
			$user = D("User")->where(array('username'=>$_SESSION['user_name']))->find();
			if($user['is_lock'])
			{
				$this->redirect("Login/out");
			}



			// 验证权限
			// 满足条件
			// 1 不是超级管理员
			// 2 是必须验证的方法
			// 3 是必须验证的控制器
			if(!in_array(session('user_id'), C('auth_superadmin')) && in_array(ACTION_NAME,C('auth_action')) && in_array(CONTROLLER_NAME,C('auth_controller')))
			{
				// 权限验证
				$auth = new Auth();

				// 处理会员和管理员规则
				if(CONTROLLER_NAME=='User' && I('role')==1)
					$controller = 'manager';
				else
					$controller = CONTROLLER_NAME;

				// 执行验证
				if(!$auth->check(strtolower(MODULE_NAME . '-' . $controller . '-' . ACTION_NAME),session('user_id')))
				{

					// 提示
					$this->assign('message','您没有相关权限');
					$this->display('./Data/Public/notice/auth.html');
					die;
				}

			}
			

			define('CONTROLLER_ACTION',strtolower(CONTROLLER_NAME.'_'.ACTION_NAME));
			// 实例化模型
			$controllerName = CONTROLLER_NAME;
		
			$notAuth = in_array($controllerName,C('NOT_D_CONTROLLER'));

			if(!$notAuth)
				$this->model = D($controllerName);
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

			if(CONTROLLER_NAME=='ModelField')
				$this->success('添加成功',U('index',array('mid'=>I('post.mid'))));
			elseif(CONTROLLER_NAME=='User')
				$this->success('添加成功',U('index',array('role'=>I('post.role'))));
			elseif(CONTROLLER_NAME=='Attr')
				$this->success('添加成功',U('index',array('typeid'=>I('post.typeid'))));
			elseif(CONTROLLER_NAME=='Ad')
				$this->success('添加成功',U('index',array('verifystate'=>I('post.verifystate'),'position_psid'=>I('post.position_psid'))));
			else
				$this->success('添加成功',U('index'));
		
		}
		else
		{
			$this->display();
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
			if(CONTROLLER_NAME=='ModelField')
				$this->success('编辑成功',U('index',array('mid'=>I('post.mid'))));
			elseif(CONTROLLER_NAME=='User')
				$this->success('编辑成功',U('index',array('role'=>I('post.role'))));
			elseif(CONTROLLER_NAME=='Attr')
				$this->success('编辑成功',U('index',array('typeid'=>I('post.typeid'))));
			elseif(CONTROLLER_NAME=='Ad')
				$this->success('编辑成功',U('index',array('verifystate'=>I('post.verifystate'),'position_psid'=>I('post.position_psid'))));
			else
				$this->success('编辑成功',U('index'));
		}
		else
		{
			$pk = $this->model->getPk();
			$id  = I('get.'.$pk);
			$data = $this->model->get_one($id);
			if(!$data)
				$this->error('信息不存在');
			$this->assign('data',$data);
			$this->display();
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
		$status = $this->model->del($id);
		
		if(!$status)
			$this->error($this->model->getError(),U('index'));
		if(CONTROLLER_NAME=='ModelField')
			$this->success('删除成功',U('index',array('mid'=>I('get.mid'))));
		elseif(CONTROLLER_NAME=='Article')
			$this->success('删除成功',U('index',array('category_cid'=>I('get.category_cid'),'verifystate'=>I('get.verifystate'))));
		elseif(CONTROLLER_NAME=='User')
			$this->success('删除成功',U('index',array('role'=>I('get.role'))));
		elseif(CONTROLLER_NAME=='Goods')
			$this->success('删除成功',U('index',array('goodscate_cid'=>I('get.goodscate_cid'),'verifystate'=>I('get.verifystate'))));
		elseif(CONTROLLER_NAME=='Attr')
				$this->success('删除成功',U('index',array('typeid'=>I('get.typeid'))));
		elseif(CONTROLLER_NAME=='Ad')
				$this->success('删除成功',U('index',array('verifystate'=>I('get.verifystate'),'position_psid'=>I('get.position_psid'))));
		elseif(CONTROLLER_NAME=='UserComment')
				$this->success('删除成功',U('index',array('verifystate'=>I('get.verifystate'))));
		else
			$this->success('删除成功',U('index'));
	 }
	/**
	 * [beachdelete 更新缓存]
	 * @return [type] [description]
	 */
	public function update_cache()
	{
	
		$this->model->update_cache();
		if(CONTROLLER_NAME=='ModelField')
			$this->success('缓存更新成功',U('index',array('mid'=>I('get.mid'))));
		elseif(CONTROLLER_NAME=='Attr')
				$this->success('缓存更新成功',U('index',array('typeid'=>I('get.typeid'))));
		else
			$this->success('缓存更新成功',U('index'));
	}


	public function  sort()
	{
		$pk = $this->model->getPk();
		
		$sort = I('post.sort');
		$this->model->update_sort($sort);
		if(CONTROLLER_NAME=='ModelField')
			$this->success('排序成功',U('index',array('mid'=>I('post.mid'))));
		elseif(CONTROLLER_NAME=='Attr')
			$this->success('排序成功',U('index',array('typeid'=>I('post.typeid'))));
		else
			$this->success('排序成功',U('index'));

	}



	public function index()
	{
		// 设置查询条件
		$this->map = $this->_search();
		$this->_list();
		$this->display();
	}


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
			$map[] = 'addtime >= '.strtotime($startTime);
		$endTime = I('get.end_time');
		if($endTime)
			$map[] = 'addtime <= '.(strtotime($endTime) + 3600*24);


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
		$count = $this->model->where($this->map)->count();
	
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
			$data = $this->model->where($this->map)->order($order.' '.$sort)->page($currentPage.','.$listRows)->select();
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
	
}