<?php
namespace app\index\controller;

/**
 * 控制器类
 */
class Video extends Init
{

    function _initialize()
    {
        parent::_initialize();
        $this->model = model('common/video');

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

        if(isset($params['keywords']) && $params['keywords']){
            $sqlmap['title'] = array('like','%'.$params['keywords'].'%');
        }elseif(isset($params['category_id']) && $params['category_id']){
            $sqlmap['category_id'] = $params['category_id'];
        }
        $order = $params['order']?$params['order']:'create_time desc';
        $limit = $params['limit']?$params['limit']:10;
        $page = $params['page']?$params['page']:1;
        $thumb = $params['thumb']?explode(',', $params['thumb']):'';

        if(empty($sqlmap)){
            return false;
        }
        $videos = $this->model->where($sqlmap)->order($order)->limit($limit)->page($page)->select();
        $lists = array();
        foreach ($videos as $k => $v) {
            $lists[$k] = $v->toArray();
            $lists[$k]['url'] = empty($v['url'])?url('index/video/show',['id'=>$v['id']]):$v['url'];
            if(is_array($thumb)){
                $lists[$k]['thumb'] = thumb($v['image_url'],$thumb[0],$thumb[1],$thumb[2]);
            }
        }
        return json($lists);
    }

    function show(){
        $id = input('param.id');
        $video = $this->model->get_details($id);
        $this->model->where('id', $id)->setInc('hits'); //点击量自增一
        $video['hits'] = $video['hits']+1; //点击量加一

        $collections = db('collection')->where(['video_id'=>$video['id']])->order('num asc')->select();

        $breadcrumb = $this->category_model->breadcrumb($video['category_id']).'<span>&gt;</span><a>'.$video['title'].'</a>';
        $category = $this->categorys[$video['category_id']];
        $top_category = $this->category_model->get_top_category($video['category_id']);
        $second_categorys = $this->category_model->get_second_categorys($video['category_id']);
        $this->seo['title'] = $video['title'].$this->seo['title_add'];
        if($video['keywords']){ $this->seo['keywords'] = $video['keywords'];}
        if($video['description']){ $this->seo['description'] = $video['description'];}
        $template = $this->category_model->get_template($category_id,3);
        return view($template,['data'=>$video,'collections'=>$collections,'category'=>$category,'breadcrumb'=>$breadcrumb,'top_category'=>$top_category,'second_categorys'=>$second_categorys,'seo'=>$this->seo]);
    }

    function get_collection_info(){
        $params = input('param.');
        $collection_id = $params['collection_id'];
        if(!$collection_id){
            return ['code'=>0,'msg'=>'暂无剧集数据'];
        }
        $collection = db('collection')->find($collection_id);
        if($collection){
            db('collection')->where('id', $collection_id)->setInc('hits');
            return array('code'=>200,'msg'=>'请求成功','data'=>$collection);
        }else{
            return ['code'=>0,'msg'=>'暂无剧集数据'];
        }
    }

    function search(){
        $params = input('param.');
        $keywords = $params['keywords'];

        return view('search',['keywords'=>$keywords]);
    }


}
