<?php

namespace app\common\model;

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
                 $v['spread']     = true;
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
        $ids[] = intval($id);
        return array_unique($ids);
    }
    /**
     * 高亮显示栏目
     * @param type $list
     * @param type $id
     * @return type
     */
    public static function currIds($list,$id){
        $arr = array();
        foreach ($list as $v){
            if ($v['id'] == $id) {
                $arr[] = $v['id'];
                $arr = array_merge($arr, self::currIds($list,$v['reid']));
            }
        }
        return $arr;
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
    //栏目高亮id
    public function artypeCurrId($id){
        $arr = array();
        $artype=self::find($id);
        if($artype){
             $arr[]=$artype->topid;
             $arr=array_merge($arr,self::artypeCurrId($artype->topid));
        }
        return $arr;
    }
}
