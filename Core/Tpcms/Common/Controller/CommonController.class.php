<?php
/**前台公用控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-27 11:08:37
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-09-18 15:20:48
 */
namespace Common\Controller;
class CommonController extends ExtendController{

	public $cid;
	public $aid;

	public function _initialize()
	{
		$this->cid = I('get.cid');
		$this->aid = I('get.aid');

		/***验证系统主题***/
		$theme = I('get.t',null);
		if($theme)
		{
			session('curTheme',$theme);
		}
		elseif(!isset($_SESSION['curTheme']))
		{
			session('curTheme',C('WEB_STYLE'));
		}
		C('DEFAULT_THEME',$_SESSION['curTheme']);	

		//p(C('URL_ROUTE_RULES'));

	}

	/**
	 * [index 默认访问方法]
	 * @return [type] [description]
	 */
	public function index()
	{
		$cms = $this->base();
		$this->assign('cms',$cms);
		$this->display();
	}


	/**
	 * [base 网站基本信息]
	 * @return [type] [description]
	 */
	public function base()
	{
		$cms['page_title'] = C('cfg_name');
		$cms['page_description'] = C('cfg_description');
		$cms['page_keywords'] = C('cfg_keywords');

		$cms['page_title_en'] = C('cfg_name_en');
		$cms['page_description_en'] = C('cfg_description_en');
		$cms['page_keywords_en'] = C('cfg_keywords_en');
		return $cms;
	}


	/**
	 * [cur 网站当前栏目和标题]
	 * @return [type] [description]
	 */
	public function cur()
	{
		$categoryService = D('Category','Service');
		$cur = $categoryService->get_one($this->cid);
		$title= $categoryService->get_page_title($this->cid);
		$top = D('Category')->get_top($this->cid);
		$cur['topCname'] = $top['cname'];
		$cur['topCname_en'] = $top['cname_en'];
		$cur['topPic'] = $top['pic'];
		$cur['topPic_en'] = $top['pic_en'];
		$cur['topCid'] = $top['cid'];
		$bread = $categoryService->get_page_bread($this->cid);
		$cur['bread'] = $bread['bread'];
		$cur['bread_en'] = $bread['bread_en'];
		return array_merge($cur,$title);
	}

	/**
	 * [cover 封面]
	 * @return [type] [description]
	 */
	public function cover()
	{
		$cur = $this->cur();
		$cms = $this->base();
		// 描述 关键词 标题
		$cms['page_description'] = $cur['description']? $cur['description']:$cms['page_description'];
		$cms['page_keywords'] = $cur['keywords']? $cur['keywords']:$cms['page_keywords'];
		$cms['page_title'] = $cur['page_title'];


		$cms['page_description_en'] = $cur['description_en']? $cur['description_en']:$cms['page_description_en'];
		$cms['page_keywords_en'] = $cur['keywords_en']? $cur['keywords_en']:$cms['page_keywords'];
		$cms['page_title_en'] = $cur['page_title_en'];

		$cms = array_merge($cur,$cms);
		$this->assign('cms',$cms);

		$this->display($cms['default_tpl']);
	}

	/**
	 * [lists 列表]
	 * @return [type] [description]
	 */
	public function lists()
	{
		$cur = $this->cur();
		$cms = $this->base();
		// 描述 关键词 标题
		$cms['page_description'] = $cur['description']? $cur['description']:$cms['page_description'];
		$cms['page_keywords'] = $cur['keywords']? $cur['keywords']:$cms['page_keywords'];
		$cms['page_title'] = $cur['page_title'];

		$cms['page_description_en'] = $cur['description_en']? $cur['description_en']:$cms['page_description_en'];
		$cms['page_keywords_en'] = $cur['keywords_en']? $cur['keywords_en']:$cms['page_keywords_en'];
		$cms['page_title'] = $cur['page_title'];
		$cms['page_title_en'] = $cur['page_title_en'];
		$cms = array_merge($cur,$cms);
		$cms = array_merge($cur,$cms);
		$this->assign('cms',$cms);


	

		$this->display($cms['list_tpl']);
	}


	/**
	 * [view 详细]
	 * @return [type] [description]
	 */
	public function view()
	{
 	
		$cur = $this->cur();
		$cms = $this->base();
		$article = D('Article','Service')->get_view($this->aid,$this->cid);

		// 描述 关键词 标题
		$cms['page_description'] = $cur['description']? $cur['description']:$cms['page_description'];
		$cms['page_keywords'] = $cur['keywords']? $cur['keywords']:$cms['page_keywords'];

		$cms['page_description_en'] = $cur['description_en']? $cur['description_en']:$cms['page_description_en'];
		$cms['page_keywords_en'] = $cur['keywords_en']? $cur['keywords_en']:$cms['page_keywords_en'];

		if($cur['cat_type']!=4)
		{
			$cms['page_title'] = $article['article_title']." > ".$cur['page_title'];
			$cms['page_title_en'] = $article['article_title_en']." > ".$cur['page_title_en'];
		}
		else
		{
			$cms['page_title'] = $cur['page_title'];
			$cms['page_title_en'] = $cur['page_title_en'];
		
		}




		$cms = array_merge($cur,$cms,$article);
		M('Article')->where(array('aid'=>$this->aid))->setInc('click',1);
		$this->assign('cms',$cms);
		$this->display($cms['view_tpl']);
	}

	/**
	 * [check_login 验证是否登录]
	 * @return [type] [description]
	 */
	public function check_login()
	{
		if(isset($_SESSION['uid']) && isset($_SESSION['username']))
			return true;
		else
			return false;
	}



	/**
	 * [msg 信息留言]
	 * @return [type] [description]
	 */
	public function msg()
	{
		if(IS_POST)
		{

			$db = D('Feedback');
			$verify = new \Think\Verify();
			// 验证码是否相等
			if(!$verify->check(I('post.code')))
			{
				$this->error(L('lang_code_failed'));
				return false;
			} 

			if(!$db->create())
				$this->error($db->getError());
			$db->add();
			$this->success(L('lang_msg_ok'));
		}
		
	}

	public function msg2()
	{
		if(IS_POST)
		{

			$db = D('Feedback');
			$verify = new \Think\Verify();
			// 验证码是否相等
			/*if(!$verify->check(I('post.code')))
			{
				$this->error(L('lang_code_failed'));
				return false;
			} 
*/
			if(!$db->create())
				$this->error($db->getError());
			$db->add();
			$this->success(L('lang_msg_ok'));
		}
		
	}


	/**
	 * [_empty 空操作]
	 * @return [type] [description]
	 */
	public function _empty()
	{
		E('页面不存在');
	}



}