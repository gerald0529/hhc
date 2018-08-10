<?php
/** [广告]
 * @Author: 976123967@qq.com
 * @Date:   2015-04-20 21:45:10
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-27 14:30:36
 */
namespace Common\Service;
use Think\Model;
class AirlinesService extends Model{
	
	/**
	 * [get_airlines 显示客服 airlines标签]
	 * [lang en ch 语言版本 默认中文]
	 */
	public function get_airlines($lang)
	{

		// 排序
		$order = 'sort asc ,id desc';
	
		$data = D('Airlines')->order($order)->select();

		if(!$data) return $data;

		$html = '';
		$html_en = '';

		foreach($data as $k=>$v)
		{
			if(!empty($v['name']) && !empty($v['account']) ){
				$html .= $v['url']; 
				$html_en .= $v['url_en'];
			}
			
		}

		if($lang == 'en'){
			return $html_en;
		}else{
			return $html;
		}

	}
}