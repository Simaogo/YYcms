<?php

/**
 * YYcms
 * ============================================================================
 * 版权所有 2021-2028 yyAdmin，并保留所有权利。
 * git地址: https://github.com/Simaogo/YYcms
 * ----------------------------------------------------------------------------
 * 采用最新Thinkphp6实现
 * ============================================================================
 * Author: simao 
 * Date: 20121/10/2
 */

namespace app\admin\controller;

use app\admin\model\AdminLog as AdminLogModel;
use app\admin\model\Admintype as AdmintypeModel;
use app\common\controller\Backend;
use think\facade\View;
use think\facade\Session;

class AdminLog extends Backend{
    
    public function __construct(){
        $this->model = new AdminLogModel();
    }
    public function index(){
        if(request()->isAjax()){
            $page = input('page');
            $limit = input('limit');
            $data = $this->model::limit(($page-1)*$limit,$limit)->order('id desc')->select(); 
            $count = $this->model->select()->count();
            return json(['code'=>0,'msg'=>'success','data'=>$data,'count'=>$count]);
        }
        return View::fetch();
    }
    public function addEdit(){
    }
}
