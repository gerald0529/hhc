<?php
/**栏目类型表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-16 11:21:52
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-27 16:17:58
 */
namespace Common\Model;
use Think\Model;
class TypeModel extends Model{
	public function _initialize()
	{
		$this->cache = S('type');
	}
	protected $_validate = array(
		array('typename','require','请输入类型名称',1)
	);
	public function get_all()
	{
		return $this->cache;
	}
	public function update_cache()
	{
		$data = $this->order(array('typeid'=>'desc'))->select();
		$temp = array();
		if($data)
		{
			foreach($data as $k=>$v)
			{
				$temp[$v['typeid']] = $v;
			}
		}
		
		S('type',$temp);
	}
	
	public function del($typeid)
	{
		$status = M('attr')->where(array('type_typeid'=>$typeid))->find();
		if($status)
		{
			$this->error='请先删除属于类型属性';
			return false;
		}
		$this->delete($typeid);

		return true;
	}




	public function get_one($typeid)
	{
		return isset($this->cache[$typeid])?$this->cache[$typeid]:null;
	}
	public function _after_insert($data,$options)
	{
		$this->update_cache();
	}
	public function _after_update($data,$options)
	{
		$this->update_cache();
	}

	/**
	 * [_after_delete 删除后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_delete($data,$options)
	{
		// 更新缓存
		$this->update_cache();
	}


	

}