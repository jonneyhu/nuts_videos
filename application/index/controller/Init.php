<?php
namespace app\index\controller;

use think\Controller;

/**
* index模块基础类
*/
class Init extends Controller
{
	function __construct()
    {
    	$request = request();
    	$this->settings = cache('settings');
    	$view_path = 'default';
    	if($this->settings['wap_enabled'] && $request->isMobile() === TRUE){
            if($this->settings['wap_jump'] && $this->settings['wap_domain'] && stripos(strtolower($_SERVER['HTTP_HOST']), $this->settings['wap_domain']) === FALSE) {
				$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				$url = str_replace($_SERVER['HTTP_HOST'],$this->settings['wap_domain'],$url);
                $this->redirect((is_ssl() ? 'https://' : 'http://').$url);
            }
            define('IS_MOBILE', TRUE);
    		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') != false ){
                define('IS_WECHAT',TRUE);
            }
            $view_path = 'wap';
		}else{
			$view_path = 'pc';
		}
		//动态配置模板
		config('template.view_path','./template/'.$view_path.'/');
		config('view_replace_str.__TEMPLATE__','/template/'.$view_path.'/');
        parent::__construct($request);
    }
    
	function _initialize()
	{
		parent::_initialize();
		error_reporting(0);
		$this->settings = cache('settings');
		if(!session('?admin_user') && $this->settings['site_status'] == 1){
			exit('<meta charset="UTF-8"><p style="text-align:center;font-size:42px;color:#f00;line-height:60px;font-weight:bold;padding-top:100px;margin-bottom:0">网站暂时关闭...</p><p style="width:500px;margin:0 auto;padding:20px;line-height24px;font-weight:bold;">关闭原因：'.$this->settings['site_closedreason'].'</p>');
		}
		$this->categorys = cache('categorys');
		$this->models = cache('models');
		/*$search_model_ids = explode(',', $this->settings['search_model']);
		foreach ($search_model_ids as $model_id) {
			$search_model_select[$model_id] = $this->models[$model_id];
		}*/
		$this->seo['title_add'] = $this->settings['title_add'];
		$this->seo['title'] = $this->settings['site_name'].$this->settings['title_add'];
		$this->seo['keywords'] = $this->settings['keywords'];
		$this->seo['description'] = $this->settings['description'];

		// 发送基本信息
		$this->assign(['settings' => $this->settings,'categorys' => $this->categorys/*,'search_model_select'=>$search_model_select*/,'seo' => $this->seo]);
	}


}