<?php
namespace app\index\controller;
use think\facade\View;
use \think\facade\Config;
class Index {
    
    public function index(){
        $template = 'index';
        if(isMobile()){
            $template = 'index_m';
            if(!file_exists(Config::get('view.view_path').''.$template .'.'.Config::get('view.view_suffix'))){
                $template = 'index';
            }
        }
        $template .=  '.'. Config::get('view.view_suffix');
        return View::fetch(Config::get('view.view_path') .''.$template);
    }
}