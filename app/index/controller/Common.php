<?php
namespace app\index\controller;
use think\facade\View;

class Common extends \app\BaseController{
    private $postition;
    public function __construct() {
       $this->initialize();
    }
    public function initialize() {
      $view = [];
      $view['position'] = '';
       View::assign('field',$view);
    }
}
