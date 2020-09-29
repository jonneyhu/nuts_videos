<?php
namespace app\common\model;

use think\Model;

/**
* 
*/
class Link extends Model
{

	function initialize()
	{
		parent::initialize();
	}

	//添加友情链接
	function add($params){
		$params['update_time'] = $params['create_time'] = time();
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}

	//修改友情链接
	function edit($params){
		$params['update_time'] = time();
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
		}
		//删除数据 
		$result = $this->destroy($ids);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	/**
	* 获取友情链接列表
	* 
	*/
	function get_list($where = '',$order = 'id desc',$page_size=0){
		if(!$order){ $order = 'id desc';}
		$links = $this->where($where)->order($order)->paginate($page_size);
		$links = $links->toArray();
		return $links;
	}

	//友情链接排序
	function sort($params){
		$list = [];
		foreach ($params as $k => $v) {
			$list[] = ['id'=>$k, 'sort'=>$v];
		}
		$result = $this->saveAll($list);
		if($result){
			return true;
		}else{
			return false;
		}
	}
}