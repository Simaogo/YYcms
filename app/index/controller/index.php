<?php
namespace app\index\controller;
use think\facade\View;

class index {
    public function index(){
        return View::fetch('../template/'. syscfg("cfg_df_style").'/index.htm');
    }
}