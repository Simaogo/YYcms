<?php
namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\model\Admintype as AdmintypeModel;
use app\admin\controller\Common;
use think\facade\View;

class Admin extends common{
    
    public function index(){
        if(request()->isAjax()){
            $data = AdminModel::select()->toArray();         
            return json(['code'=>0,'msg'=>'success','data'=>$data]);
        }
        return View::fetch();
    }
    
    public function addEdit(){
         $id = input('id');
         if(request()->isAjax()){
             $post = input();
             if($post['pwd']){
                 if($post['pwd'] != $post['pwdreplace']){
                    return json(['code'=>1,'msg'=>'两次输入密码不一致!']);
                 }
                 $post['pwd'] = md5($post['pwd']);
             } else {
                 unset($post['pwd']);
                 unset($post['pwdreplace']);
             }
             
             if($id){
                 AdminModel::update($post);
             } else {
                 if(!$post['pwd']) return json(['code'=>1,'msg'=>'密码不能为空!']);
                 
                 $useridRes = AdminModel::where('userid',$post['userid'])->find();
                 if($useridRes) return json(['code'=>1,'msg'=>'用户名已存在!']);
                 //兼容ID增长
                 $last = AdminModel::order('id desc')->limit(1)->select();
                 $post['id'] =($last[0]->id)+1;
                 AdminModel::create($post);
                 
             }
             return json(['code'=>0,'msg'=>'success']);
         }
         $view = [];
         if($id){
             $view['formData'] = AdminModel::find($id)->toArray();
             $view['formData']['pwd'] = '';
         }
         $view['usertype'] = AdmintypeModel::select()->toArray();
         View::assign($view);
         return View::fetch();
    }
    
    public function del(){
        if(request()->isAjax()){
            $id = input('id');
            AdminModel::where('id',$id)->delete();
            return json(['code'=>0,'msg'=>'success']);
        }
    }
}

