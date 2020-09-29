<?php
namespace app\common\taglib;
use think\template\TagLib;
class Lz extends TagLib{
    /**
     * 定义标签列表
     */
    protected $tags   =  [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        /*'close'     => ['attr' => 'time,format', 'close' => 0], //闭合标签，默认为不闭合
        'open'      => ['attr' => 'name,type', 'close' => 1], */
        'page'          => ['close' => 1], 
        'articles'      => ['close' => 1], 
        'videos'        => ['close' => 1],
        'products'      => ['close' => 1],
        'examples'      => ['close' => 1], 
        'pictures'      => ['close' => 1], 
        'recruits'      => ['close' => 1], 
        'downloads'     => ['close' => 1], 
        'focus'         => ['close' => 1], 
        'links'         => ['close' => 1], 
        'stores'        => ['close' => 1], 
        'workers'       => ['close' => 1], 
        
    ];

    /**
     * 这是一个闭合标签的简单演示
     */
    /*public function tagClose($tag)
    {
        $format = empty($tag['format']) ? 'Y-m-d H:i:s' : $tag['format'];
        $time = empty($tag['time']) ? time() : $tag['time'];
        $parse = '<?php ';
        $parse .= 'echo date("' . $format . '",' . $time . ');';
        $parse .= ' ?>';
        return $parse;
    }*/
    
    /**
     * 这是一个非闭合标签的简单演示
     */
    /*public function tagOpen($tag, $content)
    {
        $type = empty($tag['type']) ? 0 : 1; // 这个type目的是为了区分类型，一般来源是数据库
        $name = $tag['name']; // name是必填项，这里不做判断了
        $parse = '<?php ';
        $parse .= '$test_arr=[[1,3,5,7,9],[2,4,6,8,10]];'; // 这里是模拟数据
        $parse .= '$__LIST__ = $test_arr[' . $type . '];';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }*/
    public function tagPage($tag, $content) 
    {
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
             $parse .= '$where["category_id"] = '.$tag['category_id'].'; ';
        }
        $parse .= '$page = model("page")->where($where)->find(); ';  
        $parse .= 'if($page): ';
        $parse .= '$data = $page->toArray(); ';
        $parse .= '$data["category_name"] = cache("categorys")[$data["category_id"]]["name"]; ';
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagArticles($tag, $content) 
    {
        $order = empty($tag['order']) ? 'id desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']); 
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        if(!empty($tag['is_recommend'])){
            $parse .= '$where["is_recommend"] = "'.$tag['is_recommend'].'"; ';
        }
        if(!empty($tag['var_page'])){
	        $parse .= '$articles = model("article")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
	        $parse .= '$data = $articles; ';    
        }else{
        	$parse .= '$articles = model("article")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
        	$parse .= '$data = $articles; ';    	
        }
        $parse .= 'if($data): ';    
        $parse .= 'foreach ($data as $k => $v): '; 
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= '    $data[$k]["url"] = empty($v["url"])?url("index/article/show",["id"=>$v["id"]]):$v["url"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
        $parse .= '$pages = $articles->render(); '; 
        }
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagVideos($tag, $content)
    {
        $order = empty($tag['order']) ? 'id desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']);
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        if(!empty($tag['is_recommend'])){
            $parse .= '$where["is_recommend"] = "'.$tag['is_recommend'].'"; ';
        }
        if(!empty($tag['var_page'])){
            $parse .= '$videos = model("video")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
            $parse .= '$data = $videos; ';
        }else{
            $parse .= '$videos = model("video")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
            $parse .= '$data = $videos; ';
        }
        $parse .= 'if($data): ';
        $parse .= 'foreach ($data as $k => $v): ';
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= '    $data[$k]["url"] = empty($v["url"])?url("index/video/show",["id"=>$v["id"]]):$v["url"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
            $parse .= '$pages = $videos->render(); ';
        }
        $parse .= ' ?>';
        $parse .= $content;
        $parse .= '<?php endif; ?>';
        return $parse;
    }
    public function tagProducts($tag, $content) 
    {
        $order = empty($tag['order']) ? 'id desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']); 
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        if(!empty($tag['is_recommend'])){
            $parse .= '$where["is_recommend"] = "'.$tag['is_recommend'].'"; ';
        }
        if(!empty($tag['var_page'])){
	        $parse .= '$products = model("product")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
	        $parse .= '$data = $products; ';    
        }else{
        	$parse .= '$products = model("product")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
        	$parse .= '$data = $products; ';    	
        }
        $parse .= 'if($data): ';    
        $parse .= 'foreach ($data as $k => $v): '; 
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= '    $data[$k]["url"] = empty($v["url"])?url("index/product/show",["id"=>$v["id"]]):$v["url"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
        $parse .= '$pages = $products->render(); '; 
        }
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagExamples($tag, $content) 
    {
        $order = empty($tag['order']) ? 'id desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']); 
            if ('$' == substr($category_id, 0, 1)) {
                $parse .= 'if(is_array('.$category_id.')){ '.$category_id.' = implode(",", '.$category_id.'); }';
            }
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        if(!empty($tag['is_recommend'])){
            $parse .= '$where["is_recommend"] = "'.$tag['is_recommend'].'"; ';
        }
        if(!empty($tag['var_page'])){
            $parse .= '$examples = model("example")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
            $parse .= '$data = $examples; ';    
        }else{
            $parse .= '$examples = model("example")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
            $parse .= '$data = $examples; ';        
        }
        $parse .= 'if($data): ';    
        $parse .= 'foreach ($data as $k => $v): '; 
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= '    $data[$k]["url"] = empty($v["url"])?url("index/example/show",["id"=>$v["id"]]):$v["url"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
        $parse .= '$pages = $examples->render(); '; 
        }
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagPictures($tag, $content) 
    {
        $is_show = empty($tag['is_show']) ? 1 : $tag['is_show'];
        $order = empty($tag['order']) ? 'sort desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']); 
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        $parse .= '$where["is_show"] = "'.$is_show.'"; ';
        if(!empty($tag['var_page'])){
	        $parse .= '$pictures = model("picture")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
	        $parse .= '$data = $pictures; ';    
        }else{
        	$parse .= '$pictures = model("picture")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
        	$parse .= '$data = $pictures; ';    	
        }
        $parse .= 'if($data): ';    
        $parse .= 'foreach ($data as $k => $v): '; 
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= '    $data[$k]["url"] = empty($v["url"])?url("index/picture/show",["id"=>$v["id"]]):$v["url"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
        $parse .= '$pages = $pictures->render(); '; 
        }
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagRecruits($tag, $content) 
    {
        $order = empty($tag['order']) ? 'id desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']); 
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        if(!empty($tag['is_recommend'])){
            $parse .= '$where["is_recommend"] = "'.$tag['is_recommend'].'"; ';
        }
        if(!empty($tag['var_page'])){
	        $parse .= '$recruits = model("recruit")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
	        $parse .= '$data = $recruits; ';    
        }else{
        	$parse .= '$recruits = model("recruit")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
        	$parse .= '$data = $recruits; ';    	
        }
        $parse .= 'if($data): ';    
        $parse .= 'foreach ($data as $k => $v): '; 
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= '    $data[$k]["url"] = empty($v["url"])?url("index/recruit/show",["id"=>$v["id"]]):$v["url"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
        $parse .= '$pages = $recruits->render(); '; 
        }
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagDownloads($tag, $content) 
    {
        $order = empty($tag['order']) ? 'id desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']); 
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        if(!empty($tag['is_recommend'])){
            $parse .= '$where["is_recommend"] = "'.$tag['is_recommend'].'"; ';
        }
        if(!empty($tag['var_page'])){
	        $parse .= '$downloads = model("download")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
	        $parse .= '$data = $downloads; ';    
        }else{
        	$parse .= '$downloads = model("download")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
        	$parse .= '$data = $downloads; ';    	
        }
        $parse .= 'if($data): ';    
        $parse .= 'foreach ($data as $k => $v): '; 
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= '    $data[$k]["url"] = empty($v["url"])?url("index/download/show",["id"=>$v["id"]]):$v["url"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
        $parse .= '$pages = $downloads->render(); '; 
        }
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagFocus($tag, $content) 
    {

        $is_show = empty($tag['is_show']) ? 1 : $tag['is_show'];
        $order = empty($tag['order']) ? 'sort desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['type'])){
            $parse .= '$where["type"] = "'.$tag['type'].'"; ';
        }
        $parse .= '$where["is_show"] = "'.$is_show.'"; ';
        $parse .= '$focus = model("focus")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
        $parse .= 'if($focus): ';
        $parse .= '$data = $focus; ';      
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
     public function tagLinks($tag, $content) 
    {
        $is_show = empty($tag['is_show']) ? 1 : $tag['is_show'];
        $order = empty($tag['order']) ? 'sort desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        $parse .= '$where["is_show"] = "'.$is_show.'"; ';
        $parse .= '$links = model("link")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
        $parse .= 'if($links): ';
        $parse .= '$data = $links; ';      
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagStores($tag, $content) 
    {
        $order = empty($tag['order']) ? 'id desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']); 
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        if(!empty($tag['is_recommend'])){
            $parse .= '$where["is_recommend"] = "'.$tag['is_recommend'].'"; ';
        }
        if(!empty($tag['var_page'])){
            $parse .= '$stores = model("store")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
            $parse .= '$data = $stores; ';    
        }else{
            $parse .= '$stores = model("store")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
            $parse .= '$data = $stores; ';        
        }
        $parse .= 'if($data): ';    
        $parse .= 'foreach ($data as $k => $v): '; 
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
        $parse .= '$pages = $stores->render(); '; 
        }
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
    public function tagWorkers($tag, $content) 
    {
        $is_show = empty($tag['is_show']) ? 1 : $tag['is_show'];
        $order = empty($tag['order']) ? 'sort desc' : $tag['order'];
        $limit = empty($tag['limit']) ? 15 : $tag['limit'];
        $parse = '<?php ';
        $parse .= '$where = array(); ';
        if(!empty($tag['category_id'])){
            $category_id     = $this->autoBuildVar($tag['category_id']); 
            $parse .= '$where["category_id"] = array("IN","'.$category_id.'"); ';
        }
        $parse .= '$where["is_show"] = "'.$is_show.'"; ';
        if(!empty($tag['var_page'])){
            $parse .= '$workers = model("worker")->where($where)->order("'.$order.'")->paginate('.$limit.',false,["var_page"=>"'.$tag['var_page'].'","query"=>input("get.")]); ';
            $parse .= '$data = $workers; ';    
        }else{
            $parse .= '$workers = model("worker")->where($where)->order("'.$order.'")->limit('.$limit.')->select(); ';
            $parse .= '$data = $workers; ';        
        }
        $parse .= 'if($data): ';    
        $parse .= 'foreach ($data as $k => $v): '; 
        $parse .= '    $data[$k]["category_name"] = cache("categorys")[$v["category_id"]]["name"]; ';
        $parse .= '    $data[$k]["url"] = empty($v["url"])?url("index/worker/show",["id"=>$v["id"]]):$v["url"]; ';
        $parse .= 'endforeach;';
        if(!empty($tag['var_page'])){
        $parse .= '$pages = $workers->render(); '; 
        }
        $parse .= ' ?>';
        $parse .= $content; 
        $parse .= '<?php endif; ?>'; 
        return $parse; 
    }
   
}