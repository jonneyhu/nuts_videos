<?php
namespace app\index\controller;

/**
* 案例控制器类
*/
class example extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
		$this->model = model('common/example');
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
		$thumb_name = $params['thumb_name']?$params['thumb_name']:'image_url';
		$thumb = $params['thumb']?explode(',', $params['thumb']):'';
		$examples = $this->model->where($sqlmap)->order($order)->limit($limit)->page($page)->select();
		$lists = array();
		foreach ($examples as $k => $v) {
			$lists[$k] = $v->toArray();
			unset($lists[$k]['content']);
			$lists[$k]['url'] = empty($v['url'])?url('index/example/show',['id'=>$v['id']]):$v['url'];
			$lists[$k]['category_name'] = $this->categorys[$lists[$k]['category_id']]['name'];
			if(is_array($thumb)){
				$lists[$k]['thumb'] = thumb($v[$thumb_name],$thumb[0],$thumb[1],$thumb[2]);
				/*$lists[$k]['thumb_qrcode'] = thumb($v['thumb_qrcode'],120,120,3);*/
			}
		}
		return json($lists);
	}

	function show(){
		$id = input('param.id');
		$example = $this->model->get_details($id);
		$this->model->where('id', $id)->setInc('hits'); //点击量自增一
		$example['hits'] = $example['hits']+1; //点击量加一

		$breadcrumb = $this->category_model->breadcrumb($example['category_id']).'<span>&gt;</span><a>'.$example['title'].'</a>';
		$category = $this->categorys[$example['category_id']];
		$top_category = $this->category_model->get_top_category($example['category_id']);
		$second_categorys = $this->category_model->get_second_categorys($example['category_id']);
		$this->seo['title'] = $example['title'].$this->seo['title_add'];
		if($example['keywords']){ $this->seo['keywords'] = $example['keywords'];}
		if($example['description']){ $this->seo['description'] = $example['description'];}
		$template = $this->category_model->get_template($category_id,3);
		return view($template,['data'=>$example,'category'=>$category,'breadcrumb'=>$breadcrumb,'top_category'=>$top_category,'second_categorys'=>$second_categorys,'seo'=>$this->seo]);
	}


}
