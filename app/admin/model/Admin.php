<?php
/**
 * YYcms
 * ============================================================================
 * 版权所有 2021-2028 yyAdmin，并保留所有权利。
 * git地址: https://github.com/Simaogo/YYcms
 * ----------------------------------------------------------------------------
 * 采用最新Thinkphp6实现
 * ============================================================================
 * Author: simao 
 * Date: 20121/10/2
 */

namespace app\admin\model;

class Admin extends \think\Model{
    
    protected $autoWriteTimestamp = true;
    protected $updateTime = 'logintime';
    public function adminType(){
        return $this->hasOne('Admintype', 'rank','usertype');
    }
}
