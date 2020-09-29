<?php
namespace app\common\model;

use think\Model;

/**
* 
*/
class Recruit extends Model
{

	function initialize()
	{
		parent::initialize();
	}

	//添加招聘
	function add($params){
		$params['update_time'] = $params['create_time'] = strtotime($params['create_time']); 
		$result = $this->isUpdate(false)->allowField(true)->save($params);
		if($result){
			return $this->id;
		}else{
			return false;
		}
	}

	//修改招聘
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
	* 获取招聘列表
	* 
	*/
	function get_list($where = '',$order = 'id desc',$page_size=0){
		if(!$order){ $order = 'id desc';}
		$recruits = $this->where($where)->order($order)->paginate($page_size);
		$recruits = $recruits->toArray();
		foreach ($recruits['data'] as $k => $v) {
			$recruits['data'][$k]['category_name'] = cache('categorys')[$v['category_id']]['name'];
		}
		return $recruits;
	}
	/**
	* 获取招聘详情
	*/
	function get_details($id){
		$result = $this->get($id);
		$recruit = $result->toArray();
		$next = $this->where('create_time','<',strtotime($recruit['create_time']))->where('category_id',$recruit['category_id'])->order('create_time desc')->find();
		$prev = $this->where('create_time','>',strtotime($recruit['create_time']))->where('category_id',$recruit['category_id'])->order('create_time asc')->find();

		if($prev){
			$recruit['prev'] = $prev->toArray();
			$recruit['prev']['url'] =empty($prev["url"])?url("index/recruit/show",["id"=>$prev["id"]]):$prev["url"];
		}else{
			$recruit['prev'] = array('title'=>'返回列表','url'=>url('index/recruit/lists',['category_id'=>$recruit['category_id']]));
		}
		if($next){
			$recruit['next'] = $next->toArray();
			$recruit['next']['url'] =empty($next["url"])?url("index/recruit/show",["id"=>$next["id"]]):$next["url"];
		}else{
			$recruit['next'] = array('title'=>'返回列表','url'=>url('index/recruit/lists',['category_id'=>$recruit['category_id']]));
		}
		return $recruit;
	}
}