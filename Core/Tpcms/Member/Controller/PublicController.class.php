<?php
/**[权限验证]
 * @Author: 976123967@qq.com
 * @Date:   2015-05-11 14:19:01
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-05-11 15:55:36
 */
namespace Member\Controller;
use Common\Controller\CommonController;
class PublicController extends CommonController{

	public function _initialize()
	{
		parent::_initialize();
		$cms = $this->base();
		$this->assign('cms',$cms);
		if(!isset($_SESSION['uid'])|| !isset($_SESSION['username']))
		{
			$this->redirect('Member/Login/index');
		}
	}


}