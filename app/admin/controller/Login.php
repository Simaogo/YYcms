<?php

namespace app\admin\controller;

use think\facade\View;
use think\captcha\facade\Captcha;
use app\admin\model\Admin as AdminModel;
use think\facade\Session;
use think\facade\Db;
class Login extends \app\BaseController{

    public function index(){
        if(request()->isPost()){
            $post = input();
            $verify = $post['verify'];
            if(!captcha_check($verify)){
                return json(['code'=>0,'msg'=>'验证码不正确']);
            }
            $post['pwd'] = md5($post['pwd']);
//            \think\facade\Db::connect('tp6cms')
//                    ->table('dede_admin')
//                ->find();die;
            unset( $post['verify']);
            $Admin = AdminModel::where(['userid'=>'admin'])->find();
            if($Admin){
                 return json(['code'=>1,'msg'=>'登录成功']);
            } else {
                 return json(['code'=>0,'msg'=>'登录失败']);
            }
        }
        return View::fetch();
    }
    
    public function verify(){
        return Captcha::create();    
    }
}
