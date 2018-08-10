<?php
/**会员等级表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 09:25:55
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-31 11:05:34
 */
namespace Common\Model;
use Think\Model;
class UserGradeModel extends Model{

	private $cache;




	public function _initialize()
	{
		$this->cache = S('grade');
	}



	// 自动验证
    // array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate=array(
    	//广告位置
    	array('gname','require','请选输入会员等级',1,'regex',3),  
		array('gname','check_gname','会员等级已经存在',1,'callback',3),  
    );


    /**
     * [check_gname 检查会员等级是否存在]
     * @param  [type] $con [description]
     * @return [type]      [description]
     */
    public function check_gname($con)
    {
    	$where['gname'] = $con;
    	$gid = I('post.gid');
 
    	if($gid)
    		$where['gid'] = array('neq',$gid);
    	if($this->where($where)->count())
    		return false;
    	else
    		return true;
    }


	/**
	 * [get_all 所有分组]
	 * @return [type] [description]
	 */
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
		$data = $this->order(array('gid'=>'asc'))->select();
		$temp = array();
		foreach($data as $k=>$v)
		{
			$temp[$v['gid']]=$v;
		}
		S('grade',$temp);
	}

	/**
	 * [get_one 读取一条记录]
	 * @param  [type] $gid [description]
	 * @return [type]      [description]
	 */
	public function get_one($gid)
	{
		return isset($this->cache[$gid])?$this->cache[$gid]:null;
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

	/**
	 * [del 删除]
	 * @param  [type] $gid [description]
	 * @return [type]      [description]
	 */
	public function del($gid)
	{
		$status = D('User')->where(array('grade_gid'=>$gid))->getField('uid');
		if($status)
		{
			$this->error='会员等级使用中';
			return false;
		}
		$this->delete($gid);
		$this->update_cache();
		return true;
	}
}