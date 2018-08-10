<?php
/**会员表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 10:26:10
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-23 10:40:30
 */
namespace Common\Logic;
use Think\Model\ViewModel;
class UserViewLogic extends ViewModel{
	protected $tableName='user';

	public $viewFields  = array(
	
		'user'=>array(
			'*',
			'_type'=>'INNER',
		),
		'user_grade'=>array(
			'gname','gid',
			'_type'=>'INNER',
			'_on' =>'user_grade.gid=user.grade_gid',
		),
		
	); 
}