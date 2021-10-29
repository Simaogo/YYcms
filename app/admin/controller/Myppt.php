<?php

namespace app\admin\controller;

use app\admin\model\Myppttype as MyppttypeModel;
use app\common\model\Myppt as MypptModel;
use app\common\controller\Backend;
use think\facade\View;
use think\facade\Session;
class Myppt extends Backend{
    public function index(){
        if(request()->isAjax()){
            $data = MypptModel::select()->toArray();         
            return json(['code'=>0,'msg'=>'success','data'=>$data]);
        }
        return View::fetch();
    }
    public function addEdit(){
        $id = input('id');
        if(request()->isAjax()){
            $post = input();
            if($id){
                $where = ['aid'=>$id];
                unset($post['id']);
                MypptModel::where($where)->update($post);
            } else {
               MypptModel::create($post);
            }
            return json(['code'=>0,'msg'=>'success']);
        }

        $view = [
            'myppttype' =>MyppttypeModel::select()
        ];
        if($id){
            $view['formData'] = MypptModel::where('aid',$id)->find();
        }
        View::assign($view);
         return View::fetch();
    }
     public function del(){
        if(request()->isAjax()){
            $id = input('id');
            Myppt::where('id',$id)->delete();
            return json(['code'=>0,'msg'=>'success']);
        }
    }
}