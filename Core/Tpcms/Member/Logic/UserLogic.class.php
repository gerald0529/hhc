<?php
/**[会员模型]
 * @Author: 976123967@qq.com
 * @Date:   2015-05-11 13:03:42
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-05-11 14:17:18
 */
namespace Member\Logic;
use Think\Model;
class UserLogic extends Model{
	protected $_validate = array(
		array('username','require','请输入用户名',1),
		array('username','check_username','用户名已经注册！',1,'callback',1),
		array('email','require','请输入邮箱',1),
		array('email','email','邮箱格式不对',1),
		array('email','check_email','邮箱已经注册',1,'callback',1),
		array('password','require','请输入密码',1),
		array('passwords','require','请输入确认密码',1),
		array('passwords','password','两次密码不一致',1,'confirm'),
	);


	public function check_username($con)
	{
		$status = $this->where(array('username'=>$con))->getField('uid');
		if($status)
			return false;
		else
			return true;
	}
	public function check_email($con)
	{
		$status = $this->where(array('email'=>$con))->getField('uid');
		if($status)
			return false;
		else
			return true;
	}
	protected $_auto = array(
		array('addtime','time',1,'function'),
		array('role','2',1,'string'),
		array('times','1',1,'string'),
		array('login_time','time',1,'function'),
		array('login_ip','_ip',1,'callback'),
		array('password','md5',1,'function'),
	);
	public function _ip()
	{
		return  get_client_ip(); 
	}
}