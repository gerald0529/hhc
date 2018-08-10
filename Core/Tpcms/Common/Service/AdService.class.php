<?php
/** [广告]
 * @Author: 976123967@qq.com
 * @Date:   2015-04-20 21:45:10
 * @Last Modified by:   Administrator
 * @Last Modified time: 2015-07-27 14:30:36
 */
namespace Common\Service;
use Think\Model;
class AdService extends Model{
	
	/**
	 * [show_ad 显示广告 showad标签]
	 * @param  [type] $psid [description]
	 * @param  [type] $row  [description]
	 * @return [type]       [description]
	 */
	public function show_ad($psid,$row)
	{
		$where['verifystate'] = 2;  //审核通过
		$where['position_psid'] = $psid;  //广告位置


		// 排序
		$order = 'ad.sort asc ,aid desc';

		// 字段
		$field ='sort,verifystate,aid,position_psid,position_name,name,username,addtime,pic,url,info,info2,name_en,info_en,info_en2,pic_en';
	
		$data = D('AdView','Logic')->where($where)->limit($row)->order($order)->field($field)->select();

		if(!$data) return $data;
		foreach($data as $k=>$v)
		{
			// 图片
			$data[$k]['pic']= $v['pic']?__ROOT__.'/'.$v['pic']:__ROOT__.'/Data/Image/default.gif';
		 	$data[$k]['pic_en']= $v['pic_en']?__ROOT__.'/'.$v['pic_en']:__ROOT__.'/Data/Public/images/default.gif';
			// 添加时间
			$data[$k]['addtime']=date('Y-m-d',$v['addtime']);
		}

		return $data;
	}
}