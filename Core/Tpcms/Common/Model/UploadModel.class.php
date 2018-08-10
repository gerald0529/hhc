<?php
/**附件表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-22 11:48:20
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-06 22:56:59
 */
namespace Common\Model;
use Think\Model;
use OSS\Client;
class UploadModel extends Model{

	/**
	 * [update_uoload_attachment 更新]
	 * @param  [type] $data [description]
	 * @return [type]      [description]
	 */
	public function update_uoload_attachment($data)
	{
		//p($_SESSION['keditor']);
		// 必须有上传附件
		if(isset($_SESSION['keditor']))
		{
			$uploadModel = D('Upload');
			// 遍历session 更新关联
			foreach($_SESSION['keditor'] as $v)
			{
				$uploadModel->save(array('relation'=>$data['aid'],'type'=>'articlepic','id'=>$v));
			}
		}
		// 清空
		unset($_SESSION['keditor']);
	}

	/**
	 * [delete_upload_by_article_aid 删除附件通过关联外键article_aid]
	 * @param  [type] $aid [description]
	 * @return [type]      [description]
	 */
	public function delete_upload_by_article_aid($aid)
	{	
		
		$where['relation']= $aid;
		$where[]='type="article" or type="editor" or type="articlepic"';
		$data = $this->where($where)->select();
		if(!$data)
			return;
		foreach($data as $v)
		{
			$fullPath = $v['path'].'/'.$v['name'];
			is_file($fullPath) && unlink($fullPath);

			$info = pathinfo($fullPath);
			$medium=$info['dirname'] . '/' .$info['filename']."_medium.".$info['extension'];
        	$small = $info['dirname'] . '/' .$info['filename']."_small.".$info['extension'];
        		
        	is_file($medium) && unlink($medium);
        	is_file($small) && unlink($small);

        	if(C('cfg_is_oss')){

        		$Client = new Client();
        		$Client->deleteObject(ltrim($medium,'./'));
        		$Client->deleteObject(ltrim($small,'./'));
        	}
        	

		}
		$this->where(array('relation'=>$aid))->delete();
	}


	/**
	 * [del 删除]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function del($id)
	{	
		
		$ids = explode(',',$id);
		foreach($ids as $id)
		{
			$file = $this->find($id);
			$fullPath = $file['path'].'/'.$file['name'];
			
			if(is_file($fullPath) && unlink($fullPath)){
				$this->delete($id);
				if(C('cfg_is_oss')){

					$Client = new Client();
					$Client->deleteObject(ltrim($fullPath,'./'));
				}
			};

			 	//上传至OSS
		}
		return true;
	}


	
}