<?php
/**[***]
 * @Author: 976123967@qq.com
 * @Date:   2015-06-08 14:13:42
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-31 16:38:40
 */
namespace Common\Service;
use Think\Model;
class ArticlePicService extends Model{

	/**
	 * [get_all 获取图片]
	 * @return [type]      [description]
	 */
	public function get_all($aid)
	{
 		$data = $this->where(array('article_aid'=>$aid))->order(array('sort'=>'asc','id'=>'asc'))->select();
        $attrValueModel = D('AttrValue');
 		if(!$data) return false;
        $isattr = 0;
 		// 组合路径
 		foreach ($data as $k=>$v)
 		{
          

            if($v['attr_value_attr_value_id'])
            {
                $isattr = 1;

                $temp[$v['attr_value_attr_value_id']]['attr_value_name'] = $attrValueModel->where(array('attr_value_id'=>$v['attr_value_attr_value_id']))->getField('attr_value_name');
                $temp[$v['attr_value_attr_value_id']]['attr_value_attr_value_id']=$v['attr_value_attr_value_id'];
                $temp[$v['attr_value_attr_value_id']]['pics'][$k]['small'] = __ROOT__.'/'.$v['small'];
                $temp[$v['attr_value_attr_value_id']]['pics'][$k]['medium'] = __ROOT__.'/'.$v['medium'];
                $temp[$v['attr_value_attr_value_id']]['pics'][$k]['big'] = __ROOT__.'/'.$v['big'];
                $temp[$v['attr_value_attr_value_id']]['pics'][$k]['article_aid'] = $v['article_aid'];
                $temp[$v['attr_value_attr_value_id']]['pics'][$k]['id'] = $v['id'];
            }
            else
            {
                $temp[$k]['article_aid'] = $v['article_aid'];
                $temp[$k]['id'] = $v['id'];
                $temp[$k]['small'] = __ROOT__.'/'.$v['small'];
                $temp[$k]['medium'] = __ROOT__.'/'.$v['medium'];
                $temp[$k]['big'] = __ROOT__.'/'.$v['big'];
            }
 			
 		}

 		return array('isattr'=>$isattr,'pics'=>$temp);
	}
}