<?php
namespace app\admin\controller;

/**
* 站点设置控制器类
*/
class Setting extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
		$this->model=model('common/setting');
	}

	function base(){
		error_reporting(E_ALL^E_NOTICE^E_WARNING);
		if(request()->isPost()){
			$params = input('post.');
			if($params['search_model']){
				$params['search_model'] = implode(',',$params['search_model']);
			}else{
				$params['search_model'] = '';
			}
			$result = $this->model->update_setting($params);
			if($result){
				return json(array('code'=>200,'msg'=>'修改成功'));
			}else{
				return json(array('code'=>0,'msg'=>$this->model->getError()));
			}
		}
		$model_select = model('common/category')->get_model_select();
		$setting = $this->model->get_setting();
		return view('base',['setting'=>$setting,'model_select'=>$model_select]);
	}

	function get_point(){
		return view('get_point');
	}
	
	
	function sitemap(){
		error_reporting(E_ALL^E_NOTICE^E_WARNING);
		if(request()->isPost()){
			$params = input('post.');
			$params['sitemap_model'] = implode(',',$params['sitemap_model']);
			$result = $this->model->update_setting($params);
			$result = $this->model->set_sitemap($params['changefreq'],$params['sitemap_model']);
			if($result){
				return json(array('code'=>200,'msg'=>'操作成功'));
			}else{
				return json(array('code'=>0,'msg'=>'操作失败'));
			}
		}
		$setting = $this->model->get_setting();
		$model_select = model('common/category')->get_model_select();
		
		$changefreq_select = array(
			'always'  => '一直更新',
			'hourly'  => '小时',
			'daily'   => '天',
			'weekly'  => '周',
			'monthly' => '月',
			'yearly'  => '年',
			'never'   => '从不更新',
		);
		return view('sitemap',['setting'=>$setting,'changefreq_select'=>$changefreq_select,'model_select'=>$model_select]);
	}

	/*获取分词*/
	function get_keywords(){
		$threshold = empty($this->settings['threshold'])?0.5:$this->settings['threshold'];
		$source = input('post.source');
		$keywords = file_get_contents('http://api.pullword.com/get.php?source='.$source.'&param1='.$threshold.'&param2=0');
		$keywords = trim($keywords);
		if($keywords){
			$keywords = str_replace("\n", ',', $keywords);
			return json(array('code'=>200,'msg'=>'操作成功','keywords'=>$keywords));
		}else{
			return json(array('code'=>0,'msg'=>'操作失败'));
		}
	}
	
}