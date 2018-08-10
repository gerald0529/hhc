<?php
/**QQ客服控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-22 17:38:17
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-22 21:18:31
 */
namespace Admin\Controller;
class AirlinesController extends PublicController{

	public function _initialize(){

		parent::_initialize();
		$this->model = D('Airlines');

	}

	Public function index(){

	if(I('get.keyword')){
		$keyword = I('get.keyword');
		$where['name'] = array('like','%'.$keyword.'%');
	}else{
		$where = null;
	}

	$count      = $this->model->where($where)->count();// 查询满足要求的总记录数
	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	$show       = $Page->show();// 分页显示输出
	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	$list = $this->model->where($where)->order('sort ASC,id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
	$this->assign('data',$list);// 赋值数据集
	$this->assign('page',$show);// 赋值分页输出
	$this->display(); // 输出模板

	}

	public function add(){


		if(IS_POST){

			$data = $this->get_url($_POST);

			if(!$this->model->create($data)){
				$this->error($this->model->getError());
			}

			if(!$this->model->add()){
				$this->error('添加失败');
			}

			$this->success('添加成功',U('Airlines/index'));

		}else{
			$this->display();
		}
		
		
	}


	public function edit(){

		if(IS_POST){

			$id = I('get.id');
			$id = !empty($id) ? $id : I('post.id');
			$where['id'] = $id;

			$data = $this->get_url($_POST);

			$row = $this->model->where($where)->save($data);
			$this->success('编辑成功',U('index'));

		}else{

			$data = $this->model->get_one();
			$this->assign('data',$data);
			$this->display();

		}


	}

	public function del(){

		$id = I('get.id');
		$id = !empty($id) ? $id : I('post.id');

		$where['id'] = $id;

		$this->model->where($where)->delete();
		$this->success('删除成功');

	}

	public function get_url($data){

		$data['pic'] = "/Data/Public/images/".$data['type'].'.gif';
		$pic = __ROOT__.'/'.$data['pic'];

		switch ($data['type']) {
				case 'qq':
					$data['url'] = "<li><a class=icoTc href=http://wpa.qq.com/msgrd?v=3&uin=$data[account]&menu=yes target=\"_blank\"><img width=20 border=0 src=http://wpa.qq.com/pa?p=2:$data[account]:45 alt=$data[name] hspace=5 title=$data[name] align=absmiddle>$data[name]</a></li>";
					$data['url_en'] = "<li><a class=icoTc href=http://wpa.qq.com/msgrd?v=3&uin=$data[account]&menu=yes target=\"_blank\"><img width=20 border=0 src=http://wpa.qq.com/pa?p=2:$data[account]:45 alt=$data[name_en] hspace=5 title=$data[name_en] align=absmiddle>$data[name_en]</a></li>";
					break;
				
				case 'msn':
					$data['url'] = "<li><a class=icoTc href='msnim:chat?contact=$data[account]' title=$data[name] target=''><img width=20 src='$pic' hspace= 5 align='absmiddle'/>$data[name]</a></li>";
					$data['url_en'] = "<li><a class=icoTc href='msnim:chat?contact=$data[account]' title=$data[name_en] target=''><img width=20 src='$pic' hspace= 5 align='absmiddle'/>$data[name_en]</a></li>";	
					break;

				case 'skype':
					$data['url'] = "<li><a class=icoTc href='skype:$data[account]?call' target='_blank' title=$data[name]><img width=20 src='$pic' hspace= 5 align='absmiddle'/>$data[name]</a></li>";	
					$data['url_en'] = "<li><a class=icoTc href='skype:$data[account]?call' target='_blank' title=$data[name_en]><img width=20 src='$pic' hspace= 5 align='absmiddle'/>$data[name_en]</a></li>";	
					break;

				case 'email':
					$data['url'] = "<li><a class=icoTc href='mailto:$data[account]' title=$data[name]><img width=20 src='$pic' hspace= 5 align='absmiddle'/>$data[name]</a></li>";
					$data['url_en'] = "<li><a class=icoTc href='mailto:$data[account]' title=$data[name_en]><img width=20 src='$pic' hspace= 5 align='absmiddle'/>$data[name_en]</a></li>";
					break;

				case 'wangwang':
					$data['url'] = "<li><a class=icoTc target='_blank' href='http://www.taobao.com/webww/ww.php?ver=3&touid=$data[account]&siteid=cntaobao&status=1&charset=utf-8'><img border='0' style='vertical-align:middle;padding-top:10px;' src='http://amos.im.alisoft.com/online.aw?v=2&uid=$data[account]&site=cntaobao&s=4' alt='$data[name]'></a></li>";
					$data['url_en'] = "<li><a class=icoTc target='_blank' href='http://www.taobao.com/webww/ww.php?ver=3&touid=$data[account]&siteid=cntaobao&status=1&charset=utf-8'><img border='0' style='vertical-align:middle;padding-top:10px;' src='http://amos.im.alisoft.com/online.aw?v=2&uid=$data[account]&site=cntaobao&s=4' alt='$data[name_en]'></a></li>";
					break;

				case 'alibaba':
					$data['url'] = "<li><a class=icoTc target=\"_blank\" href=\"http://web.im.alisoft.com/msg.aw?v=2&uid=$data[account]&site=cnalichn&s=10\" ><img border=\"0\" src=\"http://web.im.alisoft.com/online.aw?v=2&uid=$data[account]&site=cnalichn&s=10\" style='vertical-align:middle;padding-top:10px;' alt=\"点击这里给我发消息\" /></a></li>";
					$data['url_en'] = "<li><a class=icoTc target=\"_blank\" href=\"http://web.im.alisoft.com/msg.aw?v=2&uid=$data[account]&site=cnalichn&s=10\" ><img border=\"0\" src=\"http://web.im.alisoft.com/online.aw?v=2&uid=$data[account]&site=cnalichn&s=10\" style='vertical-align:middle;padding-top:10px;' alt=\"Click here to send a message to me\" /></a></li>";
					break;
			}
			
			return $data;
	}

}