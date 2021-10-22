<?php

namespace app\admin\controller;
use think\facade\View;
use app\common\model\Arctype as ArctypeModel;
use app\common\model\Channeltype as ChanneltypeModel;

class Arctype extends \app\common\controller\Backend{
    public function index(){
        if(request()->isAjax()){
           $ArctypeModel = new ArctypeModel();
           $limit = input('limit') ? input('limit'):1500;
           $page = input('page');
           $page = ($page -1) * $limit;
           $data = $ArctypeModel->field('id,reid,typename')->select();
           $menu = $ArctypeModel->arctypeTree($data);

           $count = $ArctypeModel->where('ishidden',0)->count();
           return json(['code'=>0,'msg'=>'success','data'=>$data,'count'=>$count]);
        }
        return View::fetch();
    }
    public function addEdit(){
        $id = input('id');
        if(request()->isAjax()){
           $post = input(); 
           if($id){
               $res = ArctypeModel::update($post);
           } else {
              $res = ArctypeModel::insert($post);
           } 
           return json(['code'=>0,'msg'=>'success']);   
        }
        $view = [];
        if($id){
            $formData = ArctypeModel::find($id);
            $view['formData'] = $formData;
        }
        $view['channeltype']= ChanneltypeModel::select()->toArray();
        $arctypeList = ArctypeModel::select();
        $view['arctypeList'] = ArctypeModel::cateTree($arctypeList);
        $view['title'] ='编辑';
        View::assign($view);
        return View::fetch('add');
    }
    public function del(){
        if(request()->isAjax()){
            $post = input();
            $Channeltype = ArctypeModel::find($post['id']);
            $Channeltype->delete();
            return json(['code'=>0,'msg'=>'success']);
        }
    }
}
