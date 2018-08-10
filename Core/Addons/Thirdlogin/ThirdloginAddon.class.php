<?php
/**
 * @Author: cl
 * @Date:   2015-08-09 18:12:28
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-11 00:18:32
 */
namespace Addons\Thirdlogin;
use Common\Controller\Addon;
class ThirdloginAddon extends Addon{


	public $info = array(
		'name'        => 'Thirdlogin',
		'title'       => '第三方登录',
		'description' => '使用QQ、微博账号登录（注：上线使用）',
		'author'      => '快乐源泉',
		'version'     => '1.0'
	);


	public $admin_list = array(
		'fields'=>'id,name,description,verifystate',
		'model'=>'Thirdlogin',
		'order'=>'id desc',
		
	);


	// 后台编辑模板
	public $custom_adminlist = 'admin/index.html';
	public $custom_adminedit = 'admin/edit.html';


	public function __construct()
	{
		parent::__construct();
		$qq = '<br /> 腾讯QQ回调地址：'.addons_url("Thirdlogin://Qq/qq_callback");
		$qq = str_replace('Admin', 'Home', $qq);

		$sina = '<br /> 新浪微博回调地址：'.addons_url("Thirdlogin://Sina/sina_callback");
		$sina = str_replace('Admin', 'Home', $sina);

		$this->info['content']='回调地址：'.$qq.$sina;
	}


	//实现的thirdlogin钩子方法
    public function thirdlogin($param)
    {
   	  
        $data =  D('Addons://Thirdlogin/Thirdlogin')->where(array('verifystate'=>2))->select();
		$html = '';
		
		if($data && !isset($_SESSION['uid']))
		{

			$path = __ROOT__.'/Core/Addons/Thirdlogin/Platform';
			foreach($data as $k=>$v)
			{
				$remark = ucfirst($v['remark']);
				$html .= "<a href='".addons_url('Thirdlogin://'.$remark.'/index')."'><img src='$path/$v[remark]/$v[remark].png'></a> &nbsp;";
			}
		}
       echo $html;
    }

}