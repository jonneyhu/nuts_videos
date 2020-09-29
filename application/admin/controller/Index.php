<?php
namespace app\admin\controller;

/**
* 后台主页控制器
*/
class Index extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
	}

	function index()
	{
		return view('index');
	}

	function home()
	{	
		return view('home');
	}
	function ajax_system_info(){
		mysqli_connect(config('database.hostname'),config('database.username'),config('database.password')); 
		$msyql_info = version_compare(phpversion(), '7.0.0') > -1 ? @mysqli_get_server_info() : @mysql_get_server_info();;
		$system_info = array();
		$system_info['os_info'] = php_uname('s');
		$system_info['web_info'] = function_exists('apache_get_version')?apache_get_version():$_SERVER["SERVER_SOFTWARE"];
		$system_info['php_info'] = phpversion();
		$system_info['mysql_info'] = 'MySQL '.$msyql_info;
		$system_info['upload_size_info'] = ini_get('upload_max_filesize');;
		$system_info['post_size_info'] = ini_get('post_max_size');

		return json(array('code'=>200,'msg'=>'请求系统信息成功','data'=>$system_info));
	}
}