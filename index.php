<?php
/**[入口文件]
 * @Author: happy
 * @Email:  976123967@qq.com
 * @Date:   2015-05-01 15:34:59
 * @Last Modified by:   chen
 * @Last Modified time: 2015-08-20 21:35:15
 */

if(!file_exists('Data/Config/db.inc.php')) 
{
	header("location:install.php");
	die;
}
define('THINK_PATH','./Core/ThinkPHP/');
define('APP_NAME','Tpcms');
define('APP_PATH','./Core/Tpcms/');
define('RUNTIME_PATH',"./Data/Runtime/");
define('APP_DEBUG',true);
define('ADDON_PATH',dirname(__FILE__).'/Core/Addons/');
define('THIRD','Core/Third/');
require THINK_PATH.'ThinkPHP.php';