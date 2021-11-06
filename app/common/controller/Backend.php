<?php

namespace app\common\controller;

use think\facade\Session;
use think\App;
use app\common\controller\Jump;
class Backend extends \app\BaseController{
    
    use Jump;
    public $model;
    public function __construct(App $app)
    {
        // 控制器初始化
        $this->initialize();
    }
    // 初始化
    public function initialize()
    {
        if(!Session::get('admin')){
            $this->error('登录超时!', url('login/index'));
        }
        //初始化权限
       $admin = Session::get('admin');
       $authRule = \app\admin\model\Admintype::where('rank',$admin['usertype'])->value('purviews');
       $controller = request()->controller();
       if($authRule!='admin_AllowAll' && $controller !='Index' && $controller !='Login'){
           $authRule = explode(',', $authRule);
           $href = str_replace('.html','',request()->pathinfo());
            $authRuleId = \app\admin\model\AuthRule::where('href',$href)->value('id');
            if(!in_array($authRuleId, $authRule)){
                $this->error('没有权限操作', url('index/home'));
            }
           
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
            if($this->model::where($where)->save($data)){
                return json(['code'=>0,'msg'=>'success']);   
            } else {
                return json(['code'=>0,'msg'=>'error']);   
            }
        }
    }
    
    public function delAll(){
        if(request()->isAjax()){
            $ids = input('ids');
            if($this->model && $ids){
                $this->model::where('id','in',$ids)->delete();
                return json(['code'=>0,'msg'=>'success']);   
            } else {
                return json(['code'=>0,'msg'=>'error']);
            } 
        }
    }
}
