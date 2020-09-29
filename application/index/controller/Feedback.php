<?php
namespace app\index\controller;

/**
* 留言控制器
*/
class Feedback extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
		$this->model = model('common/feedback');
	}

	function index(){
		$feedbacks = $this->model->get_list('','id desc',15,1);
		return view('index',['lists'=>$feedbacks,'page'=>$feedbacks->render()]);
	}

	/*function add(){
		if(request()->isPost()){
			$params = input('post.');
			$result = $this->model->add($params);
			if($result){
				return json(array('code'=>200,'msg'=>'留言成功'));
			}else{
				return json(array('code'=>0,'msg'=>'留言失败'));
			}
		}
	}*/

}