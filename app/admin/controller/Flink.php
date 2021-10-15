<?php

namespace app\admin\controller;
use think\facade\View;
use app\common\model\Flink as FlinkModel;
use app\common\model\Flinktype as FlinktypeModel;

class Flink extends \app\common\controller\Backend{
    public function index(){
       // halt(date('Y-m-d',1226375403));
        if(request()->isAjax()){
            $Flink = new FlinkModel();
            $page = input('page') -1;
            $limit = input('limit');
            $data = $Flink->withJoin('flinktype')->limit($page,$limit)->select()->toArray();
            return json(['code'=>0,'msg'=>'success','data'=>$data]);
        }
        return View::fetch();
    }
    public function addEdit(){
        $id = input('id');
        if(request()->isAjax()){
            $post = input();
            if($id){
                FlinkModel::update($post);
            } else {
               FlinkModel::create($post);
            }
            return json(['code'=>0,'msg'=>'success']);
        }
        $view = [
            'flinktype' =>FlinktypeModel::select()
        ];
        if($id){
            $view['formData'] = FlinkModel::find($id);
        }
        View::assign($view);
         return View::fetch();
    }
    public function del(){
        if(request()->isAjax()){
            FlinkModel::destroy(input('id'));
            return json(['code'=>0,'msg'=>'success']);
        }
    }
}
