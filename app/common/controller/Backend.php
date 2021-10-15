<?php

namespace app\common\controller;

use think\facade\Session;
use think\App;
use app\common\controller\Jump;
class Backend extends \app\BaseController{
    
    use Jump;
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
    }
}
