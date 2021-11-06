<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host'         => env('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 默认应用
    'default_app'      => 'index',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => ['common'],

    // 异常页面的模板文件
    'exception_tmpl'   => app()->getThinkPath() . 'tpl/think_exception.tpl',
    'dispatch_success_tmpl' => \think\facade\App::getAppPath(). '/common/view/tpl/dispatch_jump.tpl',
    'dispatch_error_tmpl'   => \think\facade\App::getAppPath(). '/common/view/tpl/dispatch_jump.tpl',
    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => true,
    
    'app_trace' =>  true,
    
    'version' => '1.0.1',
    'list_url' => '/list',
    'view_url' => '/view',
    'app_map' => [
        'chinaadmin' => 'admin', // 把admin应用映射为chinaadmin 修改默认admin登录配置
     ],
    
];
