<?php
/**模型表模型
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-15 20:42:55
 * @Last Modified by:   happy
 * @Last Modified time: 2015-07-15 21:56:55
 */
namespace Common\Model;
use Think\Model;
class ModelModel extends Model{

	private $cache;

	public function _initialize()
	{
		$this->cache = S('model');
	}
	/**
	 * [$_validate 自动验证]
	 * @var array
	 */
	protected $_validate = array(
		array('remark','require','请输入模型名称',1),
		array('name','require','请输入表名称',1),
		array('name','/^[a-z][a-z0-9_]*$/','表名称必须以字母开头并且只能包含小写字母或数字或下划线',1,'regex',3),
		array('name','check_name','表名称重复',1,'callback',3),
		
	);
	/**
	 * [check_remark 检查表名称重复]
	 * @param  [type] $con [description]
	 * @return [type]      [description]
	 */
	public function check_name($con)
	{
		$where['name'] 	= $con;
		$mid 			= I('post.mid');
		if($mid)
			$where['mid'] = array('neq',$mid);
		if(!$this->where($where)->find())
			return ture;
		else
			return false;

	}
	/**
	 * [$_auto 自动完成]
	 * @var array
	 */
	protected $_auto = array(
		array('name','strtolower',3,'function'),
	);

	/**
	 * [get_all 所有模型]
	 * @return [type] [description]
	 */
	public function get_all()
	{
		return $this->cache;
	}

	/**
	 * [get_one 单条模型]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_one($id)
	{
		return isset($this->cache[$id])?$this->cache[$id]:null;
	}

	/**
	 * [update_cache 更新缓存]
	 * @return [type] [description]
	 */
	public function update_cache()
	{
		$data = $this->select();
		$temp = array();
		foreach($data as $k=>$v)
		{
			$temp[$v['mid']]= $v;
		}
		S('model',$temp);
	}

	/**
	 * [del 删除]
	 * @param  [type] $mid [description]
	 * @return [type]      [description]
	 */
	public function del($mid)
	{
		// 验证模型是否已经使用
		$db  = D('Category');
		$data  = $db->where(array('model_mid'=>array('in',$mid)))->select();
		if($data)
		{
			$this->error = '删除失败，选择的模型中有正在使用的模型';
			return false;
		}

		// 更改表结构
		$names  = $this->where(array('mid'=>array('in',$mid)))->getField('name',true);
		if($names)
		{
			foreach($names as $v)
			{
				$sql = 'drop table '.C('DB_PREFIX').'article_'.$v;
				$this->execute($sql);
			}
		}
		// 删除字段
		$modelFieldModel = D('ModelField');
		$fieldIds = $modelFieldModel->where(array('model_mid'=>array('in',$mid)))->getField('fid',true);
		if($fieldIds)
			D('ModelFieldValue')->where(array('field_fid'=>array('in',$fieldIds)))->delete();
		$modelFieldModel->where(array('model_mid'=>array('in',$mid)))->delete();

		// 删除数据表数据
		$this->where(array('mid'=>array('in',$mid)))->delete();
		return true;
	}


	/**
	 * [_after_insert 添加后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_insert($data,$options)
	{
		// 创建表
		$tableName = C('DB_PREFIX').'article_'.$data['name'];
		$remark = $data['remark'];
		$mid = $data['mid'];
		$sql = file_get_contents(APP_PATH.MODULE_NAME."/Conf/table.sql");
		$sql = preg_replace(array('/thinkcms_article_data/','/文章附表/'), array($tableName,$remark), $sql);


		$this->execute($sql);
		// 创建默认字段
		// 添加字段
		$modelFieldModel = M('ModelField');
		$modelFieldValueModel = M('ModelFieldValue');
		$field = array(
				'model_mid'=>$mid,
				'fname'=>'article_aid',
				'title'=>'关联字段',
				'validate'=>'',
				'require'=>0,
				'show_type'=>1,
				'show_lists'=>0,
				'is_system'=>1,
				'is_disabled'=>0,
				'sort'=>1,
			);
		$fid = $modelFieldModel->add($field);
		$fieldValue = array(
			'field_fid'=>$fid,
			'field_value'=>'',
		);
		$modelFieldValueModel->add($fieldValue);
		$field = array(
				'model_mid'=>$mid,
				'fname'=>'body',
				'title'=>'详细内容',
				'validate'=>'',
				'require'=>0,
				'show_type'=>3,
				'show_lists'=>0,
				'is_system'=>0,
				'is_disabled'=>0,
				'sort'=>900,
			);
		$fid = $modelFieldModel->add($field);
		$fieldValue = array(
			'field_fid'=>$fid,
			'field_value'=>'',
		);
		$modelFieldValueModel->add($fieldValue);

		// 更新缓存
		$this->update_cache();
		D('ModelField')->update_cache();
	}

	/**
	 * [_after_update 更新后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_update($data,$options)
	{

		$tableName = C('DB_PREFIX').'article_'.$data['name'];
		$oldTableName = C('DB_PREFIX').'article_'.I('post.old_table_name');
		$remark = $data['remark'];
		$oldRemark=I('post.old_remark');

		if($oldTableName!=$tableName)
		{
			// 更改表名称
			// sql语句
			$sql = 'alter table '.$oldTableName."  rename ".$tableName;
			$this->execute($sql);
		}
		if($oldRemark!=$remark)
		{
			// 更改表注释
			$sql = 'alter table '.$tableName .' COMMENT="'.$remark.'"';
			$this->execute($sql);
		}
		
		// 更新缓存
		$this->update_cache();
		D('ModelField')->update_cache();
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
		D('ModelField')->update_cache();
	}
}