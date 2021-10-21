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
            $post['userid'] = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $post['userid']);
            $post['pwd'] = preg_replace("/[^0-9a-zA-Z_@!\.-]/", '', $post['pwd']);
            $pwd = substr(md5($post['pwd']), 5, 20);
            unset( $post['verify']);
            $Admin = AdminModel::where(['userid'=>$post['userid']])->find();
            if($Admin){
                if($Admin->pwd !== $pwd)  return json(['code'=>0,'msg'=>'密码错误']);
                 Session::set('admin',$Admin);
                 return json(['code'=>1,'msg'=>'登录成功','url'=>url('index/index')->build()]);
            } else {
                 return json(['code'=>0,'msg'=>'用户不存在']);
            }
        }
        return View::fetch();
    }
    
    public function verify(){
        return Captcha::create();    
    }
}
