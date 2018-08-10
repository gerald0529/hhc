<?php
return array(
	//'配置项'=>'配置值'

	// 模板替换
	'TMPL_PARSE_STRING'  =>array(
   		'__PUBLIC__'=>__ROOT__.'/Data/Public/admin',
   		'__ORG__'=>__ROOT__.'/Data/Public/org',
	),

	// 版本信息
	'CMS_VERSION'			=>'2.1.0_201501010',
	

	// 分页设置
	'PAGE_LISTROWS'			=>15,
	'VAR_PAGE'				=>'pageNum',
	

	//不需要实例化的控制器
	'NOT_D_CONTROLLER'=>array('Index','Login','Cache','ExportExcel','Public','Flag','Templates','Backup'),
	// 需要权限验证控制器
	'auth_controller'=>array('Category','Article','User','UserGrade','UserComment','Feedback','AuthGroup','AuthRule','ExportExcel','Config','ad','position','Model','Flag','ModelField','Type','attr','Templates',),
	// 需要验证的方法
	'auth_action'=>array('add','edit','del','index','batch_del','set_templates','sort','check','cancel_check','operation','cancel_operation','info','change'),

	
	// 超级管理员用户id
	'auth_superadmin'=>array(1),



	//session
	'VAR_SESSION_ID' 				=> 'SSID',					
);