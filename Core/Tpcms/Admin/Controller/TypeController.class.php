<?php
/**栏目类型控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-16 11:20:33
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-16 11:31:39
 */
namespace Admin\Controller;
class TypeController extends PublicController{
	public function index()
	{

		$data = $this->model->get_all();
		$this->assign('data',$data);
		$this->display();
	}

}