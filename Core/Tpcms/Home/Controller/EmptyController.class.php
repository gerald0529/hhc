<?php
/**空控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-27 11:09:47
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-27 11:19:44
 */
namespace Home\Controller;
use Common\Controller\CommonController;
class EmptyController extends CommonController{


	/**
	 * [_empty 空操作]
	 * @return [type] [description]
	 */
	public function _empty()
	{
		E('页面不存在');
	}
}