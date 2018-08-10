<?php
/**留言表模型
 * @Author: cl
 * @Date:   2015-07-22 22:15:32
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-22 22:17:14
 */
namespace Common\Model;
use Think\Model;
class FeedbackModel extends Model{
	

	/**
	 * [get_one 读取一个字段的信息]
	 * @return [type] [description]
	*/
	public function get_one($fid)
	{
		$this->save(array('fd_id'=>$fid,'lookstate'=>2));
		return $this->find($fid);
	}

	/**
	 * [del 删除]
	 * @param  [type] $fid [description]
	 * @return [type]      [description]
	 */
	public function del($fid)
	{
		$fids = explode(',',$fid);
		foreach($fids as $fid)
		{

			$this->delete($fid);
		}

		return true;
	}
}