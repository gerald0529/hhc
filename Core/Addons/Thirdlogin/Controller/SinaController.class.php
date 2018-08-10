<?php
/**新浪微博登录
 * @Author: cl
 * @Date:   2015-08-09 18:59:12
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-11 00:33:22
 */
namespace Addons\Thirdlogin\Controller;
use Home\Controller\AddonsController;
class SinaController extends AddonsController{

	public function _initialize()
	{
		load('Thirdlogin.Platform.sina.config',TPCMS_ADDON_PATH);
		import('Thirdlogin.Platform.sina.saetv2',TPCMS_ADDON_PATH);
	}

	public function index()
	{
		$o = new \SaeTOAuthV2( WB_AKEY , WB_SKEY );
		$codeUrl = $o->getAuthorizeURL( WB_CALLBACK_URL);
		
		header('Location:'.$codeUrl);
	}

	public function sina_callback()
	{

		$o = new \SaeTOAuthV2( WB_AKEY , WB_SKEY );

		if (isset($_REQUEST['code']))
		 {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			$token = $o->getAccessToken( 'code', $keys ) ;
		}
		if ($token) 
		{
			$_SESSION['token'] = $token;
			$openid = $token['uid'];

			$thirdModel = D('Third');
			$where['openid']=$openid;
			$where['type']='sina';
			$uid = $thirdModel->where($where)->getField('user_uid');
			$user = '';
			$userModel = D('User');
			if($uid)
				$user = D('User')->find($uid);
			
			if($uid && $user)// 用户存在
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
				
				// 获取用户信息
				$c = new \SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
				$uidGet = $c->get_uid();
				$uid  = $uidGet['uid'];
				$user = $c->show_user_by_id( $uid);

				$nickname =$user['screen_name'].mt_rand(0,9999);
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
					'openid'=>$openid,
					'type'=>'sina',
				));
				session('uid',$uid);
				session('username',$nickname);
				$_SESSION['email'] = '';
				$this->redirect('Member/User/index');
			}
	
		}
		else
		{
			die('failed');
		}

	}
}