<?php
/**[登录]
 * @Author: 976123967@qq.com
 * @Date:   2015-05-11 13:50:54
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-08-08 18:03:04
 */
namespace Member\Controller;
use Common\Controller\CommonController;
class LoginController extends CommonController{
	public function index()
	{


		if(IS_POST)
		{
			$db = D('User','Logic');
			$username = I('post.username');
			$password = I('post.password');
			$where['username'] = $username;
			$user = $db->where($where)->find();
			if(!$user)
				$this->error('用户名或密码错误');
			if($user['password']!=md5($password))
				$this->error('用户名或密码错误');
			session('uid',$user['uid']);
			session('username',$user['username']);
			session('email',$user['email']);
			$db->save(array('uid'=>$user['uid'],'login_times'=>$user['logign_times']+1,'login_ip'=>get_client_ip()));
			
			$auto = I('post.auto');
			if($auto)
				setcookie(session_name(),session_id(),time()+60*60*24*14,'/');
			else
				setcookie(session_name(),session_id(),0,'/');
			$this->success('登录成功',U('Member/User/index'));
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



	public function out()
	{
		session('uid',null);
		session('username',null);
		session('email',null);
		$this->redirect('Member/Login/index');
	}

}