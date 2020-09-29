<?php
namespace app\index\controller;

/**
* 单页控制器类
*/
class Page extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
		$this->model = model('common/page');
		$this->category_model = model('common/category');
	}


	function index(){
		$category_id = input('param.category_id');
		$category = $this->categorys[$category_id];
		$top_category = $this->category_model->get_top_category($category_id);
		$second_categorys = $this->category_model->get_second_categorys($category_id);
		$breadcrumb = $this->category_model->breadcrumb($category_id);

		$page = $this->model->get_details($category_id);

		$this->seo['title'] = $this->categorys[$category_id]['name'].$this->seo['title_add'];
		$this->seo['title_no_add'] = $this->categorys[$category_id]['name'].'-'.$this->settings['site_name'];
		if($this->categorys[$category_id]['meta_keywords']){ $this->seo['keywords'] = $this->categorys[$category_id]['meta_keywords'];}
		if($page['description']){ 
			$this->seo['description'] = $page['description'];
		}elseif($this->categorys[$category_id]['meta_description']){ 
			$this->seo['description'] = $this->categorys[$category_id]['meta_description'];
		}
		$template = $this->category_model->get_template($category_id,1);
		return view($template,['category'=>$category,'top_category'=>$top_category,'data'=>$page,'breadcrumb'=>$breadcrumb,'second_categorys'=>$second_categorys,'seo'=>$this->seo]);
	}
	
}
