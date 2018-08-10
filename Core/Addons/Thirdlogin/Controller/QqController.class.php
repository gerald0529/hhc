<?php
/**qq登录
 * @Author: cl
 * @Date:   2015-08-09 18:47:57
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-11 00:33:25
 */
namespace Addons\Thirdlogin\Controller;
use Home\Controller\AddonsController;
class QqController extends AddonsController{

	public function _initialize()
	{
		load('Thirdlogin.Platform.qq.qqConnectAPI',TPCMS_ADDON_PATH);
	}

	/**
	 * [index 使用qq登录]
	 * @return [type] [description]
	 */
	public function index()
	{
		$qc = new \QC();
		$qc->qq_login();
	}

	/**
	 * [qq_callback qq登录回调]
	 * @return [type] [description]
	 */
	public function qq_callback()
	{
		
		$qc = new \QC();
		$qc->qq_callback();
		$openid = $qc->get_openid();

		$thirdModel = D('Third');
		$where['openid']=$openid;
		$where['type']='qq';
		$uid = $thirdModel->where($where)->getField('user_uid');
		$user = '';
		$userModel = D('User');
		if($uid)
			$user = D('User')->find($uid);
		
		if($uid && $user) // 用户存在
		{
			session('uid',$user['uid']);
			session('username',$user['username']);
			$_SESSION['email'] = $user['email'];
			// 更新用户登录数据
			$userModel->save(array('uid'=>$user['uid'],'times'=>$user['times']+1,'login_ip'=>get_client_ip(),'login_time'=>time()));
		
			$this->redirect('Member/User/index');
		}
		else //用户不存在
		{
			// 因调用用户信息和调用用户的openid会冲突，所以跳转
			$_SESSION['openid']=$openid;
			$url = addons_url('Thirdlogin://Qq/add');
			redirect($url);
		}
		
	}

	/**
	 * [add 添加用户]
	 */
	public function add()
	{
		$userModel = D('User');
		$thirdModel = D('Third');
		// 获取用户信息
		$qc = new \QC();
		$user = $qc->get_user_info();
		$nickname = $user['nickname'].mt_rand(0,9999);
		$data = array(
			'username'=>$nickname,
			'password'=>'',
			'login_time'=>time(),
			'times'=>1,
			'login_ip'=>get_client_ip(),
			'role'=>2,
			'nickname'=>$nickname,
			'addtime'=>time(),

		);
		$uid = $userModel->add($data);
		$thirdModel->add(array(
			'user_uid'=>$uid,
			'openid'=>$_SESSION['openid'],
			'type'=>'qq',
		));
		session('uid',$uid);
		session('username',$nickname);
		$_SESSION['openid'] = null;
		$_SESSION['email'] = '';
		$this->redirect('Member/User/index');
	}
}