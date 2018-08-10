<?php
/**配置表模型
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-07-14 22:25:41
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-06 22:25:24
 */
namespace Common\Model;
use Think\Model;
use Think\Upload;
class ConfigModel extends Model{

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

 		array('title','require','标题不能为空',1),
 		array('title','check_title','标题不能重复',1,'callback'),
 		array('code','require','变量不能为空',1),
 		array('code','/^cfg_([a-z_])+/i','变量必须以cfg_开头,且只能包含是英文或者下划线',1),
 		array('code','check_code','变量不能重复',1,'callback'),
 		array('sort','number','排序只能是数字',1),

 	);
 	/**
 	 * [check_title 标题不能重复]
 	 * @param  [type] $con [description]
 	 * @return [type]      [description]
 	 */
 	protected function check_title($con)
 	{
 		if($this->where(array('title'=>$con))->find())
 			return false;
 		return true;
 	}
 	/**
 	 * [check_code 变量不能重复]
 	 * @param  [type] $con [description]
 	 * @return [type]      [description]
 	 */
 	protected function check_code($con)
 	{
 		if($this->where(array('code'=>$con))->find())
 			return false;
 		return true;
 	}



	/**
	 * [get_all 读取所有的信息的表单]
	 * @return [type] [description]
	 */
	public function get_all()
	{
		$data = $this->order('sort asc,id asc')->select();
		if(!$data) return $data;

		// 组合表单
		foreach($data as $v)
		{
			switch ($v['config_type']) 
			{
				case 1:
					$function = 'img';
					break;
				case 2:
					$function = 'input';
					break;
				case 3:
					$function = 'textarea';
					break;
				case 4:
					$function = 'file';
					break;
				case 5:
					$function = 'radio';
					break;
			}
			
			$html=$this->$function($v,$v['body']);

			$form[] = array(
				'title'=>$v['title'],
				'form'=>$html,
				'group'=>$v['group'],
				'code'=>$v['code'],
				'sort'=>$v['sort'],
			);
		}

		$result =array();
		// 分组
		foreach($form as  $v)
		{
			$result[$v['group']][]=$v;
		}
		return $result;
	}
	/**
	 * [img 上传]
	 * @param  [type] $field [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function img($field,$value)
	{

		$html ='<input type="text" name="'.$field["code"].'" id="'.$field["code"].'" value="'.$value.'" size="45" class="input"  ondblclick="image_priview(this.value);"/> 
                			<input type="button" class="button" onclick="javascript:flashupload(\'image_images\', \'附件上传\',\''.$field["code"].'\',submit_images,\''.CONTROLLER_NAME.'\',1,1,\''.C('cfg_image').'\')" value="上传文件" />';
		return $html;
	}
	/**
	 * [file 上传]
	 * @param  [type] $field [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function file($field,$value)
	{
		$html ='<input type="text" name="'.$field["code"].'" id="'.$field["code"].'" value="'.$value.'" size="45" class="input"  ondblclick="image_priview(this.value);"/> 
                			<input type="button" class="button" onclick="javascript:flashupload(\'image_images\', \'附件上传\',\''.$field["fname"].'\',submit_attachment,\''.CONTROLLER_NAME.'\',1,0,\''.C('cfg_file').'\')" value="上传文件" />';

		/*$html = "<input type='file' name='{$field['code']}' class='file-input'>";
		if($value)
		{
			// 组合下载地址
			$value =str_replace('/', '|', $value);
			$url = U('down')."&name=".$value;
			$html .= "<br/><a href='{$url}' >点击下载</a>";
		}*/
		return $html;
	}
	/**
	 * [input 单行文本]
	 * @param  [type] $field [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function input($field,$value)
	{


		$html = "<input type='text' class='input' style='width:350px' name='{$field['code']}' value='{$value}' />";
		return $html;

	}
	/**
	 * [textarea 多行文本]
	 * @param  [type] $field [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function textarea($field,$value)
	{
		$html ="<textarea   style='width:350px;overflow: hidden; word-wrap: break-word; resize: horizontal; height: 80px;' name='{$field['code']}'>{$value}</textarea>";
		return $html;

	}

	/**
	 * [radio 多行文本]
	 * @param  [type] $field [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function radio($field,$value)
	{
		$select=$noselect='';

		if($value ==1)
			$select= 'checked ="checked"';
		else
			$noselect=  'checked ="checked"';

		$html ="<label><input type='radio' name='{$field['code']}' value='1' {$select}> 是</label>
				<label><input type='radio' name='{$field['code']}' value='0' {$noselect}> 不是</label>";
		return $html;

	}



	/**
	 * [save_config 系统设置]
	 * @return [type] [description]
	 */
	public function save_config()
	{
		$data = $_POST;

		// header("Content-type:text/html;charset=utf-8");
		$config = $this->order('sort asc,id asc')->select();
		
		foreach($config as $v)
		{
			$result['sort'] = $data['sort'][$v['code']];
			$result['body'] = '';
			// 组合数组
			$result['body'] = $data[$v['code']];
				
			
			$this->where(array('id'=>$v['id']))->save($result);
		}
		return true;
	}
	/**
	 * [write_config 写文件]
	 * @return [type] [description]
	 */
	public function write_config()
 	{
 		// 读取所有的信息
 		$config = $this->order('sort asc,id asc')->select();
 		if(!$config) return ;
 		$data = array();
 		$uploadModel = D('Upload');
 		// 循环配置
 		foreach ($config as $v) 
 		{
 			$data[$v['code']] = $v['body'];

 			// 1和4 图片和文件
 			if($v['config_type']==1 || $v['config_type'] ==4)
 			{
 				$picInfo = pathinfo($v['body']);
				$where['name'] = $picInfo['basename'];
				$id = $uploadModel->where($where)->getField('id');
				$uploadModel->save(array('relation'=>$v['id'],'type'=>'config','id'=>$id));

 			}
 		}
 		// 写文件
 		return file_put_contents("Data/Config/config.inc.php", "<?php \nreturn " . var_export($data, true) . ";\n?>");
 	}


 	/**
 	 * [_after_update 更新之后]
 	 * @param  [type] $data    [description]
 	 * @param  [type] $options [description]
 	 * @return [type]          [description]
 	 */
 	public function _after_update($data,$options)
 	{
 		$status = $this->write_config();
 		if(!$status)
 			E('配置文件写入失败，请检查Data文件目录权限');

 	}


 	/**
 	 * [_before_update 更新之前]
 	 * @param  [type] &$data   [description]
 	 * @param  [type] $options [description]
 	 * @return [type]          [description]
 	 */
 	public function _before_update(&$data,$options)
 	{		

 		$new = I('post.');

 		// 读取所有的信息
 		$config = $this->order('sort asc,id asc')->select();
 		if(!$config) return ;

 		$uploadModel = D('Upload');
 		// 循环配置
 		foreach ($config as $v) 
 		{
 			
 			// 1和4 图片和文件
 			if($v['config_type']==1 || $v['config_type'] ==4)
 			{
 				$picInfo = pathinfo($v['body']);
				$where['name'] = $picInfo['basename'];
				
				// 两次信息不一致
				$temp  = pathinfo($new[$v['code']]); //新的
				
				if($temp['basename']!=$picInfo['basename'])
				{

					is_file($v['body'])  && unlink($v['body']);
					$uploadModel->where(array('name'=>$picInfo['basename']))->delete();
				}
				

 			}
 		}
 	}
}