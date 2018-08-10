<?php
/**字段管理表模型
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-15 21:16:56
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-09-18 16:30:32
 */
namespace Common\Model;
use Think\Model;
class ModelFieldModel extends Model{
	private $cache;
	public function _initialize()
	{
		$this->cache = S('modelField');
	}


	/**
	 * [$_validate 自动验证]
	 * @var array
	 */
	protected $_validate = array(
		array('fname','require','请输入字段名',1,'regex',3),
		array('fname','/^[a-z][a-z0-9_]*$/i','字段名称必须以字母开头并且只能包含字母或者数字或者下划线',1,'regex',3),
		array('fname','check_fname','字段名称已经存在',1,'callback',3),
		array('title','require','请输入字段别名',1,'regex',3),
		array('title','check_title','字段别名已经存在',1,'callback',3),
		array('sort','require','请输入排序值',1,'regex',3),
		array('sort','/^\d+$/i','排序值只能是数字',1,'regex',3),
	);


	/**
	 * [check_title 检查字段说明是否重复]
	 * @param  [type] $con [description]
	 * @return [type]      [description]
	 */
	protected function check_title($con)
	{
		$mid = I('post.mid');
		$fid = I('post.fid');
		if($fid)
			$where['fid'] = array('neq',$fid);
		$where['title'] = $con;
		$where['model_mid'] = $mid;
		$data = $this->where($where)->find();
		if($data)
			return false;

		return true;
	}
	/**
	 * [check_fname 检查字段是否重复]
	 * @param  [type] $con [description]
	 * @return [type]      [description]
	 */
	protected function check_fname($con)
	{


		// 验证是否和主表的字段名称重复
		if(in_array($con, S('mainFieldsName')))
			return false;

		// 验证是否和当前模型附表表的字段名称重复
		$mid = I('post.mid');
		$fid = I('post.fid');
		if($fid)
			$where['fid'] = array('neq',$fid);
		$where['fname'] = strtolower($con);
		$where['model_mid'] = $mid;
		$data = $this->where($where)->find();
		if($data)
			return false;
		return true;
	}
	/**
	 * [$_auto 自动完成]
	 * @var array
	 */
	protected $_auto = array(
		array('model_mid','_mid',3,'callback'),
		array('fname','strtolower',3,'function'),
	);

	/**
	 * [_mid mid自动完成]
	 * @return [type] [description]
	 */
	protected function _mid()
	{
		return  I('post.mid');
	}


	/**
	 * [get_all 读取对应模型所有字段]
	 * @param  [type] $mid [description]
	 * @return [type]      [description]
	 */
	public function get_all($mid)
	{	
		$data = isset($this->cache[$mid])?$this->cache[$mid]:null;
		if(!$data) return null;
		foreach($data as $k=>$v)
		{
			// 1 文本 ，2 多行文本 ，3 完整编辑器 ，4 简单编辑器 ，5 单选框 ，6 下拉框，7 多选框 ，8 文件上传框，9 图片上传框 ， 10 地区联动
			switch ($v['show_type']) 
			{
				case 1:
					$data[$k]['type'] = '文本';
					break;
				case 2:
					$data[$k]['type'] = '多行文本';
					break;
				case 3:
					$data[$k]['type'] = '编辑器';
					break;
				case 4:
					$data[$k]['type'] = '简单编辑器';
					break;
				case 5:
					$data[$k]['type'] = '单选框';
					break;
				case 6:
					$data[$k]['type'] = '下拉框';
					break;
				case 7:
					$data[$k]['type'] = '多选框';
					break;
				case 8:
					$data[$k]['type'] = '文件上传框';
					break;
				case 9:
					$data[$k]['type'] = '图片上传框';
					break;
			}
		}
		return $data;
	}

	/**
	 * [update_cache 更新缓存]
	 * @return [type] [description]
	 */
	public function update_cache()
	{
		$data = $this->order('sort asc')->select();
		$temp = array();
		$modelFieldValueModel = D('ModelFieldValue');
		foreach($data as $k=>$v)
		{
			$temp[$v['model_mid']][$v['fid']] = $v;
			//字段值
			$value = $modelFieldValueModel->where(array('field_fid'=>$v['fid']))->field('field_value,fv_id')->order(array('fv_id'=>'asc'))->select();
			$temp[$v['model_mid']][$v['fid']]['field_value']=$value;
		}
		S('modelField',$temp);
	}

	/**
	 * [_after_insert 添加后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_insert($data,$options)
	{
		// 添加字段值
		$fid = $data['fid'];
		$value = I('post.value');
		$fieldValue = array();
		if($value)
		{
			foreach($value as $k=>$v)
			{
				$fieldValue[] = array(
					'field_fid'=>$fid,
					'field_value'=>$v,
				);
			}
		}
		else
		{
			$fieldValue[] = array(
					'field_fid'=>$fid,
					'field_value'=>'',
			);
		}
		D('ModelFieldValue')->addAll($fieldValue);



		// 添加表表结构的字段
		$type = $this->get_type(I('post.show_type'));
		$mid = I('post.mid');
		$tables = D('Model')->get_all();
		$table = isset($tables[$mid]['name'])?$tables[$mid]['name']:'';
		$table =  C('DB_PREFIX').'article_'.$table;
		$type = $this->get_type($data['show_type']);
		$fname = $data['fname'];
		$title = $data['title'];
		if($type!='text')
		{
			$type = ' VARCHAR(255) NOT NULL DEFAULT "" ';
			$sql='ALTER TABLE `' . $table . '` ADD  `' . $fname . '` ' . $type;
		}
		else
		{
			$type = ' text ';
			$sql='ALTER TABLE `' . $table . '` ADD  `'. $fname . '` '. $type;
		}
		$sql .= " COMMENT '{$title}'";
		$this->execute($sql);
		$this->update_cache();

	}

	/**
	 * [get_type 更具字段展示类型返回字段类型]
	 * @return [type] [description]
	 */
	public function get_type($showType)
	{	
		// 类型
		switch ($showType) {
			case 1:
				$type = 'varchar';

				break;
			case 2:
				$type = 'varchar';

				break;
			case 3:
				$type = 'text';

				break;
			case 4:
				$type = 'text';
				break;
			case 5:
				$type = 'varchar';
				break;
			case 6:
				$type = 'varchar';
				break;
			case 7:
				$type = 'varchar';
				break;
			case 8:
				$type = 'varchar';
				break;
			case 9:
				$type = 'varchar';
				break;
			case 10:
				$type = 'varchar';
				break;
		}
		return $type;

	}
	/**
	 * [get_one 读取一个字段的信息]
	 * @return [type] [description]
	 */
	public function get_one($fid)
	{
		$mid = I('get.mid');
		$data = isset($this->cache[$mid][$fid])?$this->cache[$mid][$fid]:'';
		return $data;
	}

	/**
	 * [_after_update 更新后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_update($data,$options)
	{
		
		$fid = $data['fid'];
		
		$modelFieldValueModel = D('ModelFieldValue');
		$modelFieldValueModel->where(array('field_fid'=>$fid))->delete();
		
	
		$value = $_POST['value'];
		foreach($value as $k=>$v)
		{
			if(is_array($v))
			{
				$fieldValue = array(
					'fv_id'=>key($v),
					'field_fid'=>$fid,
					'field_value'=>current($v),
				);	
			}
			else
			{
				$fieldValue = array(
					'field_fid'=>$fid,
					'field_value'=>$v,
				);	
			}
			
			$modelFieldValueModel->add($fieldValue);
		
		}

		
		
		$mid = I('post.mid');
		/***修改表结构**/
		// 表名称
		$tables 	= D('Model')->get_all();
		$table = isset($tables[$mid]['name'])?$tables[$mid]['name']:'';
		//表不存在
		if(!$table)
			return;
		$table = C('DB_PREFIX').'article_'.$table;
		
		
		// 旧字段名称
		$oldfname = isset($this->cache[$mid][$fid]['fname'])?$this->cache[$mid][$fid]['fname']:'';
		if(!$oldfname)
			return;
		// 更改之后的字段信息 字段名 字段说明 字段展示方式
		$fname = $data['fname']; 
		$title = $data['title'];
		$type = $this->get_type($data['show_type']);
		if($type!='text')
		{
			$type = ' VARCHAR(255) NOT NULL DEFAULT "" ';
			$sql='ALTER TABLE `'.$table.'` CHANGE  `'.$oldfname.'` '. $fname . $type;
		}
		else
		{
			$type = ' text  ';
			$sql='ALTER TABLE `'.$table.'` CHANGE  `'.$oldfname.'` '. $fname . $type;
		}
		$sql .= "COMMENT '{$title}'";
		$this->execute($sql);
	
		$this->update_cache();
	}
	
	/**
	 * [del 删除]
	 * @param  [type] $fid [description]
	 * @return [type]      [description]
	 */
	public function del($fid)
	{
		
		$mid = I('mid');
		/***修改表结构**/
		// 表名称
		$tables 	= D('Model')->get_all();
		$table = isset($tables[$mid]['name'])?$tables[$mid]['name']:'';
		//表不存在
		if(!$table)
			return;
		$table = C('DB_PREFIX').'article_'.$table;
		$fids = explode(',', $fid);
		$modelFieldValueModel = M('ModelFieldValue');
		foreach($fids as $fid)
		{
			// 字段名称
			$fname = isset($this->cache[$mid][$fid]['fname'])?$this->cache[$mid][$fid]['fname']:'';
			if(!$fname)
				return;
			$sql = "ALTER TABLE  `" . $table ."`  DROP  ". $fname;
			$this->execute($sql);
			
			$modelFieldValueModel->where(array('field_fid'=>$fid))->delete();
			$this->delete($fid);		
		}
		
		return true;
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

	/**
	 * [get_field_form 读取自定义模型表单]
	 * @param  [type] $mid   [description]
	 * @param  array  $value [description]
	 * @return [type]        [description]
	 */
	public function get_field_form($mid,$value=array())
	{
		$fieldAll = $this->cache;
		$field = $fieldAll[$mid];
		$model = D('Model')->get_one($mid);

		$form  		= array();
		foreach($field as $v)
		{
			if($v['fname']=='article_aid')
				continue;
			if($v['is_disabled'])
				continue;
			$temp = isset($value[$v['fname']])?$value[$v['fname']]:(isset($v['field_value'][0]['field_value'])?$v['field_value'][0]['field_value']:'');
			switch ($v['show_type']) {
				case 1: //文本框
					
					$result = "<input name = '{$v['fname']}' id='{$v['fname']}' type='text' value='{$temp}' class='input'  style='width:50%'/>";
					break;
				case 2: //多行文本框
					
					$result = "<textarea name = '{$v['fname']}'  id='{$v['fname']}'style='width:50%;height:80px'>{$temp}</textarea>";
					break;
				case 3: //完整编辑器
					
					$result =  keditor(array('name'=>$v['fname'],'content'=>$temp));
					break;
				case 4: //简单编辑器
					
					$result =  keditor(array('name'=>$v['fname'],'content'=>$temp,'style'=>2));
					break;
				case 5: //单选框
					$result ='';
					
					foreach($v['field_value'] as $f)
					{	
						$checked = $temp == $f['field_value']?"checked='checked'":"";
						$result .= "<label ><input {$checked} type='radio'  name='{$v[fname]}' value='{$f[field_value]}' /> <span>{$f[field_value]}</span></label>&nbsp;&nbsp;&nbsp;";
					}
				
					break;
				case 6: //下拉框
					$result = "<select name='{$v["fname"]}' id='{$v['fname']}'>";
					
					foreach($v['field_value'] as $f)
					{	
						$selected = $temp == $f['field_value']?"selected='selected'":"";
						$result .= "<option {$selected} value='{$f[field_value]}'>{$f[field_value]}</option>";
					}
					$result .= "</select>";
					break;
				case 7: //多选框
					$result ='';
					
					foreach($v['field_value'] as $f)
					{	
						$checked = strchr($temp,$f['field_value'])?"checked='checked'":"";
						$result .= "<label ><input {$checked} type='checkbox'  name='{$v[fname]}[]' value='{$f[field_value]}' /> <span>{$f[field_value]}</span></label>&nbsp;&nbsp;&nbsp;";
					}
				
					break;
				case 8: //文件上传
					$result ='<input type="text" name="'.$v["fname"].'" id="'.$v["fname"].'" value="'.$temp.'" size="50" class="input"  ondblclick="image_priview(this.value);"/> 
                			<input type="button" class="button" onclick="javascript:flashupload(\'image_images\', \'附件上传\',\''.$v["fname"].'\',submit_attachment,\''.CONTROLLER_NAME.'\',1,0,\''.C('cfg_file').'\')" value="上传文件" />';
					/*if($temp)
					{
						$result .= "<br/> <a href='".U('down',array('aid'=>$value['aid'],'field'=>$v["fname"]))."'>下载</a>";
						$result .= "&nbsp;<a href='javascript:;' onclick='ajax_del_attachment(this,{$value[aid]},\"$v[fname]\")'>删除</a>";
						$result .= "<input type='hidden' name='table' value='article_{$model[name]}' />";
					}*/
					break;
				case 9: //图片上传
					
					
					$result ='<input type="text" name="'.$v["fname"].'" id="'.$v["fname"].'" value="'.$temp.'" size="50" class="input"  ondblclick="image_priview(this.value);"/> 
                			<input type="button" class="button" onclick="javascript:flashupload(\'image_images\', \'附件上传\',\''.$v["fname"].'\',submit_images,\''.CONTROLLER_NAME.'\',1,0,\''.C('cfg_image').'\')" value="上传文件" />';
					// if($temp)
					// {
					// 	$result .= "<br/><img src='".__ROOT__."/".$temp."' width='100' />";
					// 	$result .= "&nbsp;<a href='javascript:;' onclick='ajax_del_attachment(this,{$value[aid]},\"$v[fname]\")'>删除</a>";

						
					// 	$result .= "<input type='hidden' name='table' value='article_{$model[name]}' />";
					// }
					break;
				case 10:
					$result = '地区联动';
					break;
			}
			if($v['require'])
			{
				$result ='<span class="must_red">*</span>'.$result;
			}
			$form[] = array('html'=>$result,'title'=>$v['title']);
			
		}

		
		return $form;
	}




	/**
	 * [get_validate 获取js验证]
	 * @return [type]      [description]
	 */
	public function get_validate()
	{
		$cid      = I('get.category_cid');
		$category = S('category');
		$mid      = $category[$cid]['model_mid'];
		$field    = $this->cache[$mid];

		$validate['rules'] = array(

			'article_title'=>array('required'=>1),
			'sort'=>array('required'=>1),
		);

		$validate['messages'] = array(

			'article_title'=>array('required'=>'标题不能为空！'),
			'sort'=>array('required'=>'排序不能为空！'),
		);
	
		foreach($field as $v)
		{
			if($v['fname']=='article_aid' || $v['fname']=='body') continue;
	
		
			// 验证必填
			// 规则
			if($v['require'])
				$validate['rules'][$v['fname']] = array('required'=>1);
			if($v['validate'])
				$validate['rules'][$v['fname']] = array('regexp'=>$v['validate']);
			


		

			// 错误提示
			if($v['require'])
				$validate['messages'][$v['fname']] = array('required'=>$v['error']);
			if($v['validate'])
				$validate['messages'][$v['fname']] = array('regexp'=>$v['error']);

		
			
		
		}

		$validate = json_encode($validate);
		$validate =  ltrim($validate,"{");
		$validate =  substr($validate,0,-1);


		return $validate;
	}
}