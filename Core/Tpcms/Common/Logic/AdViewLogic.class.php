<?php
/**广告表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-22 17:58:57
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-22 18:02:35
 */
namespace Common\Logic;
use Think\Model\ViewModel;
class AdViewLogic extends ViewModel{
	protected $tableName='ad';

	public $viewFields  = array(
	
		'ad'=>array(
			'*',
			'_type'=>'INNER',
		),
		'user'=>array(
			'username','uid',
			'_type'=>'INNER',
			'_on' =>'user.uid=ad.user_uid',
		),
		'position'=>array(
			'position_name',
			'_type'=>'INNER',
			'_on' =>'position.psid=ad.position_psid',
		),
		
	); 
}