<?php

namespace app\admin\controller;
use think\facade\View;
use app\common\model\Arctype as ArctypeModel;
use app\common\model\Channeltype as ChanneltypeModel;

class Arctype extends \app\common\controller\Backend{
    public $model;
    
    public function __construct(){
        $this->model = new ArctypeModel();
    }
    
    public function index(){
        if(request()->isAjax()){
           $ArctypeModel = new ArctypeModel();
           $limit = input('limit') ? input('limit'):1500;
           $page = input('page');
           $page = ($page -1) * $limit;
           $list = $ArctypeModel
                   ->withJoin(['Channeltype'=>['typename']])
                   ->select();
           $count = $ArctypeModel->count();
           return json(['code'=>0,'msg'=>'success','data'=>$list,'count'=>$count]);
        }
        return View::fetch();
    }
    
    public function addEdit(){
        $id = input('id');
        if(request()->isAjax()){
           $post = input(); 
           if($id){
               $res = ArctypeModel::update($post);
               //修改子级模板风格
               if(isset($post['ischild']) && $post['ischild']=='on'){
                    $template = [
                        'tempindex' =>$post['tempindex'],
                        'templist' =>$post['templist'],
                        'temparticle' =>$post['temparticle'],
                    ];
                   $menuList = ArctypeModel::select();
                   $childIds = ArctypeModel::childrenIds($menuList,$id);
                   $typeids = trim(array_reduce($childIds, function($carry, $item){
                        return $carry . ','.$item;
                    }), ',');
                   ArctypeModel::where('id','in',$typeids)->update($template);
                }
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
    
    /**
     * 隐藏显示开关
     * @return type
     */
    public function rowEdit(){
        if(request()->isAjax()){
            $post = input();
            $name = $post['name'];
            $data = [
                 $name  => $post['value'],
            ];
            $where = ['id'=>$post['id']];
            if(ArctypeModel::where($where)->save($data)){
                return json(['code'=>0,'msg'=>'success']);   
            } else {
                return json(['code'=>0,'msg'=>'error']);   
            }
        }
    }
}
