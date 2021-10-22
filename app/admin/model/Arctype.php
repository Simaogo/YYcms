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
               // $ishidden        = $v['ishidden'] ? '<span style="font-size:12px;" class="doc-icon-name">隐藏</span>':' ';
                $v['title']      = $v['typename'] .' <span style="font-size:12px;">[ID:'.$v['id'].']</span> ';
               
                $v['children']   = self::arctypeTree($list, $v['id'], $level+1);
                $arr[] = $v;
            }
        }
        return $arr;
    }
    public static function childrenIds($list,$id){
        $ids= [];
        foreach ($list as $v){
            if ($v['reid'] == $id) {
                $ids[] = $v['id'];
                $ids = array_merge($ids,self::childrenIds($list, $v['id']));
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
