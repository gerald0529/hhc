<?php
/**
 * @Author: cl
 * @Date:   2015-08-09 18:10:17
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-11 00:18:54
 */
namespace Addons\Thirdlogin\Controller;
use Admin\Controller\AddonsController;
class ThirdloginController extends AddonsController{

	public function _initialize()
	{
		parent::_initialize();
		//实例化模型
		$this->model = D('Addons://Thirdlogin/Thirdlogin');
	}

	public function edit()
	{
		if(IS_AJAX)
		{
			if(!$this->model->create())
				$this->error($this->model->getError());
			$id = I('post.id');
			$this->model->save();
			$this->write_config($id);
			
			$this->success('编辑成功',U('Addons/index',array('name'=>'Thirdlogin')));
		}
	}


	public function write_config($id)
	{

		
		$data = $this->model->find($id);
	
		$json ='';
		$save = array();
		switch ($data['remark'])
		{
			case 'qq':
				$save['appid']=$data['partnerid'];
				$save['appkey']=$data['secret'];
				$url = addons_url('Thirdlogin://Qq/qq_callback');
				$url = str_replace('Admin', 'Home', $url);
				$save['callback']= urlencode($url);
				$save['scope']='get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,check_page_fans,add_t,add_pic_t,del_t,get_repost_list,get_info,get_other_info,get_fanslist,get_idolist,add_idol,del_idol,get_tenpay_addr';
				$save['errorReport']=true;
				$save['storageType']='file';
				$save['host']='localhost';
				$save['user']='root';
				$save['password']='root';
				$save['database']='test';
				$json = json_encode($save);
				$json = urldecode($json);
				$content  = "<?php die('forbidden'); ?>\n".$json;
				file_put_contents('Core/Addons/Thirdlogin/Platform/qq/comm/inc.php', $content);
				
				break;
			case 'sina':
				
				$save['WB_AKEY']=$data['partnerid'];
				$save['WB_SKEY']=$data['secret'];
				$url = addons_url('Thirdlogin://Sina/sina_callback');
				$url = str_replace('Admin', 'Home', $url);
				$save['WB_CALLBACK_URL']= $url;

				$content =  <<<str
<?php
define('WB_AKEY','{$save['WB_AKEY']}');
define('WB_SKEY','{$save['WB_SKEY']}');
define('WB_CALLBACK_URL','{$save['WB_CALLBACK_URL']}');
str;
				file_put_contents('Core/Addons/Thirdlogin/Platform/sina/config.php', $content);
				break;

		}
		
	}
}