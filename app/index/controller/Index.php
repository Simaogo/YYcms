<?php
declare (strict_types = 1);

namespace app\index\controller;
use think\facade\View;

class Index extends \Collator
{
    public function index()
    {
         return View::fetch('../pc/index'); 
    }
}
