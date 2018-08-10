<?php
/**数据库备份控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-24 17:57:53
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-28 11:24:01
 */
namespace Admin\Controller;
use Third\Backup;
use Third\Dir;
class BackupController extends PublicController{


	public function add()
	{
		//数据库中所有表的信息
		$data = Backup::getAllTableInfo();
		//p($data);die;
		$this->assign('data',$data);
		$this->display();
	}

    /**
     * [backup 备份]
     * @return [type] [description]
     */
	public function backup()
	{
	
		$size= I('get.size');
		if(!$size)
			$this->error('请输入分卷大小');
		$result = Backup::backup(
            array(
                
				'database'=>C('DB_NAME'),
				'size'=>I('get.size'),
				'dir'=>'./Data/Backup/'.date('YmdHis').'/',
				'url'=>U('index'),
				'step_time'=>500,
            )
        );

      
        if ($result === false) 
        {
            //备份发生错误
            $this->error(Backup::$error, U('index'));
        } 
        else 
        {
            if ($result['status'] == 'success') 
            {
                //备份完成
                $this->success($result['message'],U('index'));
            } 
            else
            {
                //备份过程中
                $this->success($result['message'], $result['url']);
            }
        }
	}

    /**
     * [index 备份列表]
     * @return [type] [description]
     */
	public function index()
	{
		$data = Dir::tree('./Data/Backup/');
		$this->assign('data',$data);
		$this->display();
	}

    public function del()
    {
        $dir = I('get.dir');
        $dir = 'Data/Backup/'.$dir;
        if(!is_dir($dir))
            $this->error('备份不存在');
        Dir::del($dir);
        $this->success('备份删除成功');
    }

    /**
     * [recover 还原列表]
     * @return [type] [description]
     */
	public function recover()
	{
		$dir = I('get.dir');
		$result = Backup::recovery(array('dir'=>'Data/Backup/'.$dir,'url'=>__ACTION__));
		
		if ($result === false)
		{
		  	//还原发生错误
            $this->error(Backup::$error,U('index'));
        } 
        else 
        {
            if ($result['status'] == 'success') 
            {
            	//还原完毕
                $this->success($result['message'],U('index') );
            } 
            else 
            {	
            	//还原运行中...
                $this->success($result['message'], $result['url']);
            }
        }
	}
	
	
	/**
	 * [optimize 优化数据表]
	 * @return [type] [description]
	 */
	public function optimize()
	{
		
		if(IS_AJAX)
		{
			$table = I('post.table');
		
			if($table)
			{
				$db = M();
				foreach($table as $v)
				{
					$db->execute("OPTIMIZE TABLE `" .  $v . "`");
				}
				$this->ajaxReturn(array('status'=>1,'info'=>'优化成功'));
			}
			
			else
			{
				$this->ajaxReturn(array('status'=>0,'info'=>'优化失败'));
			}
			
		}
		else
		{
			$table = I('get.table');
			if(!$table)
				$this->error('数据表名选择不正确');
			$db = M();
			$db->execute("OPTIMIZE TABLE `" .  $table . "`");
			$this->success('优化成功');
			
		}
		
	}
	/**
	 * [repair 修复数据表]
	 * @return [type] [description]
	 */
	public function repair()
	{
		
		if(IS_AJAX)
		{
			$table = I('post.table');
			if($table)
			{
				$db = M();
				foreach($table as $v)
				{
					$db->execute("REPAIR TABLE `" .  $v . "`");
				}
				$this->ajaxReturn(array('status'=>1,'info'=>'修复成功'));
			}
			
			else
			{
				$this->ajaxReturn(array('status'=>0,'info'=>'修复失败'));
			}
			
		}
		else
		{
			$table = I('get.table');
			if(!$table)
				$this->error('数据表名选择不正确');
			$db = M();
			$db->execute("REPAIR TABLE `" .  $table . "`");
			$this->success('修复成功');
			
		}
		
	}

}