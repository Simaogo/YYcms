<?php
namespace app\admin\controller;

use app\admin\model\AuthRule as AuthRuleModel;
use think\facade\View;
class AuthRule extends \app\common\controller\Backend{
   
    public $model;
    
    public function __construct(){
        $this->model = new AuthRuleModel();
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
            if($id){
                $this->model::update($post);
            } else {
                $this->model::create($post);
            }
            return json(['code'=>0,'msg'=>'success']);
        }
        $view = [];
        if($id){
            $view['formData'] = $this->model::find($id);
        }
        $authRuleList = $this->model::select();
        $authRuleList = $authRuleList ? $authRuleList->toArray() : '';
        $view['authRuleList'] = $this->model::authRuleTree($authRuleList);
       
        $view['title'] ='编辑';
        View::assign($view);
        return View::fetch();
    }
}
