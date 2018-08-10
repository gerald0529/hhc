<?php
/**
 * 后台首页
 */
namespace Admin\Controller;
class IndexController extends PublicController 
{
    public function index()
    {
    
       
		//判断$info奇偶，奇数需要增加两列
		if(count($info)%2 != 0)
		{
			$this->assign('infonum',1); //1表示奇数，需要补全表格
		}
		$menu = array(

			'3admin'=>array(
				'icon'=>'',
				'id'=>'3admin',
				'name'=>'内容',
				'parent'=>'',
				'url'=>'',
				'items'=>array(
					'30admin'=>array(
						"id"=>"30admin"
						,"name"=>"内容信息管理"
						,"parent"=>"3admin"
						,"url"=>""
						,'items'=>array(
							array(
								'icon'=>'',
								'id'=>'301',
								'name'=>'管理内容',
								'parent'=>'30',
								'url'=>U('Article/welcome'),
							),
							array(
								'icon'=>'',
								'id'=>'302',
								'name'=>'附件管理',
								'parent'=>'30',
								'url'=>U('Upload/index'),
							),
							array(
								'icon'=>'',
								'id'=>'303',
								'name'=>'栏目列表',
								'parent'=>'30',
								'url'=>U('Category/index'),
							),
							array(
								'icon'=>'',
								'id'=>'304',
								'name'=>'栏目类型',
								'parent'=>'30',
								'url'=>U('Type/index'),
							),
								
							array(
								'icon'=>'',
								'id'=>'305',
								'name'=>'留言管理',
								'parent'=>'30',
								'url'=>U('Feedback/index'),
							),
							
						),
					),
					
					

					
					'32admin'=>array(
						"id"=>"32admin"
						,"name"=>"广告信息管理"
						,"parent"=>"3admin"
						,"url"=>""
						,'items'=>array(
							array(
								'icon'=>'',
								'id'=>'321',
								'name'=>'广告列表',
								'parent'=>'32',
								'url'=>U('Ad/index',array('verifystate'=>2)),
							),
							array(
								'icon'=>'',
								'id'=>'322',
								'name'=>'广告位置',
								'parent'=>'32',
								'url'=>U('Position/index'),
							),
							
							
						),
					),

					'49admin'=>array(
						"id"=>"49admin"
						,"name"=>"服务管理"
						,"parent"=>"3admin"
						,"url"=>""
						,'items'=>array(
							array(
								'icon'=>'',
								'id'=>'1321',
								'name'=>'碎片数据',
								'parent'=>'49',
								'url'=>U('Debris/index'),
							),
							array(
								'icon'=>'',
								'id'=>'1322',
								'name'=>'客服管理',
								'parent'=>'49',
								'url'=>U('Airlines/index'),
							),
							
							
						),
					),

					'33admin'=>array(
						"id"=>"33admin"
						,"name"=>"会员信息管理"
						,"parent"=>"3admin"
						,"url"=>''
						,'items'=>array(
							array(
								"id"=>"331"
								,"name"=>"等级管理"
								,"parent"=>"33"
								,"url"=>U('UserGrade/index')
								,'items'=>''
							),
							array(
								"id"=>"332"
								,"name"=>"会员管理"
								,"parent"=>"33"
								,"url"=>U('User/index',array('role'=>2))
								,'items'=>''
							),
							array(
								'icon'=>'',
								'id'=>'333',
								'name'=>'评论管理',
								'parent'=>'33',
								'url'=>U('UserComment/index',array('verifystate'=>1)),
							),
						)
					),


					'31admin'=>array(
						"id"=>"31admin"
						,"name"=>"内容相关设置"
						,"parent"=>"3admin"
						,"url"=>""
						,'items'=>array(
							
							
						
							array(
								'icon'=>'',
								'id'=>'313',
								'name'=>'推荐属性',
								'parent'=>'31',
								'url'=>U('Flag/index'),
							),
							array(
								'icon'=>'',
								'id'=>'314',
								'name'=>'模型管理',
								'parent'=>'31',
								'url'=>U('Model/index'),
							),
							
						),
					),

					
					

				),
			),
			


			
			'2admin'=>array(
				'icon'=>'',
				'id'=>'2admin',
				'name'=>'设置',
				'parent'=>'',
				'url'=>'',
				'items'=>array(
					'20admin'=>array(
						"id"=>"20admin"
						,"name"=>"系统设置"
						,"parent"=>"2admin"
						,"url"=>""
						,'items'=>array(
							array(
								'icon'=>'',
								'id'=>'201',
								'name'=>'站点配置',
								'parent'=>'20',
								'url'=>U('Config/index'),
							),
							array(
								'icon'=>'',
								'id'=>'202',
								'name'=>'数据库备份',
								'parent'=>'20',
								'url'=>U('Backup/index'),
							),
						),
					),
					'21admin'=>array(
						"id"=>"21admin"
						,"name"=>"管理员设置"
						,"parent"=>'2admin'
						,"url"=>""
						,'items'=>array(
							array(
								'icon'=>'',
								'id'=>'210',
								'name'=>'管理员管理',
								'parent'=>'21',
								'url'=>U('User/index',array('role'=>1)),
							),
							array(
								'icon'=>'',
								'id'=>'211',
								'name'=>'角色管理',
								'parent'=>'21',
								'url'=>U('AuthGroup/index'),
							),
							array(
								'icon'=>'',
								'id'=>'212',
								'name'=>'规则管理',
								'parent'=>'21',
								'url'=>U('AuthRule/index'),
							),
						),
					),

				),
			),
	
			
		
			


			'4admin'=>array(
				'icon'=>'',
				'id'=>'4admin',
				'name'=>'界面',
				'parent'=>'',
				'url'=>'',
				'items'=>array(
					'40admin'=>array(
						"id"=>"40admin"
						,"name"=>"模板管理"
						,"parent"=>"4admin"
						,"url"=>""
						,'items'=>array(
							array(
								'icon'=>'',
								'id'=>'401',
								'name'=>'模板风格',
								'parent'=>'40',
								'url'=>U('Templates/index'),
							),
							array(
								'icon'=>'',
								'id'=>'402',
								'name'=>'插件列表',
								'parent'=>'40',
								'url'=>U('Addons/lists'),
							),
							
						),
					),


					'41admin'=>array(
						"id"=>"41admin"
						,"name"=>"已安装插件"
						,"parent"=>"4admin"
						,"url"=>""
						,'items'=>array(
							
						),
					),
					
					

				),
			),
			

			'1admin'=>array(
				'icon'=>'',
				'id'=>'1admin',
				'name'=>'我的面板',
				'parent'=>'',
				'url'=>'',
				'items'=>array(
					'10admin'=>array(
						"id"=>"10admin"
						,"name"=>"个人信息"
						,"parent"=>"1admin"
						,"url"=>""
						,'items'=>array(
							array(
								'icon'=>'',
								'id'=>'11',
								'name'=>'修改个人信息',
								'parent'=>'10',
								'url'=>U('User/info'),
							),
							array(
								'icon'=>'',
								'id'=>'12',
								'name'=>'修改密码',
								'parent'=>'10',
								'url'=>U('User/change'),
							),

						),
						
				
					),


				),

			),

		);

		$addon = D('Addons')->select();
		$plugin = array();
		if($addon)
		{
			foreach($addon as $v)
			{
				$remark = ucfirst($v['remark']);
				$plugin[] = array(
							'icon'=>'',
							'id'=>'41'.$v['id'],
							'name'=>$v['name'],
							'parent'=>'41admin',
							'url'=>U('Addons/index',array('name'=>$v['remark'])),
						);
							
				
			}
		}
		if(!empty($plugin))
			$menu['4admin']['items']['41admin']['items'] = $plugin;
		else
			unset($menu['4admin']['items']['41admin']);
		$menu = json_encode($menu);
		$this->assign('menu',$menu);


		$auth = new \Think\Auth();
		$groups = $auth->getGroups(session('user_id'));
		$group ='';
		if(session('user_id')==1)
		{
			$group='超级管理员';
		}
		elseif($groups)
		{
			foreach($groups as $v)
			{
				$group .= $v['title'].'|';
			}
		}
		else
		{
			$group='未知分组';
		}
		$group = rtrim($group,'|');

		$this->assign('group',$group);

		


		$this->display();
    }


    /**
	 * [get_mysql_version 数据库版本]
	 * @return [type] [description]
	 */
	public function get_mysql_version()
	{
		$user = M();
		$mysqlinfo=mysql_get_server_info();
		return $mysqlinfo;
	}
	
	/**
	 * [get_os 获取操作系统]
	 * @return [type] [description]
	 */
	public function get_os()
	{
		$agent = $_SERVER['HTTP_USER_AGENT']; //获取操作系统、浏览器等信息
		$os = ''; //返回操作系统
		
		if(eregi('win', $agent) && eregi('nt 6.3', $agent))
		{
			$os = 'Windows 8.1';
		}
		elseif(eregi('win', $agent) && eregi('nt 6.2', $agent))
		{
			$os = 'Windows 8';
		}
		else if(eregi('win', $agent) && eregi('nt 6.1', $agent))
		{
			$os = 'Windows 7';
		}
		else if(eregi('win', $agent) && eregi('nt 6.0', $agent))
		{
			$os = 'Windows Vista';
		}
		else if(eregi('win', $agent) && eregi('nt 5.2', $agent))
		{
			$os = "Windows 2003"; //eregi字符串比对
		}
		else if(eregi('win', $agent) && eregi('nt 5.1', $agent))
		{
			$os = 'Windows XP';
		}
		else if(eregi('win', $agent) && eregi('nt 5', $agent))
		{
			$os = 'Windows 2000';
		}
		else if(eregi('win', $agent) && eregi('nt', $agent))
		{
			$os = 'Windows NT';
		}
		else if(eregi('linux', $agent))
		{
			$os = 'Linux';
		}
		else if(eregi('unix', $agent))
		{
			$os = 'Unix';
		}
		else if(eregi('sun', $agent) && eregi('os', $agent))
		{
			$os = 'SunOS';
		}
		else if(eregi('ibm', $agent) && eregi('os', $agent))
		{
			$os = 'IBM OS/2';
		}
		else if(eregi('Mac', $agent) && eregi('Macintosh', $agent))
		{
			$os = 'Macintosh';
		}
		else if(eregi('PowerPC', $agent))
		{
			$os = 'PowerPC';
		}
		else if(eregi('AIX', $agent))
		{
			$os = 'AIX';
		}
		else if(eregi('HPUX', $agent))
		{
			$os = 'HPUX';
		}
		else if(eregi('NetBSD', $agent))
		{
			$os = 'NetBSD';
		}
		else if(eregi('BSD', $agent))
		{
			$os = 'BSD';
		}
		else if(ereg('OSF1', $agent))
		{
			$os = 'OSF1';
		}
		else if(ereg('IRIX', $agent))
		{
			$os = 'IRIX';
		}
		else if(eregi('FreeBSD', $agent))
		{
			$os = 'FreeBSD';
		}
		else if(eregi('teleport', $agent))
		{
			$os = 'teleport';
		}
		else if(eregi('flashget', $agent))
		{
			$os = 'flashget';
		}
		else if(eregi('webzip', $agent))
		{
			$os = 'webzip';
		}
		else if(eregi('offline', $agent))
		{
			$os = 'offline';
		}
		else
		{
			$os = 'Unknown';
		}
		return $os;
	}
	public function copyright()
	{
		$info = array(
			'系统版本'=> C('CMS_VERSION'),
			'操作系统' => $this->get_os(),
			'运行环境' => $_SERVER['SERVER_SOFTWARE'],
			'PHP版本' => PHP_VERSION,
			'PHP运行方式' => php_sapi_name(),
			'数据库' => C('DB_TYPE').' '.$this->get_mysql_version(),
			'ThinkPHP版本' => THINK_VERSION,
			'最大上传附件' => ini_get('upload_max_filesize'),
		);
		// dump($info);
		$this->assign('info',$info);
		$this->display();
	}
}