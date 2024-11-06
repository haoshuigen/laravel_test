<?php
return [
    // admin站点名称
    'admin_site_name'   => env('ADMIN_SITE_NAME', 'laravel test'),
    // 是否开启验证码
    'captcha'           => env('ADMIN_CAPTCHA', false),
    // 是否开启csrf过滤
    'is_csrf'           => env('IS_CSRF', false),
    // 静态文件路径
    'static_path'       => env('ADMIN_STATIC_PATH', '/static'),
    // Admin命令空间
    'controller_namespace' => 'App\Http\Controllers\admin\\',
    // admin角色id
    'super_admin_id'       => 1,
    // 后台访问别名 默认后台访问路径
    'admin_alias_name'     => env('ADMIN_NAME', 'admin'),

    // 不需要验证登录的控制器
    'no_login_controller'  => [
        'login',
    ],

    // 不需要验证登录的节点
    'no_login_node'        => [
        'login/index',
        'login/captcha',
        'login/out',
    ],

    // 不需要验证权限的控制器
    'no_auth_controller'   => [
        'ajax',
        'login',
        'index',
    ],

    // 不需要验证权限的节点
    'no_auth_node'         => [
        'login/index',
        'login/out',
    ],
];
