<?php
/**属性管理
 * @Author: cl
 * @Date:   2015-07-22 21:27:07
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-22 21:48:35
 */
namespace Admin\Controller;
class FlagController extends PublicController{


	public function index()
	{
		if(IS_POST)
		{
			if(!$this->set_flag())
				$this->error("请检查Data文件夹的权限");
			$this->success('属性设置成功');
			die;
		}
		else
		{
			$data = C('flag');
			$this->assign('data',$data);
			$this->display();
		}

	}

	/**
	 * [set_flag 设置属性对应关系]
	 */
	public function set_flag()
	{
		$key = I('post.key');
		$data = array();
		foreach ($key as $k => $v)
		{
			$data['flag'][$v] = $k;
		}
		return file_put_contents('Data/Config/flag.inc.php', "<?php \nreturn ".var_export($data,true)."; \n?>");
	}
}