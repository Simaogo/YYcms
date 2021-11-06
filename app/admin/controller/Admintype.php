<?php

namespace app\admin\controller;
use app\admin\controller\Common;
use think\facade\View;
use app\admin\model\Admintype as AdmintypeModel;
use app\admin\model\AuthRule as AuthRuleModel;

class Admintype extends \app\common\controller\Backend{
    public $model;
    
    public function __construct(){
        $this->model = new AdmintypeModel();
    }
    public function index(){
        if(request()->isAjax()){
            $data = $this->model::select()->toArray();
            return json(['code'=>0,'msg'=>'success','data'=>$data]);
        }
        return View::fetch();
    }
    
    public function addEdit(){
       $id = input('id');
        if(request()->isAjax()){
            $post = input();
            $post['purviews'] = isset($post['purviews']) ? $typeids = trim(array_reduce($post['purviews'], function($carry, $item){
                    return $carry . ','.$item;
                }), ','):'';
            unset($post['id']);    
            if($id){
                $this->model::where('rank',$id)->update($post);
            } else {
                $this->model::create($post);
            }
            return json(['code'=>0,'msg'=>'success']);
        }
        $view = [];
        $authRuleList = AuthRuleModel::select()->toArray();
        $authRuleList = $authRuleList ? $authRuleList : '';
        if($id){
            $view['formData'] = $this->model::where('rank',$id)->find();
            $checkedIds = explode(',', $view['formData']['purviews']);
            $view['authRuleList'] = AuthRuleModel::childTree($authRuleList,$checkedIds);
        } else {
            $view['authRuleList'] = AuthRuleModel::childTree($authRuleList);
        }
        $view['title'] ='编辑';
        View::assign($view);
        return View::fetch();
    }
    
    public function authRule($checkedIds){
        $authRuleList = AuthRuleModel::select()->toArray();
        $authRuleList = $authRuleList ? $authRuleList : '';
        $list = AuthRuleModel::childTree($authRuleList,$checkedIds);
        return json($list);
    }
    
}
