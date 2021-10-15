<?php
namespace app\common\model;

class Flink extends \think\model{
    protected $name; 
    protected static function init()
    {
        
    }
    public function flinktype(){
        return $this->hasOne('Flinktype', 'id','typeid');
    }
}
