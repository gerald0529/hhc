<?php
/**规则表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 14:53:59
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-27 00:05:27
 */
namespace Common\Model;
use Think\Model;
use Third\Data;
class AuthRuleModel extends Model{
	private $cache;
	public function _initialize()
	{	
		$this->cache = S('authrule');
	}

	public function get_all($isArray=0)
	{
		if($isArray)
			return Data::channelLevel($this->cache,0,'','id','pid');
		else
			return Data::tree($this->cache,'title','id','pid');
	}

	/**
	 * [update_cache 更新缓存]
	 * @return [type] [description]
	 */
	public function update_cache()
	{
		$data = $this->order(array('sort'=>'asc','id'=>'asc'))->select();
		$temp = array();
		if($data) 
		{
			foreach($data as $k=>$v)
			{
				$temp[$v['id']] = $v;
			}
		}
		S('authrule',$temp);
	}

	
	// 自动验证
	protected $_validate = array(
		array('name','require','请输入规则标识',1),
		array('name','check_name','规则标识已经存在',1,'callback'),
		array('title','require','请输入规则名称',1),
		array('title','check_title','规则名称已经存在',1,'callback'),
	);

	/**
	 * [check_name 验证规则标识是否存在]
	 * @param  [type] $con [description]
	 * @return [type]      [description]
	 */
	protected function check_name($con)
	{
		$id  = I('post.id');
		if($id)
			$where['id'] = array('neq',$id);
		$condition  = I('post.condition');
	
		$condition  = I('post.condition');
		$where['condition'] = $condition;
		$where['name'] = $con;
		$data = $this->where($where)->find();
		if($data)
			return false;
		return true;
	}

	/**
	 * [check_title 验证规则名称是否存在]
	 * @param  [type] $con [description]
	 * @return [type]      [description]
	 */
	protected function check_title($con)
	{
		$id  = I('post.id');
		if($id)
			$where['id'] = array('neq',$id);
		$where['title'] = $con;
		$data = $this->where($where)->find();
		if($data)
			return false;
		return true;
	}

	// 自动完成
	public $_auto = array(

		array('level','_level',3,'callback'),
	);

	/**
	 * [_level 级别自动完成]
	 * @return [type] [description]
	 */
	protected function _level()
	{
		$pid = I('post.pid');
		if($pid==0)
			return 1;
		else
		{
			$data = $this->where(array('id'=>$pid))->find();
			return $data['level']+1;
		}
	}

	/**
	 * [get_one 查找一条记录]
	 * @return [type] [description]
	 */
	public function get_one($id)
	{
		return isset($this->cache[$id])?$this->cache[$id]:null;
	}

	
	/**
	 * [del 删除规则]
	 * @return [type] [description]
	 */
	public function del($id)
	{
		if($this->where(array('pid'=>$id))->count())
		{
			$this->error='请先删除子规则';
			return false;
		}
		$this->delete($id);
		$this->update_cache();
		return true;
	}
	/**
	 * [update_sort 更新排序]
	 * @param  [type] $cid   [description]
	 * @param  [type] $sort [description]
	 * @return [type]       [description]
	 */
	public function update_sort($ids,$sort)
	{

		foreach($ids as $k=>$v)
		{
			$this->save(array('sort'=>$sort[$k],'id'=>$v));
		}
		$this->update_cache();
		return true;
	}


	/**
	 * [_after_insert 添加后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_insert($data,$options)
	{
		// 更新缓存
		$this->update_cache();
	}
	
	/**
	 * [_after_update 更新后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_update($data,$options)
	{
		// 更新缓存
		$this->update_cache();
	}
}