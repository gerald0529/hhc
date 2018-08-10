<?php
return  array(
	//'配置项'=>'配置值'
	'TMPL_FILE_DEPR'=>'_',
	// 模板替换
	'TMPL_PARSE_STRING'  =>array(
   		'__PUBLIC__'=>__ROOT__.'/Templates',
	),
	'TMPL_DETECT_THEME'=>false,//自动侦测模板主题
	'THEME_LIST'=>'default',//支持的模板主题列表
	'DEFAULT_THEME'=>'default',//默认模板主题

	'VIEW_PATH'=>'./Templates/', //更改项目模板的路径
);