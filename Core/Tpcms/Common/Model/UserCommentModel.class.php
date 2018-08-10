<?php
/**用户评论表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-23 13:53:20
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-23 13:55:11
 */
namespace Common\Model;
use Think\Model;
class UserCommentModel extends Model{

	public function del($cmids)
	{
		$cmids = explode(',', $cmids);
		foreach($cmids as $cmid)
		{
			$this->delete($cmid);
		}

		return true;
	}

} 