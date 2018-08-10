<?php
/**属性表管理
 * @Author: 976123967@qq.com
 * @Date:   2015-07-16 11:58:30
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-09-18 16:23:56
 */
namespace Common\Model;
use Think\Model;
class AttrModel extends Model{

	public function _initialize()
	{
		$this->cache = S('attr');
	}

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
	   	array('attr_name','require','属性名称不能为空',1),

	   	array('sort','require','排序不能为空',1),
	   	array('sort','/^\d+$/i','排序只能填写数字',1,'regex',3)
	);

	/**
	 * [$_auto 自动完成]
	 * @var array
	 */
	protected $_auto = array(
		array('type_typeid','_typeid',3,'callback'),
		array('sort','intval',3,'function'),
		
	);

	/**
	 * [_typeid typeid自动完成]
	 * @return [type] [description]
	 */
	protected function _typeid()
	{
		return  I('post.typeid');
	}





	/**
	 * [get_all 读取数据]
	 * @param  [type] $typeid [description]
	 * @return [type]         [description]
	 */
	public function get_all($typeid)
	{

		return isset($this->cache[$typeid])?$this->cache[$typeid]:null;
	}


	public function get_one($attrid)
	{
		$typeid = I('get.typeid');
		$data = isset($this->cache[$typeid])?$this->cache[$typeid]:null;
		if(!$data) return null;
		return isset($data[$attrid])?$data[$attrid]:null;
		
	}


	/**
	 * [update_cache 更新缓存]
	 * @return [type] [description]
	 */
	public function update_cache()
	{
		$data = $this->order('sort asc')->select();

		$temp = array();
		if($data)
		{
			$attrValueModel  = M('AttrValue');

			foreach($data as $k=>$v)
			{
				$temp[$v['type_typeid']][$v['attr_id']]= $v;
				$value = $attrValueModel->where(array('attr_attr_id'=>$v['attr_id']))->field('attr_value,attr_attr_id,attr_value_id,attr_value_name,attr_value_sort')->order(array('attr_value_sort'=>'asc','attr_attr_id'=>'asc'))->select();
			
				$temp[$v['type_typeid']][$v['attr_id']]['attr_value']= $value;
			}	
		}
		s('attr',$temp);
	}


	public function _after_insert($data,$options)
	{
		$value  =  I('post.attr_value');
		$name   = I('post.attr_value_name');
		$attrValueModel =  M('AttrValue');
		if($value)
		{
			foreach($value as $k=> $v)
			{
				if($v)
				{
					$attrValue[] = array(
						'attr_attr_id'=>$data['attr_id'],
						'attr_value'=>$v,
						'attr_value_name'=>$name[$k]
					);
				}			
			}
			$attrValueModel->addAll($attrValue);
		}
		$this->update_cache();
	}


	public function _after_update($data,$options)
	{
		/***更改属性值***/
		$attrId =I('post.attr_id');
		
		$attrValueModel =  M('AttrValue');
		// 删除当前属性的所有值
		$attrValueModel->where(array('attr_attr_id'=>$attrId))->delete();
		
		$attrValue = array();
		$value =  $_POST['attr_value'];
		$name   = $_POST['attr_value_name'];
		$sort   = $_POST['attr_value_sort'];
		if($value)
		{
			foreach($value as $k=> $v)
			{
				if(is_array($v))
				{

					if(current($v))
					{
						$attrValue = array(
							'attr_value_id'=>key($v),
							'attr_attr_id'=>$attrId ,
							'attr_value'=>current($v),
							'attr_value_name'=>current($name[$k]),
							'attr_value_sort'=>current($sort[$k]),
						);
					}
				}
				else
				{
					if($v)
					{
						$attrValue = array(

						'attr_attr_id'=>$attrId ,
						'attr_value'=>$v,
						'attr_value_name'=>$name[$k],
						'attr_value_sort'=>$sort[$k],


						);
					}
				}
				//p($data);
				$attrValueModel->add($attrValue);
			}
		}
		$this->update_cache();
	}

	public function del($attrid)
	{
		$this->delete($attrid);
		M('AttrValue')->where(array('attr_aid_id'=>$attrid))->delete();
		return true;
	}

	/**
	 * [update_sort 更新排序]
	 * @param  [type] $cid   [description]
	 * @param  [type] $sort [description]
	 * @return [type]       [description]
	 */
	public function update_sort($sort)
	{
		$db = M('Attr');
		foreach($sort as $k=>$v)
		{
			$db->save(array('sort'=>$sort[$k],'attr_id'=>$k));
		}
		$this->update_cache();
		return true;
	}


	/**
	 * [get_attr_form 获取属性表单]
	 * @param  [type] $typeid [description]
	 * @return [type]         [description]
	 */
	public function get_attr_form($typeid,$aid=0)
	{
		$fields = $this->cache[$typeid];

		$form  = array();
		if(!empty($fields))
		{

			$articleAttrModel = D('ArticleAttr');
			$articleAttr = array();
			if($aid)
			{
				// 编辑时获取已经选择的属性值attr_value_attr_value_id
				$articleAttr = $articleAttrModel->where(array('article_aid'=>$aid))->getField('attr_value_attr_value_id',true);
			}

			//p($articleAttr);die;
		

			foreach ($fields as $k=>$v) 
			{
				$result = '';
				foreach($v['attr_value'] as $f)
				{	
					
					// 判断选中状态
					$checked = in_array($f['attr_value_id'],$articleAttr)?'checked="chekced"':'';
				
					$articleAttrId = 0;
					if($checked)
					{
						// 选中了就一定有文档属性的主键article_attr_id
						$articleAttrId = $articleAttrModel->where(array('article_aid'=>$aid,'attr_value_attr_value_id'=>$attrValueId))->getField('article_attr_id');
						//p($f);die;
						//echo $articleAttrModel->_sql();die;
					}

					$result .= "<label ><input {$checked} type='checkbox'  name='article_attr[{$v[attr_id]}-{$v[type]}-{$v[type_typeid]}-{$v[is_pic]}-$articleAttrId][]' value='{$f[attr_value]}' rel='{$f[attr_value_name]}' attr_value_id='{$f[attr_value_id]}'/> <span>{$f[attr_value_name]}</span></label>&nbsp;&nbsp;&nbsp;";
				}

				$form[] = array('html'=>$result,'title'=>$v['attr_name'],'is_pic'=>$v['is_pic']);
			}
		
		}
		return $form;
	}


	/**
	 * [_after_delete 删除后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_delete($data,$options)
	{
		// 更新缓存
		$this->update_cache();
	}
}
