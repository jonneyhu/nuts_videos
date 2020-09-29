<?php
namespace app\index\controller;

class Posterdate extends Init
{
    public function index()
    {  
    	
    	$save_path = DS . 'uploads' . DS . 'poster_date' . DS . date('Ymd') . '.png';

    	if(!file_exists(ROOT_PATH .$save_path)){

    		$where = array();
	    	$where['category_id'] = 36;
	    	$where['create_time'] = ['GT',strtotime(date('Y-m-d'))];
	    	$where['create_time'] = ['LT',strtotime(date('Y-m-d 23:59:59'))];
	    	$info = model('picture')->where($where)->find();

	    	$month_font_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' . DS . 'month.TTF';
	    	$week_font_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' .  DS . 'week.TTF';
	    	$day_font_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' .  DS . 'day.TTC';

	    	$poster_bg_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' .  DS . 'poster_date_bg.png';
	    	$poster = \think\Image::open(ROOT_PATH . $poster_bg_path);

	    	//右上角图片
	    	$image_path = thumb($info['image_url'],645,820);
	    	$poster->water(ROOT_PATH . $image_path,[435,0],100);

	    	//月份
	    	$image_path = DS . 'uploads' . DS . 'poster_date' . DS . 'system' .  DS . 'month' . date('m') . '.png';
	    	$poster->water(ROOT_PATH . $image_path,[300,77],100);

	    	//日期（天）
	    	$poster->text(date('d'), ROOT_PATH . $day_font_path, 100, '#242424', [45,130],0);

	    	//星期  
	    	$weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
	    	$poster->text("星期".$weekarray[date("w")], ROOT_PATH . $week_font_path, 34, '#242424', [55,290],0);

	    	//黄历接口
	    	$url = 'http://v.juhe.cn/laohuangli/d?date='.date('Y-m-d').'&key=c826c370ced424050e318dd0965f8d85';
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
			for ($i=0; $i < 6 ; $i++) { 
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
		$this->seo['title'] = '朋友圈日历';
		return view('index',['seo'=>$this->seo,'save_path'=>$save_path]);
    }
}
