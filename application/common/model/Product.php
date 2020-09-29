<?php
namespace app\common\model;

use think\Model;

/**
* 
*/
class Product extends Model
{

	function initialize()
	{
		parent::initialize();
	}

	//添加产品
	function add($params){
		$params['update_time'] = $params['create_time'] = strtotime($params['create_time']); 
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}

	//修改产品
	function edit($params){
		$params['update_time'] = time();
		if(isset($params['create_time'])){
			$params['create_time'] = strtotime($params['create_time']);
		}
		$result = $this->isUpdate(true)->allowField(true)->save($params);
		if($result){
			return true;
		}else{
			return false;
		}
	}
 
	//删除
	function del($ids){
		//删除图片
		$lists = $this->all($ids);
		foreach ($lists as $k => $v) {
			//删除图集图片
			$images = json_decode($v['images'],true);
			if(is_array($images)){
				foreach (json_decode($v['images'],true) as $img) {
					//删除缩略图
					$directory = dirname(ROOT_PATH.$img);
					if (is_dir($directory) != false) {
		        		$handle = opendir($directory);
					    while (($file = readdir($handle)) !== false) {
					        if (substr(basename($img),0,32) == substr($file, 0,32)) {
					            @unlink("$directory/$file");
					        }
					    }
				    }
				    //删除源图
					@unlink(ROOT_PATH.$img);
				}
			}
			//删除封面图缩略图
			$directory = dirname(ROOT_PATH.$v['image_url']);
			if (is_dir($directory) != false) {
        		$handle = opendir($directory);
			    while (($file = readdir($handle)) !== false) {
			        if (substr(basename($v['image_url']),0,32) == substr($file, 0,32)) {
			            @unlink("$directory/$file");
			        }
			    }
		    }
		    //删除封面图
			@unlink(ROOT_PATH.$v['image_url']);
			//删除产品配图
			$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.jpeg|\.bmp|\.png]))[\'|\"].*?[\/]?>/"; 
			preg_match_all($pattern,$v['content'],$match); 
			foreach ($match[1] as $path) {
				@unlink(ROOT_PATH.$path);
			}
		}
		//删除数据
		$result = $this->destroy($ids);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	//移动
	function move($ids,$category_id){
		if(empty($ids) || empty($category_id)){ return false; }
		$result = $this->where('id','in',$ids)->update(['category_id'=>$category_id]);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	/**
	* 获取产品列表
	* 
	*/
	function get_list($where = '',$order = 'id desc',$page_size=0){
		if(!$order){ $order = 'id desc';}
		$products = $this->where($where)->order($order)->paginate($page_size);
		$products = $products->toArray();
		foreach ($products['data'] as $k => $v) {
			$products['data'][$k]['category_name'] = cache('categorys')[$v['category_id']]['name'];
		}
		return $products;
	}
	/**
	* 获取产品详情
	*/
	function get_details($id){
		$result = $this->get($id);
		$product = $result->toArray();
		$next = $this->where('create_time','<',strtotime($product['create_time']))->where('category_id',$product['category_id'])->order('create_time desc')->find();
		$prev = $this->where('create_time','>',strtotime($product['create_time']))->where('category_id',$product['category_id'])->order('create_time asc')->find();

		if($prev){
			$product['prev'] = $prev->toArray();
			$product['prev']['url'] =empty($prev["url"])?url("index/product/show",["id"=>$prev["id"]]):$prev["url"];
		}else{
			$product['prev'] = array('title'=>'返回列表','url'=>url('index/product/lists',['category_id'=>$product['category_id']]));
		}
		if($next){
			$product['next'] = $next->toArray();
			$product['next']['url'] =empty($next["url"])?url("index/product/show",["id"=>$next["id"]]):$next["url"];
		}else{
			$product['next'] = array('title'=>'返回列表','url'=>url('index/product/lists',['category_id'=>$product['category_id']]));
		}
		return $product;
	}
}