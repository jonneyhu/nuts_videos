<?php
namespace app\common\model;

use think\Model;

/**
* 
*/
class Page extends Model
{
	
	function initialize()
	{
		parent::initialize();
		$this->url = '';
	}

	function edit($params,$isUpdate){
		$params['update_time'] = time();
		$result = $this->allowField(true)->isUpdate($isUpdate)->save($params);
		if($result){
			return $this;
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
	/**
	* 获取单页详情
	*/
	function get_details($category_id){
		return $this->get(['category_id'=>$category_id]);
	}
	
}