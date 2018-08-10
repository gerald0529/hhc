<?php
/**评论表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 13:05:45
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-23 13:40:38
 */
namespace Common\Logic;
use Think\Model\ViewModel;
class UserCommentViewLogic extends ViewModel{
	protected $tableName='user_comment';

	public $viewFields  = array(
	
		'user_comment'=>array(
			'*',
			'_type'=>'INNER',
		),
		'article'=>array(
			'article_title','category_cid','aid',
			'_type'=>'INNER',
			'_on' =>'user_comment.article_aid=article.aid',
		),
		'user'=>array(
			'username',
			'_type'=>'INNER',
			'_on' =>'user.uid=user_comment.user_uid',
		),
		
	);
}