<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

/**
 * Description of Arclist
 *
 * @author Administrator
 */
class Arclist extends \think\Model{
    protected $name = 'archives';
    // 定义时间戳字段名
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'pubdate';
    protected $createTime = 'senddate';
    protected static function init()
    {
        
    }
    public function arctype(){
        return $this->hasOne('Arctype', 'id','typeid' );
    }
}
