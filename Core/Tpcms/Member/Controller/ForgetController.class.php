<?php
/**[找回密码]
 * @Author: 976123967@qq.com
 * @Date:   2015-05-11 13:50:54
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-05-11 17:02:40
 */
namespace Member\Controller;
use Common\Controller\CommonController;
class ForgetController extends CommonController{
	public function index()
	{


		if(IS_POST)
		{
			$db = D('User','Logic');
			$email = I('post.email');
			$where['email'] = $email;
			$user = $db->where($where)->find();
			if(!$user)
				$this->error('邮箱不存在');
			$rand = $user['uid'].mt_rand(100000,999999);
			$db->where(array('email'=>$email))->save(array('rand'=>md5($rand)));
			$link = U('Member/Forget/reset',array('rand'=>$rand),'',true);
			$cfgName = C('cfg_name');
			$time = date('Y-m-d');
			$body = <<<str
			<p>您好:</p>
			<p>{$user['username']}申请找回密码，点击下面的链接继续找回,不是本人操作请忽略。</p>
			<p><a href="{$link}">继续找回</a>或者点击复制到地址栏，链接：{$link}</p>
			<p>{$cfgName}</p>
			<p>{$time}</p>

str;
			postmail($email,'找回密码-'.$cfgName,$body);
			$this->success('请登录邮箱继续找回密码',U('Member/Login/index'));
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


	public function reset()
	{
		$db = D('User','Logic');
		if(IS_POST)
		{
			$rand = I('post.rand');
			$user = $db->where(array('rand'=>md5(I('get.rand'))))->find();
			if(!$user)
				$this->error('链接错误');
			$password = I('post.password');
			$passwords = I('post.passwords');
			if(!$password)
				$this->error('链接错误');
			if($passwords!=$password)
				$this->error('两次密码不一致');

			$db->save(array('uid'=>$user['uid'],'password'=>md5($password),'rand'=>''));
			$this->success('密码修改成功',U('Member/Login/index'));
		}
		else
		{
			
			$user = $db->where(array('rand'=>md5(I('get.rand'))))->find();
			if(!$user)
				$this->error('链接错误',U('Member/Login/index'));
			$this->assign('user',$user);
			$this->display();
		}
	}


	

}