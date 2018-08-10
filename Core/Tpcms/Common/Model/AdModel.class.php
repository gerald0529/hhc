<?php
/**广告表模型
 * @Author: cl
 * @Date:   2015-07-22 20:40:48
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-06 22:24:34
 */
namespace Common\Model;
use Think\Model;
class AdModel extends Model{


	// 自动验证
    // array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate=array(
    	//广告位置
    	array('position_psid','require','请选择广告位置',1,'regex',3),  
        // 广告名称验证
        array('name','require','广告名称必须填写',1),
     	array('sort','require','请输入排序值',1,'regex',3),
		array('sort','/^\d+$/i','排序值只能是数字',1,'regex',3),
    );

    // 自动完成
    protected $_auto = array (
        // 时间转成时间戳
        array('addtime','time',1,'function'), 
        // 管理员aid
        array('user_uid','_uid',1,'callback'),
    );

    // 用户uid
	public function _uid()
	{
		return session('user_id');
	}

	



	
	/**
	 * [get_one 获取单条数据]
	 * @param  [type] $aid [description]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_one($aid)
	{
		return $this->find($aid);
	}

	/**
	 * [del 删除]
	 * @param  [type] $aid [description]
	 * @return [type]      [description]
	 */
	public function del($aid)
	{
		$aids = explode(',', $aid);
		$uploadModel = D('Upload');
		foreach($aids as $aid)
		{
			$upload = $uploadModel->where(array('relation'=>$aid,'type'=>'ad'))->select();

			if($upload)
			{
				foreach($upload as $v)
				{
					$temp = $v['path'].'/'.$v['name'];
					is_file($temp) && unlink($temp);
					$uploadModel->delete($v['id']);
				}
			}
			$this->delete($aid);
		}
		return true;
	}


	/**
	 * [update_upload 更新附件]
	 * @param  [type] $aid [description]
	 * @param  [type] $pic [description]
	 * @return [type]       [description]
	 */
	public function update_upload($aid,$pic)
	{
		$picInfo = pathinfo($pic);
		$where['name'] = $picInfo['basename'];
		D('Upload')->where($where)->save(array('relation'=>$aid,'type'=>'ad'));
	}

	/**
	 * [before_update 处理信息删除]
	 * @param  [type] $field [description]
	 * @return [type]        [description]
	 */
	public function before_update($field)
	{
		//新的
 		$pic = I('post.'.$field);
		$temp  = pathinfo($pic); 

		// 旧数据
		$aid = I('post.aid');
 		$oldPic= $this->where(array('aid'=>$aid))->getField($field);
 		$picInfo = pathinfo($oldPic);
	
		
		// 两次信息不一致
		if($temp['basename']!=$picInfo['basename'])
		{
			$uploadModel = D('Upload');
			is_file($oldPic)  && unlink($oldPic);
			$uploadModel->where(array('name'=>$picInfo['basename']))->delete();
		}
	}


	/**
	 * [after_insert 插入后]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_insert($data,$options)
	{
		// 更新附件
		$this->update_upload($data['aid'],$data['pic']); 	//中文
		$this->update_upload($data['aid'],$data['pic_en']); //英文
	}

	/**
	 * [_after_update 更新后]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_update($data,$options)
	{
		// 更新附件
		$this->update_upload($data['aid'],$data['pic']);  	//中文
		$this->update_upload($data['aid'],$data['pic_en']); //英文
	}


  /**
   * [_before_update 更新前]
   * @param  [type] &$data   [description]
   * @param  [type] $options [description]
   * @return [type]          [description]
   */
   public function _before_update(&$data,$options)
   {
   		$this->before_update('pic'); 	//中文图片信息修改删除
   		$this->before_update('pic_en'); //英文图片信息修改删除
   }



	


	
}