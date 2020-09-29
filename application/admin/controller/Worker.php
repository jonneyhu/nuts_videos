<?php
namespace app\admin\controller;

/**
* 员工控制器
*/
class Worker extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
		$this->model = model('common/worker');
		$this->category_model = model('common/category');
	}

	function index(){
		$params = input('param.');
		$category_id = $params['category_id'];
		$page_size = isset($params['limit'])?$params['limit']:15;
		$map = array('category_id'=>$category_id);
		$order = array('sort'=>'asc'); 
		if(isset($params['search']) && is_array($params['search'])){
			foreach ($params['search'] as $k => $v) {
				if($v){
					$map[$k] = array('like','%'.$v.'%'); 
				}
			}
		}
		$url_params_arr = url_params_unique(request()->except(['category_id']));
		$url_params_str = format_url_params($url_params_arr);
		$order = isset($url_params_arr['order'])?$url_params_arr['order']:[];
		$workers = $this->model->get_list($map,$order,$page_size);
		return view('list',['category_id'=>$category_id,'workers'=>$workers,'url_params_arr'=>$url_params_arr,'url_params_str'=>$url_params_str]);
	}

	function add(){
		if(request()->isPost()){
			$params = input('post.');
			$result = $this->model->add($params);
			if($result){
				return json(array('code'=>200,'msg'=>'添加成功'));
			}else{
				return json(array('code'=>0,'msg'=>'添加失败'));
			}
		}
		$category_id = input('param.category_id'); 
		$model_category_select_option = $this->category_model->get_model_category_select_with_option($category_id);
		return view('add',['category_id'=>$category_id,'model_category_select_option'=>$model_category_select_option]);
	}

	function edit(){
		if(request()->isPost()){
			$params = input('post.');
			$result = $this->model->edit($params);
			if($result){
				return json(array('code'=>200,'msg'=>'修改成功'));
			}else{
				return json(array('code'=>0,'msg'=>'修改失败'));
			}
		}
		$worker = $this->model->where('id',input('param.id'))->find();
		$model_category_select_option = $this->category_model->get_model_category_select_with_option($worker['category_id']);
		return view('edit',array('worker'=>$worker,'model_category_select_option'=>$model_category_select_option));
	}

	function del(){
		$result = $this->model->del(input('post.id'));
		if($result){
			return json(array('code'=>200,'msg'=>'删除成功'));
		}else{
			return json(array('code'=>0,'msg'=>'删除失败'));
		}
	}

	//批量删除
	function batches_delete(){
		$params = input('post.');
		$ids =  $params['ids'];
		$result = $this->model->del($ids);
		if($result){
			return json(array('code'=>200,'msg'=>'批量删除成功'));
		}else{
			return json(array('code'=>0,'msg'=>'批量删除失败'));
		}
	} 

	//批量移动
	function batches_move(){
		$params = input('post.');
		$result = $this->model->move($params['ids'],$params['to_category_id']);
		if($result){
			return json(array('code'=>200,'msg'=>'批量移动成功'));
		}else{
			return json(array('code'=>0,'msg'=>'批量移动失败'));
		}
	} 

	//显示
	function to_show(){ 
		$id = input('post.id');
		$data['id'] = $id;
		$data['is_show'] = array('exp','1-is_show');
		$result = $this->model->edit($data);
		if($result){
			return json(array('code'=>200,'msg'=>'操作成功'));
		}else{
			return json(array('code'=>0,'msg'=>'操作失败'));
		}
	}


}