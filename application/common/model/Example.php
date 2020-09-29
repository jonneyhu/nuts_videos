<?php
namespace app\common\model;

use think\Model;

/**
* 
*/
class Example extends Model
{

	function initialize()
	{
		parent::initialize();
	}

	//添加案例
	function add($params){
		$params['update_time'] = $params['create_time'] = strtotime($params['create_time']); 
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}

	//修改案例
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

			if(is_file(ROOT_PATH.$v['index_image_url'])){
				//删除logo缩略图
				$directory = dirname(ROOT_PATH.$v['index_image_url']);
				if (is_dir($directory) != false) {
	        		$handle = opendir($directory);
				    while (($file = readdir($handle)) !== false) {
				        if (substr(basename($v['index_image_url']),0,32) == substr($file, 0,32)) {
				            @unlink("$directory/$file");
				        }
				    }
			    }
			    //删除logo
				@unlink(ROOT_PATH.$v['index_image_url']);	
			}

			//删除案例配图
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
	* 获取案例列表
	* 
	*/
	function get_list($where = '',$order = 'id desc',$page_size=0){
		if(!$order){ $order = 'id desc';}
		$examples = $this->where($where)->order($order)->paginate($page_size);
		$examples = $examples->toArray();
		foreach ($examples['data'] as $k => $v) {
			$examples['data'][$k]['category_name'] = cache('categorys')[$v['category_id']]['name'];
		}
		return $examples;
	}
	/**
	* 获取案例详情
	*/
	function get_details($id){
		$result = $this->get($id);
		$example = $result->toArray();
		$next = $this->where('create_time','<',strtotime($example['create_time']))->where('category_id',$example['category_id'])->order('create_time desc')->find();
		$prev = $this->where('create_time','>',strtotime($example['create_time']))->where('category_id',$example['category_id'])->order('create_time asc')->find();

		if($prev){
			$example['prev'] = $prev->toArray();
			$example['prev']['url'] =empty($prev["url"])?url("index/example/show",["id"=>$prev["id"]]):$prev["url"];
		}else{
			$example['prev'] = array('title'=>'返回列表','url'=>url('index/example/lists',['category_id'=>$example['category_id']]));
		}
		if($next){
			$example['next'] = $next->toArray();
			$example['next']['url'] =empty($next["url"])?url("index/example/show",["id"=>$next["id"]]):$next["url"];
		}else{
			$example['next'] = array('title'=>'返回列表','url'=>url('index/example/lists',['category_id'=>$example['category_id']]));
		}
		return $example;
	}
}