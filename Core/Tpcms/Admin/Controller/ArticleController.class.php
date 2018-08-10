<?php
/**文档管理控制器
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-16 23:06:56
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-09-19 09:21:00
 */

namespace Admin\Controller;
class ArticleController extends PublicController{

	public $cid;
	public $categoryModel;
	public $cat;
	public function _initialize()
	{
		parent::_initialize();
		$this->cid = I('category_cid'); //有get访问和post
		$this->categoryModel = D('Category');

		// 当前栏目
		$this->cat = $this->categoryModel->get_one($this->cid);
		$this->assign('cat',$this->cat);
		// 当前栏目的顶级
		$topCat = $this->categoryModel->get_top($this->cid);
		$this->assign('topCat',$topCat);



	}

	public function category()
	{
		// 栏目树
		$category = $this->categoryModel->article_ztree();
		$this->json = json_encode($category);

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

		// 当前分类 包过自己在内的所有子栏目的cid
		$childCids = $this->categoryModel->get_child_cid($this->cid);
		$map['category_cid'] = array('in',$childCids);


		$startTime = I('get.start_time');
		$controllerName = strtolower(CONTROLLER_NAME);
		if($startTime)
			$map[] = $controllerName.'.addtime >= '.strtotime($startTime);
		$endTime = I('get.end_time');
		if($endTime)
			$map[] = $controllerName.'.addtime <= '.(strtotime($endTime) + 3600*24);
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
		$order = I('post._order','sort');


		// 排序方式 默认为降序排列
		$sort  = I('post._sort','asc');
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
			$worder[$this->model->getPk()]= 'desc';

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
	 * [add 添加]
	 */
	public function add()
	{
		if(IS_POST)
		{
			if(!$this->model->create())
				$this->error($this->model->getError());
			$this->model->add();
			$url = U('index',array('category_cid'=>$this->cid,'verifystate'=>I('post.verifystate')));
			if($this->cat['cat_type'] == 4)
				$url = U('Index/copyright');
			$this->success('文档添加成功',$url);
		}
		else
		{

			if($this->cat['cat_type'] == 4)
			{
				$aid = $this->model->where(array('category_cid'=>$this->cid))->getField('aid');
				if($aid)
					$this->redirect('Article/edit',array('category_cid'=>$this->cid,'aid'=>$aid));
			}
			
			// 当前栏目顶级栏目的所有子分类
			$topChild    = $this->categoryModel->get_top_child($this->cid);
			$this->assign('topChild',$topChild);

			//扩展表表单
			$extForm = D("ModelField")->get_field_form($this->cat['model_mid']);
			$this->assign('extForm',$extForm);


			// 读取栏目的文档类型表单
			$attrModel = D('Attr');
			$typeid = $this->cat['type_typeid'];
			$attrForm = $attrModel->get_attr_form($typeid);
			$this->assign('attrForm',$attrForm);
			$_SESSION['keditor'] = array();

			// 表单验证
			$validate = D("ModelField")->get_validate();
			$this->assign('validate',$validate);
			$this->display();
		}

	}

	/**
	 * [edit 编辑]
	 * @return [type] [description]
	 */
	public function edit()
	{
		if(IS_POST)
		{
			if(!$this->model->create())
				$this->error($this->model->getError());
			$this->model->save();
			$url = U('index',array('category_cid'=>$this->cid,'verifystate'=>I('post.verifystate')));
			if($this->cat['cat_type'] == 4)
				$url = U('Index/copyright');
			$this->success('文档编辑成功',$url);
		}
		else
		{

			$aid = I('get.aid');	
			$data = $this->model->get_one($aid,$this->cid);
			$this->assign('data',$data);

			// 当前栏目顶级栏目的所有子分类
			$topChild    = $this->categoryModel->get_top_child($this->cid);
			$this->assign('topChild',$topChild);

			//扩展表表单
			$extForm = D("ModelField")->get_field_form($this->cat['model_mid'],$data);
			$this->assign('extForm',$extForm);


			// 读取栏目的文档类型表单
			$attrModel = D('Attr');
			$typeid = $this->cat['type_typeid'];
			$attrForm = $attrModel->get_attr_form($typeid,$aid);
			$this->assign('attrForm',$attrForm);

			// 图集
			$pics = D('ArticlePic')->get_all($aid);
			$this->assign('pics',$pics);

			$_SESSION['keditor'] = array();

			// 表单验证
			$validate = D("ModelField")->get_validate();
			$this->assign('validate',$validate);

			$this->display();
		}
	}

	/**
	 * [sort 排序]
	 * @return [type] [description]
	 */
	public function sort()
	{
		$ids  = I('post.ids');
		$sort = I('post.sort');
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$db = M('article');
		foreach($ids as  $k=>$v)
		{
			$db->save(array('aid'=>$v,'sort'=>$sort[$k]));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'排序成功'));
	}


	/**
	 * [check 审核]
	 * @return [type] [description]
	 */
	public function check()
	{
		$ids  = I('post.ids');
		
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$db = M('article');
		foreach($ids as  $k=>$v)
		{
			$db->save(array('aid'=>$v,'verifystate'=>2));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'审核成功'));
	}


	/**
	 * [cancel_check 取消审核]
	 * @return [type] [description]
	 */
	public function cancel_check()
	{
		$ids  = I('post.ids');
		
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$db = M('article');
		foreach($ids as  $k=>$v)
		{
			$db->save(array('aid'=>$v,'verifystate'=>1));
		}
		$this->ajaxReturn(array('status'=>1,'info'=>'取消审核成功'));
	}


	/**
	 * [batch_delete 删除]
	 * @return [type] [description]
	 */
	public function batch_delete()
	{
		$ids  = I('post.ids');
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$this->model->del(implode(',', $ids));
		$this->ajaxReturn(array('status'=>1,'info'=>'删除成功'));
	}

	public function operation()
	{
		$action  = I('post.action');
		$ids  = I('post.ids');
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$this->model->update_flag($ids,1);
		$this->ajaxReturn(array('status'=>1,'info'=>'处理成功'));
		
	}

	public function cancel_operation()
	{
		$action  = I('post.action');
		$ids  = I('post.ids');
		if(!$ids)
			$this->ajaxReturn(array('status'=>0,'info'=>'没有选择任何记录'));
		$this->model->update_flag($ids,0);
		$this->ajaxReturn(array('status'=>1,'info'=>'处理成功'));
	}
	
	
}