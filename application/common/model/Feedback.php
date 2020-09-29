<?php
namespace app\common\model;

use think\Model;

/**
* 留言模型类
*/
class Feedback extends Model
{
	
	function initialize()
	{
		parent::initialize();
	}

	//添加留言
	function add($params){
		$params['create_time'] = time();
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	//修改留言
	function edit($params){
		if(isset($params['create_time'])){
			$params['create_time'] = strtotime($params['create_time']);
		}
		if(isset($params['reply_time'])){
			$params['reply_time'] = strtotime($params['reply_time']);
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
		//删除数据
		$result = $this->destroy($ids);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	/**
	* 获取留言列表
	*  
	*/
	function get_list($where = '',$order = 'id desc',$page_size=0){
		if(!$order){ $order = 'id desc';}
		$feedbacks = $this->where($where)->order($order)->paginate($page_size);
		$feedbacks = $feedbacks->toArray();
		return $feedbacks;
	}

}