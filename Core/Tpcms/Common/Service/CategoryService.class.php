<?php
/** [栏目模型]
 * @Author: 976123967@qq.com
 * @Date:   2015-04-17 16:39:45
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-09-18 15:38:17
 */
namespace Common\Service;
use Think\Model;
use Third\Data;
class CategoryService extends Model{


	private $cache;

	public function _initialize()
	{
		$this->cache = S('category');
	}



	/**
	 * [get_page_title 网站标题]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_page_title($cid)
	{
		$result = array('page_title'=>'','page_title_en'=>'');
		if(!$cid)
			return $result;
		$parents = Data::parentChannel($this->cache,$cid);
		
		if($parents)
		{
			foreach($parents as $v)
			{
				$result['page_title'] .= $v['cname']." > ";
				$result['page_title_en'] .= $v['cname_en']." > ";
			}
			$result['page_title'] .=C('cfg_name');
			$result['page_title_en'] .=C('cfg_name_en');

		}

		return $result;
	}


	/**
	 * [get_page_bread 面包导航]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_page_bread($cid)
	{

		$result = array('page_title'=>'','page_title_en'=>'');
		if(!$cid)
			return $result;
		import('ORG.Util.Data');
		$parents = Data::parentChannel($this->cache,$cid);
		$parents = array_reverse($parents);
		$bread = '<a href="'.__ROOT__.'/">首页</a> &gt;';
		$breadEn = '<a href="'.__ROOT__.'/">Home</a> &gt;';
		if($parents)
		{
			$i = 0;
			foreach($parents as $v)
			{

				$remark =  strtolower($v['remark']);
				$url = $this->get_url($v);
				if($i+1 == count($parents))
				{
					$bread   .= '<span>'.$v['cname'].'</span> ';
					$breadEn .= '<span>'.$v['cname_en'].'</span>';
				}
				else
				{
					$bread .= '<a href='.$url.'>'.$v['cname'].'</a> &gt; ';
					$breadEn .= '<a href='.$url.'>'.$v['cname_en'].'</a> &gt; ';
				}
				$i++;
			}
		}
		return array('bread'=>$bread,'bread_en'=>$breadEn);
	}


	/**
	 * [get_nav 导航]
	 * @param  integer $pid [description]
	 * @return [type]       [description]
	 */
	public function get_nav($pid=0)
	{
		
		$nav = array();
		// 没有栏目
		if(!$this->cache) 
			return $nav;
		// 当前浏览的cid的所有父级cid
		$parentCids = array();
		$cid = I('get.cid',null,'intval');
		if(!$cid)
		{
			$search = I('get.s');
			$search = explode('-', $search);
			$cid = array_shift($search);
		}
		if($cid)
		{
			$parentCids = D('Category')->get_parent_cid($cid);
		}
		// 遍历栏目组合数组
	
		foreach($this->cache as $k=> $v)
		{
			$nav[$k] = $v;
			$url = $this->get_url($v);
			$nav[$k]['url']= $url;
		
			// 判断高亮
			if(in_array($v['cid'], $parentCids))
				$nav[$k]['cur'] = 1;
			else
				$nav[$k]['cur'] = 0;
		
		}
		return  Data::channelLevel($nav,$pid);
	}
	/**
	 * [get_url 栏目链接]
	 * @param  [type] $cat [description]
	 * @return [type]       [description]
	 */
	public function get_url($cat)
	{
		// 有设置跳转到子栏目 并且有子栏目
		$cat = $this->get_child_cat($cat);
	
		// 根据类型生成url
		$temp = array(
			'cat_type'=>$cat['cat_type'],
			'cid'=>$cat['cid'],
			'go_url'=>$cat['go_url'],
			'file_url'=>$cat['file_url']);

		
		$remark = strtolower($cat['remark']);
		switch ($temp['cat_type']) {
			case 1: //普通栏目
				if($temp['file_url'])
					$url  =  __APP__.'/'.$temp['file_url'];
				else
					$url  =  U('/'.$remark."_l_".$temp['cid']);
				
				break;
			case 2: //封面栏目
				$fileUrl = str_replace('.html', '', $temp['file_url']);
				if($temp['file_url'])
					$url  =  __APP__.'/'.$fileUrl.'/index.html';
				else
					$url =  U('/'.$remark."_c_".$temp['cid']);
			
				break;
			case 3: //跳转
				$url = $temp['go_url'];
				$murl= $temp['go_url'];
				break;
			case 4:
				$article = D('Article')->where(array('category_cid'=>$temp['cid']))->find();
				$url  =  build_article_url(array(
					'aid'=>$article['aid'],
					'category_cid'=>$temp['cid'],
					'remark'=>$remark,
					'file_url'=>$article['file_url'],
					'jump_url'=>$article['jump_url'],
				));
				
				break;	
		}

		/*switch ($temp['cat_type']) {
			case 1: //普通栏目
				unset($temp['cat_type']);
				unset($temp['go_url']);
				$url =  U('Home/'.$cat['remark'].'/lists',$temp);
				break;
			case 2: //封面栏目
				unset($temp['cat_type']);
				$url = U('Home/'.$cat['remark'].'/cover',$temp);
				break;
			case 3: //跳转
				$url = $temp['go_url'];
				break;
			case 4:
				unset($temp['cat_type']);
				unset($temp['go_url']);
				$url = U('Home/'.$cat['remark'].'/view',$temp);
				break;	
		}*/
		return $url;
	}


	private function get_child_cat($cat)
	{

		$child = D('Category')->get_child_list($cat['cid']);

		if(!$cat['go_child'] || !$child)
			return $cat;

		return $this->get_child_cat($child[0]);
	}





	/**
	 * [get_one 读取一个字段的信息]
	 * @return [type] [description]
	*/
	public function get_one($cid)
	{
		$data = isset($this->cache[$cid])?$this->cache[$cid]:'';
		if($data)
		{
			$url = $this->get_url($data);
			$data['url'] = $url;
		}

		return $data;
	}




}