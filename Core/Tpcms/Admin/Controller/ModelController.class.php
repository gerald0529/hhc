<?php
/**模型控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-15 15:26:05
 * @Last Modified by:   happy
 * @Last Modified time: 2015-07-15 21:05:16
 */
namespace Admin\Controller;
class ModelController extends PublicController{
	public function index()
	{
		$data = $this->model->get_all();
		$this->assign('data',$data);
		$this->display();
	}

}	
