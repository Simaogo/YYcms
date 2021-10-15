<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\admin\controller;

use think\facade\View;
use app\common\model\Config as ConfigModel;
class Config extends \app\common\controller\Backend{
    public function index(){
        if(request()->isAjax()){
            $post = input();
            foreach ($post as $key=>$val){
               ConfigModel::where(['varname'=>$key])->update(['value'=>$val]); 
            }
            return json(['code'=>0,'msg'=>'success']);
        }
       
        $view = [
            'groupList'=>['站点设置','核心设置','附件设置','会员设置','互动设置','性能选项','其它选项','模块设置'],
        ];
        foreach ($view['groupList'] as $key=>$val){
            $view['list'][$key] =ConfigModel::where('groupid',$key+1)->select();
        }
        View::assign($view);
        return View::fetch();
    }
}
