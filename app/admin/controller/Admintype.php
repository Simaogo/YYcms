<?php

namespace app\admin\controller;
use app\admin\controller\Common;
use think\facade\View;
use app\admin\model\Admintype as AdmintypeModel;

class Admintype extends \app\common\controller\Backend{
    public function index(){
        if(request()->isAjax()){
            $data = AdmintypeModel::select()->toArray();
            return json(['code'=>0,'msg'=>'success','data'=>$data]);
        }
        return View::fetch();
    }
    
    public function addEdit(){
        
        return View::fetch();
    }
    
}
