<?php
namespace app\admin\controller;

/**
* 图片控制器
*/
class Picture extends Init
{
	
	function _initialize()
	{
		parent::_initialize();
		$this->model = model('common/picture');
		$this->category_model = model('common/category');
	}

	function index(){
		$params = input('param.');
		$category_id = $params['category_id'];
		$page_size = isset($params['limit'])?$params['limit']:15;
		$map = array('category_id'=>$category_id);
		$order = array('id'=>'desc');
		if(isset($params['search']) && is_array($params['search'])){
			foreach ($params['search'] as $k => $v) {
				if($v){
					$map[$k] = array('like','%'.$v.'%'); 
				}
			}
		}
		$url_params_arr = url_params_unique(request()->except(['category_id']));
		$url_params_str = format_url_params($url_params_arr);
		$order = isset($url_params_arr['order'])?$url_params_arr['order']:[];
		$pictures = $this->model->get_list($map,$order,$page_size);
		return view('list',['category_id'=>$category_id,'pictures'=>$pictures,'url_params_arr'=>$url_params_arr,'url_params_str'=>$url_params_str]);
	}

	function add(){
		if(request()->isPost()){
			$params = input('post.');
			$result = $this->model->add($params);
			if($result){
				return json(array('code'=>200,'msg'=>'添加成功'));
			}else{
				return json(array('code'=>0,'msg'=>'添加失败'));
			}
		}
		$category_id = input('param.category_id'); 
		$model_category_select_option = $this->category_model->get_model_category_select_with_option($category_id);
		return view('add',['category_id'=>$category_id,'model_category_select_option'=>$model_category_select_option]);
	}

	function edit(){
		if(request()->isPost()){
			$params = input('post.');
			$result = $this->model->edit($params);
			if($result){
				return json(array('code'=>200,'msg'=>'修改成功'));
			}else{
				return json(array('code'=>0,'msg'=>'修改失败'));
			}
		}
		$picture = $this->model->where('id',input('param.id'))->find();
		$model_category_select_option = $this->category_model->get_model_category_select_with_option($picture['category_id']);
		return view('edit',array('picture'=>$picture,'model_category_select_option'=>$model_category_select_option));
	}

	function del(){
		$result = $this->model->del(input('post.id'));
		if($result){
			return json(array('code'=>200,'msg'=>'删除成功'));
		}else{
			return json(array('code'=>0,'msg'=>'删除失败'));
		}
	}

	//批量删除
	function batches_delete(){
		$params = input('post.');
		$ids =  $params['ids'];
		$result = $this->model->del($ids);
		if($result){
			return json(array('code'=>200,'msg'=>'批量删除成功'));
		}else{
			return json(array('code'=>0,'msg'=>'批量删除失败'));
		}
	} 

	//批量移动
	function batches_move(){
		$params = input('post.');
		$result = $this->model->move($params['ids'],$params['to_category_id']);
		if($result){
			return json(array('code'=>200,'msg'=>'批量移动成功'));
		}else{
			return json(array('code'=>0,'msg'=>'批量移动失败'));
		}
	} 

	//显示
	function to_show(){ 
		$id = input('post.id');
		$data['id'] = $id;
		$data['is_show'] = array('exp','1-is_show');
		$result = $this->model->edit($data);
		if($result){
			return json(array('code'=>200,'msg'=>'操作成功'));
		}else{
			return json(array('code'=>0,'msg'=>'操作失败'));
		}
	}

	function view_posterdate(){
		$info = $this->model->where('id',input('param.id'))->find();
		$time = strtotime($info['create_time'])+1;
		$save_path = DS . 'uploads' . DS . 'poster_date' . DS . date('Ymd',$time) . '.png';

    	if(!file_exists(ROOT_PATH .$save_path) || input('param.reset') == '1'){

    		$where = array();
	    	$where['category_id'] = 36;
	    	$where['create_time'] = ['GT',strtotime(date('Y-m-d',$time))];
	    	$where['create_time'] = ['LT',strtotime(date('Y-m-d 23:59:59',$time))];

	    	$month_font_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' . DS . 'month.TTF';
	    	$week_font_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' .  DS . 'week.TTF';
	    	$day_font_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' .  DS . 'day.TTC';

	    	$poster_bg_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' .  DS . 'poster_date_bg.png';
	    	$poster = \think\Image::open(ROOT_PATH . $poster_bg_path);

	    	//右上角图片
	    	$image_path = thumb($info['image_url'],645,820);
	    	$poster->water(ROOT_PATH . $image_path,[435,0],100);

	    	//月份
	    	$image_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' .  DS . 'month' . date('m',$time) . '.png';
	    	$poster->water(ROOT_PATH . $image_path,[300,77],100);

	    	//日期（天）
	    	$poster->text(date('d',$time), ROOT_PATH . $day_font_path, 100, '#242424', [45,130],0);

	    	//星期  
	    	$weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
	    	$poster->text("星期".$weekarray[date("w",$time)], ROOT_PATH . $week_font_path, 34, '#242424', [55,290],0);

	    	//黄历接口
	    	$url = 'http://v.juhe.cn/laohuangli/d?date='.date('Y-m-d',$time).'&key=c826c370ced424050e318dd0965f8d85';
	    	$res = \Http::getRequest($url);
			$res = json_decode($res,true);
			$huangli = $res['result'];
			$yi_arr = explode(' ', $huangli['yi']);
			$ji_arr = explode(' ', $huangli['ji']);

			//宜忌
			$yi_start_x = 237;
			$yi_start_y = 522;
			$ji_start_x = 237;
			$ji_start_y = 663;
			for($i = 0;$i < 5;$i ++){
				//宜
				if(isset($yi_arr[$i])){
					$yi_x = $yi_start_x - ($i * 40);
					$yi_y = $yi_start_y;
					$yi_text = mb_substr($yi_arr[$i], 0,1,'utf8')."\n".mb_substr($yi_arr[$i], 1,1,'utf8');
					$poster->text($yi_text, ROOT_PATH . $week_font_path, 20, '#242424', [$yi_x,$yi_y],0);
				}
				//忌
				if(isset($ji_arr[$i])){
					$ji_x = $ji_start_x - ($i * 40);
					$ji_y = $ji_start_y;
					$ji_text = mb_substr($ji_arr[$i], 0,1)."\n".mb_substr($ji_arr[$i], 1,1);
					$poster->text($ji_text, ROOT_PATH . $week_font_path, 20, '#242424', [$ji_x,$ji_y],0);
				}
			}

			//农历
			$poster->text($huangli['yinli'], ROOT_PATH . $month_font_path, 28, '#242424', [50,410],0);

			//文字
			$content = $info['description'];
			$content_start_x = 970;
			$content_start_y = 875;
			for ($i=0; $i < 6; $i++) { 
				$content_x = $content_start_x - ($i * 80);
				$content_y = $content_start_y;
				$content_text = '';
				for ($j=0; $j < 12; $j++) { 
					$content_text .= mb_substr($content, $j + ($i * 12),1,'utf8')."\n";
				}
				$poster->text($content_text, ROOT_PATH . $week_font_path, 30, '#242424', [$content_x,$content_y],0);
			}



			//标题
			$title = $info['title'];
			if($title != '1'){
				$title_x = 480;
				$title_y = 1380 - (mb_strlen($title,'UTF8') * 30);
				$title_text = '';
				for ($j=0; $j < 12; $j++) { 
					$title_text .= mb_substr($title, $j ,1,'utf8')."\n";
				}
				//文字
				$poster->text($title_text, ROOT_PATH . $week_font_path, 30, '#242424', [$title_x,$title_y],0);
				//破折号
				$poster->text('——', ROOT_PATH . $week_font_path, 30, '#242424', [$title_x + 48,$title_y-100],0,90);
			}
			

			//保存图片
			$poster->save(ROOT_PATH . $save_path,null,100,false);

		}

		echo '<img src="'.$save_path.'" />';

	}

}