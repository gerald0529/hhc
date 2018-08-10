<?php
/**风格管理控制器
 * @Author: cl
 * @Date:   2015-07-24 23:25:25
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-25 23:20:16
 */
namespace Admin\Controller;
use Third\Dir;
use Third\Xml;
class TemplatesController extends PublicController{
	public function index()
	{
		$dirs = Dir::tree('Templates');
		foreach ($dirs as $tpl)
		{
			if(!is_dir($tpl['path'])) continue;
            $xml = $tpl['path'] . '/config.xml';
            if (!is_file($xml)){
                continue;
            }
            if (!$config = Xml::toArray(file_get_contents($xml))){
                continue;
            }
            $tpl['filename'] = $tpl['name'];
            $tpl['name'] = isset($config['name']) ? $config['name'][0] : ''; //模型名
            $tpl['author'] = isset($config['author']) ? $config['author'][0] : ''; //作者
            $tpl['image'] =  isset($config['image'])?__ROOT__.'/Templates/'.$tpl['filename'].'/'.$config['image'][0] :__ROOT__.'/Core/Tpcms/'.MODULE_NAME.'/View/Public/images/preview.jpg'; //预览图
           
            $tpl['email'] = isset($config['email']) ? $config['email'][0] : ''; //邮箱
            $tpl['current'] = C("WEB_STYLE") == $tpl['filename'] ? 1 : 0; //正在使用的模板
            $style[] = $tpl;
        }
        $this->assign('data',$style);
        $this->assign('count',count($style));
		$this->display();
	}


    public function set_templates()
    {

        $data['WEB_STYLE'] = I('get.filename');
        if(C("WEB_STYLE")==$data['WEB_STYLE'])
            $this->error('没有任何改变',U('index'));
        file_put_contents('./Data/Config/theme.inc.php', "<?php\n return ".var_export($data,true).";");
        session('curTheme',$data['WEB_STYLE']);
        $this->success('风格设置成功',U('index'));
    }
}