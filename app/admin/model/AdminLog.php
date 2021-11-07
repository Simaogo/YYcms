<?php

namespace app\admin\model;
class AdminLog extends \think\Model{
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'update_time';
    protected $createTime = 'create_time';
    protected static function init()
    {
        
    }
}
