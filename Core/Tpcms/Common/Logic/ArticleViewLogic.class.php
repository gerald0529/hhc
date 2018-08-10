<?php
/**文档表逻辑模型
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-14 22:02:49
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-19 17:04:07
 */
namespace Common\Logic;
use Think\Model\ViewModel;
class ArticleViewLogic extends ViewModel{

	protected $tableName='article';

	public $viewFields  = array(
	
		'article'=>array(
			'*',
			'_type'=>'INNER',
		),
		'user'=>array(
			'username','uid',
			'_type'=>'INNER',
			'_on' =>'user.uid=article.user_uid',
		),
		'category'=>array(
			'cid','cname','remark',
			'_type'=>'INNER',
			'_on' =>'category.cid=article.category_cid',
		)
	); 

}