<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 随机字符串
 * @param int $length 长度
 * @param int $numeric 类型(0：混合；1：纯数字)
 * @return string
 */
function random($length, $numeric = 0) {
     $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
     $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
     if($numeric) {
          $hash = '';
     } else {
          $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
          $length--;
     }
     $max = strlen($seed) - 1;
     for($i = 0; $i < $length; $i++) {
          $hash .= $seed{mt_rand(0, $max)};
     }
     return $hash;
}

/**
 * 缩略图生成
 * @param sting $src
 * @param intval $width
 * @param intval $height
 * @param boolean $replace
 * @param intval $type 
                 1、标识缩略图等比例缩放类型
                 2、标识缩略图缩放后填充类型 
                 3、标识缩略图居中裁剪类型
                 4、标识缩略图左上角裁剪类型
                 5、标识缩略图右下角裁剪类型
                 6、标识缩略图固定尺寸缩放类型
 * @return string
 */
function thumb($src = '', $width = 500, $height = 500, $type = 1, $replace = false) {
    $src = './'.$src;
    if(is_file($src) && file_exists($src)) {
        $ext = pathinfo($src, PATHINFO_EXTENSION);
        $name = basename($src, '.'.$ext);
        $dir = dirname($src);
        if(in_array($ext, array('gif','jpg','jpeg','bmp','png'))) {
            $name = $name.'_thumb_'.$width.'_'.$height.'.'.$ext;
            $file = $dir.'/'.$name;
            if(!file_exists($file) || $replace == TRUE) {
                $image = \think\Image::open($src);
                $image->thumb($width, $height, $type);
                $image->save($file,null,100,false);
            }
            $file=str_replace("\\","/",$file);
            $file = '/'.trim($file,'./');
            return $file;
        }
    }
    $src=str_replace("\\","/",$src);
    $src = '/'.trim($src,'./');
    return $src;
}

/**
 * 删除目录（包括下面的文件）
 * @return void
 */
function delDir($directory, $subdir = true) {
    if (is_dir($directory) == false) {
        return false;
    }
    $handle = opendir($directory);
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != "..") {
            is_dir("$directory/$file") ?delDir("$directory/$file") : unlink("$directory/$file");
        }
    }
    if (readdir($handle) == false) {
        closedir($handle);
        rmdir($directory);
    }
}

/**
 * 对一个给定的二维数组按照指定的键值进行排序
 * @return array
 */
function array_sort($arr,$keys,$type='asc'){  
    $keysvalue = $new_array = array();  
    foreach ($arr as $k=>$v){  
        $keysvalue[$k] = $v[$keys];  
    }  
    if($type == 'asc'){  
        asort($keysvalue);  
    }else{  
        arsort($keysvalue);  
    }  
    reset($keysvalue);  
    foreach ($keysvalue as $k=>$v){  
        $new_array[$k] = $arr[$k];  
    }  
    return $new_array;  
} 
/**
 * 时间日期格式化为多少天前
 * @param sting|intval $date_time
 * @param intval $type 1、'Y-m-d H:i:s' 2、时间戳
 * @return string
 */
function format_datetime($date_time,$type=1,$format){
    if($type == 1){
        $timestamp = strtotime($date_time);
    }elseif($type == 2){
        $timestamp = $date_time;
        $date_time = date('Y-m-d H:i:s',$date_time);
    }
    if(isset($format)){
        return date($format,$timestamp);
    }
    $difference = time()-$timestamp;
    if($difference <= 180){
        return '刚刚';
    }elseif($difference <= 3600){
        return ceil($difference/60).'分钟前';
    }elseif($difference <= 86400){
        return ceil($difference/3600).'小时前';
    }elseif($difference <= 2592000){
        return ceil($difference/86400).'天前';
    }elseif($difference <= 31536000){
        return ceil($difference/2592000).'个月前';
    }else{
        return ceil($difference/31536000).'年前';
        //return $date_time;
    }
}
/**
 * 请求参数格式化
 * @param array $params
 * @return string
 */
function format_url_params($params){
    if(!empty($params) && is_array($params)){
        $params_str = '';
        foreach ($params as $k => $v) {
            if(is_array($v)){
                end($v);
                $key = key($v);
                $params_str .= $k.'['.$key.']='.$v[$key].'&';
            }else{
                $params_str .= $k.'='.$v.'&';
            }
        }
        return trim($params_str,'&');
    }
    return '';
}
/**
 * 请求参数去重
 * @param array $params
 * @return array
 */
function url_params_unique($params){
    if(!empty($params) && is_array($params)){
        $params_arr = [];
        foreach ($params as $k => $v) {
            if(is_array($v)){
                end($v);
                $key = key($v);
                $params_arr[$k][$key] = $v[$key];
            }else{
                $params_arr[$k] = $v;         
            }
        }
        return $params_arr;
    }
    return [];
}

/**
 * 判断是否SSL协议
 * @return boolean
 */
function is_ssl() {
    if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
        return true;
    }elseif(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}