<?php
namespace app\common\model;

use think\Model;

/**
* 
*/
class Download extends Model
{

	function initialize()
	{
		parent::initialize();
	}

	//添加下载
	function add($params){
		$params['update_time'] = $params['create_time'] = strtotime($params['create_time']); 
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}

	//修改下载
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
			//删除下载配图
			$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.jpeg|\.bmp|\.png]))[\'|\"].*?[\/]?>/"; 
			preg_match_all($pattern,$v['content'],$match); 
			foreach ($match[1] as $path) {
				@unlink(ROOT_PATH.$path);
			}
			//删除文件
			@unlink(ROOT_PATH.$v['file_url']);
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
	* 获取下载列表
	* 
	*/
	function get_list($where = '',$order = 'id desc',$page_size=0){
		if(!$order){ $order = 'id desc';}
		$downloads = $this->where($where)->order($order)->paginate($page_size);
		$downloads = $downloads->toArray();
		foreach ($downloads['data'] as $k => $v) {
			$downloads['data'][$k]['category_name'] = cache('categorys')[$v['category_id']]['name'];
		}
		return $downloads;
	}
	/**
	* 获取下载详情
	*/
	function get_details($id){
		$result = $this->get($id);
		$download = $result->toArray();
		$next = $this->where('create_time','<',strtotime($download['create_time']))->where('category_id',$download['category_id'])->order('create_time desc')->find();
		$prev = $this->where('create_time','>',strtotime($download['create_time']))->where('category_id',$download['category_id'])->order('create_time asc')->find();

		if($prev){
			$download['prev'] = $prev->toArray();
			$download['prev']['url'] =empty($prev["url"])?url("index/download/show",["id"=>$prev["id"]]):$prev["url"];
		}else{
			$download['prev'] = array('title'=>'返回列表','url'=>url('index/download/lists',['category_id'=>$download['category_id']]));
		}
		if($next){
			$download['next'] = $next->toArray();
			$download['next']['url'] =empty($next["url"])?url("index/download/show",["id"=>$next["id"]]):$next["url"];
		}else{
			$download['next'] = array('title'=>'返回列表','url'=>url('index/download/lists',['category_id'=>$download['category_id']]));
		}
		return $download;
	}
}