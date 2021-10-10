<?php

namespace app\admin\model;

class Arctype extends \think\Model{
    protected $table = '';
    protected static function init()
    {
        
    }
    
    public static function arctypeTree($list ,$reid = 0 , $level = 0 ){
        $arr = array();
        foreach ($list as $v){
            if ($v['reid'] == $reid) {
                $v['level']      = $level + 1;
                $v['title']      = $v['typename'];
                $v['children']   = self::arctypeTree($list, $v['id'], $level+1);
                $arr[] = $v;
            }
        }
        return $arr;
    }
    public static function childrenIds($list,$id){
        $ids= [];
        $ids[] = $id;
        foreach ($list as $v){
            if ($v['reid'] == $id) {
                $ids[] = $v['id'];
                self::childrenIds($list, $v['id']);
            }
        }
        return $ids;
    }
    public static function cateTree($cate ,$name='typename', $lefthtml = '|---- ' , $reid = 0 , $level = 0 ){
        $arr = array();
        foreach ($cate as $v){
            if ($v['reid'] == $reid) {
                $v['level']      = $level + 1;
                $v['lefthtml'] = str_repeat($lefthtml,$level);
                $v['l'.$name]   = $v['lefthtml'].$v[$name];
                $arr[] = $v;
                $arr = array_merge($arr, self::cateTree($cate,$name, $lefthtml, $v['id'], $level+1));
            }
        }
        return $arr;
    }
}
