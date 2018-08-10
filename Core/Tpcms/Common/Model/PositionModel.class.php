<?php
/**广告分类表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-22 16:20:38
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-22 17:01:55
 */
namespace Common\Model;
use Think\Model;
class PositionModel extends Model{


	private $cache;
	public function _initialize()
	{
		$this->cache = S('position');
	}
	// 自动验证
	/* array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
	*
	*  验证条件
	*  Model::EXISTS_VALIDATE 或者0 存在字段就验证 （默认）
	*  Model::MUST_VALIDATE 或者1 必须验证
	*  Model::VALUE_VALIDATE或者2 值不为空的时候验证
	*
	*  验证时间
	*  Model:: MODEL_INSERT 或者1新增数据时候验证
	*  Model:: MODEL_UPDATE 或者2编辑数据时候验证
	*  Model:: MODEL_BOTH 或者3 全部情况下验证（默认）
	* */

	protected $_validate = array(
	   	array('position_name','require','广告位置名称不能为空',1),
	   	array('width','number','位置宽度只能填写数字',2,'',3),
        array('height','number','点位置高度只能填写数字',2,'',3),
	);

	public function get_all()
	{
		return $this->cache;
	}

	/**
	 * [update_cache 更新缓存]
	 * @return [type] [description]
	 */
	public function update_cache()
	{
		$data = $this->order('psid asc')->select();
		$temp = array();
		foreach($data as $k=>$v)
		{
			$temp[$v['psid']] = $v;
		}
		S('position',$temp);
	}

	/**
	 * [get_one 读取一条记录]
	 * @param  [type] $psid [description]
	 * @return [type]       [description]
	 */
	public function get_one($psid)
	{
		return isset($this->cache[$psid])?$this->cache[$psid]:null;
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


	public function del($psid)
	{
		$data = D('Ad')->where(array('position_psid'=>$psid))->getField('aid');

		if($data)
		{
			$this->error= '广告位置正在使用中';
			return false;
		}
		$this->delete($psid);
		$this->update_cache();

		return true;
	}
}