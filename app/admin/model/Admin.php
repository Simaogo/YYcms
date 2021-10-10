<?php
namespace app\admin\model;
class Admin extends \think\Model{

    protected $autoWriteTimestamp = true;
    protected $pubdate = 'logintime';
    protected static function init()
    {
        
    }
}
