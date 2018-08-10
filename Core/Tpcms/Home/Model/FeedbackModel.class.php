<?php
/**[***]
 * @Author: 976123967@qq.com
 * @Date:   2015-04-29 17:16:11
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-30 22:30:30
 */
namespace Home\Model;
use Think\Model;
class FeedbackModel extends Model{

	// 自动验证
	/* array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
	*
	*  验证条件
	*  Model::EXISTS_VALIDATE 或者0 存在字段就验证 （默认）
	*  Model::MUST_VALIDATE 或者1 必须验证
	*  Model::VALUE_VALIDATE或者2 值不为空的时候验证
	*
	*  验证时间
	*  Model:: MODEL_INSERT 或者1新增数据时候验证
	*  Model:: MODEL_UPDATE 或者2编辑数据时候验证
	*  Model:: MODEL_BOTH 或者3 全部情况下验证（默认）
	* */

	protected $_validate = array(
	   array('body','require','留言内容不能为空',1),
	);


	// 自动完成
	/* array(填充字段,填充内容,[填充条件,附加规则])
	*  填充条件
	*  Model:: MODEL_INSERT或者1 新增数据的时候处理（默认）
	*  Model:: MODEL_UPDATE或者2更新数据的时候处理
	*  Model:: MODEL_BOTH或者3所有情况都进行处理
	* 
	**/
	protected $_auto = array(
		array('addtime','time',1,'function'),
	);

}