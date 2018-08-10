<?php
/**[会员中心]
 * @Author: 976123967@qq.com
 * @Date:   2015-05-11 14:18:01
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-08-08 20:51:23
 */
namespace Member\Controller;
class UserController extends PublicController{
	

	public function index()
	{
		header('Content-Type: text/html; charset=UTF-8');
		p($_SESSION['uid']);
		p($_SESSION['username']);
		p($_SESSION['email']);
		die;
		$this->display();
	}

	public function password()
	{
		if(IS_POST)
		{
			$oldpassword = I('post.oldpassword');
			if(!$oldpassword)
			{
				$this->error('请输入原始密码');
			}
			$password = I('post.password');
			if(!$password)
			{
				$this->error('请输入新密码');
			}
			$passwords = I('post.passwords');
			if(!$passwords)
			{
				$this->error('请输入确认密码');
			}

			$db = D('User','Logic');
			$user = $db->where(array('uid'=>session('uid')))->find();
			// p($user);
			// p(md5($oldpassword));die;
			if($user['password']!=md5($oldpassword))
			{
				$this->error('原始密码不对');
			}
			if($password!=$passwords)
			{
				$this->error('两次密码不一致');
			}
			$db->save(array('uid'=>session('uid'),'password'=>md5($password)));
			$this->success('密码修改成功',U('index'));
		}
		else
		{
			$this->display();
		}
	}


	public function email()
	{
		if(IS_POST)
		{
			$email = I('post.email');
			if(!$email)
				$this->error('请输入邮箱');
			$where['email']  = $email;
			$where['uid']  = array('neq',session('uid'));
			$status = D('User','Logic')->where($where)->getField('uid');
			if($status)
				$this->error('邮箱已经存在');
			D('User','Logic')->save(array('uid'=>session('uid'),'email'=>$email));
			session('email',$email);
			$this->success('邮箱修改成功',U('index'));
		}
		else
		{
			$this->display();
		}
	}

	public function ajax_email()
	{
		$email = I('get.email');
		$where['email']  = $email;
		$where['uid']  = array('neq',session('uid'));
		$status = D('User','Logic')->where($where)->getField('uid');
		if($status)
			echo "false";
		else
			echo "true";
		die;
	}
}