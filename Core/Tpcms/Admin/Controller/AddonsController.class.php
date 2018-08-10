<?php
/**
 * 扩展控制器
 * 用于调度各个扩展的URL访问需求
 */
namespace Admin\Controller;
use Third\Dir;
class AddonsController extends PublicController{

	protected $addons = null;

    /**
     * [lists 插件列表]
     * @return [type] [description]
     */
    public function lists()
    {
        $dirs = Dir::tree('Core/Addons');
        $data  = $this->model->getField('remark',true);


        foreach ($dirs as $tpl)
        {
            
            if(!is_dir($tpl['path'])) continue;
            $class = get_addon_class($tpl['name']);
            $addon  =   new $class();
            $plugin = $addon->info;

            $plugin['install'] = 0;
            $plugin['addtime'] = 0;
            $plugin['filemtime'] = $tpl['filemtime'];

            if(in_array_case($tpl['name'], $data))
            {
                $plugin['install']  = 1;
                $plugin['addtime']  = $this->model->where(array('name'=>$tpl['name']))->getField('addtime');
            }
          

           $lists[] = $plugin;
        }
   

        $this->assign('data',$lists);
       
        $this->display();
    }




	 /**
     * 插件后台显示页面
     * @param string $name 插件名
     */
    public function index($name)
    {
       
        $class = get_addon_class($name);
        if(!class_exists($class))
            $this->error('插件不存在');
        $addon  =   new $class();
        $this->assign('addon', $addon);
        $param  =   $addon->admin_list;
        if(!$param)
            $this->error('插件信息不正确');
        extract($param);
        $this->assign($param);

        if(!isset($model))
             $this->error('插件信息不正确');
        if(!isset($order))
            $this->error('插件信息不正确');
        if(!isset($map))
            $map = array();
         if(!isset($fields))
            $fields = '*';

        foreach($map as $v)
        {
            if(I('get.'.$v))
                $search[$v]= I('get.'.$v);   
        }
        $db = D('Addons://'.$name.'/'.$model);
        $count = $db->where($search)->count();

        $page = new \Think\Page($count,20);
        $data = $db->field($fields)->where($search)->order($order)->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('page',$page->show());
        $this->assign('data', $data);
        if($addon->custom_adminlist)
            $this->assign('custom_adminlist', $this->fetch($addon->addon_path.$addon->custom_adminlist));
        $this->display();
    }

    /**
     * [add 信息添加]
     */
    public function add($name)
    {
       
        $class = get_addon_class($name);
        if(!class_exists($class))
            $this->error('插件不存在');
        $addon  =   new $class();
        $this->assign('addon', $addon);
        $param  =   $addon->admin_list;
        if(!$param)
            $this->error('插件列表信息不正确');
        extract($param);

        $this->assign($param);
        
        
        $this->assign('custom_adminadd', $this->fetch($addon->addon_path.$addon->custom_adminadd));
        $this->display();
    }

    /**
     * [edit 信息编辑]
     */
    public function edit($name)
    {
       

        $class = get_addon_class($name);
        if(!class_exists($class))
            $this->error('插件不存在');
        $addon  =   new $class();
        $this->assign('addon', $addon);
        $param  =   $addon->admin_list;
        if(!$param)
            $this->error('插件列表信息不正确');
        extract($param);
        $this->assign($param);
         $db = D('Addons://'.$name.'/'.$model);
        $id = $db->getPk();
        $id = I('get.'.$id);
        $data = $db->find($id);
        $this->assign('data',$data);
        
        $this->assign('custom_adminedit', $this->fetch($addon->addon_path.$addon->custom_adminedit));
        $this->display();
    }



    /**
     * [install 执行安装]
     * @return [type] [description]
     */
    public function install()
    {
    
        $remark = I('get.remark');
        $path = 'Core/Addons/'.$remark;
        if(!is_dir($path))
            $this->error('插件不存在');
        $status  = $this->model->where(array('remark'=>$remark))->count();
        if($status)
            $this->error('已经安装');

        
        // 安装sql
        $dbPrefix = C('DB_PREFIX');
        $install = $path.'/Config/install.sql';
        if(!is_file($install))
            $this->error('缺少install.sql文件');
        $sql = file_get_contents($install);

        $sql =preg_split('/;{}/', $sql);
        $db  = M();
        foreach ($sql as $k => $v) 
        {
            
            
            $temp=array();
            // 过滤注释
            $preg="/(\/\*.*\*\/)/isU";
            preg_match_all($preg, trim($v),  $temp);
            $v=str_replace($temp[1], '', $v);
            // 过滤注释
            $preg="/(--.*\r\n)/isU";
            preg_match_all($preg, trim($v),  $temp);
            $v=str_replace($temp[1], '', $v);
            // 替换表前缀
            $v=str_replace('thinkcms_', $dbPrefix, $v);
            // 执行mysql
          

            if($v)
                $db->execute($v);
            
        } 
            


        // 插入数据
        $class = get_addon_class($remark);
        $addon  =   new $class();
        $info = $addon->info;

        $data = array(
            'remark'=>$remark,
            'name'=>$info['title'],
            'addtime'=>time(),
            'user_uid'=>session('user_id'),
        );
        $this->model->add($data);
        S('hooks',null);
        $this->success($info['title'].'插件安装成功',U('lists'));
        
    }


    /**
     * [uninstall 卸载]
     * @return [type] [description]
     */
    public function uninstall()
    {
        $remark = I('get.remark');
        $path = 'Core/Addons/'.$remark;
        if(!is_dir($path))
            $this->error('插件不存在');
     
        $status  = $this->model->where(array('remark'=>$remark))->count();
        if(!$status)
            $this->error('插件未安装');


        // 删除sql
        $dbPrefix = C('DB_PREFIX');
        $uninstall = $path.'/Config/uninstall.sql';
        if(!is_file($uninstall))
            $this->error('缺少uninstall.sql文件');
        $sql = file_get_contents($uninstall);
        $sql =preg_split('/;{}/', $sql);
        $db  = M();
        foreach ($sql as $k => $v) 
        {
            
            
            $temp=array();
            // 过滤注释
            $preg="/(\/\*.*\*\/)/isU";
            preg_match_all($preg, trim($v),  $temp);
            $v=str_replace($temp[1], '', $v);
            // 过滤注释
            $preg="/(--.*\r\n)/isU";
            preg_match_all($preg, trim($v),  $temp);
            $v=str_replace($temp[1], '', $v);
            // 替换表前缀
            $v=str_replace('thinkcms_', $dbPrefix, $v);
            // 执行mysql
          

            if($v)
            {
                $db->execute($v);
            }
            
        } 
            



        $class = get_addon_class($remark);
        $addon  =   new $class();
        $info = $addon->info;
       
        // 删除数据
        $this->model->where(array('remark'=>$remark))->delete();
        S('hooks',null);
        $this->success($info['title'].'插件卸载成功',U('lists'));
    }


    /**
     * [info 插件详细说明]
     * @return [type] [description]
     */
    public function info()
    {
        $remark = I('get.remark'); 
       

        
        // 插入数据
        $class = get_addon_class($remark);
        $addon  =   new $class();
        $data = $addon->info;
        $data['call'] = '{:HOOK(\''.strtolower($remark).'\')}';
     

        $status  = $this->model->where(array('remark'=>$remark))->count();

        $data['install'] = 0;
        $data['addtime'] = 0;
        if($status)
        {
            $data['install']  = 1;
            $data['addtime']  = $this->model->where(array('remark'=>$remark))->getField('addtime');
        }
    
        $this->assign('data',$data);
        $this->display();
    }




	public function execute($_addons = null, $_controller = null, $_action = null)
    {
		if(C('URL_CASE_INSENSITIVE')){
			$_addons = ucfirst(parse_name($_addons, 1));
			$_controller = parse_name($_controller,1);
		}

		if(!empty($_addons) && !empty($_controller) && !empty($_action)){
			$Addons = A("Addons://{$_addons}/{$_controller}")->$_action();
		} else {
			$this->error('没有指定插件名称，控制器或操作！');
		}
	}




}
