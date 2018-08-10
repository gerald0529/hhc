<?php
/**钓子行为扩展
 * @Author: cl
 * @Date:   2015-08-09 11:44:51
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-11 00:33:52
 */
namespace Common\Behavior;
use Think\Behavior;
use Think\Hook;
defined('THINK_PATH') or exit();

// 初始化钩子信息
class InitHookBehavior extends Behavior {

    // 行为扩展的执行入口必须是run
    public function run(&$content)
    {
     
        $data = S('hooks');

        if(!$data)
        {
            // 读取已经安装的插件
            $addons = M('Addons')->getField('remark',true);
            foreach ($addons as $k=> $v) 
            {
               //处理插件路径
               $class = get_addon_class($v);
               $method = strtolower($v); 
               // 动态添加钓子   
               Hook::add($method,$class); 
            } 

       
            // 缓存  
            S('hooks',Hook::get());
        }
        else
        {
            // 批量导入钓子
            Hook::import($data,false);
        }
    }
}