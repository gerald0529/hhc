<?php
/** [文档模型]
 * @Author: 976123967@qq.com
 * @Date:   2015-04-17 16:41:51
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-10-12 16:11:25
 */
namespace Common\Service;
use Think\Model;
use Think\Page;
class ArticleService extends Model{


	/**
	 * [get_flag 推荐]
	 * @param  [type] $cid   [description]
	 * @param  [type] $flag  [description]
	 * @param  [type] $row   [description]
	 * @param  [type] $order [description]
	 * @return [type]        [description]
	 */
	public function get_flag($cid,$flag,$row,$order)
	{

		$where['verifystate'] = 2;
		$no = true;
		if(strchr($cid,','))
		{
			$no=false;
		}
		$cid = explode(',', $cid);
		$cids = array();

		foreach($cid as $c)
		{
			$temp =D('Category')->get_child_cid($c);
			$cids = array_merge($cids,$temp);
		}
	
		
		$where['category_cid'] = array('in',$cids);
		$where['addtime'] = array('lt',time());
		$cfgFlag = C('flag');
		if($flag)
			$where[] = "find_in_set('".$cfgFlag[$flag]."',flag)";
		$order = $order?$order:'sort asc,addtime desc,aid desc';
		$field = 'article_title,category_cid,pic,file,addtime,aid,keywords,description,article_title_en,jump_url,file_url';
		// 读取主表数据
		$data = $this->where($where)->order($order)->field($field)->limit($row)->select();

		

		$cur = 	 D('Category')->get_one($cid[0]);
		$model = D('Model')->get_one($cur['model_mid']);
		$table = 'article_'.$model['name'];
		// 列表中要显示的字段
		$modelFields = D('ModelField')->get_all($model['mid']);
		$extfield = array();
		foreach($modelFields as $v)
		{
			if($v['show_lists'])
				$extfield[]=$v['fname'];
		}
		$extfield = implode(',', $extfield);
	

		$db = M($table);
		if(!$data)
			return false;
		// 重组数据

		$categoryService = D('Category','Service');
		foreach($data as $k=>$v)
		{
			$cur = $categoryService->get_one($v['category_cid']);
	    	$catUrl = $categoryService->get_url($cur);
	    	$data[$k]['cat_url'] = $catUrl;
	    	$data[$k]['cat_name'] = $cur['cname'];

			$data[$k]['time'] = $v['addtime'];
			$data[$k]['addtime'] = date('Y-m-d',$v['addtime']);
			$remark = strtolower($categoryService->where(array('cid'=>$v['category_cid']))->getField('remark'));
			$data[$k]['url'] = build_article_url(array(
			 	'aid'=>$v['aid'],
			 	'category_cid'=>$v['category_cid'],
			 	'jump_url'=>$v['jump_url'],
			 	'file_url'=>$v['file_url'],
			 	'remark'=>$remark

			 	));
			// 图片
			$data[$k]['pic'] = $v['pic']?__ROOT__.'/'.$v['pic']:__ROOT__.'/Data/Public/404/images/default.gif';
			// 合并数据
			if($field&&$no)
			{
				$ext = $db->field($extfield)->where(array('article_aid'=>$v['aid']))->find();

				$data[$k] = array_merge($data[$k],$ext);
			}
		}

		return $data;
	}


	/**
	 * [get_list 列表数据]
	 * @param  [type] $order [description]
	 * @param  [type] $lang  [description]
	 * @return [type]        [description]
	 */
	public function get_list($order,$lang)
	{
		$keywords = I('get.keywords');
		if($keywords)
		{
			$where[] = 'article.article_title like "%'.$keywords.'%" or article.keywords like "%'.$keywords.'%" or article.description like "%'.$keywords.'%"';
		}


		$cid = I('get.cid');
		$where['verifystate'] = 2;
		$where['addtime'] = array('lt',time());
		$order = $order?$order:'sort asc,addtime desc,aid desc';
		$db = D('ArticleView',"Logic");
		$categoryService = D('Category','Service');
		$pageCount = 20;
		
		$extfield = $modelFields = array();
		if($cid)
		{
			
			$cids = D('Category')->get_child_cid($cid);
			$where['category_cid'] = array('in',$cids);
			$cur = $categoryService->get_one($cid);
			$model = D('Model')->get_one($cur['model_mid']);
			$table = 'article_'.$model['name'];
			// 附表中要显示在列表中字段
			$modelFields = D('ModelField')->get_all($model['mid']);

			
			foreach($modelFields as $v)
			{
				if($v['show_lists'])
					$extfield[]=$v['fname'];
			}

			if(!empty($extfield))
			{
				$db->viewFields[$table] =  $extfield;
				$extfield = implode(',', $extfield);
			}
			// 视图模型添加附表关系
			$db->viewFields[$table]['_on'] = 'article.aid='.$table.'.article_aid';
		
		    $pageCount = $cur['page'];
		}
	
		
		
		
	    // 读取数据
	    $count = $db->where($where)->count();
	 
	    if(!$count)
	    	return false;
	    $page = new Page($count,$pageCount);
	    // 组合要显示的字段
	    $field='article_title,category_cid,pic,file,addtime,aid,keywords,description,cname,article_title_en,came_en,jump_url,file_url';
	    $field =$extfield?$extfield.','.$field:$field;
	    $data = $db->where($where)->field($field)->limit($page->firstRow.','.$page->listRows)->order($order)->select();

	    $uploadModel = D('Upload');
	    // 重组数据
	    foreach($data as $k=>$v)
	    {
	    	$cur = $categoryService->get_one($v['category_cid']);
	    	$catUrl = $categoryService->get_url($cur);
	    	$data[$k]['cat_url'] = $catUrl;
	    	$data[$k]['cat_name'] = $cur['cname'];
	    	$data[$k]['time'] = $v['addtime'];
			$data[$k]['addtime'] = date('Y-m-d',$v['addtime']);
			$remark = strtolower($cur['remark']);
			// 图片地址
			$data[$k]['pic'] = $v['pic']?__ROOT__.'/'.$v['pic']:__ROOT__.'/Data/Public/404/images/default.gif';
			$data[$k]['url'] = build_article_url(array(
			 	'aid'=>$v['aid'],
			 	'category_cid'=>$v['category_cid'],
			 	'jump_url'=>$v['jump_url'],
			 	'file_url'=>$v['file_url'],
			 	'remark'=>$remark
			));

			// 下载资料
			$file = is_file($v['file'])?pathinfo($v['file']):'';
			$data[$k]['file'] = '' ;
			if($file)
			{
				$tempid = $uploadModel->where(array('name'=>$file['basename']))->getField('id');
				$data[$k]['file'] = U('down',array('id'=>$tempid));
			}

			if($cid && $extfield && $modelFields)
			{

				foreach($modelFields as $value)
				{

					if($value['show_type']==8 && strchr($extfield,$value['fname']))
					{

						$file = is_file($v[$value['fname']])?pathinfo($v[$value['fname']]):'';
						$data[$k][$value['fname']] = '' ;
						if($file)
						{
							$tempid = $uploadModel->where(array('name'=>$file['basename']))->getField('id');
							$data[$k][$value['fname']] = U('down',array('id'=>$tempid));
						}

					}	
				}
			}
			
			
	    }
	    // 页脚信息
	    if($lang == 'en')
	    {
	    	$page->setConfig('header',' record ');
			$page->setConfig('prev',' prev ');
			$page->setConfig('next',' next ');
			$page->setConfig('first',' first ');
			$page->setConfig('last',' last ');
			$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	    }
	 	$data['page'] = $page->show();
	 	return $data;
	}


	/**
	 * [get_view 详细页]
	 * @param  [type] $aid [description]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_view($aid,$cid)
	{

		if(!$aid)
			$aid = $this->where(array('category_cid'=>$cid))->getField('aid');

		$categoryService = D('Category','Service');
		$cur = $categoryService->get_one($cid);
		

		$model = D('Model')->get_one($cur['model_mid']);
		$table = 'article_'.$model['name'];
		$db = D('ArticleView','Logic');
	    $db->viewFields[$table] = array(
	        '*',
	        '_on'=>'article.aid='.$table.'.article_aid',
	    );

	    $where['addtime'] = array('lt',time());
	    $where['aid'] = $aid;
	    $data =$db->where($where)->find();
    //print_r($data);exit;
	    if(empty($data)){
	    	E('页面不存在');exit;
	    }

	    $cur = $categoryService->get_one($data['category_cid']);
	    $catUrl = $categoryService->get_url($cur);
	   
	    $data['cat_url'] = $catUrl[0];

	    $data['time'] = $data['addtime'];
	    $data['addtime'] = date('Y-m-d',$data['addtime']);
	    $pics = D('ArticlePic','Service')->get_all($data['aid']); 
	    $data['pics'] = $pics['pics']; 
	    $data['pic'] = $data['pic']?__ROOT__.'/'.$data['pic']:__ROOT__.'/Data/Public/images/default.gif';

	    $data['cat_url'] =  $categoryService->get_url($cur);
	    
	    return $data;
	}


	public function next($flag,$lang)
	{
		$aid =  I('get.aid',null,'intval');
		$cid = I('get.cid',null,'intval');

		$where = 'aid<'.$aid.' and category_cid='.$cid;
		$order ='aid desc';
		$field = 'remark,cid,aid,article_title,category_cid,article_title_en';
		
		// 下一条
		$fieldNext = D('ArticleView','Logic')->where($where)->order($order)->field($field)->find();
		if($fieldNext)
		{
			// 控制器
			$remark = strtolower($fieldNext['remark']);
			// 当前URL地址
			$url  =U('/'.$remark.'_v_'.$fieldNext['category_cid'].'_'.$fieldNext['aid']);
			
			if($lang=='en')
			{
				$next = "<a href='".$url."'>{$fieldNext['article_title_en']}</a>";
			
			}
			else
			{

				$next = "<a href='".$url."'>{$fieldNext['article_title']}</a>";
				
			}
		}	
		else
		{
			if($lang=='cn')
				$next = '没有了';
			else
				$next = 'none';
		}

		
		// 上一条
		$where = 'aid>'.$aid.' and category_cid='.$cid;
		$order ='aid asc';
		$fieldPre = D('ArticleView','Logic')->where($where)->order($order)->field($field)->find();
		if($fieldPre)
		{
			// 控制器
			$remark = strtolower($fieldPre['remark']);
			// 当前URL地址
			$url  = U('/'.$remark.'_v_'.$fieldPre['category_cid'].'_'.$fieldPre['aid']);
			
			if($lang=='en')
			{

				$pre  = "<a href='".$url."'>{$fieldPre['article_title_en']}</a>";
			
			}
			else
			{

				$pre  = "<a href='".$url."'>{$fieldPre['article_title']}</a>";
					
			}
		}
		else
			if($lang=='cn')
				$pre = '没有了';
			else
				$pre = 'none';

		switch ($flag) 
		{
			// 上一条和下一条
			case 1:
				return $pre.$next;
			
			// 上一条
			case 2:
				return $pre;
			
			//下一条
			case 3:
				return $next;
				
				
			
		}


	}
}