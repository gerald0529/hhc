<?php
/**附件表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-22 14:49:31
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-22 15:31:37
 */
namespace Common\Logic;
use Think\Model\ViewModel;
class UploadViewLogic extends ViewModel{
	protected $tableName='upload';

	public $viewFields  = array(
	
		'upload'=>array(
			'*',
			'_type'=>'INNER',
		),
		'user'=>array(
			'username','uid',
			'_type'=>'INNER',
			'_on' =>'user.uid=upload.user_uid',
		),
		
	); 
}