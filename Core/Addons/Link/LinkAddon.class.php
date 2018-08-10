<?php
/**
 * @Author: cl
 * @Date:   2015-08-09 11:44:51
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-11 00:13:06
 */
namespace Addons\Link;
use Common\Controller\Addon;
class LinkAddon extends Addon{
	public $info = array(
		'name'        => 'Link',
		'title'       => '友情链接',
		'description' => '网站友情链接',
		'content'	  => '网站友情链接',
		'author'      => '快乐源泉',
		'version'     => '1.0'
	);


	public $admin_list = array(
		'fields'=>'lid,name,sort,url,sort,addtime,logo',
		'model'=>'Link',
		'order'=>'sort asc,lid desc',
		'map'=>array('verifystate'),
	);


	// 后台编辑模板
	public $custom_adminlist = 'admin/index.html';
	public $custom_adminadd  = 'admin/add.html';
	public $custom_adminedit = 'admin/edit.html';



	/**
	 * [link 实现钓子link方法]
	 * @return [type] [description]
	 */
	public function link()
    {
    	
    	$linkModel = D('Addons://Link/Link');
        $type = I('get.type');
        if($type==1)
             $where['logo']= array('neq','');  
        $where['verifystate']=2;
        $data = $linkModel->where($where)->select();
    	if($data)
    	{
    		foreach ($data as $k=> $v) 
    		{
    			 $data[$k]['logo'] = __ROOT__.'/'.$v['logo'];
    		}
    	}
    	$class = get_addon_class('Link');
    	$addon =   new $class();
    	$this->assign('data',$data);
        $this->display('index/index');

    }



}