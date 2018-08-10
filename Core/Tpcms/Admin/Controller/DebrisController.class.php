<?php
/**碎片数据控制器
 * @Author: 976123967@qq.com
 * @Date:   2015-07-22 17:38:17
 * @Last Modified by:   cl
 * @Last Modified time: 2015-07-22 21:18:31
 */
namespace Admin\Controller;
class DebrisController extends PublicController{

	public function _initialize(){

		parent::_initialize();
		$this->model = D('Debris');

	}

	Public function index(){

	if(I('get.keyword')){
		$keyword = I('get.keyword');
		$where['title'] = array('like','%'.$keyword.'%');
	}else{
		$where = null;
	}
		
	$count      = $this->model->where($where)->count();// 查询满足要求的总记录数
	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	$show       = $Page->show();// 分页显示输出
	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	$list = $this->model->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
	$this->assign('data',$list);// 赋值数据集
	$this->assign('page',$show);// 赋值分页输出
	$this->display(); // 输出模板

	}

	public function add(){


		if(IS_POST){

			if(!$this->model->create()){
				$this->error($this->model->getError());
			}

			if(!$this->model->add()){
				$this->error('添加失败');
			}

			$this->success('添加成功',U('Debris/index'));

		}else{

			$body =  keditor(array('name'=>'body','content'=>''));
			$body_en =  keditor(array('name'=>'body_en','content'=>''));
			$this->assign('body',$body);
			$this->assign('body_en',$body_en);

		}
		
		$this->display();
	}


	public function edit(){

		if(IS_POST){

			$id = I('get.id');
			$id = !empty($id) ? $id : I('post.id');
			$where['id'] = $id;

			$row = $this->model->where($where)->save($_POST);
			$this->success('编辑成功',U('index'));

		}else{

			$data = $this->model->get_one();

			$body =  keditor(array('name'=>'body','content'=>$data['body']));
			$body_en =  keditor(array('name'=>'body_en','content'=>$data['body_en']));
			$this->assign('body',$body);
			$this->assign('body_en',$body_en);

			$this->assign('data',$data);

		}

		$this->display();

	}

	public function del(){

		$id = I('get.id');
		$id = !empty($id) ? $id : I('post.id');

		$where['id'] = $id;

		$this->model->where($where)->delete();
		$this->success('删除成功');

	}

}