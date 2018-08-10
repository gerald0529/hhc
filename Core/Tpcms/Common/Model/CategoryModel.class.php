<?php
/**栏目表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-16 11:18:27
 * @Last Modified by:   cl
 * @Last Modified time: 2015-10-11 17:36:57
 */
namespace Common\Model;
use Think\Model;
use Think\Upload;
use Third\Data;
class CategoryModel extends Model{
	private $cache;
	public function _initialize()
	{
		$this->cache = S('category');
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
	   	array('cname','require','分类名不能为空',1),
	   	array('pid','check_pid','不能选择自己',1,'callback',2),
	   	array('default_tpl','require','封面模板不能为空',1),
	   	array('list_tpl','require','列表页模板不能为空',1),
	   	array('view_tpl','require','详细页模板不能为空',1),
	   	array('remark','require','请输入控制器名称',1),
	);

	/**
	 * [check_pid 验证父级pid]
	 * @return [type]      [description]
	 */
	public function check_pid()
	{
		// 父级pid
		$pid =I('post.pid',null,'intval');
		$childCids = D('Category')->get_child_cid($pid);
		array_shift($childCids);
		// 父级pid不能是0 的情况下，编辑时候判断父级和自己的所有子集cid 不能相同
		if($pid!=0 && in_array($pid, $childCids))
		{
			return false;
		}
		// cid
		$cid = I('post.cid',null,'intval');
 		// 编辑时候判断父级和cid 不能相同
		if($cid == $pid)
		{
			return false;
		}
		return true;
	}

	// 自动完成
	/* array(填充字段,填充内容,[填充条件,附加规则])
	*  填充条件
	*  Model:: MODEL_INSERT或者1 新增数据的时候处理（默认）
	*  Model:: MODEL_UPDATE或者2更新数据的时候处理
	*  Model:: MODEL_BOTH或者3所有情况都进行处理
	* 
	**/
	protected $_auto = array(
		array('remark','_ucfirst',3,'callback'),
		array('sort','intval',3,'function') 
	);

	/**
	 * [_ucfirst 处理控制器名称]
	 * @param  [type] $con [description]
	 * @return [type]      [description]
	 */
	protected function _ucfirst($con)
	{
		// 全部转成小写，在首字母大写
		return ucfirst(strtolower($con));
	}



	
	/**
	 * [get_all 读取所有信息]
	 * @return [type] [description]
	 */
	public function get_all()
	{
		$data = $this->cache;
		if(!$data) return false;
		// 返回树状结构
		return Data::tree($data,'cname','cid');
	}
	
	/**
	 * [update_cache 更新缓存]
	 * @return [type] [description]
	 */
	public function update_cache()
	{
		$data = $this->order(array('sort'=>'asc'))->select();
		$temp = array();
		$modelAll   = D('Model')->get_all();





		if($data)
		{

			$remarkArr = array();

			foreach($data as $k=>$v)
			{

				
				if($v['pid']==0&&$v['remark']!='Index' && !in_array($v['remark'], $remarkArr))
				{
					$remarkArr[]= $v['remark'];
				}
				$v['disabled']='';
				if($v['cat_type']==1)
				{
					$v['type']="普通";
				}
				elseif($v['cat_type']==2)
				{
					$v['disabled']='disabled="disabled"';
					$v['type']="封面";
				}
				elseif($v['cat_type']==3)
				{
					
					$v['type']="跳转";
				}
				elseif($v['cat_type']==4)
				{
					$v['type']="单页";
				}


				$v['showtarget']='';
				if($v['target'] == 2)
				{
					$v['showtarget']='target="_blank"';
				}

				$v['has_pic'] = false;
				// 栏目图片
				if($v['pic'])
				{
					$v['has_pic'] = true;
				}
				
				$v['pathpic']= $v['pic']?__ROOT__.'/'.$v['pic']:__ROOT__.'/Data/Public/images/default.gif';

				// 栏目选择的模型名称
				$v['model'] = $modelAll[$v['model_mid']]['remark'];
				$temp[$v['cid']]=$v;
			}
		}
		
		S('category',$temp);

		$rule =<<<str
'/^index_c_(\d+)$/'=>'Home/Index/cover?cid=:1',
'/^index_l_(\d+)$/'=>'Home/Index/lists?cid=:1',
'/^index_v_(\d+)_(\d+)$/'=>'Home/Index/view?cid=:1&aid=:2',
'/^index_v_(\d+)$/'=>'Home/Index/index?cid=:1',\n
str;

		foreach($remarkArr as $v)
		{
		
			$remark = strtolower($v);

			$rule .= <<<str
'/^{$remark}_c_(\d+)\$/'=>'Home/{$v}/cover?cid=:1',
'/^{$remark}_l_(\d+)\$/'=>'Home/{$v}/lists?cid=:1',
'/^{$remark}_v_(\d+)_(\d+)\$/'=>'Home/{$v}/view?cid=:1&aid=:2',
'/^{$remark}_v_(\d+)\$/'=>'Home/{$v}/view?cid=:1',\n
str;
		}

		file_put_contents('./Data/Config/rule.inc.php', "<?php\n return array(\n".$rule.");");


	}
	
	/**
	 * [get_one 读取一个字段的信息]
	 * @return [type] [description]
	*/
	public function get_one($cid)
	{
		$data =  $this->get_one_cate($cid);
		if($data)
		{
			$parent = $this->get_one_cate($data['pid']);
			if(!$parent)
				$data['parent_cname'] = '顶级栏目';
			else
				$data['parent_cname'] = $parent['cname'];
		}
		return  $data;
	}

	/**
	 * [get_one_cate 读取一个字段的信息]
	 * @return [type] [description]
	*/
	public function get_one_cate($cid)
	{
		return isset($this->cache[$cid])?$this->cache[$cid]:'';
	}
	
	
	
	
	/**
	 * [update_upload 更新栏目附件]
	 * @return [type] [description]
	 */
	public function update_upload($cid,$pic)
	{


		if(is_file($pic))
		{
			$picInfo = pathinfo($pic);
			$where['name'] = $picInfo['basename'];
			D('Upload')->where($where)->save(array('relation'=>$cid,'type'=>'category'));
		}
		
	}
	


	
	
	
	
	/**
	 * [del 删除]
	 * @param  [type] $fid [description]
	 * @return [type]      [description]
	 */
	public function del($cid)
	{
		$cids = explode(',',$cid);
		$categoryModel = D('Category');
		$articleModel  = D('Article');
		$articleModel  = D('Article');
		$uploadModel   = D('Upload');
		foreach($cids as $cid)
		{
			$temp = $this->where(array('pid'=>$cid))->getField('cid');
			if($temp)
			{
				$this->error = '请先删除子栏目';
				return false;
			}
			$cur = $this->cache[$cid];
			if($cur['cat_type']==4)
			{
				$aid = $articleModel->where(array('category_cid'=>$cid))->getField('aid');
				if($aid)
					$articleModel->del($aid);
			}

			$where['category_cid'] = array('in',$categoryModel->get_child_cid($cid));
			if($articleModel->where($where)->find())
			{
				$this->error = '分类下还有文档存在';
				return false;
			}

			// 栏目图片删除
			$upload = $uploadModel->where(array('relation'=>$cid,'type'=>'category'))->select();
			// dump($upload);die;
			if($upload)
			{
				foreach($upload as $v)
				{
					$temp = $v['path'].'/'.$v['name'];
					is_file($temp) && unlink($temp);
					$uploadModel->delete($v['id']);
				}
			}



			$this->delete($cid);
		}
		$category = include 'Data/Config/category.inc.php';
		if(isset($category[$cid]))
			unset($category[$cid]);
		file_put_contents('./Data/Config/category.inc.php', "<?php\n return ".var_export($category,true)."; ");

		$this->update_cache();
		

		return true;
	}
	
	/**
	 * [update_sort 更新排序]
	 * @param  [type] $sort [description]
	 * @return [type]       [description]
	 */
	public function update_sort($sort)
	{

		foreach($sort as $k=>$v)
		{
			$this->save(array('sort'=>$v,'cid'=>$k));
		}
		return true;
	}
	
	/**
	 * [del_attachment 删除附件]
	 * @param  [type] $cid   [description]
	 * @param  [type] $field [description]
	 * @return [type]       [description]
	 */
	public function del_attachment($cid,$field)
	{
		$pic = $this->where(array('cid'=>$cid))->getField($field);
		is_file($pic) && unlink($pic);
		M('Category')->save(array($field=>'','cid'=>$cid));
		$this->update_cache();
		return true;
	}
	
	/**
	 * [article_ztree 栏目树菜单]
	 * @return [type]       [description]
	 */
	public function article_ztree()
	{
		$category = array();
		$cate = $this->cache;
		if (!empty($cate))
		{
			foreach ($cate as $n => $cat) 
			{
				$data = array();
				//过滤掉外部链接栏目
				if ($cat['cat_type'] != 3) 
				{
					//单文章栏目
					if ($cat['cat_type'] == 4) 
					{
						$link = U('Article/add',array('category_cid'=>$cat['cid']));
						$url = $link;
					} 
					else if ($cat['cat_type'] == 1 || $cat['cat_type'] == 2) 
					{
						$url = U('Article/index', array('category_cid' => $cat['cid'], 'verifystate' => 2));
					} 
					else 
					{
						$url = 'javascript:;';
					}
					$data['catid'] = $cat['cid'];
					$data['parentid'] = $cat['pid'];
					$data['url'] = $url;
					$data['target'] = 'right';
					$data['open'] = true;
			
					$status = $this->get_child_list($cat['cid']);
					
					if($cat['pid']||empty($status))
					{
						if($cat['cat_type']==4)
						{
						
							$data['icon'] = __ROOT__ . '/Data/Public/org/zTree/zTreeStyle/img/diy/2.png';
						}
						if($cat['cat_type']==1)
						{
							$data['icon'] = __ROOT__ . '/Data/Public/org/zTree/zTreeStyle/img/diy/10.png';
						}
					}
					$data['catname'] = $cat['cname'];
					$category[] = $data;
				}
			}
		}
		
		return $category;
	}
	
	
	
	
	
	public function set_url($cid)
    {
    	$this->cache = S('category');
     	$data = $this->cache[$cid];
     	$category = include 'Data/Config/category.inc.php';
     	$remark = strtolower($data['remark']);

     	if($data['file_url'])
     	{
     		$fileUrl = str_replace('.html', '', $data['file_url']);
     		$fileUrl = str_replace('/', '\/', $fileUrl);
 			$category[$cid]= array(
 				'/^'.$fileUrl.'\/index$/'=>"Home/$remark/cover?cid={$data['cid']}",
 				'/^'.$fileUrl.'$/'=>"Home/$remark/lists?cid={$data['cid']}",

 			);
     	}
     	else
     	{
     		if(isset($category[$cid]))
				unset($category[$cid]);
     	}
     	file_put_contents('./Data/Config/category.inc.php', "<?php\n return ".var_export($category,true)."; ");
    }


    /**
	 * [get_parent_list 获取分类的所有父级栏目]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_parent_list($cid)
	{
		return Data::parentChannel($this->cache,$cid);
	}

	/**
	 * [get_parent_cid 所有父级的cid]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_parent_cid($cid)
	{
		$data =$this->get_parent_list($cid);
		$result  = array();
		foreach($data as $v)
		{
			$result[] =$v['cid'];
		}
		return $result;
	}
	
	/**
	 * [get_top_child 获取顶级栏目子集 树状]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_top_child($cid)
	{
		$parentCids = $this->get_parent_cid($cid);
		return Data::channelList($this->cache,$parentCids[count($parentCids)-1],'---');
	}

	/**
	 * [get_child_cid 子栏目的所有的cid]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_child_list($cid)
	{
		$result =Data::channelList($this->cache,$cid,'');
		return $result;
	}
	/**
	 * [get_child_cid 子栏目的所有的cid]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_child_cid($cid)
	{
		$data = $this->get_child_list($cid);
	
		$result = array($cid);
		foreach($data as $v)
		{
			$result[]= $v['cid'];
		}
		return $result;
	}



	/**
	 * [get_top 顶级cid]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_top($cid)
	{
		$parents = D('Category')->get_parent_list($cid);
		$parents = array_reverse($parents);
		return $parents[0];
	}



	/**
 	 * [_before_update 更新之前]
 	 * @param  [type] &$data   [description]
 	 * @param  [type] $options [description]
 	 * @return [type]          [description]
 	 */
 	public function _before_update(&$data,$options)
 	{	

 		
 		$this->before_update('pic');
 		$this->before_update('pic_en');
	
 	}


 	public function before_update($field)
	{
		//新的
 		$pic = I('post.'.$field);
		$temp  = pathinfo($pic); 
 	
 	
 	

		// 旧数据
		$cid = I('post.cid');
 		$oldPic= $this->where(array('cid'=>$cid))->getField($field);
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
	 * [_after_update 更新后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_update($data,$options)
	{
		// 更新缓存
		$this->update_cache();
		// 设置栏目访问url
		$this->set_url($data);
		// 更新栏目附件
		$this->update_upload($data['cid'],$data['pic']);
		$this->update_upload($data['cid'],$data['pic_en']);
	}


	/**
	 * [_after_insert 添加后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_insert($data,$options)
	{
		// 更新缓存
		$this->update_cache();
		// 设置栏目访问url
		$this->set_url($data['cid']);
		// 更新栏目附件
		$this->update_upload($data['cid'],$data['pic']);
		$this->update_upload($data['cid'],$data['pic_en']);
	}
	


}