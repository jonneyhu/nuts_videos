<?php
namespace app\admin\controller;

/**
* 
*/
class Admin extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
		$this->model = model('admin');
	}

	function edit(){
		if(request()->isPost()){
			$params = input('post.');
			$params['encrypt'] = random(8);
			if(isset($params['password']) && !empty($params['password'])){
				$params['password'] = strtolower(md5(md5($params['password']).$params['encrypt']));
			}else{
				unset($params['password']);
			}
			$result = $this->model->edit($params);
			if($result){
				/*if(isset($params['password']) && !empty($params['password'])){
					session('admin_user',null);
				}*/
				return json(array('code'=>200,'msg'=>'修改成功'));
			}else{
				return json(array('code'=>0,'msg'=>'修改失败'));
			}
		}
		return view('edit');
	}

}