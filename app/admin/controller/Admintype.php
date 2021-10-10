<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\controller;
use app\admin\controller\Common;
use think\facade\View;
use app\admin\model\Admintype as AdmintypeModel;

/**
 * Description of Admintype
 *
 * @author Administrator
 */
class Admintype extends Common{
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
