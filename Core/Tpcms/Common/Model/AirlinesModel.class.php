<?php
/**碎片数据表模型
 * @Author: cl
 * @Date:   2015-07-22 20:40:48
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-06 22:24:34
 */
namespace Common\Model;
use Think\Model;
class AirlinesModel extends Model{


	// 自动验证
    // array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate=array(
    	//广告位置
    	// array('position_psid','require','请选择广告位置',1,'regex',3),  
        // 广告名称验证
        array('name','require','客服名称必填',1),
        array('type','require','客服类型必选',1),
        array('account','require','客服账号必填',1),
  //    	array('sort','require','请输入排序值',1,'regex',3),
		// array('sort','/^\d+$/i','排序值只能是数字',1,'regex',3),
    );


    // 自动完成
    protected $_auto = array (
        // 时间转成时间戳
        array('addtime','time',1,'function'), 
      
    );


	 public function get_one(){

    $id = I('get.id');
    $id = !empty($id) ? $id : I('post.id');

    $where['id'] = $id;
    $data = $this->where($where)->find();
    return $data;

   }


	
}