<?php
/**友情链接表模型
 * @Author: cl
 * @Date:   2015-08-10 22:36:22
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-10 23:08:46
 */
namespace Addons\Link\Model;
use Think\Model;
class LinkModel extends Model{


	protected $_validate = array(
		array('name','require','请输入名称',1),
		array('url','require','请输入链接地址',1),
	);


	/**
	 * [_after_insert 添加数据后]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	protected function _after_insert($data,$options)
	{
		$this->update_upload($data['lid'],'logo');
	}

	/**
	 * [_after_update 更新数据后]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	protected function  _after_update($data,$options)
	{
		$lid = I('post.lid');
		$this->update_upload($lid,'logo');
	}

	/**
	 * [_before_update 更新数据前]
	 * @param  [type] &$data   [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	protected function _before_update(&$data,$options)
	{
		$lid = I('post.lid');
		$this->update_before_upload($lid,'logo');
	}



	/**
	* [update_upload 更新附件]
	* @param  [type] $id [description]
	* @return [type]     [description]
	*/
	protected function update_upload($id,$field)
	{
	 	$logo = I('post.'.$field);
	 	$info = pathinfo($logo);
	 	D('Upload')->where(array('name'=>$info['basename']))->save(array('relation'=>$id,'type'=>'link'));
	}


	/**
	* [update_before_upload 编辑前比较附件]
	* @param  [type] $id [description]
	* @return [type]     [description]
	*/
	protected function update_before_upload($id,$field)
	{
		$newlogo = I('post.'.$field);
		$oldlogo = $this->where(array('lid'=>$id))->getField($field);

		if($newlogo!=$oldlogo)
		{
			$info  = pathinfo($oldlogo);
			is_file($oldlogo) && unlink($oldlogo);
			D('Upload')->where(array('name'=>$info['basename']))->delete();
			// echo 1;die;
		}
	}

}