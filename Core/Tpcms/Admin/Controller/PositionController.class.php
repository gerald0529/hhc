<?php
/**广告位置控制器
 * @Author: cl
 * @Date:   2015-07-20 22:53:12
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-22 16:18:12
 */
namespace Admin\Controller;
class PositionController extends PublicController{
	public function index()
	{

		$this->assign('data',$this->model->get_all());
		$this->display();
	}
}