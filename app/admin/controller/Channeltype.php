<?php

namespace app\admin\controller;

use app\common\model\Channeltype as ChanneltypeModel;
use think\facade\View;
class Channeltype extends \app\common\controller\Backend{
    public function index(){
        if(request()->isAjax()){
            $list = ChanneltypeModel::select();
            return json(['code'=>0,'msg'=>'success','data'=>$list]);
        }
        return View::fetch();
    }
    public function addEdit(){
        if(request()->isAjax()){
            $post = input();
            if(ChanneltypeModel::find($post['id'])){
                ChanneltypeModel::update($post);
            } else {
                ChanneltypeModel::insert($post);
            }
            return json(['code'=>0,'msg'=>'success']);
        }
        $id = input('id');
        if($id){
            $formData = ChanneltypeModel::order('id asc')->find($id);
            $view = [
                'formData' => $formData,
            ];
            View::assign($view);
        }
        
        return View::fetch('add');
    }
    public function del(){
        if(request()->isAjax()){
            $post = input();
            $Channeltype = ChanneltypeModel::find($post['id']);
            $Channeltype->delete();
            return json(['code'=>0,'msg'=>'success']);
        }
    }
}
