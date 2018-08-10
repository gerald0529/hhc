<?php
/**文档表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-20 14:18:45
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-06 22:30:20
 */
namespace Common\Model;
use Think\Model;
class ArticleModel extends Model{


	// 自动验证
	public $_validate = array(
		array('category_cid','/^[^0]\d*$/','请选择栏目',1,'regex',3),  
		array('article_title','require','标题不能为空',1,'regex',3),
		array('sort','require','请输入排序值',0,'regex',3),
		array('sort','/^\d+$/i','排序值只能是数字',0,'regex',3),
		array('click','require','请输入浏览次数',0,'regex',3),
		array('click','/^\d+$/i','浏览次数只能是数字',0,'regex',3),
	);

	// 自动完成
    // array(填充字段,填充内容,[填充条件,附加规则])
    protected $_auto = array (
        // 发布时间
        array('addtime','_addtime',3,'callback'),
        // 编辑时间
        array('edittime','time',3,'function'),
        // 属性
        array('flag','_flag',3,'callback'),
        // user_uid
		array('user_uid','_uid',1,'callback'),
    );

    // 发布时间
    public function _addtime($con)
    {
    	if(!$con)
    		return strtotime(date('Y-m-d'));
    	else
    		return strtotime($con);
    }


    // 用户uid
	public function _uid()
	{
		return session('user_id');
	}

    // 属性自动完成
	public function _flag()
	{
		$flag = I('post.flag');
		return $flag? implode(',', $flag):'';
	}




	

	/**
	 * [update_upload 更新栏目附件]
	 * @return [type] [description]
	 */
	public function update_upload($aid,$cid,$pic)
	{
	
		if(is_file($pic))
		{
			$picInfo = pathinfo($pic);
			$where['name'] = $picInfo['basename'];
			D('Upload')->where($where)->save(array('type'=>'article','relation'=>$aid));
		}

		$file = $data['file'];
		if(is_file($file))
		{
			$fileInfo = pathinfo($file);
			$where['name'] = $fileInfo['basename'];
			D('Upload')->where($where)->save(array('type'=>'article','relation'=>$aid));
		}
		
	}



	/**
	 * [add_ext 添加扩展字段]
	 * @param [type] $aid [description]
	 * @param [type] $cid [description]
	 */
	public function add_ext($aid,$cid)
	{
		$cat = D('Category')->get_one($cid);
		$mid = $cat['model_mid'];
		$model = D('Model')->get_one($mid);
		// 1获取附表名称
		$table = 'article_'.$model['name'];
		// 2获取字段数据
		$field = D('ModelField')->get_all($mid);
		$data = array();
		$data['article_aid'] = $aid;
		$strhtml = '';
		$uploadModel = D('Upload');
		foreach($field as $k=>$v)
		{
			

			// 系统关联字段
			if($v['fname']=='article_aid') continue; 

			// 字段内容值初始化
			$value = '';

			// 7是多选
			if($v['show_type']==7)
				$value = implode(',', $_POST[$v['fname']]);
			else
				// stripcslashes 处理引号被转义问题
				$value = stripcslashes($_POST[$v['fname']]);
			
			


			//3 编辑器
			if($v['show_type']==3)
				$strhtml .=$value;

			//8 9是图片上传和文件上传
			if($v['show_type']==8||$v['show_type']==9)
			{
				$fileInfo = pathinfo($value);
				$uploadModel->where(array('name'=>$fileInfo['basename']))->save(array('type'=>'article','relation'=>$aid));
			}

			$data[$v['fname']] = $value;
		}
		M($table)->add($data);
		// 处理编辑器图片删除
		
		$this->check_upload($strhtml,$aid);
	}

	/**
	 * [edit_ext 更新扩展字段]
	 * @param [type] $aid [description]
	 * @param [type] $cid [description]
	 */
	public function edit_ext($aid,$cid)
	{
		$cat = D('Category')->get_one($cid);
		$mid = $cat['model_mid'];
		$model = D('Model')->get_one($mid);
		// 1获取附表名称
		$table = 'article_'.$model['name'];
		// 2获取字段数据
		$field = D('ModelField')->get_all($mid);
		$data = array();
		$data['article_aid'] = $aid;
		$strhtml = '';
		$uploadModel = D('Upload');
		foreach($field as $k=>$v)
		{
			

			// 系统关联字段
			if($v['fname']=='article_aid') continue; 

			// 字段内容值初始化
			$value = '';

			// 7是多选
			if($v['show_type']==7)
				$value = implode(',', $_POST[$v['fname']]);
			else
				// stripcslashes 处理引号被转义问题
				$value = stripcslashes($_POST[$v['fname']]);


			//3 编辑器
			if($v['show_type']==3)
				$strhtml .=$value;
			
		

			//8 9是图片上传和文件上传
			if($v['show_type']==8||$v['show_type']==9)
			{
				$fileInfo = pathinfo($value);
				$uploadModel->where(array('name'=>$fileInfo['basename']))->save(array('type'=>'article','relation'=>$aid));
			}

			$data[$v['fname']] = $value;
		}
		M($table)->where(array('article_aid'=>$aid))->save($data);

		// 处理编辑器图片删除
		$this->check_upload($strhtml,$aid);
	}

	/**
	 * [check_upload 添加修改文档时候，删除编辑器中的图片]
	 * @param  [type] $strhtml [description]
	 * @param  [type] $aid     [description]
	 * @return [type]          [description]
	 */
	public function check_upload($strhtml,$aid)
	{
		
		$db = D('Upload');
		$upload = $db->where(array('relation'=>$aid,'type'=>'editor'))->select();
		if($upload)
		{
			foreach($upload as $up)
			{
				$temppic =$up['path'].'/'.$up['name'];
				$temppic = ltrim($temppic,'./');
	
				if(!strchr($strhtml,$temppic))
				{	

					is_file($temppic) && unlink($temppic);
					$db->delete($up['id']);
				}
			}
		}

	}




	/**
	 * [set_url 设置文件访问名称]
	 * @param [type] $aid [description]
	 */
	public function set_url($aid)
    {
     	$data = $this->where(array('aid'=>$aid))->field('file_url,category_cid,aid')->find();
     	$cur = D('Category')->get_one($data['category_cid']);
     	$remark = strtolower($cur['remark']);
     	$article = include 'Data/Config/article.inc.php';

     	if($data['file_url'])
     	{
     		$fileUrl = str_replace('.html', '', $data['file_url']);
     		$fileUrl = str_replace('/', '\/', $fileUrl);
 			$article[$aid]= array(
 				'/^'.$fileUrl.'$/'=>"Home/$remark/view?cid={$data['category_cid']}&aid={$data['aid']}",
 			);

     	}
     	else
     	{
     		if(isset($article[$aid]))
				unset($article[$aid]);
     	}
		
     	file_put_contents('./Data/Config/article.inc.php', "<?php\n return ".var_export($article,true)."; ");

    }


    /**
	 * [get_one 获取单条数据]
	 * @param  [type] $aid [description]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	public function get_one($aid,$cid)
	{
		$cur = D('Category')->get_one($cid);

		$mid = $cur['model_mid'];
		$model = D('Model')->get_one($mid);
		// 1获取附表名称
		$table = 'article_'.$model['name'];
		$ext = M($table)->where(array('article_aid'=>$aid))->find();

		$data = $this->find($aid);

		return array_merge($data,$ext);
	}



	public function del($aid)
	{
		$aids = explode(',',$aid);
		$articlePicModel = D('ArticlePic');
		$ArticleModel = D('Article');
		$categoryModel = D('Category');
		$modelModel = D('Model');
		$articleAttrModel = D('ArticleAttr');
		$uploadModel = D('Upload');
		foreach($aids as $aid)
		{
			if($aid)
			{
				$cid = $ArticleModel->where(array('aid'=>$aid))->getField('category_cid');
			
				$cur = $categoryModel->get_one($cid);
				$model = $modelModel->get_one($cur['model_mid']);
				$table = 'article_'.$model['name'];
				M($table)->where(array('article_aid'=>$aid))->delete();
				// 删除图集图片
				$articlePicModel->where(array('article_aid'=>$aid))->delete();
				// 删除属性
				$articleAttrModel->where(array('article_aid'=>$aid))->delete();
				// 删除附近的图片
				$uploadModel->delete_upload_by_article_aid($aid);
				
				$this->delete($aid);

				// 更新规则
				$article = include 'Data/Config/article.inc.php';
				if(isset($article[$aid]))
					unset($article[$aid]);
				file_put_contents('./Data/Config/article.inc.php', "<?php\n return ".var_export($article,true)."; ");

			}

		}
		return true;
	}


	/**
	 * [update_flag 更新属性]
	 * @param  [type] $aids   [description]
	 * @param  [type] $action [description]
	 * @return [type]         [description]
	 */
	public function update_flag($aids,$action)
    {
    	$flag = I('post.opa');

    	foreach($aids as $k=>$v)
		{
			// 把原先的属性取出
			$oldFlag = $this->where(array('aid'=>$v))->getField('flag');
			// 验证是否已经有属性存在
			if($action)
			{
				if(!strchr($oldFlag,$flag))
					$oldFlag .=','.$flag;
			}
			else
			{
				if(strchr($oldFlag,$flag))
					$oldFlag  = preg_replace('/(,)?'.$flag.'(,)?/', ',', $oldFlag);
			}
			$newFlag = trim($oldFlag,',');
			M('article')->save(array('flag'=>$newFlag,'aid'=>$v));
		}
		return true;
    
    }


    /**
     * [before_article_upload 检查是否有新的图片上传]
     * @return [type] [description]
     */
    public function before_article_upload()
    {
    	$this->before_update('pic');

     	$this->before_update('file');


     	$aid = I('post.aid');
     	// 图集
     	$oldPics =D('ArticlePic')->where(array('article_aid'=>$aid))->getField('big',true);
     	$pics = I('post.pics');
     	$uploadModel = D('Upload');
     	if($oldPics)
     	{
     		foreach($oldPics as $v)
     		{

     			if(!in_array($v,$pics))
     			{

     				$pic =pathinfo($v);
     				
		    		
     				is_file($v) && unlink($v);
		    		$medium=$pic['dirname'] . '/' .$pic['filename']."_medium.".$pic['extension'];
            		$small = $pic['dirname'] . '/' .$pic['filename']."_small.".$pic['extension'];

            		is_file($medium) && unlink($medium);
            		is_file($small) && unlink($small);

       
		    		$uploadModel->where(array('name'=>$pic['basename']))->delete();
     			}
     		}
     	}
   


    }


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
     * [_befor_update 更新之前方法]
     * @param  [type] &$data   [description]
     * @param  [type] $options [description]
     * @return [type]          [description]
     */
    public function _before_update(&$data,$options)
    {
    	// 上传之前处理图片是否有更新
    	$this->before_article_upload();
    }








    /**
	 * [_after_insert 添加后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_insert($data,$options)
	{

		// 更新栏目附件
		$this->update_upload($data['aid'],$data['category_cid'],$data['pic']);
		$this->update_upload($data['aid'],$data['category_cid'],$data['file']);
		// 添加图片集合
		$isattr = I('post.isattr');
		if(!$isattr)
			D('ArticlePic')->add_pic($data);
		else
			D('ArticlePic')->add_attr_pic($data);
		
		
		// 更新编辑器上传的附件
		D('Upload')->update_uoload_attachment($data);
		// 筛选属性
		D('ArticleAttr')->alert_article_attr($data['aid']);

		$this->add_ext($data['aid'],$data['category_cid']);
		$this->set_url($data['aid']);




		
		
	}
	
	/**
	 * [_after_update 更新后置方法]
	 * @param  [type] $data    [description]
	 * @param  [type] $options [description]
	 * @return [type]          [description]
	 */
	public function _after_update($data,$options)
	{

		// 更新栏目附件
		$this->update_upload($data['aid'],$data['category_cid'],$data['pic']);
		$this->update_upload($data['aid'],$data['category_cid'],$data['file']);

		// 添加图片集合
		$isattr = I('post.isattr');
		if(!$isattr)
			D('ArticlePic')->add_pic($data);
		else
			D('ArticlePic')->add_attr_pic($data);
		
		// 更新编辑器上传的附件
		D('Upload')->update_uoload_attachment($data);
		// 筛选属性
		D('ArticleAttr')->alert_article_attr($data['aid']);

		$this->edit_ext($data['aid'],$data['category_cid']);
		$this->set_url($data['aid']);

	
	
	}

}