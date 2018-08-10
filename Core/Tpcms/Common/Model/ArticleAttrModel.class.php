<?php
/**文档属性表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-20 15:11:46
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-20 15:13:45
 */
namespace Common\Model;
use Think\Model;
class ArticleAttrModel extends Model{

	/**
	 * [alert_article_attr 修改文档属性]
	 * @param [type] $aid [description]
	 */
	public function alert_article_attr($aid)
	{
		$cid = I('post.category_cid');
		$articleAttr = $_POST['article_attr'];

		// 删除原先的数据
		$this->where(array('article_aid'=>$aid))->delete();
		//p($articleAttr);

		$attrValueModel = D('AttrValue');
		foreach($articleAttr as $k=>$v)
		{
			$temp = explode('-', $k);

			foreach ($v as  $value) 
			{
				$attrValueId = $attrValueModel->where(array('attr_value'=>$value))->getField('attr_value_id');

				$data = array(
					'article_aid'=>$aid,
					'category_cid'=>$cid,
					'attr_attr_id'=>$temp[0],
					'type'=>$temp[1],
					'type_typeid'=>$temp[2],
					'is_pic'=>$temp[3],
					'attr_value_attr_value_id'=>$attrValueId,
					'attr_value'=>$value,
				);
				// 验证是否有主键，目的要保留原来的值文档属性主键值article_attr_id
				if($temp[4])
						$data['article_attr_id'] = $temp[4];
				
				$this->add($data);
			}	
		}
	
	}
	
}