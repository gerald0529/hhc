<?php
/**[注册]
 * @Author: 976123967@qq.com
 * @Date:   2015-05-11 12:02:40
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-05-11 15:44:14
 */
namespace Member\Controller;
use Common\Controller\CommonController;
class RegController extends CommonController{



	public function index()
	{
		if(IS_POST)
		{
			$db = D('User','Logic');
			if(!$db->create())
			{
				$this->error($db->getError());
			}
			$uid = $db->add();
			session('uid',$uid);
			session('username',I('post.username'));
			session('email',I('post.email'));
			$this->success('注册成功',U('Member/User/index'));
		}
		else
		{
			if(isset($_SESSION['uid']) && isset($_SESSION['username']))
			{
				$this->redirect('Member/User/index');
			}
			$cms = $this->base();
			$this->assign('cms',$cms);
			$this->display();
		}
	}


	public function ajax_username()
	{
		$username = I('get.username');
		$status = D('User','Logic')->check_username($username);
		if(!$status)
			echo "false";
		else
			echo "true";
		die;
	}
	public function ajax_email()
	{
		$email = I('get.email');

		$status = D('User','Logic')->check_email($email);
		if(!$status)
			echo "false";
		else
			echo "true";
		die;
	}

}