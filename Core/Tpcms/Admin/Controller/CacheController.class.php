<?php
/**缓存控制器
 * @Author: cl
 * @Date:   2015-07-24 22:47:17
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-09-18 16:44:10
 */

namespace Admin\Controller;
use Third\Dir;
class CacheController extends PublicController{


	/**
	 * [cache 更新缓存]
	 * @return [type] [description]
	 */
	public function cache()
	{
		if(IS_POST)
		{
			$action = I('post.action');
			S('action',$action);
			$this->success('准备更新...',U('Cache/update'));
			die;
		}
		$this->display();
	}

	/**
	 * [update 执行缓存更新]
	 * @return [type] [description]
	 */
	public function update()
	{
		$action = S('action');
		
	

		if($action)
		{
			$current = array_shift($action);
			$this->assign('waitSecond',1);
			S('action',$action);
			switch ($current) 
			{
				case 'Config':
					D('Config')->write_config();
					$this->success('网站配置更新成功...',U('Cache/update'));
					break;
				case 'Category':
					D('Category')->update_cache();
					$this->success('栏目缓存更新成功...',U('Cache/update'));
					break;
				case 'Table':

					// 自定义模型缓存更新
					D('Model')->update_cache();
					// 自定义模型字段缓存更新
					D("ModelField")->update_cache();
					// 文档类型缓存更新
					D('Type')->update_cache();
					// 文档属性缓存更新
					D('Attr')->update_cache();
					// 广告位置缓存更新
					D('Position')->update_cache();
					// 规则缓存更新
					D("AuthRule")->update_cache();
					// 会员登记缓存更新
					D('UserGrade')->update_cache();
					// 地区更新
					//D('Region')->update_cache();

					// 载入目录处理类
				
					is_file('./Data/Runtime/common~runtime.php') && 
					unlink('./Data/Runtime/common~runtime.php');
					// 删除目录
					Dir::del('./Data/Runtime/Cache');
					Dir::del('./Data/Runtime/Data');
					Dir::del('./Data/Runtime/Logs');
					// 创建目录
					$dir= array(
						'./Data/Runtime/Cache',
						'./Data/Runtime/Data',
						'./Data/Runtime/Logs',
						);
					foreach($dir as $v)
					{
						is_dir($v) || mkdir($v,0777,true);
					}
	

					$this->success('数据表缓存更新成功...',U('Cache/update'));
					break;
			}
		}
		else
		{
			$this->success('缓存更新成功...',U('Cache/cache'));
		}
		

	}
}