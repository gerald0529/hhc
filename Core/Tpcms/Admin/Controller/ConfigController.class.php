<?php
/**网站配置控制器
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-14 22:01:43
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-24 13:30:32
 */
namespace Admin\Controller;
class ConfigController extends PublicController{

	/**
	 * [index 配置列表]
	 * @return [type] [description]
	 */
	public function index()
	{
	
		$data = $this->model->get_all();
		$this->assign('data',$data);
		$this->display();
	}

	/**
	 * [edit 更新配置]
	 * @return [type] [description]
	 */
	public function edit()
	{
		if(IS_POST)
		{
			// 保存信息到数据库
			if(!$this->model->save_config()) 
				$this->error($this->logic->getError());
			// 提示
			$this->success('系统设置更新成功',U('Config/index'));
			
		}
	}

	/**
	 * [update_cache 更新缓存]
	 * @return [type] [description]
	 */
	public function update_cache()
	{
		if(!$this->model->write_config())
			$this->error("'配置文件写入失败，请检查Data文件目录权限");
		$this->success('缓存更新成功',U('Config/index'));
	}
}