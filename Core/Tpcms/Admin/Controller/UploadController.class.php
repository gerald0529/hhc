<?php
/**附件控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-16 15:30:10
 * @Last Modified by:   cl
 * @Last Modified time: 2015-10-11 20:55:11
 */
namespace Admin\Controller;
use Think\Upload;
use OSS\Client;
class UploadController extends PublicController{


	/**
	 * [swfupload 初始化上传]
	 * @return [type] [description]
	 */
	public function swfupload()
	{
		// 允许上传文件的数量
		$num = I('get.num');
		// 上传文件的格式
		$fileTypes = I('get.ext');

		$args['num'] = $num;
		$args['controller'] = I('get.controller');
		$args['textareaid'] = I('get.textareaid');
		$args['is_pic'] = I('get.is_pic');
		$args['ext'] = $fileTypes;
		// 初始化上传参数
		$this->assign('initupload',initupload($args));

		// 图片库
		$where['ext']= array('in',explode('|', $fileTypes));
		$where['relation'] = '';
		$files = $this->model->where($where)->order('addtime desc')->select();
		foreach($files as $k=>$v)
		{
			if(!in_array($v['ext'],explode('|', C('cfg_image'))))
				$files[$k]['filename'] ='Data/Public/admin/images/ext/'.$v['ext'].'.png';
			else
				$files[$k]['filename'] =$v['path'].'/'.$v['name'];
		}

		$this->assign('files',$files);

		$this->assign('fileTypes',$fileTypes);
		$this->assign('fileUploadLimit',$num);

		$this->assign('fileSizeLimit',get_size(314572800));

		
		$this->display();
	}

	/**
	 * [do_upload 执行上传]
	 * @return [type] [description]
	 */
	public function do_upload()
	{
		// 上传格式
		$ext = I('post.ext');
		// 要求上传的是不是图片
		$isPic = I('post.is_pic');
		//上传文件
		$upload = new Upload();             // 实例化上传类
		$upload->maxSize  = 314572800 ;     // 设置附件上传大小
		$upload->exts  = explode('|', $ext);// 设置附件上传类型
		$upload->autoSub =false;            //不要自动创建子目录
		$upload->rootPath = './Data/Uploads/'; //设置上传根路径 这个系统不会自动创建
		$rootPath = 'Data/Uploads/'; //设置上传根路径 这个系统不会自动创建
		if($isPic)
			$upload->savePath = 'image/'.date('Y').'/'.date('m').'/'.date('d').'/';
		else
			$upload->savePath = 'file/'.date('Y').'/'.date('m').'/'.date('d').'/';
		if($info=$upload->uploadOne($_FILES['Filedata']))
	    {
	    	// 上传成功服务器地址
	   	 	$pic = $upload->rootPath.$info['savepath'].$info['savename'];
	   	 	$picPath = $rootPath.$info['savepath'].$info['savename'];
	   	 	$file = pathinfo($pic);

	   	 	// 文件原名称
	   	 	$name = $_FILES['Filedata']['name'];
	   	 	$data = array(
	   	 		'remark'=>$name,
	   	 		'name'=>$file['basename'],
	   	 		'ext'=>$file['extension'],
	   	 		'path'=>$file['dirname'],
	   	 		'addtime'=>time(),
	   	 		'user_uid'=>session('user_id'),
	   	 		'size'=>filesize($pic)
	   	 	);
	   	 	
	   	 	$id  = $this->model->add($data); //添加进入数据库

	   	 	if(C('cfg_is_oss')){

	   	 		if(!empty($id)){
	   	 		$Client = new Client();
				$Client->putObject($picPath); 	//上传至OSS
	   	 		}

	   	 	}



	   	 	//图片id,图片服务器地址,是图片则是1 不是图片则用扩展名,图片原来名称
	    	$extArr = explode('|', C('cfg_image'));
	    	if(in_array($file['extension'],$extArr))
	    		echo $id.",".$pic.",1," . str_replace(array("\\", "/"), "", $name);
	    	else
	    		echo $id.",".$pic.",".$file['extension']."," . str_replace(array("\\", "/"), "", $name);

	    }
	    else
	    	exit("0,".$upload->getError());
	    die;
	}

	/**
	 * [_search 设置查询条件]
	 * @return [type] [description]
	 */
	public function _search()
	{

		$fields = $this->model->getDbFields();
		if($fields)
		{
			foreach($fields as $v)
			{
				if(I('get.'.$v))
					$map[$v] = I('get.'.$v);
			}
		}

		$keyword = I('get.keyword');
		
		if($keyword )
		{
			$map['remark'] = array('like','%'.$keyword.'%'); 
		}

		$status = I('get.status');
		switch ($status) 
		{
			
			case 2:
				$map['relation'] ='';
				break;
			case 1:
				$map['relation'] =array('neq','');
				
				break;
			
		}

		

		$startTime = I('get.start_time');
		$controllerName = strtolower(CONTROLLER_NAME);
		if($startTime)
			$map[] = $controllerName.'.addtime >= '.strtotime($startTime);
		$endTime = I('get.end_time');
		if($endTime)
			$map[] = $controllerName.'.addtime <= '.(strtotime($endTime) + 3600*24);
		$endTime = I('get.end_time');

		$ext = I('get.ext');
		if($ext)
			$map['ext'] = $ext;
		return $map;

	}

	/**
	 * [_list 列表]
	 * @return [type] [description]
	 */
	public function _list()
	{

		// 排序字段 默认为表的主键
		$order = I('post._order',$this->model->getPk());


		// 排序方式 默认为降序排列
		$sort  = I('post._sort','desc');
		// 统计
		$controllerName = strtolower(CONTROLLER_NAME);
		$dbLogic = D(CONTROLLER_NAME.'View','Logic');
		$count = $dbLogic->where($this->map)->count();
		if($count>0)
		{
			import('ORG.Util.Page');
			// 每页显示记录数
			$listRows = I('post.numPerPage',C('PAGE_LISTROWS'));
			// 实例化分页类 传入总记录数和每页显示的记录数
			$page = new \Think\Page($count,$listRows);
			// 当前页数
			$currentPage = I(C('VAR_PAGE'),1);
			// 进行分页数据查询
			$worder[$order]= $sort;


			$data = $dbLogic->where($this->map)->order($worder)->page($currentPage.','.$listRows)->select();
			foreach($data as $k=>$v)
			{
				$ext = explode('|', C('cfg_image'));
				if(in_array($v['ext'], $ext))
				{

					$data[$k]['is_jpg'] = 1;
					$data[$k]['preview']='<img src="'.__ROOT__.'/Data/Public/admin/images/ext/jpg.gif" />';
				}
				else
				{
					$data[$k]['is_jpg'] = 0;
					$data[$k]['preview']='<img src="'.__ROOT__.'/Data/Public/admin/images/ext/'.$v['ext'].'.gif"  />';
				}
			}
			// 分页显示输出
			$show = $page->show();

			//列表排序显示
			//排序图标
			$sortImg = $sort; 
			//排序提示
			$sortAlt = $sort == 'desc' ? '降序排列' : '升序排列'; 
			//排序方式
			$sort = $sort =='desc' ? 1 : 0;

			//模板赋值
			$this->assign('data',$data);
			$this->assign('sort',$sort);
			$this->assign('order',$order);
			$this->assign('sortImg',$sortImg);
			$this->assign('sortType',$sortAlt);
			$this->assign('page',$show);
			$this->assign('totalCount',$count);
			$this->assign('numPerPage',$listRows);
			$this->assign('currentPage',$currentPage);
		}
	}

	/**
	 * [bathdelete 批量删除]
	 * @return [type] [description]
	 */
	public function bathdelete()
	{
		$id = I('post.id');

		$id = implode(',', $id);
	
		$this->model->del($id);
		$this->success('删除成功',U('index'));
	}
	
  
}