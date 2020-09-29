<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    //单页模型
    '[page]'     => [
        ':category_id'   => ['index/page/index', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    //文章模型
    '[article-index]'    => [
        ':category_id'   => ['index/article/index', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    '[article-lists]'    => [
        ':category_id'   => ['index/article/lists', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    '[article]'          => [
        ':id'            => ['index/article/show', ['method' => 'get'], ['id' => '\d+']],
    ],
    //案例模型
    '[case-index]'    => [
        ':category_id'   => ['index/example/index', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    '[case-lists]'    => [
        ':category_id'   => ['index/example/lists', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    '[case]'          => [
        ':id'            => ['index/example/show', ['method' => 'get'], ['id' => '\d+']],
    ],
    //员工模型
    '[worker-index]'    => [
        ':category_id'   => ['index/worker/index', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    '[worker-lists]'    => [
        ':category_id'   => ['index/worker/lists', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    '[worker]'          => [
        ':id'            => ['index/worker/show', ['method' => 'get'], ['id' => '\d+']],
    ],
    //图片模型
    '[picture-index]'    => [
        ':category_id'   => ['index/picture/index', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    '[picture-lists]'    => [
        ':category_id'   => ['index/picture/lists', ['method' => 'get'], ['category_id' => '\d+']],
    ],
    '[picture]'          => [
        ':id'            => ['index/picture/show', ['method' => 'get'], ['id' => '\d+']],
    ],
  
];
