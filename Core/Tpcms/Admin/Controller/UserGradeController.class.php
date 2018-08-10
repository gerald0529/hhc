<?php
/*会员等级
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 09:24:23
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-23 09:25:43
 */
namespace Admin\Controller;
class UserGradeController extends PublicController{

	public function index()
	{
		$data = $this->model->get_all();
		$this->assign('data',$data);
		$this->display();
	}
}