<?php
namespace app\admin\controller;

use think\Controller;

/**
* admin模块基础类
*/
class Init extends Controller
{
	
	function _initialize()
	{
		parent::_initialize();
		if(!cache('models')){model('common/category')->cache_models();}
		if(!cache('categorys')){model('common/category')->cache_category();}
		if(!cache('settings')){model('common/setting')->cache_setting();}
		if(!session('?admin_user') && strtolower(request()->controller()) != 'login'){
			$this->redirect('login/login');
		}
		$this->settings = cache('settings');
		$this->categorys = cache('categorys'); 
		$admin_user = model('admin')->get(session('admin_user.id'));
		// 发送基本信息
		$this->assign(['settings' => $this->settings,'categorys' => $this->categorys,'admin_user' => $admin_user]);
	}


}