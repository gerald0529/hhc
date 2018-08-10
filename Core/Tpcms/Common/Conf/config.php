<?php
//数据库配置文件
$db  	= include 'Data/Config/db.inc.php';
$web 	= include 'Data/Config/config.inc.php';
$flag 	= include 'Data/Config/flag.inc.php';
$theme 	= include './Data/Config/theme.inc.php';

$configRule  = include './Data/Config/rule.inc.php';
$article 	 = include './Data/Config/article.inc.php';
$category 	 = include './Data/Config/category.inc.php';
$articleRule = array();

// 自定义文档文件名
if($article)
{
	foreach ($article as  $v) 
	{
		$articleRule[key($v)]=current($v) ;
	}
}
// 自定义栏目文件文件名
$categoryleRule = array();
if($category)
{
	foreach ($category as  $v) 
	{
		foreach ($v as  $key=>$value) 
		{
			$categoryleRule[$key]=$value ;
		}
	}
}
$rule['URL_ROUTE_RULES']  = array_merge($configRule,$articleRule,$categoryleRule);



// 主要配置项
$common  = array(
	//'配置项'=>'配置值'

	'AUTOLOAD_NAMESPACE' => array('Addons' => TPCMS_ADDON_PATH,'Third'=>THIRD), //扩展模块列表

	'MODULE_ALLOW_LIST'=>array('Admin','Home','Member'),
	'DEFAULT_MODULE'=>'Home',

	'TMPL_ACTION_ERROR' 	=> './Data/Public/notice/error.html',	//默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'	=> './Data/Public/notice/success.html',//默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'	=>'./Data/Public/notice/404.html',// 异常页面的模板文件

	'TMPL_STRIP_SPACE' 		=> false, 	//是否去除模板文件里面的html空格与换行
	'TAGLIB_BUILD_IN' 		=> 'Cx,Hd',  //自定义标签	
	'LANG_SWITCH_ON'   		=> true,	// 开启语言包功能
	'LANG_AUTO_DETECT' 		=> false,	// 自动侦测语言 开启多语言功能后有效
	'LANG_LIST'        		=> 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
	'VAR_LANGUAGE'     		=> 'l',		// 默认语言切换变量
	'URL_CASE_INSENSITIVE'	=> false,	//表示URL区分大小写 true则表示不区分大小写
	'URL_ROUTER_ON'			=>true,     //	开启路由	
	
	//'show_page_trace'		=>true,
	
	

);
// 合并数组 返回配置项
return array_merge($db,$web,$flag,$theme,$rule,$common);