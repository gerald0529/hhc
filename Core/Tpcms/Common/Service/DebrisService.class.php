<?php
/** [广告]
 * @Author: 976123967@qq.com
 * @Date:   2015-04-20 21:45:10
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-27 14:30:36
 */
namespace Common\Service;
use Think\Model;
class DebrisService extends Model{
	
	/**
	 * [get_airlines 显示客服 airlines标签]
	 * [lang en ch 语言版本 默认中文]
	 */
	public function get_one($id)
	{

		// 排序
		$where['id'] = $id;
		$data = D('Debris')->where($where)->find();
		return $data;

	}
}