<?php

namespace app\admin\controller;

use app\common\model\Myppttype as MyppttypeModel;
use app\common\controller\Backend;
use think\facade\View;
use think\facade\Session;
class Myppttype extends Backend{
    public function index(){
        if(request()->isAjax()){
            $data = MyppttypeModel::select()->toArray();         
            return json(['code'=>0,'msg'=>'success','data'=>$data]);
        }
        return View::fetch();
    }
    public function addEdit(){
        $id = input('id');
        if(request()->isAjax()){
            $post = input();
            if($id){
                $where = ['id'=>$id];
                unset($post['id']);
                MyppttypeModel::where($where)->update($post);
            } else {
               MyppttypeModel::create($post);
            }
            return json(['code'=>0,'msg'=>'success']);
        }

        if($id){
            $view['formData'] = MyppttypeModel::where('id',$id)->find();
            View::assign($view);
        }
        return View::fetch();
    }
     public function del(){
        if(request()->isAjax()){
            $id = input('id');
            MyppttypeModel::where('id',$id)->delete();
            return json(['code'=>0,'msg'=>'success']);
        }
    }
}