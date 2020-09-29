<?php
namespace app\index\controller;

/**
* 图片控制器类
*/
class picture extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
		$this->model = model('common/picture');
		$this->category_model = model('common/category');
	}

	function index(){
		$category_id = input('param.category_id');
		$category = $this->categorys[$category_id];
		$top_category = $this->category_model->get_top_category($category_id);
		$second_categorys = $this->category_model->get_second_categorys($category_id);
		$breadcrumb = $this->category_model->breadcrumb($category_id);

		$this->seo['title'] = $this->categorys[$category_id]['name'].$this->seo['title_add'];
		if($this->categorys[$category_id]['meta_keywords']){ $this->seo['keywords'] = $this->categorys[$category_id]['meta_keywords'];}
		if($this->categorys[$category_id]['meta_description']){ $this->seo['description'] = $this->categorys[$category_id]['meta_description'];}
		$template = $this->category_model->get_template($category_id,1);
		return view($template,['category'=>$category,'top_category'=>$top_category,'breadcrumb'=>$breadcrumb,'second_categorys'=>$second_categorys,'seo'=>$this->seo]);
	}

	function lists(){
		$category_id = input('param.category_id');
		$category = $this->categorys[$category_id];
		$top_category = $this->category_model->get_top_category($category_id);
		$second_categorys = $this->category_model->get_second_categorys($category_id);
		$breadcrumb = $this->category_model->breadcrumb($category_id);

		$this->seo['title'] = $this->categorys[$category_id]['name'].$this->seo['title_add'];
		if($this->categorys[$category_id]['meta_keywords']){ $this->seo['keywords'] = $this->categorys[$category_id]['meta_keywords'];}
		if($this->categorys[$category_id]['meta_description']){ $this->seo['description'] = $this->categorys[$category_id]['meta_description'];}
		$template = $this->category_model->get_template($category_id,2);
		return view($template,['category'=>$category,'top_category'=>$top_category,'breadcrumb'=>$breadcrumb,'second_categorys'=>$second_categorys,'seo'=>$this->seo]);
	}
	function get_ajax_lists(){
		$params = input('param.');
		$sqlmap = array();
		$sqlmap['category_id'] = $params['category_id'];
		$order = $params['order']?$params['order']:'create_time desc';
		$limit = $params['limit']?$params['limit']:10;
		$page = $params['page']?$params['page']:1;
		$thumb = $params['thumb']?explode(',', $params['thumb']):'';
		$pictures = $this->model->where($sqlmap)->order($order)->limit($limit)->page($page)->select();
		$lists = array();
		foreach ($pictures as $k => $v) {
			$lists[$k] = $v->toArray();
			$lists[$k]['url'] = empty($v['url'])?url('index/picture/show',['id'=>$v['id']]):$v['url'];
			if(is_array($thumb)){
				$lists[$k]['thumb'] = thumb($v['image_url'],$thumb[0],$thumb[1],$thumb[2]);
			}
		}
		return json($lists);
	}

	function show(){
		$id = input('param.id');
		$picture = $this->model->get_details($id);
		$this->model->where('id', $id)->setInc('hits'); //点击量自增一
		$picture['hits'] = $picture['hits']+1; //点击量加一

		$breadcrumb = $this->category_model->breadcrumb($picture['category_id']).'<span>&gt;</span><a>'.$picture['title'].'</a>';
		$category = $this->categorys[$picture['category_id']];
		$top_category = $this->category_model->get_top_category($picture['category_id']);
		$second_categorys = $this->category_model->get_second_categorys($picture['category_id']);
		$this->seo['title'] = $picture['title'].$this->seo['title_add'];
		if($picture['keywords']){ $this->seo['keywords'] = $picture['keywords'];}
		if($picture['description']){ $this->seo['description'] = $picture['description'];}
		$template = $this->category_model->get_template($category_id,3);
		return view($template,['data'=>$picture,'category'=>$category,'breadcrumb'=>$breadcrumb,'top_category'=>$top_category,'second_categorys'=>$second_categorys,'seo'=>$this->seo]);
	}


}
